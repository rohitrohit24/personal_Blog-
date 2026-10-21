@extends('admin.layout.main_layout')

@section('content')
    <div class="container-fluid px-0">
        <!-- Stats Row -->
        <div class="row g-4 mb-4">
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card-stat">
                    <div>
                        <p class="fw-bold mb-1 fs-6">Total Posts</p>
                        <h3 class="mb-0 fw-bold">{{ $totalPosts }}</h3>
                    </div>
                    <div class="icon-box text-primary">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card-stat">
                    <div>
                        <p class="fw-bold mb-1 fs-6">Categories</p>
                        <h3 class="mb-0 fw-bold">{{ $categories }}</h3>
                    </div>
                    <div class="icon-box text-success">
                        <i class="fa-solid fa-table-cells-large"></i>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card-stat">
                    <div>
                        <p class="fw-bold mb-1 fs-6">Draft Posts</p>
                        <h3 class="mb-0 fw-bold">{{ $draftPosts }}</h3>
                    </div>
                    <div class="icon-box text-warning">
                        <i class="fa-solid fa-file-pen"></i>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card-stat">
                    <div>
                        <p class="fw-bold mb-1 fs-6">Published Posts</p>
                        <h3 class="mb-0 fw-bold">{{ $publishedPosts }}</h3>
                    </div>
                    <div class="icon-box text-danger">
                        <i class="fa-solid fa-upload"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <!-- Recent Posts -->
            <div class="col-12 col-lg-8">
                <div class="card card-custom border-0 shadow-sm rounded-3">
                    <div class="card-body p-3 p-sm-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0">Recent Posts</h5>
                            <a href="{{ route('posts.index') }}" class="btn btn-sm btn-primary px-3 rounded-pill">View
                                All</a>
                        </div>

                        <div class="table-responsive custom-scroll" style="height: 450px; overflow-y: auto;">
                            <table class="table table-hover align-middle mb-0">
                                <thead
                                    style="position: sticky; top: 0; background-color: #fff; z-index: 2; box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.05);">
                                    <tr class="table-light">
                                        <th class="py-3 px-4 border-0">Title</th>
                                        <th class="py-3 px-4 border-0">Category</th>
                                        <th class="py-3 px-4 border-0">Status</th>
                                        <th class="py-3 px-4 border-0 text-end">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recentPosts as $post)
                                        <tr>
                                            <td class="py-3 px-4 fw-medium text-dark">{{ $post->title }}</td>
                                            <td class="py-3 px-4 text-muted">{{ $post->category->name ?? 'Uncategorized' }}
                                            </td>
                                            <td class="py-3 px-4">
                                                <span
                                                    class="badge rounded-pill {{ $post->status === 'published' ? 'bg-success' : 'bg-warning' }} px-3 py-2 fw-medium">
                                                    {{ ucfirst($post->status) }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 text-end text-muted">
                                                {{ $post->created_at ? $post->created_at->format('M d') : '' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5 text-muted">
                                                <i class="fa-regular fa-folder-open fs-3 mb-2 d-block"></i>
                                                No recent posts found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Comments -->
            <div class="col-12 col-lg-4">
                <div class="card card-custom border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="fw-bold mb-0">Recent Comments</h5>
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1">
                                {{ count($recentComments) }}
                            </span>
                        </div>

                        <div class="custom-scroll pe-2 d-flex flex-column gap-3" style="height: 450px; overflow-y: auto;">
                            @forelse ($recentComments as $comment)
                                <div class="d-flex align-items-start pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                    <div class="flex-shrink-0">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->name ?? 'User') }}&background=e9ecef&color=495057"
                                            class="rounded-circle shadow-sm" width="40" height="40"
                                            alt="{{ $comment->name }}">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <h6 class="mb-0 fw-semibold text-dark" style="font-size: 0.95rem;">
                                                {{ $comment->name }}
                                            </h6>
                                            <small class="text-muted" style="font-size: 0.75rem;">
                                                {{ $comment->created_at ? $comment->created_at->diffForHumans() : '' }}
                                            </small>
                                        </div>
                                        <p class="text-muted small mb-0 line-clamp-2" style="line-height: 1.4;">
                                            {{ $comment->comment_body }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted my-auto py-5">
                                    <i class="fa-regular fa-comment-dots fs-3 mb-2 d-block"></i>
                                    <span class="small">No comments yet.</span>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
