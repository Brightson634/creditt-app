<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Asset;
use App\Models\Supplier;
use App\Models\AssetGroup;
use App\Models\StaffMember;
use Illuminate\Http\Request;
use App\Entities\AccountingAccount;
use App\Http\Controllers\Controller;
use App\Services\PermissionsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AssetController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:webmaster');
  }

  public function assets()
  {
    PermissionsService::check('view_assets');
    $page_title = 'Assets';
    $assets = Asset::all();
    $accounts_array = $this->getAllChartOfAccounts();
    return view('webmaster.assets.index', compact('page_title', 'assets', 'accounts_array'));
  }

  public function assetCreate()
  {
    PermissionsService::check('add_assets');
    $page_title = 'Add Asset';
    $asset_no = generateAssetNumber();
    $staffs = StaffMember::all();
    $suppliers = Supplier::all();
    $assetgroups = AssetGroup::all();
    $accounts_array = $this->getAllChartOfAccounts();
    return view('webmaster.assets.create', compact('page_title', 'asset_no', 'staffs', 'suppliers', 'assetgroups', 'accounts_array'));
  }

  public function assetStore(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name'                  => 'required',
      'assetgroup_id'         => 'required',
      'serial_no'             => 'required',
      'cost_price'            => 'required|numeric',
      'purchase_date'         => 'required',
      'staff_id'              => 'required',
      'location'              => 'required',
      'warrant_period'        => 'required|numeric',
      'depreciation_period'   => 'required|numeric',
      'depreciation_amount'   => 'required|numeric',
      'supplier_id'           => 'required',
      'account_id'            => 'required',
    ], [
      'name.required'                 => 'The name is required',
      'assetgroup_id.required'        => 'The asset group is required',
      'serial_no.required'            => 'The serial or model number is required',
      'cost_price.required'           => 'The cost price is required',
      'purchase_date.required'        => 'The purchase date is required',
      'staff_id.required'             => 'The staff is required',
      'location.required'             => 'The location is required',
      'warrant_period.required'       => 'The warrant period is required',
      'depreciation_period.required'  => 'The depreciation period is required.',
      'depreciation_amount.required'  => 'The depreciation amount is required.',
      'supplier_id.required'          => 'The supplier  is required.',
      'account_id'                    => 'Account Type is required'
    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => 400,
        'message' => $validator->errors()
      ]);
    }

    $asset = new Asset();
    $asset->asset_no = $request->asset_no;
    $asset->name = $request->name;
    $asset->assetgroup_id = $request->assetgroup_id;
    $asset->serial_no = $request->serial_no;
    $asset->cost_price = $request->cost_price;
    $asset->purchase_date = $request->purchase_date;
    $asset->staff_id = $request->staff_id;
    $asset->location = $request->location;
    $asset->warrant_period = $request->warrant_period;
    $asset->depreciation_period = $request->depreciation_period;
    $asset->depreciation_amount = $request->depreciation_amount;
    $asset->supplier_id = $request->supplier_id;
    $asset->account_type = $request->account_id;
    $asset->save();

    $notify[] = ['success', 'Asset added Successfully!'];
    session()->flash('notify', $notify);

    return response()->json([
      'status' => 200,
      'url' => route('webmaster.assets')
    ]);
  }

  public function getAllChartOfAccounts()
  {
    $business_id = request()->attributes->get('business_id');
    $accounts = AccountingAccount::forDropdown($business_id, true);
    // return new JsonResponse($accounts);
    // return $accounts;
    $translations = [
      "accounting::lang.accounts_payable" => "Accounts Payable",
      "accounting::lang.accounts_receivable" => "Accounts Receivable (AR)",
      "accounting::lang.credit_card" => "Credit Card",
      "accounting::lang.current_assets" => "Current Assets",
      "accounting::lang.cash_and_cash_equivalents" => "Cash and Cash Equivalents",
      "accounting::lang.fixed_assets" => "Fixed Assets",
      "accounting::lang.non_current_assets" => "Non Current Assets",
      "accounting::lang.cost_of_sale" => "Cost of Sale",
      "accounting::lang.expenses" => "Expenses",
      "accounting::lang.other_expense" => "Other Expense",
      "accounting::lang.income" => "Income",
      "accounting::lang.other_income" => "Other Income",
      "accounting::lang.owners_equity" => "Owner Equity",
      "accounting::lang.current_liabilities" => "Current Liabilities",
      "accounting::lang.non_current_liabilities" => "Non-Current Liabilities",
    ];

    $accounts_array = [];
    foreach ($accounts as $account) {
      $translatedText = $translations[$account->sub_type] ?? $account->sub_type;
      $accounts_array[] = [
        'id' => $account->id,
        'name' => $account->name,
        'primaryType' => $account->account_primary_type,
        'subType' => $translatedText,
        'currency' => $account->account_currency
      ];
    }

    return $accounts_array;
  }

  public function assetEdit($id)
  {
    PermissionsService::check('edit_assets','Unauthorized action');
    $asset = Asset::findOrFail($id);
    $page_title = 'Edit Asset';
    $asset_no = generateAssetNumber();
    $staffs = StaffMember::all();
    $suppliers = Supplier::all();
    $assetgroups = AssetGroup::all();
    $accounts_array = $this->getAllChartOfAccounts();
    return view('webmaster.assets.edit', compact(
      'page_title',
      'asset_no',
      'staffs',
      'suppliers',
      'assetgroups',
      'accounts_array',
      'asset'
    ));
  }
  public function assetUpdate(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name'                  => 'required',
      'assetgroup_id'         => 'required',
      'serial_no'             => 'required',
      'cost_price'            => 'required|numeric',
      'purchase_date'         => 'required',
      'staff_id'              => 'required',
      'location'              => 'required',
      'warrant_period'        => 'required|numeric',
      'depreciation_period'   => 'required|numeric',
      'depreciation_amount'   => 'required|numeric',
      'supplier_id'           => 'required',
      'account_id'            => 'required',
    ], [
      'name.required'                 => 'The name is required',
      'assetgroup_id.required'        => 'The asset group is required',
      'serial_no.required'            => 'The serial or model number is required',
      'cost_price.required'           => 'The cost price is required',
      'purchase_date.required'        => 'The purchase date is required',
      'staff_id.required'             => 'The staff is required',
      'location.required'             => 'The location is required',
      'warrant_period.required'       => 'The warrant period is required',
      'depreciation_period.required'  => 'The depreciation period is required.',
      'depreciation_amount.required'  => 'The depreciation amount is required.',
      'supplier_id.required'          => 'The supplier  is required.',
      'account_id'                    => 'Account Type is required'
    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => 400,
        'message' => $validator->errors()
      ]);
    }

    $asset = Asset::findOrFail($request->id);
    $asset->asset_no = $request->asset_no;
    $asset->name = $request->name;
    $asset->assetgroup_id = $request->assetgroup_id;
    $asset->serial_no = $request->serial_no;
    $asset->cost_price = $request->cost_price;
    $asset->purchase_date = $request->purchase_date;
    $asset->staff_id = $request->staff_id;
    $asset->location = $request->location;
    $asset->warrant_period = $request->warrant_period;
    $asset->depreciation_period = $request->depreciation_period;
    $asset->depreciation_amount = $request->depreciation_amount;
    $asset->supplier_id = $request->supplier_id;
    $asset->account_type = $request->account_id;
    $asset->save();

    $notify[] = ['success', 'Asset Updated Successfully!'];
    session()->flash('notify', $notify);

    return response()->json([
      'status' => 200,
      'url' => route('webmaster.assets')
    ]);
  }

  public function assetDestroy($id)
  {
    if (!Auth::guard('webmaster')->user()->can('delete_assets')) {
      $notify[] = ['error', 'Unauthorized Action!'];
      session()->flash('notify', $notify);
      return redirect()->back()->send();
    }
    $asset = Asset::findOrFail($id);
    $asset->delete();
    $notify[] = ['success', 'Asset deleted successfully!'];
    session()->flash('notify', $notify);
    return redirect()->back()->with('success', 'Asset deleted successfully.');
  }
}
