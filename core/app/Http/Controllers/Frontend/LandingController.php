<?php

namespace App\Http\Controllers\Frontend;

use App\Models\PageSection;
use App\Models\Feature;
use App\Models\Faq;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LandingController extends Controller
{

   public function index()
   {

      // $data = PageSection::where('id', 1)->first();
      // $data->views += 1;
      // $data->update();

      $data = 'dfdf';

      // $features = Feature::all();

      // vistorInformation($_SERVER["REMOTE_ADDR"], url()->current());
      return view('frontend.home', compact('data'));
   }

   public function sitemap()
   {
      $projects = Project::all();
      $categories = ProjectCategory::all();
      $services = Service::all();

      return response()->view('sitemap.index', [
         'projects'    => $projects,
         'categories'  => $categories,
         'services'    => $services,
      ])->header('Content-Type', 'text/xml');
   }

   // public function servicePage()
   // {
   //    $data = Page::where('page_slug', 'services')->first();
   //    $services = Project::where('status', 1)->get();
   //    vistorInformation($_SERVER["REMOTE_ADDR"], url()->current());
   //    return view('frontend.pages.services', compact('data', 'services'));
   // }

   // public function serviceDetailPage($slug)
   // {
   //    $data = Service::where('slug', $slug)->first();
   //    $services = Service::where('status', 1)->where('id', '!=', $data->id)->get();
   //    vistorInformation($_SERVER["REMOTE_ADDR"], url()->current());
   //    return view('frontend.pages.service_detail', compact('data', 'services'));
   // }
 
   




   // public function sendContact(Request $request)
   // {
   //    $validator = Validator::make($request->all(), [
   //      'names' => 'required',
   //      'email' => 'required|email',
   //      'subject' => 'required',
   //      'message' => 'required',
   //    ], [
   //        'names.required' => 'The names are required',
   //        'email.required' => 'The email is required',
   //        'subject.required' => 'The subject is required',
   //        'message.required' => 'The message is required'
   //    ]);

   //    if($validator->fails()){
   //      return response()->json([
   //        'status' => 400,
   //        'message' => $validator->errors()
   //      ]);
   //    }
      
   //    $receiver_email = 'kvntume20@gmail.com';

   //    $name = $request->names;
   //    $email_from = $request->email;
   //    $subject = $request->subject;
   //    $message = $request->message . "<br>Regards<br>" . $name;
   //    $from = $email_from;

   //    $headers = "From: <$from> \r\n";
   //    $headers .= "Reply-To: <$from> \r\n";
   //    $headers .= "MIME-Version: 1.0\r\n";
   //    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

   //    $to = $receiver_email;

   //    if (@mail($to, $subject, $message, $headers)) {
   //       // echo 'Your message has been sent.';
   //    } else {
   //       //echo 'There was a problem sending the email.';
   //    }

   //    $notify[] = ['success', 'Message submitted successfully!'];
   //    session()->flash('notify', $notify);

   //    return response()->json([
   //      'status' => 200
   //    ]);
   // }


}
