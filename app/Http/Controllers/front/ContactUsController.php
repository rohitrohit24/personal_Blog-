<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Subscribers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContactUsController extends Controller
{
    public function subscriber(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);
        $subscriber = Subscribers::where('email', $validated['email'])->first();

        if ($subscriber) {

            if ($subscriber->is_active) {
                return back()->with('error', 'Aap pehle se subscribed hain!');
            }

            $subscriber->update([
                'is_active' => true,
                'token' => Str::random(64),
            ]);

            return back()->with('success', 'Aapne dobara successfully subscribe kar liya!');
        }

        Subscribers::create([
            'email' => $validated['email'],
            'token' => Str::random(64),
            'is_active' => true,
        ]);
        return back()->with('success', 'Thank you! Aap successfully subscribe ho chuke hain.');
    }
}
