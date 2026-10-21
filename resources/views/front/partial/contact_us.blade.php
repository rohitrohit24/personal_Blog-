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
        <div class="container-fluid px-3 px-md-4">
            <div class="col-12 w-100 d-flex flex-column justify-content-between py-4 py-md-5 px-2 px-md-4" style="min-height: 70vh;">

                {{-- 1. Top Heading --}}
                <div class="w-100 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                    <h4 class="fw-bold mt-1 font-family mb-0 display-4 display-md-2">About Me</h4>
                    <span class="text-second-colour fw-medium mb-0 lead">Say hello, pitch a collab, <br class="d-none d-sm-inline"> or subscribe below
                    </span>
                </div>

                {{-- 2. Center Me Image Card (Hi, I'm Rohit) --}}
                <div class="d-flex justify-content-center my-4 w-100">
                    <div class="text-second-back-colour p-3 p-md-4 text-center w-100 shadow-sm rounded-3" style="max-width: 500px;">
                        <img src="{{ asset('images/QVgijyaUUuFSTpcxWrWkNQvcJATzelQw6tqVQIGe.jpg') }}"
                            class="img-fluid w-100 rounded contact-profile-img" alt="Rohit Profile">
                        <h3 class="py-3 py-md-5 mb-0 text-main font-family fw-bold">Hi, I'M Rohit</h3>
                    </div>
                </div>

                {{-- 3. Bottom Text --}}
                <div class="w-100 d-flex pt-3 pt-md-4 justify-content-center">
                    <p class="text-second-colour text-center fw-medium mb-0 lead px-2 px-md-5" style="max-width: 850px;">
                        Welcome to my personal lifestyle space where I document everyday stories, aesthetic designs,
                        travel diaries, and minimal living perspectives.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="p-2 p-md-4">
        <div class="container-fluid p-3 p-md-5 mb-4 soft-white rounded-3">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">

                    <!-- Main Heading -->
                    <h1 class="fs-8 fw-bold font-family text-main mb-4 mb-md-5">
                        One note a month. <br> No spam.
                    </h1>

                    <!-- Subscribe Form (Livewire) -->
                    <livewire:newsletter-subscribe variant="contact" />

                </div>
            </div>
        </div>
    </section>
@endsection
