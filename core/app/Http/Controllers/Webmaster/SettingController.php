<?php

namespace App\Http\Controllers\Webmaster;
use App\Models\Branch;
use App\Models\Setting;
use App\Models\Webmaster;
use App\Utility\Business;
use App\Utility\Currency;
use App\Models\ExchangeRate;
use Illuminate\Http\Request;
use App\Models\PrefixSetting;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\AccountType;
use App\Models\CollateralItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Utility\Business as UtilityBusiness;

class SettingController extends Controller
{
   public function __construct()
   {
     $this->middleware(['auth:webmaster']);
   }

   public function generalSetting()
   {
      $page_title = 'General Setting';
      $activeNav ='generalsetting';
      $setting = Setting::where('id', 1)->first();
      return view('webmaster.setting.generalsetting', compact('page_title', 'setting','activeNav'));
   }

   public function updateGeneralSetting(Request $request)
   {
      $validator = Validator::make($request->all(), [
        'system_name' => 'required',
        'company_name' => 'required',
        'currency_symbol' => 'required',
        // 'daily_payment' => 'required',
        // 'investor_earning' => 'required',
        // 'company_earning' => 'required',
        'address' => 'required',
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      Setting::where('id', 1)->update([
          'system_name' => $request->system_name,
          'company_name' => $request->company_name,
          'currency_symbol' => $request->currency_symbol,
          // 'daily_payment' => $request->daily_payment,
          // 'investor_earning' => $request->investor_earning,
          // 'company_earning' => $request->company_earning,
          'address' => $request->address,
          'phone_contact_one'=>$request->phone_contact_one,
          'phone_contact_two'=>$request->phone_contact_two,
          'phone_contact_three'=>$request->phone_contact_three,
          'email_address_one'=>$request->email_address_one,
          'email_address_two'=>$request->email_address_two,
          'post_office'=>$request->post_office,
          'physical_location'=>$request->physical_location,
      ]);

      $notify[] = ['success', 'General Setting information updated successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
         'status' => 200
      ]);
  }

    public function emailSetting()
    {
      $page_title = 'Email Setting';
      $setting = Setting::where('id', 1)->first();
      $activeNav ='emailsetting';
      return view('webmaster.setting.emailsetting', compact('page_title', 'setting','activeNav'));
    }

    public function updateEmailSetting(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'smtp_host' => 'required',
        'mail_type' => 'required',
        'smtp_port' => 'required',
        'smtp_password' => 'required',
        'mail_encryption' => 'required',
        'from_email' => 'required',
        'from_name' => 'required'
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      Setting::where('id', 1)->update([
          'smtp_host' => $request->smtp_host,
          'mail_type' => $request->mail_type,
          'smtp_port' => $request->smtp_port,
          'smtp_user' => $request->from_email,
          'smtp_password' => $request->smtp_password,
          'mail_encryption' => $request->mail_encryption,
          'from_email' => $request->from_email,
          'from_name' => $request->from_name
      ]);

      $notify[] = ['success', 'Email Setting information updated successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
         'status' => 200
      ]);
  }

    public function logoSetting()
    {

      $page_title = 'Logo, Favicon & Main Setting';
      $setting = Setting::where('id', 1)->first();
      $activeNav ='logosetting';
      return view('webmaster.setting.logosetting', compact('page_title', 'setting','activeNav'));
    }

   public function updateLogo(Request $request)
   {
     $setting = Setting::where('id', 1)->first();

      if ($request->hasFile('logo')) {
         $temp_name = $request->file('logo');
         $logo =  'logo-'.uniqid().time().'.'.$temp_name->getClientOriginalExtension();
         $temp_name->move('assets/uploads/generals', $logo);

         if ($setting->logo) {
            @unlink('assets/uploads/generals/'.$setting->logo);
         }
      }

      Setting::where('id', 1)->update([ 'logo' => $logo ]);

      $notify[] = ['success', 'Main updated successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
         'status' => 200
      ]);
   }

    public function updateFooterLogo(Request $request)
    {
     $setting = Setting::where('id', 1)->first();

      if ($request->hasFile('footerlogo')) {
         $temp_name = $request->file('footerlogo');
         $footerlogo = 'footerlogo-'.uniqid().time().'.'.$temp_name->getClientOriginalExtension();
         $temp_name->move('assets/uploads/generals', $footerlogo);

         if ($setting->footerlogo) {
            @unlink('assets/uploads/generals/'.$setting->footerlogo);
         }
      }

      Setting::where('id', 1)->update([ 'footerlogo' => $footerlogo ]);

      $notify[] = ['success', 'Footer Logo updated successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
         'status' => 200,
      ]);
    }

   public function updateFavicon(Request $request)
   {
     $setting = Setting::where('id', 1)->first();

      if ($request->hasFile('favicon')) {
         $temp_name = $request->file('favicon');
         $favicon = 'favicon-'.uniqid().time().'.'.$temp_name->getClientOriginalExtension();
         $temp_name->move('assets/uploads/generals', $favicon);

         if ($setting->favicon) {
            @unlink('assets/uploads/generals/'.$setting->favicon);
         }
      }

      Setting::where('id', 1)->update([ 'favicon' => $favicon ]);

      $notify[] = ['success', 'Favicon updated successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
         'status' => 200,
      ]);
   }

   public function sendTestEmail(Request $request)
   {
      $validator = Validator::make($request->all(), [
        'email' => 'required|email'
      ], [
          'email.required' => 'The email is required',
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      // $emaildata = array();
      // $emaildata['testing'] = 'Dynamic data from the system';

      // $receiver_name = 'Testing Subscriber';
      // $receiver_email = $request->subscriber_email;
      // $subject = 'Website visitor subscription';
      // //$message = view('emailtemplate/testing', $emailadata ,TRUE);
      // $message = view('emailtemplate/testing', $emaildata);
      // sendSmtpMail($receiver_email, $receiver_name, $subject, $message);


      $emaildata = array();
      $emaildata['note'] = 'Dynamic data from the system';
      $receiver_name = 'Testing Email';
      $receiver_email = $request->email;
      $subject = 'Testing Send Email';
      $message = view('template/test', compact('emaildata'));
      sendSmtpMail($receiver_email, $receiver_name, $subject, $message);

      $notify[] = ['success', 'Email sent successfully!'];
      session()->flash('notify', $notify);
      return response()->json([
        'status' => 200
      ]);
   }
   public function settingExchangerate(Request $request){
        $page_title = 'Exchange Rates';
        $currencies = Currency::forDropdown();
        $branch_id = $request->attributes->get('branch_id');
        $default_branch_curr = Currency::find($request->attributes->get('default_branch_curr'));

        $exchangeRates = ExchangeRate::where('branch_id',$request->attributes->get('branch_id'))->get();
        // Adding the foreign_currency attribute to each exchange rate
        foreach ($exchangeRates as $exchangeRate) {
            $currency = Currency::find($exchangeRate->from_currency_id);
            if ($currency) {
                $exchangeRate->foreign_currency = $currency->country . ' - ' . $currency->currency;
                $exchangeRate->code=$currency->code;
            } else {
                $exchangeRate->foreign_currency = 'Unknown';
            }
        }
        // dd($request->attributes->get('business_id'));
        return view('webmaster.setting.exchangerates',compact('page_title','currencies','default_branch_curr','exchangeRates'));
   }

    /**
     * It saves branch exchange rates for foreign currencies
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse|mixed
     */
    public function saveExchangeRate(Request $request)
    {
        // $user = Auth::user();
        // $default_branch_curr = Branch::find($user->branch_id)->default_currency;
        $request->validate([
        'froCurrency' => 'required|exists:currencies,id',
        'exchangeRate' => 'required|numeric|min:0',
        ]);

        $data=[
            'from_currency_id' => $request->froCurrency,
            'exchange_rate' => $request->exchangeRate,
            'to_currency_id'=>$request->attributes->get('default_branch_curr'),
            'branch_id'=>$request->attributes->get('branch_id'),
        ];

        $exchangeRate = ExchangeRate::updateOrCreate(
            $data
        );

        if ($exchangeRate) {
            return response()->json(['success' => 'Exchange rate saved successfully!']);
        } else {
            return response()->json(['error' => 'Failed to save exchange rate.'], 500);
        }
    }

    public function getExchangeRateToUpdate(Request $request)
    {
       $rateId = $request->input('rateId');
       $exchangeRate = ExchangeRate::findOrFail($rateId);

       return response()->json([
       'froCurrencyId' => $exchangeRate->from_currency_id,
       'exchangeRate' => $exchangeRate->exchange_rate,
       ]);
    }
    public function updateExchangeRate(Request $request)
    {
       $request->validate([
       'froCurrency' => 'required|exists:currencies,id',
       'exchangeRate' => 'required|numeric|min:0',
       'rateId' => 'required|exists:exchange_rates,id',
       ]);

       $exchangeRate = ExchangeRate::findOrFail($request->rateId);

       $exchangeRate->from_currency_id = $request->froCurrency;
       $exchangeRate->exchange_rate = $request->exchangeRate;

       if($exchangeRate->save()){
        return response()->json(['message' => 'Exchange rate updated successfully!']);
       }else{
        return response()->json(['message' => 'There was an expected error!']);
       };
    }
    public function deleteRate(Request $request)
    {
         $rateId = $request->input('rateId');
          $exchangeRate = ExchangeRate::find($rateId);

          if ($exchangeRate) {
             $exchangeRate->delete();
             return new JsonResponse(['success' => true, 'message' => 'Exchange rate deleted successfully!']);
          } else {
            return new JsonResponse(['success' => false, 'message' => 'Exchange rate not found.'], 404);
          }
    }

    public function prefixSettingView(){
      $page_title = 'Prefix Setting';
      $prefixes = Setting::find(1);
      $activeNav ='prefixsetting';
      return view('webmaster.setting.prefixsetting',compact('page_title','prefixes','activeNav'));
    }

    public function savePrefixSettings(Request $request){
      
      $validator = Validator::make($request->all(), [
         'loan_prefix' => 'nullable|string|max:5|required_without_all:investment_prefix,member_account_prefix,member_prefix',
         'investment_prefix' => 'nullable|string|max:5|required_without_all:loan_prefix,member_account_prefix,member_prefix',
         'member_prefix' => 'nullable|string|max:5|required_without_all:loan_prefix,investment_prefix,member_account_prefix',
         'member_account_prefix' => 'nullable|string|max:5|required_without_all:loan_prefix,investment_prefix,member_prefix',
     ]);
     
      
         if ($validator->fails()) {
               return response()->json([
                  'errors' => $validator->errors(),
               ], 422);
         }

         if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

      //   return response()->json($request);
        try {

         $settings = Setting::find(1);
 
         if (!$settings) {
             $settings = new Setting();
         }

         if ($request->filled('loan_prefix')) {
             $settings->loan_prefix = $request->loan_prefix;
         }
 
         if ($request->filled('investment_prefix')) {
             $settings->investment_prefix = $request->investment_prefix;
         }
         if ($request->filled('member_prefix')) {
            $settings->member_prefix = $request->member_prefix;
         }
 
         if ($request->filled('member_account_prefix')) {
             $settings->member_account_prefix = $request->member_account_prefix;
         }

 
         $settings->save();
 
         return response()->json([
             'success' => true,
             'message' => 'Prefix settings saved successfully.'
         ]);
     } catch (\Exception $e) {
         return response()->json([
             'success' => false,
             'message' => 'Something went wrong: ' . $e->getMessage()
         ], 500);
     }
        
    }

    public function deletePrefixSettings(Request $request)
    {
         try {

            $settings = Setting::find(1);
   
            if (!$settings) {
               return response()->json([
                  'error' => true,
                  'message' => 'Settings not found.'
               ], 404);
            }
   
            // Update the specified prefix column to null
            $prefixType = $request->prefixType;
   
            $settings->$prefixType = null;
            $settings->save();
            return response()->json([
               'status' => 200,
               'message' => 'Prefix deleted successfully!',
           ]);
         } catch (\Exception $e) {
            return response()->json([
               'success' => false,
               'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
      }
    }

   public function loanSettingView(){
      $page_title = 'Loan Process Settings';
      $activeNav  = 'loanprocesssetting';
      $settings =Setting::find(1);
      $collateralMethods = explode(',', $settings->collateral_methods);
      return view('webmaster.setting.loansetting',compact('page_title','activeNav','collateralMethods'));
   }

   public function loanSettingCollateralMethod(Request $request){
     
     $validator = Validator::make($request->all(), [
      'collateralMethod' => 'required|in:collateral_items,min_balance,both',
    ]);

      if($validator->fails()) {
         return response()->json([
               'errors' => $validator->errors(),
         ], 422);
        }

 
     $collateralMethods = [];
     if ($request->collateralMethod == 'both') {
         $collateralMethods[] = 'collateral_items';
         $collateralMethods[] = 'min_balance';
     } else {
         $collateralMethods[] = $request->collateralMethod;
     }
 
     $collateralMethodsString = implode(',', $collateralMethods);
     $settings = Setting::find(1);
     $settings->collateral_methods = $collateralMethodsString;
     $settings->save();
     try {
      return response()->json([
         'success' => true,
         'message' => 'Prefix settings saved successfully.'
     ]);
     } catch (\Exception $e) {
      return response()->json([
         'success' => false,
         'message' => 'Something went wrong: ' . $e->getMessage()
      ], 500);
     }
     
   }

   public function deleteCollateralMethod($method)
   {
      $settings = Setting::find(1);

      $collateralMethods = explode(',', $settings->collateral_methods);

      if(($key = array_search($method, $collateralMethods)) !== false) {
         unset($collateralMethods[$key]);
      }
      $settings->collateral_methods = implode(',', $collateralMethods);
      try {
         $settings->save();
         return response()->json([
            'status' => 200,
            'message' => 'Prefix deleted successfully!',]);
      } catch (\Exception $e) {
         return response()->json([
            'success' => false,
            'message' => 'Something went wrong: ' . $e->getMessage()
         ], 500);
      }
   }

   public function collateralItemIndex(){
      $page_title="Collateral Items Settings";
      $activeNav='collaterals';
      $collaterals = CollateralItem::all();
      return view('webmaster.setting.collateral_index',compact('page_title','activeNav','collaterals'));
   }
   public function collateralItemStore(Request $request){

      try {

         $request->validate([
               'collateral_name' => 'required|string|max:255',
               'status' => 'required|in:0,1',
         ]);

         if($request->has('min_balance_collateral') && $request->min_balance_collateral) {
               $existingCollateral = CollateralItem::where('name', 'Minimum Account Balance')->first();
               if (!$existingCollateral) {
                  $minBalanceCollateral = new CollateralItem();
                  $minBalanceCollateral->name = 'Minimum Account Balance';
                  $minBalanceCollateral->status = 1;
                  $minBalanceCollateral->save();
               }
         }
         $collaterals = new CollateralItem();
         $collaterals->name = $request->collateral_name;
         $collaterals->status = $request->status;
         $collaterals->save();
         return response()->json(['success' => true, 'message' => 'Account Type saved successfully']);

     } catch (\Illuminate\Validation\ValidationException $e) {
         return response()->json(['success' => false, 'errors' => $e->errors()], 422);
     }

   }

   public function collateralsEdit($id)
   {
      $collateral =CollateralItem::find($id);
      if(!$collateral) {
         return response()->json(['error' => 'Account Type not found.'], 404);
      }
      $view = view('webmaster.setting.collateral_edit', compact('collateral'))->render();
      return response()->json(['html' => $view,'status'=>200]);
   }
   public function collateralsUpdate(Request $request,$id)
   {
      try {
         $request->validate([
               'collateral_name' => 'required|string|max:255',
               'status' => 'required|in:0,1',
         ]);
 
         $collaterals = CollateralItem::findorFail($id);
         $collaterals->name = $request->collateral_name;
         $collaterals->status = $request->status;
         $collaterals->save();
         return response()->json(['success' => true, 'message' => 'Collateral Item updated successfully']);

     } catch (\Illuminate\Validation\ValidationException $e) {
         return response()->json(['success' => false, 'errors' => $e->errors()], 422);
     }

   }
   public function collateralsDelete($id)
   {
      $collateral = CollateralItem::findOrFail($id);
      $collateral->delete();
      return response()->json([
         'status' => 200,
         'message' => 'Prefix deleted successfully!',]);
   }
   public function accountTypeIndex(){
      $page_title ="Account Type Settings";
      $accountTypes = AccountType::all();
      $activeNav='accounttypes';
      return view('webmaster.setting.accounttype_index',compact('page_title','activeNav','accountTypes'));
   }

   public function accountTypeStore(Request $request)
   {
      try {
         // Validate the incoming request data
         $validatedData = $request->validate([
             'account_name'   => 'required|string|max:255',
             'minimum_amount' => 'required|numeric|min:0',
             'description'    => 'nullable|string|max:500',
             'status'         => 'required|boolean',
         ]);
 
         // Create a new AccountType instance and save it
         $accountType = new AccountType();
         $accountType->name = $validatedData['account_name'];
         $accountType->min_amount = $validatedData['minimum_amount'];
         $accountType->description = $validatedData['description'];
         $accountType->status = $validatedData['status'];
         $accountType->save();
         return response()->json(['success' => true, 'message' => 'Account Type saved successfully']);

     } catch (\Illuminate\Validation\ValidationException $e) {
         return response()->json(['success' => false, 'errors' => $e->errors()], 422);
     }

   }
   public function accountTypeEdit($id)
   {
      $accountType =AccountType::find($id);
      if(!$accountType) {
         return response()->json(['error' => 'Account Type not found.'], 404);
      }
      $view = view('webmaster.setting.accounttype_edit', compact('accountType'))->render();
      return response()->json(['html' => $view,'status'=>200]);
   }
   public function accountTypeUpdate(Request $request,$id)
   {
      try {
         // Validate the incoming request data
         $validatedData = $request->validate([
             'account_name'   => 'required|string|max:255',
             'minimum_amount' => 'required|numeric|min:0',
             'description'    => 'nullable|string|max:500',
             'status'         => 'required|boolean',
         ]);
 
         // Create a new AccountType instance and save it
         $accountType = AccountType::findorFail($id);
         $accountType->name = $validatedData['account_name'];
         $accountType->min_amount = $validatedData['minimum_amount'];
         $accountType->description = $validatedData['description'];
         $accountType->status = $validatedData['status'];
         $accountType->save();
         return response()->json(['success' => true, 'message' => 'Account Type updated successfully']);

     } catch (\Illuminate\Validation\ValidationException $e) {
         return response()->json(['success' => false, 'errors' => $e->errors()], 422);
     }

   }
   public function accountTypeDelete($id)
   {
      $accountType = AccountType::findOrFail($id);
      $accountType->delete();
      return response()->json([
         'status' => 200,
         'message' => 'Prefix deleted successfully!',]);
   }

}
