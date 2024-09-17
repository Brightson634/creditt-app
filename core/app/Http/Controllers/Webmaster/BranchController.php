<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Branch;
use App\Utility\Currency;
use App\Utility\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
   public function __construct()
   {
     $this->middleware('auth:webmaster');
   }

   public function branches()
   {
      $page_title = 'Branches';
      $branches = Branch::all();

      foreach($branches as $branch){
            $currency = Currency::find($branch->default_currency);
            if ($currency) {
            $branch->default_currency = $currency->country . ' - ' . $currency->currency;
            $branch->code=$currency->code;
            } else {
            $branch->default_currency = 'Not Set';
            }
     }

    //  return new JsonResponse($branches);

      $currencies = Currency::forDropdown();
      return view('webmaster.branches.index', compact('page_title', 'page_title','branches','currencies'));
   }

   public function branchCreate()
   {
      $page_title = 'Add Branch';
      $branch_no = generateBranchNumber();
      $currencies = Currency::forDropdown();
      return view('webmaster.branches.create', compact('page_title', 'branch_no','currencies'));
   }

    public function branchStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email|unique:branches',
        'telephone' => 'required',
        'physical_address' => 'required',
        'postal_address' => 'required',
        'default_curr' => 'required'
        ], [
        'name.required' => 'The name is required.',
        'email.required' => 'The email is required.',
        'email.unique' => 'The email is already registered',
        'telephone.required' => 'The telephone is required',
        'postal_address.required' => 'The postal address is required',
        'default_curr.required' => 'Default Branch currency is required'
        ]);

        if ($validator->fails()) {
        return response()->json([
        'status' => 400,
        'message' => $validator->errors()
        ]);
        }

        DB::beginTransaction();

        try {
        $branch = new Branch();
        $branch->branch_no = $request->branch_no;
        $branch->name = strtoupper($request->name);
        $branch->email = strtolower($request->email);
        $branch->telephone = $request->telephone;
        $branch->physical_address = $request->physical_address;
        $branch->postal_address = $request->postal_address;
        $branch->default_currency = $request->default_curr;
        $branch->is_main = $request->is_main;
        $branch->save();

        $this->saveBranchDetailsToBusiness($branch->id, $request->default_curr, $request->name);

        DB::commit();

        $notify[] = ['success', 'Branch added Successfully!'];
        session()->flash('notify', $notify);

        return response()->json([
        'status' => 200,
        'url' => route('webmaster.branches')
        ]);
        } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Branch Store Error: ' . $e->getMessage());

        return response()->json([
        'status' => 500,
        'message' => 'There was an error processing your request: '
        ]);
        }
    }
    /**
     * Saves branch information necessary for accounting
     * module in the business model
     * @param mixed $branchId
     * @param mixed $currencyId
     * @param mixed $name
     * @return Business|\Illuminate\Database\Eloquent\Model
     */
    public function saveBranchDetailsToBusiness($branchId, $currencyId, $name)
    {
        $data = [
        'name' => $name,
        'currency_id' => $currencyId,
        'owner_id' => $branchId,
        ];

        return Business::create($data);
    }
    public function branchEdit(Request $request)
    {
        $branchId = $request->branchId;
        // return response()->json($branchId);
        $branch = Branch::find($branchId);
        // return new JsonResponse($branch);
        if (!$branch) {
            return response()->json([
            'status' => 404,
            'message' => 'Branch not found'
            ]);
        }

        return response()->json([
        'status' => 200,
        'branch' => $branch
        ]);
    }

    public function branchUpdate(Request $request)
    {
        return response()->json(['hi']);
        $branchId = $request->branch_id;

            // Validate the request data
              // Validate the request data
              $validator = Validator::make($request->all(), [
              'name' => 'required',
              'email' => 'required|email',
              'telephone' => 'required',
              'physical_address' => 'required',
              'postal_address' => 'required',
              'default_curr' => 'required'
              ], [
              'name.required' => 'The name is required.',
              'email.required' => 'The email is required.',
              'email.email' => 'The email must be a valid email address.',
              'email.unique' => 'The email is already registered.',
              'telephone.required' => 'The telephone is required.',
              'physical_address.required' => 'The physical address is required.',
              'postal_address.required' => 'The postal address is required.',
              'default_curr.required' => 'Default Branch currency is required.'
              ]);


           // Check if validation fails
           if ($validator->fails()) {
           return response()->json([
           'status' => 422,
           'errors' => $validator->errors()
           ], 422);
           }

           $branch = Branch::find($branchId);

           if (!$branch) {
           return response()->json([
           'status' => 404,
           'message' => 'Branch not found'
           ], 404);
           }


            DB::beginTransaction();
            try {
            // Update branch details
            $branch->branch_no = $request->branch_no;
            $branch->name = strtoupper($request->name);
            $branch->email = strtolower($request->email);
            $branch->telephone = $request->telephone;
            $branch->physical_address = $request->physical_address;
            $branch->postal_address = $request->postal_address;
            $branch->default_currency = $request->default_curr;
            $branch->is_main = $request->is_main;
            $branch->save();

            // Update or create business details
            if (Business::where('owner_id', $branchId)->exists()) {
                $this->updateBusiness($branchId, $request->name, $request->default_curr);
            } else {
                $this->saveBranchDetailsToBusiness($branchId, $request->default_curr, $request->name);
            }

            DB::commit();

            return response()->json([
            'status' => 200,
            'message' => true
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Branch Update Error: ' . $e->getMessage());

            return response()->json([
            'status' => 500,
            'message' => 'Server Error: ' . $e->getMessage()
            ]);
        }
    }


    /**
     * Updates the branch details in the business model
     * used by the accounting module
     * @param mixed $name
     * @param mixed $currencyId
     * @param mixed $branchId
     * @return bool
     */
    public function updateBusiness($name,$currencyId,$branchId)
    {
        $data = [
        'name' => $name,
        'currency_id' => $currencyId,
        ];
        return Business::where('owner_id',$branchId)->update($data);
    }

    public function branchDelete(Request $request)
    {
        $branch = Branch::find($request->id);
        if($branch){
            $branch->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Branch Deleted'
            ]);
        }
        return response()->json([
            'status'=>404,
            'message'=>'Branch not found'
        ]);
    }

//    public function saveBranchDetailsToBusinessLoc($businessId,$currencyId,$name,){
//         $data=[
//         'business_id'=>$businessId,
//         'name'=>$name,
//         'owner_id'=>$branchId,
//         ];
//    }
}

