@extends('front.layout.view')

@section('content')
    <section id="blogs">
        <div class="container-fluid main-colour px-3 px-md-4">
            {{-- section heading --}}
            <div class="d-flex flex-wrap align-items-center justify-content-between px-2 px-md-3 mb-3 gap-2">
                <div>
                    <span class="fs-8 font-family">The Blog</span>
                </div>
                <div>
                    <a href="" class="custom-btn btn-solid category-btn"data-id="all">View All Posts</a>
                </div>
            </div>

            <!-- Categories Header Bar (Ek line mein scrollable/flex wrap) -->
            <div class="d-flex align-items-center gap-3 overflow-auto py-2 mb-2 flex-nowrap" style="white-space: nowrap;">
                <!-- Default: All Posts Button -->
                <button type="button" class="btn btn-outline btn-sm rounded-pill px-3 category-btn active" data-id="all">
                    All Posts
                </button>

                @forelse ($categories as $category)
                    @php
                        $catId = is_array($category) ? $category['id'] : $category->id;
                        $catName = is_array($category) ? $category['name'] : $category->name;
                    @endphp

                    <!-- Category Item Button -->
                    <button type="button" class="btn btn-outline btn-sm rounded-pill px-3 category-btn"
                        data-id="{{ $catId }}">
                        {{ $catName }}
                    </button>

                @empty
                    <span class="text-muted small">No categories found.</span>
                @endforelse
            </div>

            @if (isset($tags) && count($tags) > 0)
                <!-- Tags Filter Bar -->
                <div class="d-flex align-items-center gap-2 overflow-auto pb-3 mb-4 flex-nowrap"
                    style="white-space: nowrap;">
                    <span class="text-second-colour small me-1 fw-semibold"><i class="bi bi-tags me-1"></i>Tags:</span>
                    <button type="button" class="btn btn-sm rounded-pill px-3 tag-btn btn-outline active" data-id="all">
                        All Tags
                    </button>
                    @foreach ($tags as $tag)
                        <button type="button" class="btn btn-sm rounded-pill px-3 tag-btn btn-outline"
                            data-id="{{ $tag->id }}">
                            #{{ $tag->name }} <span
                                class="badge bg-secondary-subtle text-dark ms-1">{{ $tag->posts_count ?? 0 }}</span>
                        </button>
                    @endforeach
                </div>
            @endif

            <div id="posts-container" class="pb-5">
                @include('front.partial.post_list', ['posts' => $posts])
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.category-btn');
            const tagButtons = document.querySelectorAll('.tag-btn');
            const container = document.getElementById('posts-container');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            buttons.forEach(btn => {
                btn.addEventListener('click', function() {
                    buttons.forEach(b => {
                        b.classList.remove('btn-solid', 'active');
                        b.classList.add('btn-outline');
                    });
                    this.classList.remove('btn-outline');
                    this.classList.add('btn-primary', 'active');

                    const categoryId = this.getAttribute('data-id');

                    container.innerHTML = `
                        <div class="text-center py-5">
                            <div class="spinner-border text-second-colour" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    `;

                    fetch(`{{ route('post.filter') }}?category_id=${categoryId}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(res => res.text())
                        .then(html => {
                            container.innerHTML = html;
                        })
                        .catch(err => {
                            console.error(err);
                            container.innerHTML =
                                '<p class="text-danger text-center">Failed to load posts.</p>';
                        });
                });
            });

            tagButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    tagButtons.forEach(b => {
                        b.classList.remove('btn-solid', 'active');
                        b.classList.add('btn-outline');

                    });
                    this.classList.remove('btn-outline');
                    this.classList.add('btn-primary', 'active');

                    const tagId = this.getAttribute('data-id');

                    container.innerHTML = `
                        <div class="text-center py-5">
                            <div class="spinner-border text-second-colour" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    `;

                    fetch(`{{ route('post.filter') }}?tag_id=${tagId}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(res => res.text())
                        .then(html => {
                            container.innerHTML = html;
                        })
                        .catch(err => {
                            console.error(err);
                            container.innerHTML =
                                '<p class="text-danger text-center">Failed to load posts.</p>';
                        });
                });
            });

            container.addEventListener('click', async function(e) {
                const btn = e.target.closest('.like-btn');
                if (!btn) return;

                const postId = btn.getAttribute('data-post-id');
                const countSpan = btn.querySelector('.likes-count');
                const textSpan = btn.querySelector('.like-text');

                btn.disabled = true;

                try {
                    const response = await fetch(`/posts/${postId}/like`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const data = await response.json();

                    if (data.status === 'success') {
                        countSpan.innerText = data.likes_count;
                        textSpan.innerText = data.liked ? 'Liked' : 'Like';

                        if (data.liked) {
                            btn.classList.add('btn-danger', 'text-white');
                            btn.classList.remove('btn-outline-secondary');
                        } else {
                            btn.classList.add('btn-outline-secondary');
                            btn.classList.remove('btn-danger', 'text-white');
                        }
                    }
                } catch (error) {
                    console.error('Error liking post:', error);
                } finally {
                    btn.disabled = false;
                }
            });
            // Comment form submit event using Event Delegation
            container.addEventListener('submit', async function(e) {
                const form = e.target.closest('.comment-form');
                if (!form) return;

                e.preventDefault();

                const postId = form.getAttribute('data-post-id');
                const nameInput = form.querySelector('.comment-name');
                const emailInput = form.querySelector('.comment-email');
                const bodyInput = form.querySelector('.comment-body');
                const sendBtn = form.querySelector('.send-btn');

                const commentBody = bodyInput.value.trim();
                if (!commentBody) return;

                // Button disable karein double submit rokne ke liye
                sendBtn.disabled = true;

                try {
                    const response = await fetch(`/posts/${postId}/comments`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            name: nameInput ? nameInput.value.trim() : null,
                            email: emailInput ? emailInput.value.trim() : null,
                            comment_body: commentBody
                        })
                    });

                    const data = await response.json();

                    if (response.ok && data.status === 'success') {
                        // 1. Comment list me live append karna
                        const popup = form.closest('.floating-comment-popup');
                        const commentList = popup.querySelector('.comment-list');

                        const newCommentHTML = `
                <div class="border-bottom pb-1 mb-1">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-semibold text-dark" style="font-size: 12px;">${data.comment.name}</span>
                        <span class="text-muted" style="font-size: 10px;">${data.comment.time_ago}</span>
                    </div>
                    <p class="mb-0 text-secondary" style="font-size: 12px;">${data.comment.comment_body}</p>
                </div>
            `;
                        commentList.insertAdjacentHTML('beforeend', newCommentHTML);
                        commentList.scrollTop = commentList.scrollHeight; // Auto scroll to bottom

                        // 2. Card footer ka comment badge update karna
                        const card = form.closest('.card');
                        const badge = card.querySelector('.comment-count-badge');
                        if (badge) {
                            badge.innerText = data.comments_count;
                        }

                        // 3. Form input clear karna (name/email chahein toh retain rakh sakte hain)
                        bodyInput.value = '';
                    } else {
                        alert(data.message || 'Error adding comment.');
                    }
                } catch (error) {
                    console.error('Comment submission error:', error);
                    alert('Something went wrong. Please try again.');
                } finally {
                    sendBtn.disabled = false;
                }
            });
        });
    </script>
@endpush
