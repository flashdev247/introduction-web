<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private $settingKeys = [
        'site_name',
        'logo',
        'email',
        'phone',
        'zalo',
        'hotline',
        'address',
        'contact_info',
    ];

    public function edit()
    {
        $settings = [];
        foreach ($this->settingKeys as $key) {
            $settings[$key] = Setting::get($key, '');
        }
        return view('admin.settings.edit', ['settings' => $settings]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'zalo' => ['nullable', 'string', 'max:255'],
            'hotline' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'contact_info' => ['nullable', 'string'],
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'Settings updated.');
    }
}
