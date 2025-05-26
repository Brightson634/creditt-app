<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Faq;
use App\Models\Role;
use App\Models\Branch;
use App\Models\Feature;
use App\Models\Tenants;
use App\Models\PageSection;
use App\Models\StaffMember;
use Illuminate\Http\Request;
// use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
// use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
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
      return view('frontend.index', compact('data'));
   }

   /**
    * Return registration view
    *
    * @return void
    */
   public function register()
   {
      return view('frontend.register');
   }

   /**
    * Store new business registration
    *
    * @return void
    */
   
   public function store(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'business_name' => 'required|string|max:255',
         'address' => 'required|string|max:255',
         'business_contact' => 'required|string|regex:/^\d{10,15}$/',
         'alternate_contact' => 'nullable|string|regex:/^\d{10,15}$/',
         'entity_email' => 'required|email|max:255',
         'alternate_email' => 'nullable|email|max:255',
         'title' => 'required|string|max:10',
         'fname' => 'required|string|max:255',
         'lname' => 'required|string|max:255',
         'email' => 'required|email|unique:staff_members,email',
         'phone' => 'required|string|regex:/^\d{10,15}$/',
         'password' => 'required|string|min:8|confirmed',
      ]);

      if ($validator->fails()) {
         Log::error('Validation failed during registration', ['errors' => $validator->errors()]);
         return response()->json([
               'status' => false,
               'errors' => $validator->errors(),
         ], 422);
      }

      DB::beginTransaction();

      try {
         // Save business entity
         $tenant = new Tenants();
         $tenant->physical_location = $request->address;
         $tenant->company_name = $request->business_name;
         $tenant->phone_contact_one = $request->business_contact;
         $tenant->phone_contact_two = $request->alternate_contact ?? null;
         $tenant->email_address_one = $request->entity_email;
         $tenant->email_address_two = $request->alternate_email ?? null;
         $tenant->save();
         $lastInsertedId = $tenant->id;

         // Create default branch
         $branch = new Branch();
         $branch->tenant_id = $lastInsertedId;
         $branch->branch_no = 'BR00' . $lastInsertedId;
         $branch->name = 'Main Branch';
         $branch->is_main = 1;
         $branch->default_currency = 0;
         $branch->save();


        //creating an admin role
         $admin = Role::firstOrCreate([
            'name' => 'Admin#'.$lastInsertedId,
            'guard_name' => 'webmaster',
            'tenant_id'=>$lastInsertedId,
            'is_default'=>true,
        ]);

        //creating permissions for new tenant
        $permissions=createTenantPermissions();
        $admin->syncPermissions($permissions);

         // Create admin user
         $staff = new StaffMember();
         $staff->title = $request->title;
         $staff->fname = $request->fname;
         $staff->lname = $request->lname;
         $staff->tenant_id= $lastInsertedId;
         $staff->email = $request->email;
         $staff->telephone = $request->phone;
         $staff->password = Hash::make($request->password);
         $staff->staff_no = 'ADMIN00' . $lastInsertedId;
         $staff->branch_id = $branch->id;
         $staff->role_id = $admin->id;
         $staff->save();


         $staff->assignRole($admin);

         DB::commit();

         return response()->json([
               'status' => true,
               'message' => 'Business registered successfully.',
         ], 201);
      } catch (\Exception $e) {
         DB::rollBack();
         Log::error('Error during tenant registration', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
         return response()->json([
               'status' => false,
               'message' => 'Registration failed. Please try again later.',
         ], 500);
      }
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
