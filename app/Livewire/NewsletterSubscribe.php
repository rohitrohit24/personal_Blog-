<?php

namespace App\Livewire;

use App\Models\Subscribers;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class NewsletterSubscribe extends Component
{
    public string $variant = 'box';

    public string $email = '';
    public bool $consent = true;
    public bool $isOpen = false;
    public bool $isSubscribed = false;
    public ?string $message = null;
    public ?string $statusMessage = null;
    public string $messageType = 'success';

    protected function rules(): array
    {
        $rules = [
            'email' => 'required|email:filter|max:255',
        ];

        if ($this->variant === 'contact') {
            $rules['consent'] = 'accepted';
        }

        return $rules;
    }

    protected $messages = [
        'email.required' => 'The email address is required.',
        'email.email' => 'Please enter a valid email address.',
        'consent.accepted' => 'Please accept the newsletter consent.',
    ];

    public function mount()
    {
        $cookieEmail = Cookie::get('subscribed_email');

        if ($cookieEmail) {
            $normalizedEmail = trim(strtolower($cookieEmail));
            $subscriber = Subscribers::where('email', $normalizedEmail)->first();

            if ($subscriber && $subscriber->is_active) {
                $this->isSubscribed = true;
                $this->email = $normalizedEmail;
            } else {
                Cookie::queue(Cookie::forget('subscribed_email'));
            }
        }
    }

    #[On('subscriber-status-changed')]
    public function onSubscriberStatusChanged(bool $isSubscribed, string $email = ''): void
    {
        $this->isSubscribed = $isSubscribed;
        $this->email = $email;
        $this->isOpen = false;
        $this->statusMessage = null;
        $this->message = null;
        $this->resetErrorBag();
    }

    public function toggleOpen(): void
    {
        $this->isOpen = !$this->isOpen;
        $this->resetErrorBag();
        $this->statusMessage = null;
        $this->message = null;
    }

    public function close(): void
    {
        $this->isOpen = false;
        $this->resetErrorBag();
        $this->statusMessage = null;
        $this->message = null;
    }

    public function subscribe(): void
    {
        $this->validate();

        $normalizedEmail = trim(strtolower($this->email));
        $subscriber = Subscribers::where('email', $normalizedEmail)->first();

        $cookieTime = 525600; // 1 year

        if ($subscriber) {
            if ($subscriber->is_active) {
                Cookie::queue('subscribed_email', $normalizedEmail, $cookieTime);
                $this->isSubscribed = true;
                $this->isOpen = false;
                $this->resetErrorBag();

                $this->messageType = 'info';
                $this->statusMessage = 'You are already subscribed!';
                $this->message = 'You are already subscribed!';

                $this->dispatch('subscriber-status-changed', isSubscribed: true, email: $normalizedEmail);
                return;
            }

            $subscriber->update([
                'is_active' => true,
                'token' => Str::random(64),
            ]);

            Cookie::queue('subscribed_email', $normalizedEmail, $cookieTime);
            $this->isSubscribed = true;
            $this->isOpen = false;
            $this->resetErrorBag();

            $this->messageType = 'success';
            $this->statusMessage = 'You have successfully subscribed again!';
            $this->message = 'You have successfully subscribed again!';

            $this->dispatch('subscriber-status-changed', isSubscribed: true, email: $normalizedEmail);
            return;
        }

        Subscribers::create([
            'email' => $normalizedEmail,
            'token' => Str::random(64),
            'is_active' => true,
        ]);

        Cookie::queue('subscribed_email', $normalizedEmail, $cookieTime);
        $this->isSubscribed = true;
        $this->isOpen = false;
        $this->resetErrorBag();

        $this->messageType = 'success';
        $this->statusMessage = 'Thank you! You have successfully subscribed.';
        $this->message = 'Thank you! You have successfully subscribed.';

        $this->dispatch('subscriber-status-changed', isSubscribed: true, email: $normalizedEmail);
    }

    public function unsubscribe(): void
    {
        $email = $this->email ?: (Cookie::get('subscribed_email') ?? '');

        if ($email) {
            $normalizedEmail = trim(strtolower($email));
            Subscribers::where('email', $normalizedEmail)->update(['is_active' => false]);
            Cookie::queue(Cookie::forget('subscribed_email'));
        }

        $this->isSubscribed = false;
        $this->email = '';
        $this->isOpen = false;
        $this->messageType = 'success';
        $this->statusMessage = 'You have been successfully unsubscribed.';
        $this->message = 'You have been successfully unsubscribed.';
        $this->resetErrorBag();

        $this->dispatch('subscriber-status-changed', isSubscribed: false, email: '');
    }

    public function render()
    {
        return view('livewire.newsletter-subscribe');
    }
}
