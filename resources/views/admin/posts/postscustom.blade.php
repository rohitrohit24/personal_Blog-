<div>
    <!-- Search / Filter section agar Rappasoft ka default use karna ho toh yahan aayega -->

    <!-- Grid Layout -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
        @forelse ($rows as $row)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">

                    <!-- Post Image & Status Badge -->
                    <div class="position-relative" style="height: 190px; background-color: #f1f3f5;">
                        @if ($row->image)
                            <img src="{{ asset('storage/' . $row->image) }}" alt="{{ $row->title }}"
                                class="w-100 h-100 object-fit-cover">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                <i class="fa-solid fa-image fa-2x"></i>
                            </div>
                        @endif

                        <!-- Status Badge -->
                        <span
                            class="position-absolute top-0 end-0 m-3 badge rounded-pill {{ $row->status === 'published' ? 'bg-success' : 'bg-warning' }} px-3 py-2 shadow-sm">
                            {{ ucfirst($row->status) }}
                        </span>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-4 d-flex flex-column">

                        <!-- Category & Date -->
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-light text-primary border px-2.5 py-1 fw-medium">
                                {{ $row->category->name ?? 'Uncategorized' }}
                            </span>
                            <span class="text-muted" style="font-size: 0.85rem;">
                                {{ $row->created_at->format('d M, Y') }}
                            </span>
                        </div>

                        <!-- Post Title -->
                        <h5 class="fw-bold text-dark mb-2 text-truncate" title="{{ $row->title }}">
                            {{ $row->title }}
                        </h5>

                        <!-- Post Content Excerpt -->
                        <p class="text-muted small mb-4 flex-grow-1" style="line-height: 1.5;">
                            {{ Str::limit(strip_tags($row->content), 85) }}
                        </p>

                        <!-- Actions & ID Footer inside card -->
                        <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-auto">
                            <span class="text-muted small fw-medium">ID: #{{ $row->id }}</span>

                            <div>
                                @include('components.table-actions', [
                                    'id' => $row->id,
                                    'editTarget' => 'editPostsModal',
                                    'deleteTarget' => 'deletePostsModal',
                                    'row' => [
                                        'id' => $row->id,
                                        'title' => $row->title,
                                        'slug' => $row->slug,
                                        'category_id' => $row->category_id,
                                        'status' => $row->status,
                                        'content' => $row->content,
                                        'image' => $row->image,
                                    ],
                                ])
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="card border-0 shadow-sm p-5">
                    <div class="text-muted py-4">
                        <i class="fa-solid fa-folder-open fa-3x mb-3 text-secondary opacity-50"></i>
                        <h5 class="fw-bold text-dark">No Posts Found</h5>
                        <p class="mb-0 text-muted">Get started by creating a new post.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $rows->links() }}
    </div>
</div>
