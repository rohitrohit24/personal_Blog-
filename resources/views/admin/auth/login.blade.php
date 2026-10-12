<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap");

        :root {
            --primary: #4f46e5;
            --on-primary: #ffffff;
            --background: #0f172a;
            --surface: #ffffffe3;
            --surface-low: #e9e9e2e2;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --text-light: #f1f5f9;
            --border-color: #e2e8f0;
            --success: #10b981;
            --warning: #dada0f;
            --danger: #ef4444;
        }

        body {
            font-family: "Inter", sans-serif;
            background-color: var(--background);
            color: var(--text-light);
        }

        /* Project color overrides */
        .bg-surface {
            background-color: var(--surface) !important;
        }

        .bg-surface-low {
            background-color: var(--surface-low) !important;
        }

        .bg-warning-custom {
            background-color: var(--warning) !important;
        }

        .text-main {
            color: var(--text-main) !important;
        }

        .text-warning-custom {
            color: var(--warning) !important;
        }

        .border-top-warning {
            border-top: 5px solid var(--warning) !important;
        }

        /* Focus & Button State */
        .form-control:focus {
            border-color: var(--warning);
            box-shadow: 0 0 0 0.25rem rgba(218, 218, 15, 0.25);
        }

        .btn-warning-custom {
            background-color: var(--warning);
            color: var(--background);
            font-weight: 700;
            border: none;
            transition: all 0.2s;
        }

        .btn-warning-custom:hover {
            filter: brightness(0.95);
            color: var(--background);
        }

        .form-check-input:checked {
            background-color: var(--warning);
            border-color: var(--warning);
        }
    </style>
</head>

<body class="min-vh-100 d-flex align-items-center justify-content-center p-3">

    <div class="card bg-surface text-main shadow-lg border-0 border-top-warning rounded-4 w-100"
        style="max-width: 420px;">
        <!-- Header -->
        <div class="card-body p-4 p-sm-5 pb-sm-4 text-center">
            <div class="d-inline-flex align-items-center justify-content-center rounded-3 bg-dark text-warning-custom mb-3 shadow-sm"
                style="width: 54px; height: 54px; font-size: 1.5rem;">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h3 class="fw-bold text-main mb-1">Admin Login</h3>
            <p class="text-secondary small mb-4">Enter your credentials to continue</p>

            <!-- Login Form -->
            <form action="{{ route('admin.auth') }}" method="POST" class="text-start">
                @csrf
                <div class="mb-3">
                    <label for="adminEmail" class="form-label small fw-semibold text-main mb-1">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-secondary">
                            <i class="fa-regular fa-envelope"></i>
                        </span>
                        <input type="email" class="form-control border-start-0 ps-0" id="email" name="email"
                            placeholder="admin@example.com" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="adminPassword" class="form-label small fw-semibold text-main mb-1">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-secondary">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" class="form-control border-start-0 border-end-0 ps-0" id="Password"
                            name="password" placeholder="••••••••" required>
                        <button class="btn btn-outline-secondary border-start-0 bg-white" type="button"
                            id="togglePasswordBtn">
                            <i class="fa-regular fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input shadow-none" type="checkbox" id="rememberMe">
                        <label class="form-check-label small text-secondary" for="rememberMe">Remember me</label>
                    </div>
                    <a href="#" class="small text-secondary text-decoration-none">Forgot password?</a>
                </div>

                <button type="submit"
                    class="btn btn-warning-custom w-100 py-2 rounded-3 text-uppercase d-flex align-items-center justify-content-center gap-2">
                    <span>Sign In</span>
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="card-footer bg-surface-low text-center py-3 border-0 rounded-bottom-4">
            <span class="small text-secondary">Protected Admin Zone &bull; <a href="#"
                    class="text-main fw-semibold text-decoration-none">Support</a></span>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Password Toggle Script -->
    <script>
        const toggleBtn = document.getElementById('togglePasswordBtn');
        const passwordInput = document.getElementById('Password');
        const toggleIcon = document.getElementById('toggleIcon');

        toggleBtn.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            toggleIcon.classList.toggle('fa-eye');
            toggleIcon.classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>
