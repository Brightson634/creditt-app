<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Webmaster;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
   public function __construct()
   {
     $this->middleware('auth:webmaster');
   }

   public function generalSetting()
   {
      $page_title = 'General Setting';
      $setting = Setting::where('id', 1)->first();
      return view('webmaster.setting.generalsetting', compact('page_title', 'setting'));
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
          'address' => $request->address
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
      return view('webmaster.setting.emailsetting', compact('page_title', 'setting'));
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
      return view('webmaster.setting.logosetting', compact('page_title', 'setting'));
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
    return view('webmaster.setting.exchangerates',compact('page_title'));
   }

}
