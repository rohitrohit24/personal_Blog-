<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProScript Admin Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <div class="d-flex w-100 h-100">
        <aside id="sidebar">
            <a href="{{ url('admin/dashboard') }}" class="brand-logo">
                <i class="fa-solid fa-bolt text-primary me-2"></i>
                <span>ProScript</span>
            </a>
            <nav class="mt-4 flex-grow-1">
                <a href="{{ url('admin/dashboard') }}" class="nav-link">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <a href="{{ url('/posts') }}" class="nav-link ">
                    <i class="fa-solid fa-pen-nib"></i>
                    <span class="nav-text">Posts</span>
                </a>
                <a href="{{ url('/tags') }}" class="nav-link ">
                    <i class="fa-solid fa-tags"></i>
                    <span class="nav-text">Tags</span>
                </a>
                <a href="{{ url('/categories') }}" class="nav-link ">
                    <i class="fa-solid fa-folder"></i>
                    <span class="nav-text">Categories</span>
                </a>
                <a href="{{ url('/comments') }}" class="nav-link ">
                    <i class="fa-solid fa-comments"></i>
                    <span class="nav-text">Comments</span>
                </a>
            </nav>
            <div class="mt-auto mb-4">
                <a href="{{ url('admin/settings') }}" class="nav-link ">
                    <i class="fa-solid fa-gear"></i>
                    <span class="nav-text">Settings</span>
                </a>
            </div>
            {{-- <div class="mt-auto mb-4">
                <a href="{{ url('admin/settings') }}"
                    class="nav-link {{ request()->is('admin/settings') ? 'active' : '' }}">
                    <i class="fa-solid fa-gear"></i>
                    <span class="nav-text">Settings</span>
                </a>
            </div> --}}
        </aside>

        <div id="page-content-wrapper">
            <header id="topbar">
                <div class="d-flex align-items-center">
                    <button id="menu-toggle" class="d-lg-none">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div class=" d-none d-md-block">
                        <h6 class="mb-0 fw-semibold text-light">Welcome back, {{ Auth::user()->name ?? 'Admin' }}!</h6>
                        <small class="" style="font-size: 0.75rem;">Here's what's happening today.</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-link text-light position-relative p-0 me-2">
                        <i class="fa-solid fa-bell fs-5"></i>
                        <span
                            class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"
                            style="width: 10px; height: 10px;"></span>
                    </button>
                    <div class="dropdown">
                        <a href="#"
                            class="d-flex align-items-center text-decoration-none dropdown-toggle text-light"
                            data-bs-toggle="dropdown">
                            @php
                                $avatarUrl = Auth::user()?->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name ?? 'Admin') . '&background=4f46e5&color=fff';
                            @endphp
                            <img src="{{ $avatarUrl }}" alt="Profile"
                                class="profile-img">
                            <div class="ms-2 d-none d-sm-block">
                                <span class="fw-medium d-block lh-1 small">{{ Auth::user()->name ?? 'Admin' }}</span>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><a class="dropdown-item" href="{{ route('admin.profile.edit') }}"><i
                                        class="fa-regular fa-user me-2"></i>
                                    Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="#"
                                    onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                                    <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                                </a>
                                <form id="admin-logout-form" action="{{ route('admin.profile.logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- ==================== MAIN AREA (Partials loaded here) ==================== -->
            <main id="content-area">
                <!-- Top-Right Floating Notification Container -->
                <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999; max-width: 380px;">

                    {{-- 1. Validation Errors (Red Color) --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show shadow auto-dismiss-alert d-flex align-items-start"
                            role="alert">
                            <i class="fa-solid fa-triangle-exclamation me-2 mt-1"></i>
                            <div>
                                <ul class="mb-0 ps-2" style="list-style-type: disc;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- 2. Custom Error (Red Color) --}}
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show shadow auto-dismiss-alert d-flex align-items-center"
                            role="alert">
                            <i class="fa-solid fa-circle-xmark me-2"></i>
                            <div>{{ session('error') }}</div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- 3. Success Message (Green Color) --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow auto-dismiss-alert d-flex align-items-center"
                            role="alert">
                            <i class="fa-solid fa-circle-check me-2"></i>
                            <div>{{ session('success') }}</div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- 4. Warning Message (Yellow Color) --}}
                    @if (session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show shadow auto-dismiss-alert d-flex align-items-center"
                            role="alert">
                            <i class="fa-solid fa-triangle-exclamation me-2"></i>
                            <div>{{ session('warning') }}</div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- 5. Info Message (Blue Color) --}}
                    @if (session('info'))
                        <div class="alert alert-info alert-dismissible fade show shadow auto-dismiss-alert d-flex align-items-center"
                            role="alert">
                            <i class="fa-solid fa-circle-info me-2"></i>
                            <div>{{ session('info') }}</div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                </div>

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS for Menu Toggle -->
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });
    </script>
    <!-- 5 Second Auto-Close Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.auto-dismiss-alert');
            alerts.forEach(function(alertElement) {
                setTimeout(function() {
                    // Smooth fade effect and removal
                    alertElement.classList.remove('show');
                    setTimeout(() => alertElement.remove(), 300);
                }, 5000); // 5000 ms = 5 Seconds
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
