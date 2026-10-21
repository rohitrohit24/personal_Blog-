@extends('front.layout.view')

@section('content')
    @if (session('success'))
        <div class="p-3 mb-4 text-green-800 bg-green-100 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="p-3 mb-4 text-red-800 bg-red-100 rounded">
            {{ session('error') }}
        </div>
    @endif
    <section id="hero">
        <div class="container-fluid main-colour text-center hero-images pb-4">
            <div class="hero-image-wrapper">

                <!-- Left Image -->
                <div class="hero-left-image">
                    <img src="{{ asset('images/QVgijyaUUuFSTpcxWrWkNQvcJATzelQw6tqVQIGe.jpg') }}" alt="Hero Image Left">
                </div>

                <!-- Center Main Image -->
                <div class="hero-main-container">
                    <img src="{{ asset('images/QVgijyaUUuFSTpcxWrWkNQvcJATzelQw6tqVQIGe.jpg') }}" class="hero-image"
                        alt="Hero Main Image">
                </div>

                <!-- Right Image -->
                <div class="hero-right-image">
                    <img src="{{ asset('images/QVgijyaUUuFSTpcxWrWkNQvcJATzelQw6tqVQIGe.jpg') }}" alt="Hero Image Right">
                </div>

            </div>
            <h1 class="hero-heading">
                <span class="bg-box">Life, Style.</span>
            </h1>
            <div class="d-flex flex-wrap justify-content-center align-items-center gap-2 mb-2">
                {{-- <a href="#" class="custom-btn btn-solid">Read More</a> --}}
                <livewire:newsletter-subscribe variant="hero" />
            </div>
        </div>
    </section>
    <section id="posts">
        <div class="container-fluid px-3 pt-3">
            {{-- section heading --}}
            <div class="d-flex flex-wrap align-items-center justify-content-between px-2 px-md-3 mb-3 gap-2">
                <div>
                    <span class="fs-8 font-family text-main">Latest Posts</span>
                </div>
                <div>
                    <a href="{{ route('front.blog') }}" class="custom-btn btn-outline-main-colour">View All Posts</a>
                </div>
            </div>

            <div class="row py-3 py-md-5 g-3 g-md-4">
                @forelse ($recentPosts as $post)
                    <div class="col-12 col-md-6 col-lg-4 d-flex">
                        <div class="latest-posts-image card rounded-0 border-0 shadow-sm overflow-hidden w-100">

                            {{-- Agar dynamic image field hai toh $post->image use karein --}}
                            <img src="{{ $post->image ?? asset('images/QVgijyaUUuFSTpcxWrWkNQvcJATzelQw6tqVQIGe.jpg') }}"
                                alt="{{ $post->title ?? 'Post Image' }}" class="img-fluid w-100 latest-posts-card-img">

                            <div class="p-3 py-4 bg-white flex-grow-1 d-flex flex-column">
                                <span class="fs-small mb-1">
                                    {{ $post->created_at ? $post->created_at->format('M d') : 'Feb 6' }}
                                </span>

                                <h4 class="my-2">
                                    {{ $post->title ?? 'I Am Fohit Kumar' }}
                                </h4>

                                <p class="mb-0">
                                    {{ \Illuminate\Support\Str::limit($post->content ?? 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quae sapiente deserunt ducimus dolorum optio.', 120) }}
                                </p>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-4">
                        <p class="text-muted mb-0">No posts found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <section id="about-me">
        <div class="container-fluid px-4 ">
            <div class="row py-5 g-4 align-items-stretch">

                {{-- Left Column: Reference Image --}}
                <div class="col-md-6">
                    <div class="card rounded-0 border-0 shadow-sm overflow-hidden h-100">
                        <img src="{{ asset('images/QVgijyaUUuFSTpcxWrWkNQvcJATzelQw6tqVQIGe.jpg') }}"
                            alt="Featured Left Image" class="img-fluid w-100 about-featured-img">
                    </div>
                </div>

                {{-- Right Column: Top Heading, Center Image, Bottom Text --}}
                <div class="col-md-6 d-flex flex-column justify-content-between">

                    {{-- 1. Top Heading (Left Image ke top ke barabar) --}}
                    <div class="w-100">
                        <span class="text-uppercase tracking-wider small text-muted">About The Author</span>
                        <h4 class="fw-bold mt-1 font-family mb-0 display-6">About Me</h4>
                    </div>

                    {{-- 2. Center Me Image Card (Hi, I'm Rohit) --}}
                    <div class="d-flex justify-content-center my-3">
                        <div class="col-md-7 main-colour p-3 text-center w-100" style="max-width: 320px;">
                            <img src="{{ asset('images/QVgijyaUUuFSTpcxWrWkNQvcJATzelQw6tqVQIGe.jpg') }}"
                                class="img-fluid w-100 author-profile-img" alt="Rohit Profile">
                            <h4 class="py-5 mb-0 font-family fw-bold">Hi, I'M Rohit</h4>
                        </div>
                    </div>

                    {{-- 3. Bottom Text (Left Image ke bottom ke barabar) --}}
                    <div class="w-100">
                        <p class="text-muted text-center fw-bold mb-0">
                            Welcome to my personal lifestyle space where I document everyday stories, aesthetic designs,
                            travel diaries, and minimal living perspectives.
                        </p>
                    </div>

                </div>

            </div>
        </div>
    </section>
    <section id="subscribe" class="position-relative overflow-hidden py-5"
        style="min-height: 550px; background: url('https://static.wixstatic.com/media/c837a6_ea71dc0d75734ba08a43e9cc48ff15b3~mv2.jpg/v1/fill/w_960,h_779,fp_0.50_0.50,q_85,usm_0.66_1.00_0.01,enc_auto/blog_Seedream%20V5%20Edit_2026-03-06_12-34-18%201.jpg') center/cover no-repeat;">
        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-50"></div>

        <!-- Main Container -->
        <div class="container position-relative h-100 d-flex flex-column justify-content-between py-4 py-md-5 text-white">

            <!-- 1. Top Heading -->
            <div class="row pt-2 pt-md-4">
                <div class="d-flex align-items-center px-2 px-md-3 mb-3">
                    <div>
                        <span class="fs-8 font-family text-main">Subscribe</span>
                    </div>
                </div>
            </div>

            <!-- 2. Left Bottom Box -->
            <div class="row pb-2 pb-md-4">
                <div class="col-12 col-md-8 col-lg-5">
                    <div class="text-second-back-colour text-main shadow-lg border-0 p-3 p-md-4 d-flex flex-column justify-content-center rounded-3"
                        style="min-height: 250px;">

                        <h5 class="fw-bold mb-2">Subscribe / Contact Us</h5>
                        <p class="text-main small mb-3">Apna email dalein, hum aapse jald hi contact karenge.</p>

                        <livewire:newsletter-subscribe variant="box" />

                    </div>
                </div>
            </div>

        </div>
    </section>
    <section id="archive">
        <div class="container py-5">
            {{-- section heading --}}
            <div class="d-flex flex-wrap align-items-center justify-content-between px-2 px-md-3 mb-3 gap-2">
                <div>
                    <span class="fs-8 font-family text-main">From The Archive</span>
                </div>
                <div>
                    <a href="{{ route('front.blog') }}" class="custom-btn btn-outline-main-colour">View All Posts</a>
                </div>
            </div>

            <div class="row g-4 g-lg-5 py-2">
                @forelse ($recentPosts as $post)
                    <div class="col-12">
                        <div class="card rounded-0 border-0 bg-transparent overflow-hidden w-100">
                            <div class="row archive-card g-0 align-items-center">

                                <div class="col-md-5 col-lg-4">
                                    <img src="{{ $post->image ?? asset('images/QVgijyaUUuFSTpcxWrWkNQvcJATzelQw6tqVQIGe.jpg') }}"
                                        alt="{{ $post->title ?? 'Post Image' }}" class="img-fluid w-100 archive-card-img">
                                </div>

                                <div class="col-md-7 col-lg-8">
                                    <div
                                        class="card-body bg-transparent p-3 p-md-4 p-lg-5 d-flex flex-column justify-content-center">
                                        <span class="fs-small mb-2">
                                            {{ $post->created_at ? $post->created_at->format('M d, Y') : 'Feb 6, 2026' }}
                                        </span>

                                        <h3 class="card-title fw-bold my-3">
                                            {{ $post->title ?? 'I Am Rohit Kumar' }}
                                        </h3>

                                        <p class="card-text mb-3 lh-base" style="text-align: justify;">
                                            {{ \Illuminate\Support\Str::limit($post->content ?? 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quae sapiente deserunt ducimus dolorum optio.', 320) }}
                                        </p>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-4">
                        <p class="text-muted mb-0">No posts found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
