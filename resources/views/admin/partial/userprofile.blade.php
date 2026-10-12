@extends('admin.layout.main_layout')

@section('content')
    <div class="container-fluid px-0">

        <!-- Page Header (Only header base custom class, rest 100% Bootstrap 5) -->
        <div class="custom-page-header d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
            <div class="d-flex align-items-center gap-3">
                <div class="header-icon">
                    <i class="fa-solid fa-user-gear"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-dark">Admin Profile & Settings</h4>
                    <small class="text-muted">Manage your personal author information, credentials and blog defaults</small>
                </div>
            </div>
            <div>
                <button type="submit" form="profileForm" class="btn btn-warning text-dark fw-bold px-4 shadow-sm">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Save All Changes
                </button>
            </div>
        </div>

        <!-- Main Settings Form -->
        <form id="profileForm" action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-4">

                <!-- ================= LEFT CARD: Profile, Bio & Social Links ================= -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">

                        <div class="d-flex align-items-center gap-2 mb-4 pb-2 border-bottom">
                            <i class="fa-solid fa-id-badge text-warning fs-5"></i>
                            <h5 class="fw-bold mb-0 text-dark">Author & Public Profile</h5>
                        </div>

                        <!-- Avatar Upload Section -->
                        <div class="d-flex flex-column align-items-center text-center mb-4">
                            <div class="position-relative avatar-circle mb-3">
                                <img id="avatarPreview"
                                    src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0f172a&color=dada0f' }}"
                                    alt="Avatar" class="avatar-preview-img rounded-circle shadow">

                                <label for="avatarInput"
                                    class="btn btn-dark text-warning btn-sm position-absolute bottom-0 end-0 rounded-circle shadow-sm d-flex align-items-center justify-content-center p-0"
                                    style="width: 36px; height: 36px; cursor: pointer;">
                                    <i class="fa-solid fa-camera"></i>
                                </label>
                                <input type="file" id="avatarInput" name="avatar" class="d-none" accept="image/*"
                                    onchange="previewImage(event)">
                            </div>
                            <span class="small text-muted">Allowed formats: JPG, PNG, WEBP (Max: 2MB)</span>
                        </div>

                        <!-- Social Links (Pure Bootstrap Input Groups) -->
                        <div class="mb-4 p-3 rounded-3 bg-light border">
                            <h6 class="fw-bold text-dark mb-3">
                                <i class="fa-solid fa-share-nodes me-2 text-warning"></i>Social Profiles
                            </h6>

                            <div class="input-group mb-2 shadow-sm">
                                <span class="input-group-text bg-white text-dark border-end-0"><i
                                        class="fa-brands fa-github"></i></span>
                                <input type="url" name="github_url" value="{{ $user->social_links['github'] ?? '' }}"
                                    class="form-control border-0">
                            </div>

                            <div class="input-group mb-2 shadow-sm">
                                <span class="input-group-text bg-white text-primary border-end-0"><i
                                        class="fa-brands fa-linkedin"></i></span>
                                <input type="url" name="linkedin_url"
                                    value="{{ $user->social_links['linkedin'] ?? '' }}" class="form-control border-0">
                                {{-- <input type="url" name="linkedin_url" class="form-control border-start-0"
                                    placeholder="https://linkedin.com/in/username"> --}}
                            </div>

                            <div class="input-group mb-2 shadow-sm">
                                <span class="input-group-text bg-white text-dark border-end-0"><i
                                        class="fa-brands fa-x-twitter"></i></span>
                                <input type="url" name="twitter_url" value="{{ $user->social_links['twitter'] ?? '' }}"
                                    class="form-control border-0">
                                {{-- <input type="url" name="twitter_url" class="form-control border-start-0"
                                    placeholder="https://x.com/username"> --}}
                            </div>

                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-white text-success border-end-0"><i
                                        class="fa-solid fa-globe"></i></span>
                                <input type="url" name="portfolio_url"
                                    value="{{ $user->social_links['portfolio'] ?? '' }}" class="form-control border-0">
                                {{-- <input type="url" name="portfolio_url" class="form-control border-start-0"
                                    placeholder="https://yourportfolio.com"> --}}
                            </div>
                        </div>

                        <!-- Author Details Inputs -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Display Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $user->name ?? '' }}"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Designation / Tagline</label>
                                <input type="text" name="tagline" class="form-control" value="{{ $user->tagline ?? '' }}"
                                    placeholder="Full Stack Developer & Blogger">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark">Author Bio (About)</label>
                                <textarea name="bio" class="form-control" rows="4">{{ old('bio', $user->bio ?? '') }}</textarea>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ================= RIGHT CARD: Security, Forgot Password & Site Details ================= -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">

                        <!-- Account & Security Section -->
                        <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-shield-halved text-warning fs-5"></i>
                                <h5 class="fw-bold mb-0 text-dark">Security & Credentials</h5>
                            </div>
                            <a href="#" class="small text-decoration-none fw-semibold link-primary">
                                <i class="fa-solid fa-key me-1"></i>Forgot Password?
                            </a>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark">Admin Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i
                                            class="fa-regular fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control border-start-0"
                                        value="{{ $user->email ?? '' }}" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark">Current Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i
                                            class="fa-solid fa-lock"></i></span>
                                    <input type="password" name="current_password" id="current_password"
                                        class="form-control border-start-0" placeholder="••••••••">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">New Password</label>
                                <input type="password" name="new_password" id="new_password" class="form-control"
                                    placeholder="New password">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Confirm Password</label>
                                <input type="password" name="new_password_confirmation" class="form-control"
                                    placeholder="Confirm password">
                            </div>
                        </div>

                        <!-- Site Preferences & Defaults -->
                        <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                            <i class="fa-solid fa-sliders text-warning fs-5"></i>
                            <h5 class="fw-bold mb-0 text-dark">Site Preferences</h5>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Default Post Status</label>
                                <select name="default_post_status" class="form-select">
                                    <option value="draft" {{ $user->default_post_status == 'draft' ? 'selected' : '' }}>
                                        Draft</option>
                                    <option value="published"
                                        {{ $user->default_post_status == 'published' ? 'selected' : '' }}>Published
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Comments Moderation</label>
                                <select name="comment_moderation" class="form-select">
                                    <option value="manual" selected>Manual Approval Required</option>
                                    <option value="auto">Auto-Approve Comments</option>
                                </select>
                            </div>

                            <div class="col-12 mt-4 pt-2">
                                <div
                                    class="p-3 rounded-3 bg-light border d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark">Email Alerts on New Comments</h6>
                                        <small class="text-muted">Receive an instant notification when someone leaves a
                                            comment</small>
                                    </div>
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input fs-5" type="checkbox" name="email_notifications"
                                            id="notifySwitch" {{ $user->email_notifications ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </form>
    </div>

    <!-- Image Preview Script -->
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('avatarPreview');
                output.src = reader.result;
            };
            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    </script>
@endsection
