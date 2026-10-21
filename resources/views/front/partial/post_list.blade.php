<div class="row g-4 align-items-stretch">
    @forelse ($posts as $post)
        <div class="col-12 col-md-6 col-lg-4 d-flex">
            <!-- Card Wrapper -->
            <div
                class="card w-100 h-100 shadow-sm light-border main-colour rounded-0 d-flex flex-column position-relative">

                <!-- 1. Top Image -->
                @if (!empty($post->image))
                    @php
                        $imgSrc = \Illuminate\Support\Str::startsWith($post->image, ['http://', 'https://'])
                            ? $post->image
                            : asset('storage/' . $post->image);
                    @endphp
                    <div class="post-card-img-wrapper">
                        <img src="{{ $imgSrc }}" class="card-img-top rounded-0 w-100 h-100"
                            style="object-fit: cover;" alt="{{ $post->title }}">
                    </div>
                @else
                    <div
                        class="bg-light d-flex align-items-center justify-content-center text-muted post-card-img-wrapper">
                        <i class="bi bi-image fs-1 text-secondary opacity-50"></i>
                    </div>
                @endif

                <!-- 2. Card Body -->
                <div class="card-body p-3 d-flex flex-column flex-grow-1">
                    <!-- Meta Info -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name ?? 'Admin') }}&background=0D8ABC&color=fff&rounded=true"
                                class="rounded-circle" width="34" height="34" alt="Author">
                            <div>
                                <h6 class="mb-0 fw-semibold small">{{ $post->user->name ?? 'Admin' }}</h6>
                                <small style="font-size: 11px;">
                                    {{ \Carbon\Carbon::parse($post->created_at)->format('M d') }} • 1 min read
                                </small>
                            </div>
                        </div>

                        <!-- 3-Dot Menu -->
                        <div class="dropdown">
                            <button class="btn btn-link text-secondary text-decoration-none fs-5 p-0 lh-1"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                &#8942;
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                <li>
                                    <a class="dropdown-item small" href="javascript:void(0)"
                                        onclick="navigator.clipboard.writeText('{{ route('blog.show', $post->id) }}'); alert('Link copied!');">
                                        Share
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Title (2 lines clamp taaki card height barabar rahe) -->
                    <h3 class="card-title fw-bold my-2 fs-5"
                        style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.8rem;"
                        title="{{ $post->title }}">
                        {{ $post->title }}
                    </h3>

                    @if (!empty($post->tags) && count($post->tags) > 0)
                        <div class="d-flex flex-wrap gap-1 mb-2">
                            @foreach ($post->tags as $t)
                                <span class="badge bg-light text-primary border" style="font-size: 11px;">
                                    #{{ $t->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <!-- Description (3 lines clamp) -->
                    <p class="card-text small fw-blod flex-grow-1 mb-3"
                        style="display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; font-size: 15px; line-height: 1.5;">
                        {{ strip_tags($post->content ?? $post->description) }}
                    </p>
                </div>

                <!-- 3. Card Footer (mt-auto se bottom me locked rahega) -->
                <div
                    class="card-footer bg-white border-top d-flex justify-content-between rounded-0 align-items-center px-3 py-2 text-muted mt-auto">
                    <div class="small d-flex align-items-center" style="font-size: 12px;">
                        <span>{{ number_format($post->views_count ?? 0) }} views</span>

                        <!-- Comment Trigger Icon -->
                        <span class="ps-3 d-inline-flex align-items-center gap-1 text-secondary" role="button"
                            data-bs-toggle="collapse" data-bs-target="#floating-comment-{{ $post->id }}"
                            aria-expanded="false" style="cursor: pointer;" title="Leave a comment">
                            <i class="bi bi-chat-square fs-6"></i>
                            <span
                                class="comment-count-badge fw-bold">{{ $post->comments->where('status', 'approved')->count() }}</span>
                        </span>
                    </div>

                    <!-- Like Button -->
                    <button type="button" class="btn btn-sm border-0 like-btn" data-post-id="{{ $post->id }}"
                        style="cursor: pointer; padding: 4px 12px;">
                        ❤️ <span class="like-text">Like</span> (<span
                            class="likes-count">{{ $post->likes_count }}</span>)
                    </button>
                </div>

                <!-- 4. Floating Comment Popup (z-index 1050 se card ke upar tairta hua) -->
                <div class="collapse floating-comment-popup shadow-lg rounded-3 border bg-white position-absolute"
                    id="floating-comment-{{ $post->id }}"
                    style="bottom: 50px; left: 10px; right: 10px; z-index: 1050;">

                    <div class="p-3">
                        <!-- Header with Close Cross Button -->
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom">
                            <span class="fw-bold text-dark small">💬 Comments</span>
                            <button type="button" class="btn-close p-0" style="font-size: 11px;"
                                data-bs-toggle="collapse" data-bs-target="#floating-comment-{{ $post->id }}"
                                title="Close"></button>
                        </div>

                        <!-- Mini Comments Feed -->
                        <!-- Mini Comments Feed -->
                        <div class="comment-list d-flex flex-column gap-2 mb-2 pe-1"
                            id="comment-list-{{ $post->id }}" style="max-height: 120px; overflow-y: auto;">

                            {{-- Post ke existing comments yahan show honge --}}
                            @forelse($post->comments->where('status', 'approved') as $cmt)
                                <div class="bg-light rounded p-2 border">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="fw-bold" style="font-size: 11px;">{{ $cmt->name }}</span>
                                        <small class="text-muted"
                                            style="font-size: 10px;">{{ $cmt->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="text-dark" style="font-size: 12px; word-break: break-word;">
                                        {{ $cmt->comment_body }}
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted no-comments-msg" style="font-size: 12px;">
                                    No comments yet. Be the first to comment!
                                </div>
                            @endforelse
                        </div>

                        <!-- Comment Form -->
                        <form class="comment-form w-100 mt-2" data-post-id="{{ $post->id }}">
                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <input type="text" class="form-control form-control-sm comment-name"
                                        placeholder="Your Name (Optional)" maxlength="100" style="font-size: 12px;">
                                </div>
                                <div class="col-6">
                                    <input type="email" class="form-control form-control-sm comment-email"
                                        placeholder="Your Email (Optional)" maxlength="255" style="font-size: 12px;">
                                </div>
                            </div>

                            <div class="input-group bg-light border rounded px-2 py-1 w-100">
                                <input type="text"
                                    class="form-control bg-transparent border-0 shadow-none comment-body"
                                    placeholder="Type a comment..." autocomplete="off" required
                                    style="font-size: 13px;">
                                <button class="btn btn-link text-primary p-0 ps-2 text-decoration-none send-btn"
                                    type="submit" title="Send Comment">
                                    <i class="bi bi-send-fill fs-6"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted">No posts available in this category.</p>
        </div>
    @endforelse
</div>
