<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Blog Website</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/front.css') }}">
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">{{ $siteUser->name ?? 'Rohit Kumar' }}</a>

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
                    <li class="nav-item">
                        <!-- Subscribe ko highlight karne ke liye highlight class -->
                        <a class="nav-link custom-nav-link subscribe-link" href="#">Subscribe</a>
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
                    <h3 class="fw-bold mb-3">Rohit Kumar</h3>
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
                        <i class="bi bi-envelope-fill me-2 "></i> rohitverma@gmail.com
                    </p>

                    <!-- Social Icons -->
                    @if ($siteUser)
                        <div class="d-flex gap-2">
                            @if ($siteUser->social_links['portfolio'])
                                <a href="{{ $siteUser->social_links['portfolio'] }}" target="_blank"
                                    rel="noopener noreferrer"
                                    class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 38px; height: 38px;">
                                    <i class="bi bi-instagram"></i>
                                </a>
                            @endif

                            @if ($siteUser->social_links['github'])
                                <a href="{{ $siteUser->social_links['github'] }}" target="_blank"
                                    rel="noopener noreferrer"
                                    class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 38px; height: 38px;">
                                    <i class="bi bi-github"></i>
                                </a>
                            @endif

                            @if ($siteUser->social_links['twitter'])
                                <a href="{{ $siteUser->social_links['twitter'] }}" target="_blank"
                                    rel="noopener noreferrer"
                                    class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 38px; height: 38px;">
                                    <i class="bi bi-twitter"></i>
                                </a>
                            @endif

                            @if ($siteUser->social_links['linkedin'])
                                <a href="{{ $siteUser->social_links['linkedin'] }}" target="_blank"
                                    rel="noopener noreferrer"
                                    class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 38px; height: 38px;">
                                    <i class="bi bi-linkedin"></i>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Subscribe Button -->
                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-3">Stay Updated</h5>
                    <p class="small">Subscribe to receive notifications about our latest posts.</p>

                    <form action="{{ route('contact.subscriber') }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <input type="email" class="form-control rounded-5" name="email" required
                                id="email" placeholder="Enter your email address">
                        </div>
                        @error('email')
                            <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
                        @enderror
                        <button type="submit" class="custom-btn btn-outline w-100">Subscribe Now</button>
                    </form>
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
    @stack('scripts')
</body>

</html>
