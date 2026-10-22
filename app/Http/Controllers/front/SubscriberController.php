<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Subscribers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class SubscriberController extends Controller
{
    private const COOKIE_LIFETIME_MINUTES = 525600;

    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email:filter|max:255',
        ]);

        $normalizedEmail = trim(strtolower($validated['email']));
        $subscriber = Subscribers::where('email', $normalizedEmail)->first();

        if ($subscriber) {
            if ($subscriber->is_active) {
                Cookie::queue('subscribed_email', $normalizedEmail, self::COOKIE_LIFETIME_MINUTES);
                return back()->with('info', 'You are already subscribed!');
            }

            $subscriber->update([
                'is_active' => true,
                'token' => Str::random(64),
            ]);

            Cookie::queue('subscribed_email', $normalizedEmail, self::COOKIE_LIFETIME_MINUTES);
            return back()->with('success', 'You have successfully subscribed again!');
        }

        Subscribers::create([
            'email' => $normalizedEmail,
            'token' => Str::random(64),
            'is_active' => true,
        ]);

        Cookie::queue('subscribed_email', $normalizedEmail, self::COOKIE_LIFETIME_MINUTES);
        return back()->with('success', 'Thank you! You have successfully subscribed.');
    }

    public function unsubscribe($token)
    {
        $subscriber = Subscribers::where('token', $token)->first();

        if ($subscriber) {
            $subscriber->update(['is_active' => false]);
            Cookie::queue(Cookie::forget('subscribed_email'));
            return redirect()->route('home')->with('success', 'You have been successfully unsubscribed from the newsletter.');
        }

        return redirect()->route('home')->with('error', 'Invalid or expired unsubscribe link.');
    }
}
