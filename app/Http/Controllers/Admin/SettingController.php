<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $setting = ContactSetting::firstOrCreate([], ['site_name' => 'Your Site Title']);
        return view('admin.settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = ContactSetting::firstOrCreate([], ['site_name' => 'Your Site Title']);
        $setting->update($request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'contact_info' => ['nullable', 'string'],
        ]));
        return back()->with('success', 'Settings updated.');
    }
}
