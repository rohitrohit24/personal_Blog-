<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('admin.partial.userprofile', compact('user'));
    }
    public function update(Request $request)
    {
        $user = Auth::user();
        // $user = auth('user')->user();
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,webp,jpg|max:2048',
            'current_password' => 'required_with:new_password',
            'new_password' => 'min:4|confirmed',
            'github_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'portfolio_url' => 'nullable|url',
        ]);
        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }
        $user->social_links = [
            'github' => $request->github_url,
            'linkedin' => $request->linkedin_url,
            'twitter' => $request->twitter_url,
            'portfolio' => $request->portfolio_url,
        ];



        // dd($request->current_password);

        // $a = $user->id;
        // dd($a);
        // dd($request->current_password);
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {

                return back()->withErrors(['current_password' => 'Current password not matched!']);
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->tagline = $request->tagline;
        $user->bio = $request->bio;
        $user->default_post_status = $request->default_post_status;
        $user->comment_moderation = $request->comment_moderation;
        $user->email_notifications = $request->has('email_notifications');

        $user->save();

        return back()->with('success', 'Profile & Settings successfully update ho gayi!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'Logged out successfully!')
            ->withCookie(Cookie::forget(config('session.cookie')))
            ->withCookie(Cookie::forget('XSRF-TOKEN'))
            ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');
    }
}
