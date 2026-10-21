@extends('admin.layout.main_layout')

@section('content')
    <div class="container-fluid px-0">
        <div class="custom-page-header mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-content">
                    <div class="d-flex align-items-center gap-3">
                        <div class="header-icon">
                            <i class="fa-solid fa-file-lines"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1">Posts Management</h4>
                            <p class="text-muted mb-0">Create, edit, and organize your blog posts</p>
                        </div>
                    </div>
                </div>
                <div class="header-action">
                    <x-button.modal-trigger target="createPostModal" text="Add Post" color="primary" icon="plus"
                        class="shadow-sm px-4 py-2"></x-button.modal-trigger>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body p-4">
                <livewire:posts-table />
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <x-modal id="createPostModal" title="Add New Post" action="{{ route('posts.store') }}" width="800px" method="POST">
        <div class="row">
            <div class="col-md-6">
                <x-form.input type="text" id="title" name="title" label="Post Title"
                    placeholder="e.g. My First Post" required="true" />
            </div>
            <div class="col-md-6">
                <x-form.input type="text" id="slug" name="slug" label="URL Slug"
                    placeholder="Auto-generated based on title" readonly="true" />
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select" required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-3">
                <label class="form-label fw-semibold">Tags</label>
                <div class="d-flex flex-wrap gap-2 border rounded p-3 bg-light" style="max-height: 120px; overflow-y: auto;">
                    @forelse ($tags as $tag)
                        <div class="form-check me-3">
                            <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}" id="create_tag_{{ $tag->id }}">
                            <label class="form-check-label user-select-none" for="create_tag_{{ $tag->id }}">
                                <i class="fa-solid fa-tag me-1 text-primary"></i>{{ $tag->name }}
                            </label>
                        </div>
                    @empty
                        <small class="text-muted">No tags created yet.</small>
                    @endforelse
                </div>
            </div>
        </div>

        <x-form.input type="text" id="image" name="image" label="Image URL"
            placeholder="https://example.com/image.jpg" />

        <x-form.textarea id="content" name="content" label="Content" placeholder="Write your post content here..."
            rows="6" />

        <x-slot name="buttons">
            <x-button.simple type="button" text="Cancel" color="light" data-bs-dismiss="modal" />
            <x-button.simple type="submit" text="Save Post" color="primary" icon="save" />
        </x-slot>
    </x-modal>

    <!-- Edit Modal -->
    <x-modal id="editPostsModal" title="Edit Post" action="#" width="800px" method="PUT">
        <input type="hidden" id="edit_id" name="id">

        <div class="row">
            <div class="col-md-6">
                <x-form.input type="text" id="edit_title" name="title" label="Post Title" required="true" />
            </div>
            <div class="col-md-6">
                <x-form.input type="text" id="edit_slug" name="slug" label="URL Slug" />
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" id="edit_category_id" class="form-select" required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Status</label>
                <select name="status" id="edit_status" class="form-select" required>
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-3">
                <label class="form-label fw-semibold">Tags</label>
                <div class="d-flex flex-wrap gap-2 border rounded p-3 bg-light" style="max-height: 120px; overflow-y: auto;">
                    @forelse ($tags as $tag)
                        <div class="form-check me-3">
                            <input class="form-check-input edit-tag-checkbox" type="checkbox" name="tags[]" value="{{ $tag->id }}" id="edit_tag_{{ $tag->id }}">
                            <label class="form-check-label user-select-none" for="edit_tag_{{ $tag->id }}">
                                <i class="fa-solid fa-tag me-1 text-primary"></i>{{ $tag->name }}
                            </label>
                        </div>
                    @empty
                        <small class="text-muted">No tags created yet.</small>
                    @endforelse
                </div>
            </div>
        </div>

        <x-form.input type="text" id="edit_image" name="image" label="Image URL" />

        <x-form.textarea id="edit_content" name="content" label="Content" rows="6" />

        <x-slot name="buttons">
            <x-button.simple type="button" text="Cancel" color="light" data-bs-dismiss="modal" />
            <x-button.simple type="submit" text="Update Post" color="primary" icon="save" />
        </x-slot>
    </x-modal>

    <!-- Show Post Details Modal -->
    <x-modal id="showPostsModal" title="Post Details" width="800px">
        <div class="text-start">

            <!-- 1. Top Featured Image & Category Badge -->
            <div class="position-relative rounded-4 overflow-hidden mb-4 shadow-sm admin-modal-img-container"
                style="background-color: #f1f3f5;">
                <img id="show_image" src="" alt="Post Image" class="admin-modal-preview-img"
                    style="display: none;">

                <div id="show_no_image" class="d-flex align-items-center justify-content-center text-muted"
                    style="height: 200px; display: none;">
                    <i class="fa-solid fa-image fa-3x opacity-50"></i>
                </div>

                <!-- Category Badge over Image -->
                <span id="show_category"
                    class="position-absolute top-0 start-0 m-3 badge bg-primary px-3 py-2 shadow-sm rounded-pill">
                    Category Name
                </span>

                <!-- Status Badge over Image -->
                <span id="show_status"
                    class="position-absolute top-0 end-0 m-3 badge px-3 py-2 shadow-sm rounded-pill text-uppercase">
                    Status
                </span>
            </div>

            <!-- 2. Post Title -->
            <h3 id="show_title" class="fw-bold text-dark mb-3">
                Post Title Here
            </h3>

            <!-- 3. Meta Info (Date & ID) -->
            <div class="d-flex align-items-center gap-3 text-muted small mb-3 pb-3 border-bottom">
                <span><i class="fa-solid fa-hashtag me-1"></i> ID: <strong id="show_id"></strong></span>
                <span><i class="fa-solid fa-link me-1"></i> Slug: <strong id="show_slug"></strong></span>
            </div>

            <!-- Attached Tags Display -->
            <div class="mb-3">
                <h6 class="fw-bold text-secondary text-uppercase fs-7 mb-2">Attached Tags</h6>
                <div id="show_tags" class="d-flex flex-wrap gap-2">
                    <!-- Dynamic tag badges injected via JS -->
                </div>
            </div>

            <!-- 4. Full Content Area -->
            <div class="mb-3">
                <h6 class="fw-bold text-secondary text-uppercase fs-7 mb-2">Content</h6>
                <div id="show_content" class="text-dark p-3 bg-light rounded-3"
                    style="line-height: 1.7; max-height: 300px; overflow-y: auto;">
                    <!-- Content goes here -->
                </div>
            </div>

        </div>

        <x-slot name="buttons">
            <x-button.simple type="button" text="Close" color="light" data-bs-dismiss="modal"
                class="rounded-pill px-4" />
        </x-slot>
    </x-modal>

    {{-- delete modal --}}
    <x-delete_modal id="deletePostsModal" title="Delete Post?">
        <input type="hidden" id="delete_id" name="id">
    </x-delete_modal>
@endsection

@push('scripts')
    {{-- show modal script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show action button listener
            document.addEventListener('click', function(e) {
                let showBtn = e.target.closest('.show-action-btn');

                if (showBtn) {
                    let rowData = JSON.parse(showBtn.getAttribute('data-row'));

                    // Populate fields
                    document.getElementById('show_id').innerText = rowData.id;
                    document.getElementById('show_title').innerText = rowData.title;
                    document.getElementById('show_category').innerText = rowData.category_name || 'Category';
                    document.getElementById('show_slug').innerText = rowData.slug;
                    document.getElementById('show_content').innerHTML = rowData.content;

                    // Tags population
                    let tagsContainer = document.getElementById('show_tags');
                    if (tagsContainer) {
                        tagsContainer.innerHTML = '';
                        if (rowData.tag_names && rowData.tag_names.length > 0) {
                            rowData.tag_names.forEach(tagName => {
                                tagsContainer.innerHTML += `<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 fw-semibold"><i class="fa-solid fa-tag me-1"></i>${tagName}</span>`;
                            });
                        } else {
                            tagsContainer.innerHTML = '<span class="text-muted small">No tags attached to this post.</span>';
                        }
                    }

                    // Status Badge Styling
                    let statusBadge = document.getElementById('show_status');
                    statusBadge.innerText = rowData.status;
                    statusBadge.className =
                        `position-absolute top-0 end-0 m-3 badge px-3 py-2 shadow-sm rounded-pill text-uppercase ${rowData.status === 'published' ? 'bg-success' : 'bg-warning'}`;

                    document.getElementById('show_category').innerText = rowData.category_name || 'Category';

                    // Image Handling
                    let imgElement = document.getElementById('show_image');
                    let noImgElement = document.getElementById('show_no_image');

                    if (rowData.image) {
                        if (rowData.image.startsWith('http://') || rowData.image.startsWith('https://')) {
                            imgElement.src = rowData.image;
                        } else {
                            imgElement.src = `/storage/${rowData.image}`;
                        }
                        imgElement.style.display = 'block';
                        if (noImgElement) noImgElement.style.display = 'none';
                    } else {
                        imgElement.style.display = 'none';
                        if (noImgElement) noImgElement.style.display = 'flex';
                    }
                }
            });
        });
    </script>
    {{-- delete modal script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('click', function(e) {
                let deleteBtn = e.target.closest('.delete-action-btn');
                if (deleteBtn) {
                    let rowData = JSON.parse(deleteBtn.getAttribute('data-row'));
                    document.getElementById('delete_id').value = rowData.id;
                }
            });

            document.addEventListener('click', function(e) {
                let confirmBtn = e.target.closest('#deletePostsModal .btn-danger');
                if (confirmBtn) {
                    let id = document.getElementById('delete_id').value;
                    if (id) {
                        Livewire.dispatch('executeDeletePost', {
                            id: id
                        });
                    }
                }
            });

            window.addEventListener('close-modal', event => {
                let modalId = event.detail.modalId;
                let modalElement = document.getElementById(modalId);
                if (modalElement) {
                    let modalInstance = bootstrap.Modal.getInstance(modalElement);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                }
            });
        });
    </script>
    {{-- auto fill slug --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const titleInput = document.getElementById('title');
            const slugInput = document.getElementById('slug');

            if (titleInput && slugInput) {
                titleInput.addEventListener('input', function() {
                    let slug = this.value.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
                    slugInput.value = slug;
                });
            }
        });
    </script>
    {{-- edit slug --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const titleInput = document.getElementById('edit_title');
            const slugInput = document.getElementById('edit_slug');

            if (titleInput && slugInput) {
                titleInput.addEventListener('input', function() {
                    let slug = this.value.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
                    slugInput.value = slug;
                });
            }
        });
    </script>
    {{-- modal edit --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Edit action button population
            document.addEventListener('click', function(e) {
                let editBtn = e.target.closest('.edit-action-btn');

                if (editBtn) {
                    let rowData = JSON.parse(editBtn.getAttribute('data-row'));

                    // Populate inputs
                    if (document.getElementById('edit_id')) document.getElementById('edit_id').value = rowData.id ?? '';
                    if (document.getElementById('edit_title')) document.getElementById('edit_title').value = rowData.title ?? '';
                    if (document.getElementById('edit_slug')) document.getElementById('edit_slug').value = rowData.slug ?? '';
                    if (document.getElementById('edit_content')) document.getElementById('edit_content').value = rowData.content ?? '';
                    if (document.getElementById('edit_image')) document.getElementById('edit_image').value = rowData.image || '';

                    // Select Category
                    let categorySelect = document.getElementById('edit_category_id');
                    if (categorySelect && (rowData.category_id !== undefined && rowData.category_id !== null)) {
                        categorySelect.value = String(rowData.category_id);
                        Array.from(categorySelect.options).forEach(opt => {
                            opt.selected = (opt.value == String(rowData.category_id));
                        });
                    }

                    // Select Status
                    let statusSelect = document.getElementById('edit_status');
                    if (statusSelect && rowData.status) {
                        statusSelect.value = rowData.status;
                        Array.from(statusSelect.options).forEach(opt => {
                            opt.selected = (opt.value.toLowerCase() === String(rowData.status).toLowerCase());
                        });
                    }

                    // Reset and populate edit tag checkboxes
                    document.querySelectorAll('.edit-tag-checkbox').forEach(cb => cb.checked = false);
                    if (rowData.tag_ids && Array.isArray(rowData.tag_ids)) {
                        rowData.tag_ids.forEach(tagId => {
                            let cb = document.getElementById(`edit_tag_${tagId}`);
                            if (cb) cb.checked = true;
                        });
                    }
                }
            });

            // Edit Form AJAX Handler
            const editForm = document.querySelector('#editPostsModal form');
            if (editForm) {
                editForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    let form = this;
                    let id = document.getElementById('edit_id').value;
                    let submitBtn = form.querySelector('button[type="submit"]');
                    let originalBtnText = submitBtn.innerHTML;

                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Updating...';

                    let formData = new FormData(form);
                    formData.append('_method', 'PUT');

                    fetch(`/posts/update/${id}`, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                            }
                        })
                        .then(response => {
                            if (!response.ok) throw response;
                            return response.json();
                        })
                        .then(data => {
                            bootstrap.Modal.getInstance(document.getElementById('editPostsModal'))
                                .hide();
                            Livewire.dispatch('refreshDatatable');
                        })
                        .catch(async error => {
                            if (error.status === 422) {
                                alert("Validation failed! Please check your inputs.");
                            } else {
                                alert("Server error occurred!");
                            }
                        })
                        .finally(() => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalBtnText;
                        });
                });
            }
        });
    </script>
@endpush
