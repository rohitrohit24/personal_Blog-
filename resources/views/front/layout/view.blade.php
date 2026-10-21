<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $siteSettings['site_name'] ?? 'Blog Website' }}</title>
    @if (!empty($siteSettings['site_description']))
        <meta name="description" content="{{ $siteSettings['site_description'] }}">
    @endif
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/front.css') }}">
    @livewireStyles
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold"
                href="{{ url('/') }}">{{ $siteSettings['site_name'] ?? ($siteUser->name ?? 'Rohit Kumar') }}</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- gap-2 se har button ke beech me space aayega -->
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-2">
                    <li class="nav-item">
                        <a class="nav-link custom-nav-link active" aria-current="page"
                            href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom-nav-link" href="{{ url('front/blog') }}">Blogs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom-nav-link" href="{{ url('front/contactus') }}">Contact</a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <livewire:newsletter-subscribe variant="navbar" />
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')
    <footer class="main-colour footer pb-3">
        <div class="container">

            <div class="row g-4 pb-5">

                <!--  Website Name & Intro -->
                <div class="col-lg-3 col-md-6">
                    <h3 class="fw-bold mb-3">{{ $siteSettings['site_name'] ?? 'Rohit Kumar' }}</h3>
                    @if (!empty($siteSettings['site_description']))
                        <p class="small text-white-50">{{ $siteSettings['site_description'] }}</p>
                    @endif
                </div>

                <!-- Navlinks -->
                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Blogs</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">About Us</a>
                        </li>
                        <li class="mb-2"><a href="#" class=" text-white text-decoration-none">Contact</a></li>
                    </ul>
                </div>

                <!-- Details -->
                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-3">Contact Info</h5>
                    <p class="small mb-2">
                        Feel free to reach out to us for any queries or collaborations:
                    </p>
                    <p class="small mb-1">
                        <i class="bi bi-telephone-fill me-2 "></i> +91 80940 24015
                    </p>
                    <p class="small mb-3">
                        <i class="bi bi-envelope-fill me-2 "></i>
                        {{ !empty($siteSettings['contact_email']) ? $siteSettings['contact_email'] : 'rohitverma@gmail.com' }}
                    </p>

                    <!-- Social Icons -->
                    <div class="d-flex gap-2">
                        @php
                            $githubUrl = !empty($siteSettings['github_url'])
                                ? $siteSettings['github_url']
                                : $siteUser->social_links['github'] ?? null;
                            $twitterUrl = !empty($siteSettings['twitter_url'])
                                ? $siteSettings['twitter_url']
                                : $siteUser->social_links['twitter'] ?? null;
                            $linkedinUrl = !empty($siteSettings['linkedin_url'])
                                ? $siteSettings['linkedin_url']
                                : $siteUser->social_links['linkedin'] ?? null;
                        @endphp

                        @if ($githubUrl)
                            <a href="{{ $githubUrl }}" target="_blank" rel="noopener noreferrer"
                                class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 38px; height: 38px;">
                                <i class="bi bi-github"></i>
                            </a>
                        @endif

                        @if ($twitterUrl)
                            <a href="{{ $twitterUrl }}" target="_blank" rel="noopener noreferrer"
                                class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 38px; height: 38px;">
                                <i class="bi bi-twitter"></i>
                            </a>
                        @endif

                        @if ($linkedinUrl)
                            <a href="{{ $linkedinUrl }}" target="_blank" rel="noopener noreferrer"
                                class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 38px; height: 38px;">
                                <i class="bi bi-linkedin"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Subscribe Button -->
                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-3">Stay Updated</h5>
                    <p class="small">Subscribe to receive notifications about our latest posts.</p>
                    <livewire:newsletter-subscribe variant="footer" />
                </div>

            </div>

            <div class="row align-items-end gy-3 text-center text-md-start">

                <div class="col-12 col-md-6">
                    <h2 class="font-family fs-8 fw-bold mb-0">Life, Style by Rohit</h2>
                </div>

                <div class="col-12 col-md-3 pb-3 text-md-end small">
                    <a href="#" class="text-decoration-underline  text-white me-3">Privacy Policy</a>
                    <a href="#" class="text-decoration-underline text-white me-3">Terms of Use</a>
                </div>

                <div class="col-12 col-md-3 pb-3 text-md-center small">
                    &copy; 2026 Rohit. All rights reserved.
                </div>

            </div>

        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
    @livewireScripts
    @stack('scripts')
</body>

</html>
