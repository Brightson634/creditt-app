<?php

namespace App\Http\Controllers\Webmaster;

use Carbon\Carbon;
use App\Models\Package;
use App\Models\Tenants;
use Illuminate\Http\Request;
use App\Models\TenantPackage;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SuperadminController extends Controller
{
    //

    /**
     * Return a resource
     *
     * @return void
     */
    public function index()
    {
        $page_title = 'Super Admin';
        return view('webmaster.superadmin.index',compact('page_title'));
    }

    public function getTenants()
    {
           // Check if the authenticated user (via webmaster guard) has the Superadmin role
        if (!Auth::guard('webmaster')->user() || !Auth::guard('webmaster')->user()->hasRole('Superadmin')) {
            abort(403, 'Unauthorized: Superadmin role required.');
        }
        $tenants = Tenants::with('tenantPackages')->get();
        $packages = Package::all();
        // return response()->json($tenants);
        return view('webmaster.superadmin.tenants',compact('tenants','packages'));
    }

    /**
     * Add Subscription
     *
     * @param Request $request
     * @return void
     */
    public function addSubscription(Request $request)
    {
        // Check if the authenticated user (via webmaster guard) has the Superadmin role
        if (!Auth::guard('webmaster')->user() || !Auth::guard('webmaster')->user()->hasRole('Superadmin')) {
            return response()->json(['message' => 'Unauthorized: Superadmin role required.'], 403);
        }

        // Validate the request
        try {
            $validated = $request->validate([
                'tenant_id' => 'required|exists:tenants,id',
                'package_id' => 'required|exists:packages,id',
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|date|after:start_date',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed for subscription creation', [
                'errors' => $e->errors(),
                'tenant_id' => $request->input('tenant_id'),
                'package_id' => $request->input('package_id'),
                'ip' => $request->ip(),
            ]);
            throw $e; // Re-throw to return validation errors to the client
        }

        try {
            // Create the subscription
            $subscription = TenantPackage::create([
                'tenant_id' => $validated['tenant_id'],
                'package_id' => $validated['package_id'],
                'start_date' => Carbon::parse($validated['start_date']),
                'end_date' => Carbon::parse($validated['end_date']),
                'status' => 1, // Active
            ]);

            return response()->json([
                'message' => 'Subscription added successfully',
                'created_at' => $subscription->created_at->timezone('Africa/Nairobi')->format('F d, Y h:i A'),
            ], 201);
        } catch (\Exception $e) {
            // Log database or other errors
            Log::error('Failed to create subscription', [
                'error' => $e->getMessage(),
                'tenant_id' => $request->input('tenant_id'),
                'package_id' => $request->input('package_id'),
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'message' => 'An error occurred while adding the subscription.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
