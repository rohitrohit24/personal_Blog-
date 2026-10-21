@extends('admin.layout.main_layout')

@section('content')
<div class="container-fluid px-0">
    <!-- Page Header -->
    <div class="custom-page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="header-content">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon">
                        <i class="fa-solid fa-gear"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">Settings</h4>
                        <p class="text-muted mb-0">Configure your blog preferences and options</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        <div class="row g-4">

            <!-- General Settings -->
            <div class="col-12 col-lg-8">
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-2 mb-4 pb-3 border-bottom">
                            <span class="rounded-3 d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:#f0f0ff;">
                                <i class="fa-solid fa-globe text-primary"></i>
                            </span>
                            <h5 class="fw-bold mb-0">General</h5>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Site Name <span class="text-danger">*</span></label>
                            <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? 'ProScript Blog' }}" required>
                            <small class="text-muted">The name of your blog shown in browser tab and header.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Site Description</label>
                            <textarea name="site_description" class="form-control" rows="2">{{ $settings['site_description'] ?? '' }}</textarea>
                            <small class="text-muted">Brief description for SEO meta tags.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Contact Email</label>
                            <input type="email" name="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? '' }}" placeholder="admin@example.com">
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-semibold">Posts Per Page</label>
                            <input type="number" name="posts_per_page" class="form-control" value="{{ $settings['posts_per_page'] ?? 10 }}" min="1" max="100" style="max-width: 120px;">
                            <small class="text-muted">How many posts to show per page on the frontend.</small>
                        </div>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-2 mb-4 pb-3 border-bottom">
                            <span class="rounded-3 d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:#f0f7ff;">
                                <i class="fa-solid fa-share-nodes text-info"></i>
                            </span>
                            <h5 class="fw-bold mb-0">Social Links</h5>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fa-brands fa-twitter me-2 text-info"></i>Twitter / X URL</label>
                            <input type="url" name="twitter_url" class="form-control" value="{{ $settings['twitter_url'] ?? '' }}" placeholder="https://twitter.com/yourusername">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fa-brands fa-github me-2"></i>GitHub URL</label>
                            <input type="url" name="github_url" class="form-control" value="{{ $settings['github_url'] ?? '' }}" placeholder="https://github.com/yourusername">
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-semibold"><i class="fa-brands fa-linkedin me-2 text-primary"></i>LinkedIn URL</label>
                            <input type="url" name="linkedin_url" class="form-control" value="{{ $settings['linkedin_url'] ?? '' }}" placeholder="https://linkedin.com/in/yourusername">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-12 col-lg-4">
                <!-- Blog Options -->
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-2 mb-4 pb-3 border-bottom">
                            <span class="rounded-3 d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:#f0fff7;">
                                <i class="fa-solid fa-sliders text-success"></i>
                            </span>
                            <h5 class="fw-bold mb-0">Blog Options</h5>
                        </div>

                        <!-- Allow Comments Toggle -->
                        <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded-3" style="background: #f8f9ff;">
                            <div>
                                <div class="fw-semibold text-dark" style="font-size: 0.9rem;">Allow Comments</div>
                                <small class="text-muted">Let readers comment on posts</small>
                            </div>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" name="allow_comments" id="allow_comments" role="switch" style="width: 2.5rem; height: 1.25rem;" {{ ($settings['allow_comments'] ?? '1') === '1' ? 'checked' : '' }}>
                            </div>
                        </div>

                        <!-- Maintenance Mode Toggle -->
                        <div class="d-flex justify-content-between align-items-center p-3 rounded-3" style="background: #fff8f0;">
                            <div>
                                <div class="fw-semibold text-dark" style="font-size: 0.9rem;">Maintenance Mode</div>
                                <small class="text-muted">Show maintenance page to visitors</small>
                            </div>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" name="maintenance_mode" id="maintenance_mode" role="switch" style="width: 2.5rem; height: 1.25rem;" {{ ($settings['maintenance_mode'] ?? '0') === '1' ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-2 mb-3 pb-3 border-bottom">
                            <span class="rounded-3 d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:#fff0f5;">
                                <i class="fa-solid fa-chart-bar text-danger"></i>
                            </span>
                            <h5 class="fw-bold mb-0">Quick Stats</h5>
                        </div>
                        @php
                            $totalPostsCount = \App\Models\Post::count();
                            $totalCatCount = \App\Models\Category::count();
                            $totalTagCount = \App\Models\Tag::count();
                            $totalComments = \App\Models\Comment::count();
                        @endphp
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Total Posts</span>
                            <span class="fw-semibold text-primary">{{ $totalPostsCount }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Categories</span>
                            <span class="fw-semibold text-success">{{ $totalCatCount }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Tags</span>
                            <span class="fw-semibold text-info">{{ $totalTagCount }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2">
                            <span class="text-muted">Comments</span>
                            <span class="fw-semibold text-warning">{{ $totalComments }}</span>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary rounded-3 py-3 fw-semibold">
                        <i class="fa-solid fa-floppy-disk me-2"></i>Save Settings
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection
