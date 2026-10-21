<?php

use App\Livewire\NewsletterSubscribe;
use App\Models\Subscribers;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

it('renders all variants of newsletter subscribe', function (string $variant) {
    Livewire::test(NewsletterSubscribe::class, ['variant' => $variant])
        ->assertStatus(200);
})->with(['navbar', 'hero', 'footer', 'contact', 'box']);

it('can subscribe a new email', function () {
    $email = 'tester@example.com';
    Subscribers::where('email', $email)->delete();

    Livewire::test(NewsletterSubscribe::class, ['variant' => 'box'])
        ->set('email', $email)
        ->call('subscribe')
        ->assertSet('isSubscribed', true)
        ->assertDispatched('subscriber-status-changed');

    expect(Subscribers::where('email', $email)->where('is_active', true)->exists())->toBeTrue();

    // Clean up
    Subscribers::where('email', $email)->delete();
});

it('can unsubscribe an active email', function () {
    $email = 'unsub-test@example.com';
    $subscriber = Subscribers::create([
        'email' => $email,
        'token' => 'dummy-token-1234',
        'is_active' => true,
    ]);

    Livewire::test(NewsletterSubscribe::class, ['variant' => 'navbar'])
        ->set('email', $email)
        ->set('isSubscribed', true)
        ->call('unsubscribe')
        ->assertSet('isSubscribed', false)
        ->assertDispatched('subscriber-status-changed');

    expect($subscriber->fresh()->is_active)->toBeFalse();

    // Clean up
    $subscriber->delete();
});

it('can unsubscribe via token route', function () {
    $email = 'route-test@example.com';
    $subscriber = Subscribers::create([
        'email' => $email,
        'token' => 'token-abc-xyz',
        'is_active' => true,
    ]);

    $response = $this->get(route('unsubscribe', 'token-abc-xyz'));
    $response->assertRedirect(route('home'));
    $response->assertSessionHas('success');

    expect($subscriber->fresh()->is_active)->toBeFalse();

    // Clean up
    $subscriber->delete();
});

it('renders home, blog, and contact pages successfully with livewire', function (string $url) {
    $response = $this->get($url);
    $response->assertStatus(200);
    $response->assertSeeLivewire(NewsletterSubscribe::class);
})->with(['/', '/front/blog', '/front/contactus']);



