<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.partial.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name'        => 'required|string|max:255',
            'site_description' => 'nullable|string|max:500',
            'contact_email'    => 'nullable|email|max:255',
            'posts_per_page'   => 'nullable|integer|min:1|max:100',
            'allow_comments'   => 'nullable|boolean',
            'maintenance_mode' => 'nullable|boolean',
            'twitter_url'      => 'nullable|url|max:255',
            'github_url'       => 'nullable|url|max:255',
            'linkedin_url'     => 'nullable|url|max:255',
        ]);

        $keys = ['site_name', 'site_description', 'contact_email', 'posts_per_page', 'twitter_url', 'github_url', 'linkedin_url'];

        foreach ($keys as $key) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $request->input($key)]
            );
        }

        // Handle toggle/checkbox fields explicitly
        Setting::updateOrCreate(['key' => 'allow_comments'], ['value' => $request->has('allow_comments') ? '1' : '0']);
        Setting::updateOrCreate(['key' => 'maintenance_mode'], ['value' => $request->has('maintenance_mode') ? '1' : '0']);

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}
