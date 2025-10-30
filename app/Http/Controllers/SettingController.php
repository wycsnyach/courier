<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::latest()->first(); // Latest record for editing
        $allSettings = Setting::all();         // For listing (if needed)

        return view('settings.index', compact('setting', 'allSettings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'street_address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $setting = Setting::firstOrNew(['id' => 1]);

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($setting->logo && Storage::disk('public')->exists($setting->logo)) {
                Storage::disk('public')->delete($setting->logo);
            }

            // Store the new logo in storage/app/public/logos
            $path = $request->file('logo')->store('logos', 'public');
            $setting->logo = $path;
        }

        // Save other fields
        $setting->fill($request->except('logo'));
        $setting->save();

        return back()->with('success', 'Settings updated successfully!');
    }
}
