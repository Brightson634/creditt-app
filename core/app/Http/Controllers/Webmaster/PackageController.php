<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Models\PackageModule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    //
    public function index()
    {
          // Check if the authenticated user (via webmaster guard) has the Superadmin role
        if (!Auth::guard('webmaster')->user() || !Auth::guard('webmaster')->user()->hasRole('Superadmin')) {
            abort(403, 'Unauthorized: Superadmin role required.');
        }
        $packages = Package::with('modules')->orderBy('sort_order')->get();
        return view('webmaster.packages.index', compact('packages'));
    }

    public function create()
    {
          // Check if the authenticated user (via webmaster guard) has the Superadmin role
        if (!Auth::guard('webmaster')->user() || !Auth::guard('webmaster')->user()->hasRole('Superadmin')) {
            abort(403, 'Unauthorized: Superadmin role required.');
        }
        return view('webmaster.packages.create');
    }

    public function store(Request $request)
    {
          // Check if the authenticated user (via webmaster guard) has the Superadmin role
        if (!Auth::guard('webmaster')->user() || !Auth::guard('webmaster')->user()->hasRole('Superadmin')) {
            abort(403, 'Unauthorized: Superadmin role required.');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'trial_days' => 'nullable|integer|min:0',
            'sort_order' => 'required|integer|min:0',
            'modules' => 'required|array',
            'modules.*.name' => 'required|string',
            'modules.*.limits' => 'nullable|array',
        ]);

        $package = Package::create([
            'name' => $request->name,
            'price' => $request->price,
            'trial_days' => $request->trial_days ?? 0,
            'sort_order' => $request->sort_order,
        ]);

        foreach ($request->modules as $module) {
            PackageModule::create([
                'package_id' => $package->id,
                'module_name' => $module['name'],
                'limits' => $module['limits'] ?? null,
            ]);
        }

        return redirect()->route('webmaster.superadmin.package')->with('success', 'Package created successfully.');
    }

    public function edit(Package $package)
    {
          // Check if the authenticated user (via webmaster guard) has the Superadmin role
        if (!Auth::guard('webmaster')->user() || !Auth::guard('webmaster')->user()->hasRole('Superadmin')) {
            abort(403, 'Unauthorized: Superadmin role required.');
        }
        $package->load('modules');
        return view('webmaster.packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
          // Check if the authenticated user (via webmaster guard) has the Superadmin role
        if (!Auth::guard('webmaster')->user() || !Auth::guard('webmaster')->user()->hasRole('Superadmin')) {
            abort(403, 'Unauthorized: Superadmin role required.');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'trial_days' => 'nullable|integer|min:0',
            'sort_order' => 'required|integer|min:0',
            'modules' => 'required|array',
            'modules.*.name' => 'required',
            'modules.*.limits' => 'nullable|array',
        ]);

        $package->update([
            'name' => $request->name,
            'price' => $request->price,
            'trial_days' => $request->trial_days ?? 0,
            'sort_order' => $request->sort_order,
        ]);

        $package->modules()->delete();
        foreach ($request->modules as $module) {
            PackageModule::create([
                'package_id' => $package->id,
                'module_name' => $module['name'],
                'limits' => $module['limits'] ?? null,
            ]);
        }

          return redirect()->route('webmaster.superadmin.package')->with('success', 'Package updated successfully.');
    }
}
