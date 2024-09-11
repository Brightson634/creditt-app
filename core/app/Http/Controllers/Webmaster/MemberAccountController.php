<?php

namespace App\Http\Controllers\Webmaster;

use Carbon\Carbon;
use App\Models\Fee;
use App\Models\Branch;
use App\Models\Member;
use App\Models\FeeRange;
use App\Models\Statement;
use App\Models\AccountType;
use App\Models\StaffMember;
use Illuminate\Http\Request;
use App\Models\MemberAccount;
use App\Utils\AccountingUtil;
use App\Models\AccountTransaction;
use Illuminate\Support\Facades\DB;
use App\Entities\AccountingAccount;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Entities\AccountingAccountType;
use Illuminate\Support\Facades\Validator;
use App\Entities\AccountingAccountsTransaction;
use App\Models\Setting;

class MemberAccountController extends Controller
{
    protected $accountingUtil;
    public function __construct(AccountingUtil $accountingUtil)
    {
        $this->middleware('auth:webmaster');
        $this->accountingUtil = $accountingUtil;
    }

    public function memberaccounts()
    {
        $page_title = 'Member Accounts';
        $accounts = MemberAccount::all();
        //extra info for the rest of tabs
        $member_no = generateMemberNumber();
        $branches = Branch::all();
        $staffs = StaffMember::all();
        $members = Member::all();
        $accounttypes = AccountType::all();
        $fees = Fee::all();
        $account_no = generateAccountNumber();
        $activeTab = 'tab4';


        return view('webmaster.memberaccounts.index', compact(
            'page_title',
            'accounts',
            'account_no',
            'staffs',
            'members',
            'accounttypes',
            'fees',
            'member_no',
            'branches',
            'activeTab',
            'account_no'
        ));
    }

    public function memberaccountCreate()
    {
        $page_title = 'Create Member Account';
        $account_no = generateAccountNumber();
        $staffs = StaffMember::all();
        $members = Member::all();
        $accounttypes = AccountType::all();
        $fees = Fee::all();
        $accounts = MemberAccount::all();


        //extra info for the rest of tabs
        $member_no = generateMemberNumber();
        $branches = Branch::all();
        $activeTab = 'tab3';

        return view('webmaster.memberaccounts.create', compact(
            'page_title',
            'account_no',
            'staffs',
            'members',
            'accounttypes',
            'fees',
            'member_no',
            'branches',
            'activeTab',
            'accounts'
        ));
    }


    public function memberaccountStore(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'member_id'                 => 'required',
            'accounttype_id'            => 'required',
            'fees_id'                   => 'required',
            'opening_balance'           => 'required|numeric',
            'account_purpose'           => 'required',
            'parent_account'            => 'required',
        ], [
            'member_id.required'                   => 'The name is required.',
            'accounttype_id.required'              => 'The account type is required',
            'fees_id.required'                     => 'The fee is required',
            'opening_balance.required'             => 'The opening balance  is required',
            'account_purpose.required'             => 'The account purpose is required',
            'parent_account.required'              => 'The parent account is required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()
            ]);
        }

        DB::beginTransaction(); // Start the transaction

        try {
            $accounttype = AccountType::where('id', $request->accounttype_id)->first();
            $fees = Fee::whereIn('id', $request->fees_id)->get();
            $feesTotal = 0;

            foreach ($fees as $fee) {
                if ($fee->rate_type === 'fixed') {
                    $feesTotal += $fee->amount;
                } elseif ($fee->rate_type === 'percent') {
                    $feesTotal += ($fee->rate_value) * $request->opening_balance;
                } elseif ($fee->rate_type === 'range') {
                    $feeRanges = FeeRange::where('fee_id', $fee->id)->get();
                    foreach ($feeRanges as $range) {
                        if ($request->opening_balance >= $range->min_amount && $request->opening_balance <= $range->max_amount) {
                            $feesTotal += $range->amount;
                            break;
                        }
                    }
                }
            }

            // Create member account
            $account = new MemberAccount();
            $account->member_id           = $request->member_id;
            $account->accounttype_id      = $request->accounttype_id;
            $account->fees_id             = implode(',', $request->fees_id);
            $account->account_no          = $request->account_no;
            $account->opening_balance    = $request->opening_balance;
            $account->current_balance    = $request->opening_balance - $feesTotal;
            $account->available_balance  = $request->opening_balance - $feesTotal;
            $account->account_purpose     = $request->account_purpose;
            $account->is_default = $request->default_on ? 1 : 0;
            $account->account_status      = ($request->opening_balance >= $accounttype->min_amount) ? 1 : 0;
            $account->staff_id            = webmaster()->id;
            $account->save();

            //save transaction in account transactions
            // Create the account transaction
            $transaction = new AccountTransaction();
            $transaction->account_id = $account->id;
            $transaction->type === 'credit';
            $transaction->operation = "opening balance";
            $transaction->amount = $request->opening_balance;
            $transaction->previous_amount = 0;
            $transaction->current_amount = $request->opening_balance;
            $transaction->description = 'Opening Balance';
            $transaction->date = Carbon::now()->format('Y-m-d');
            $transaction->save();



            // Create member in COA 
            $openingBalance = $request->opening_balance;
            $this->createMemberAccountInCOA($request->account_no, $request->parent_account, $openingBalance);

            foreach ($request->fees_id as $feeId) {
                $fee = Fee::find($feeId);
                $statement = new Statement();
                $statement->member_id = $request->member_id;
                $statement->account_id = $account->id;
                $statement->type = 'CHARGES';
                $statement->detail = 'Charge - : ' . $fee->name;

                if ($fee->rate_type === 'fixed') {
                    $statement->amount = $fee->amount;
                } elseif ($fee->rate_type === 'percent') {
                    $statement->amount = $fee->rate_value * $request->opening_balance;
                } elseif ($fee->rate_type === 'range') {
                    $feeRanges = FeeRange::where('fee_id', $fee->id)->get();
                    foreach ($feeRanges as $range) {
                        if ($request->opening_balance >= $range->min_amount && $request->opening_balance <= $range->max_amount) {
                            $statement->amount = $range->amount;
                            break;
                        }
                    }
                }

                $statement->status = 0;
                $statement->save();
            }

            DB::commit();

            $notify[] = ['success', 'Account added Successfully!'];
            session()->flash('notify', $notify);

            return response()->json([
                'status' => 200,
                'url' => route('webmaster.memberaccounts')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error in memberaccountStore: ' . $e->getMessage());

            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while processing the request.'
            ]);
        }
    }


    public function createMemberAccountInCOA($accName, $accSubTypeId, $openBalance)
    {

        $business_id = request()->attributes->get('business_id');
        $user_id = (request()->attributes->get('user'))->id;
        try {
            DB::beginTransaction();

            $account_type = AccountingAccountType::find($accSubTypeId);


            $dataUserAcc['name'] = $accName;
            $dataUserAcc['account_primary_type'] = $account_type->account_primary_type;
            $dataUserAcc['account_sub_type_id'] = $accSubTypeId;
            $dataUserAcc['created_by'] = $user_id;
            $dataUserAcc['business_id'] = $business_id;
            $dataUserAcc['status'] = 'active';

            $account = AccountingAccount::create($dataUserAcc);

            if ($account_type->show_balance == 1 && ! empty($openBalance)) {
                //Opening balance
                $data = [
                    'amount' => $this->accountingUtil->num_uf($openBalance),
                    'accounting_account_id' => $account->id,
                    'created_by' => auth()->user()->id,
                    'operation_date' => \Carbon\Carbon::today()->format('Y-m-d'),
                ];
                //Opening balance
                $data['type'] = in_array($account_type->account_primary_type, ['asset', 'expenses']) ? 'debit' : 'credit';
                $data['sub_type'] = 'Opening Balance';
                AccountingAccountsTransaction::createTransaction($data);
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::emergency('File:' . $e->getFile() . 'Line:' . $e->getLine() . 'Message:' . $e->getMessage());
            return false;
        }
    }
    public function memberaccountEdit($id)
    {
        $page_title = 'Account Update';
        $memberAccount = MemberAccount::findorFail($id);
        $members = Member::all();
        $accounttypes = AccountType::all();
        $account_no = generateAccountNumber();
        $fees = Fee::all();
        return view('webmaster.members.account_edit', compact(
            'memberAccount',
            'accounttypes',
            'fees',
            'page_title',
            'members',
            'account_no'
        ));
    }


    public function memberaccountUpdate(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'member_id'                 => 'required',
            'accounttype_id'            => 'required',
            'fees_id'                   => 'required',
            'opening_balance'           => 'required|numeric',
            'account_purpose'           => 'required',
            'parent_account'            => 'required',
        ], [
            'member_id.required'                   => 'The name is required.',
            'accounttype_id.required'              => 'The account type is required',
            'fees_id.required'                     => 'The fee is required',
            'opening_balance.required'             => 'The opening balance  is required',
            'account_purpose.required'             => 'The account purpose is required',
            'parent_account.required'              => 'The parent account is required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()
            ]);
        }

        DB::beginTransaction(); // Start the transaction

        try {
            // Find the existing member account
            $account = MemberAccount::findOrFail($request->account);

            // Get the account type and fees
            $accounttype = AccountType::where('id', $request->accounttype_id)->first();
            $fees = Fee::whereIn('id', $request->fees_id)->get();
            $feesTotal = 0;

            foreach ($fees as $fee) {
                if ($fee->rate_type === 'fixed') {
                    $feesTotal += $fee->amount;
                } elseif ($fee->rate_type === 'percent') {
                    $feesTotal += ($fee->rate_value) * $request->opening_balance;
                } elseif ($fee->rate_type === 'range') {
                    $feeRanges = FeeRange::where('fee_id', $fee->id)->get();
                    foreach ($feeRanges as $range) {
                        if ($request->opening_balance >= $range->min_amount && $request->opening_balance <= $range->max_amount) {
                            $feesTotal += $range->amount;
                            break;
                        }
                    }
                }
            }

            // Update member account details
            $account->member_id           = $request->member_id;
            $account->accounttype_id      = $request->accounttype_id;
            $account->fees_id             = implode(',', $request->fees_id);
            $account->account_no          = $request->account_no;
            $account->opening_balance    = $request->opening_balance;
            $account->current_balance    = $request->opening_balance - $feesTotal;
            $account->available_balance  = $request->opening_balance - $feesTotal;
            $account->account_purpose     = $request->account_purpose;
            $account->is_default = $request->default_on ? 1 : 0;
            $account->account_status      = ($request->opening_balance >= $accounttype->min_amount) ? 1 : 0;
            $account->staff_id            = webmaster()->id;
            $account->save();

            // Update transaction (if required, or log changes in a new transaction)
            $transaction = AccountTransaction::where('account_id', $account->id)
                ->where('operation', 'opening balance')
                ->first();

            if ($transaction) {
                $transaction->amount = $request->opening_balance;
                $transaction->current_amount = $request->opening_balance;
                $transaction->date = Carbon::now()->format('Y-m-d');
                $transaction->save();
            }

            // Update member account in COA if necessary
            $this->createMemberAccountInCOA($request->account_no, $request->parent_account, $request->opening_balance);

            // Update the associated fees and statements
            foreach ($request->fees_id as $feeId) {
                $fee = Fee::find($feeId);
                $statement = Statement::where('account_id', $account->id)
                    ->where('type', 'CHARGES')
                    ->first();

                if ($statement) {
                    $statement->detail = 'Charge - : ' . $fee->name;
                    if ($fee->rate_type === 'fixed') {
                        $statement->amount = $fee->amount;
                    } elseif ($fee->rate_type === 'percent') {
                        $statement->amount = $fee->rate_value * $request->opening_balance;
                    } elseif ($fee->rate_type === 'range') {
                        $feeRanges = FeeRange::where('fee_id', $fee->id)->get();
                        foreach ($feeRanges as $range) {
                            if ($request->opening_balance >= $range->min_amount && $request->opening_balance <= $range->max_amount) {
                                $statement->amount = $range->amount;
                                break;
                            }
                        }
                    }
                    $statement->status = 0;
                    $statement->save();
                }
            }

            DB::commit();

            $notify[] = ['success', 'Account updated Successfully!'];
            session()->flash('notify', $notify);

            return response()->json([
                'status' => 200,
                'url' => route('webmaster.memberaccounts')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error in memberaccountUpdate: ' . $e->getMessage());

            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while processing the request.'
            ]);
        }
    }


    public function memberAccountStatement($id, Request $request)
    {
    
        if ($request->ajax()) {
            // Initialize the query
            $transactions = AccountTransaction::with(['deposit', 'withdraw', 'transfer'])
                ->where('account_id', $id);
    
            // Apply date filter if present
            if ($request->start_date && $request->end_date) {
                $transactions = $transactions->whereBetween('date', [$request->start_date, $request->end_date]);
            }
    
            // Get the transactions
            $transactions = $transactions->get();
    
            return datatables()->of($transactions)
                ->addIndexColumn()
                ->addColumn('deposit_amount', function ($transaction) {
                    return $transaction->deposit ? $transaction->deposit->amount : null;
                })
                ->addColumn('withdraw_amount', function ($transaction) {
                    return $transaction->withdraw ? $transaction->withdraw->amount : null;
                })
                ->addColumn('transfer_amount', function ($transaction) {
                    return $transaction->transfer ? $transaction->transfer->amount : null;
                })
                ->make(true);
        }
    
        $page_title = 'Member Account Statement';
        $memberAccount = MemberAccount::findOrFail($id);
        $settings =Setting::find(1);
        return view('webmaster.members.account_statement', compact('page_title', 'id','memberAccount','settings'));
    }
    
    
}
