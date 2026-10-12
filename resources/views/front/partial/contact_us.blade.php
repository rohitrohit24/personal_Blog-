@extends('front.layout.view')

@section('content')
    {{-- @if (session('success'))
        <div class="p-3 mb-4 text-green-800 bg-green-100 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="p-3 mb-4 text-red-800 bg-red-100 rounded">
            {{ session('error') }}
        </div>
    @endif --}}
    <section id="about_me" class="main-colour mb-4">
        <div class="container-fluid px-4">
            <div class="col-12 w-100 d-flex flex-column justify-content-between py-5 px-3 px-md-5" style="min-height: 80vh;">

                {{-- 1. Top Heading --}}
                <div class="w-100 d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold mt-1 font-family mb-0 display-2">About Me</h4>
                    <span class="text-second-colour fw-medium mb-0 lead">Say hello, pitch a collab, <br> or subscribe below
                    </span>

                </div>

                {{-- 2. Center Me Image Card (Hi, I'm Rohit) --}}
                <div class="d-flex justify-content-center my-4 w-100">
                    <div class="text-second-back-colour p-4 text-center w-100 shadow-sm" style="max-width: 500px;">
                        <img src="{{ asset('images/QVgijyaUUuFSTpcxWrWkNQvcJATzelQw6tqVQIGe.jpg') }}"
                            class="img-fluid w-100 rounded"
                            style="height: 520px; object-fit: cover; object-position: center;" alt="Rohit Profile">
                        <h3 class="py-5  mb-0 text-main font-family fw-bold">Hi, I'M Rohit</h3>
                    </div>
                </div>

                {{-- 3. Bottom Text --}}
                <div class="w-100 d-flex pt-4 justify-content-center">
                    <p class="text-second-colour text-center fw-medium mb-0 lead px-md-5" style="max-width: 850px;">
                        Welcome to my personal lifestyle space where I document everyday stories, aesthetic designs,
                        travel diaries, and minimal living perspectives.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="p-4">
        <div class="container-fluid p-4 mb-4 soft-white">
            <div class="row justify-content-center">
                <div class="">

                    <!-- Main Heading (display-1) -->
                    <h1 class="fs-8 fw-bold font-family text-main mb-5">
                        One note a month. <br> No spam.
                    </h1>

                    <!-- Subscribe Form -->
                    <form action="{{ route('contact.subscriber') }}" method="POST">
                        @csrf
                        <!-- Email Input -->
                        <div class="mb-3">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                id="email" placeholder="Enter your email address" required>
                            @error('email')
                                <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="consent" id="newsletterConsent" required>
                            <label class="form-check-label text-muted user-select-none" for="newsletterConsent"
                                style="cursor: pointer;">
                                Yes, I want to subscribe to your newsletter.
                            </label>
                        </div>

                        <!-- Submit Button -->

                        <button type="submit" class="btn main-colour w-100 text-uppercase fw-semibold py-2">
                            Subscribe
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </section>
@endsection
