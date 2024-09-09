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
use Illuminate\Support\Facades\DB;
use App\Entities\AccountingAccount;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Entities\AccountingAccountType;
use Illuminate\Support\Facades\Validator;
use App\Entities\AccountingAccountsTransaction;

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


    function createMemberAccountInCOA($accName, $accSubTypeId, $openBalance)
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
}
