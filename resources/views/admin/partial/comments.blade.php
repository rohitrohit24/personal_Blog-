@extends('admin.layout.main_layout')

@section('content')
    <div class="container-fluid px-0">
        <div class="custom-page-header mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-content">
                    <div class="d-flex align-items-center gap-3">
                        <div class="header-icon">
                            <i class="fa-solid fa-comments"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1">Comments Management</h4>
                            <p class="text-muted mb-0">Manage and moderate user comments</p>
                        </div>
                    </div>
                </div>
                <div class="header-action">
                    <x-button.modal-trigger target="createCommentModal" text="Add Comment" color="primary" icon="plus"
                        class="shadow-sm px-4 py-2"></x-button.modal-trigger>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body p-4">
                <livewire:comments-table />
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <x-modal id="createCommentModal" title="Add New Comment" action="{{ route('comments.store') }}" width="800px"
        method="POST">
        
        <div class="row">
            <div class="col-md-12 mb-3">
                <label class="form-label">Post</label>
                <select name="post_id" class="form-select" required>
                    <option value="">Select Post</option>
                    @foreach($posts as $post)
                        <option value="{{ $post->id }}">{{ $post->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <x-form.input type="text" id="name" name="name" label="Name" placeholder="John Doe" required="true" />
            </div>
            <div class="col-md-6">
                <x-form.input type="email" id="email" name="email" label="Email" placeholder="john@example.com" required="true" />
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12 mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="spam">Spam</option>
                </select>
            </div>
        </div>
        
        <x-form.textarea id="comment_body" name="comment_body" label="Comment" placeholder="Write the comment here..." rows="4" required="true" />

        <x-slot name="buttons">
            <x-button.simple type="button" text="Cancel" color="light" data-bs-dismiss="modal" />
            <x-button.simple type="submit" text="Save Comment" color="primary" icon="save" />
        </x-slot>
    </x-modal>

    <!-- Edit Modal -->
    <x-modal id="editCommentsModal" title="Edit Comment" action="#" width="800px" method="PUT">
        <input type="hidden" id="edit_id" name="id">
        
        <div class="row">
            <div class="col-md-12 mb-3">
                <label class="form-label">Post</label>
                <select name="post_id" id="edit_post_id" class="form-select" required>
                    <option value="">Select Post</option>
                    @foreach($posts as $post)
                        <option value="{{ $post->id }}">{{ $post->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <x-form.input type="text" id="edit_name" name="name" label="Name" required="true" />
            </div>
            <div class="col-md-6">
                <x-form.input type="email" id="edit_email" name="email" label="Email" required="true" />
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-3">
                <label class="form-label">Status</label>
                <select name="status" id="edit_status" class="form-select" required>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="spam">Spam</option>
                </select>
            </div>
        </div>
        
        <x-form.textarea id="edit_comment_body" name="comment_body" label="Comment" rows="4" required="true" />

        <x-slot name="buttons">
            <x-button.simple type="button" text="Cancel" color="light" data-bs-dismiss="modal" />
            <x-button.simple type="submit" text="Update Comment" color="primary" icon="save" />
        </x-slot>
    </x-modal>

    {{-- delete modal --}}
    <x-delete_modal id="deleteCommentsModal" title="Delete Comment?">
        <input type="hidden" id="delete_id" name="id">
    </x-delete_modal>
    <style>
        .admin-table th:last-child,
        .admin-table td:last-child {
            min-width: 240px !important;
        }
    </style>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Delete modal trigger
            document.addEventListener('click', function(e) {
                let deleteBtn = e.target.closest('.delete-action-btn');
                if (deleteBtn) {
                    let rowData = JSON.parse(deleteBtn.getAttribute('data-row'));
                    document.getElementById('delete_id').value = rowData.id;
                }
            });

            // Delete confirm trigger
            document.addEventListener('click', function(e) {
                let confirmBtn = e.target.closest('#deleteCommentsModal .btn-danger');
                if (confirmBtn) {
                    let id = document.getElementById('delete_id').value;
                    if (id) {
                        Livewire.dispatch('executeDeleteComment', {
                            id: id
                        });
                    }
                }
            });

            // Approve Action Handler
            document.addEventListener('click', function(e) {
                let approveBtn = e.target.closest('.approve-action-btn');
                if (approveBtn && !approveBtn.disabled) {
                    let id = approveBtn.getAttribute('data-id');
                    if (id) {
                        approveBtn.disabled = true;
                        approveBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
                        
                        fetch(`/comments/approve/${id}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (window.Livewire) {
                                Livewire.dispatch('refreshDatatable');
                            }
                        })
                        .catch(() => {
                            if (window.Livewire) {
                                Livewire.dispatch('executeApproveComment', { id: id });
                            }
                        });
                    }
                }

                // Reject Action Handler
                let rejectBtn = e.target.closest('.reject-action-btn');
                if (rejectBtn && !rejectBtn.disabled) {
                    let id = rejectBtn.getAttribute('data-id');
                    if (id) {
                        rejectBtn.disabled = true;
                        rejectBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
                        
                        fetch(`/comments/reject/${id}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (window.Livewire) {
                                Livewire.dispatch('refreshDatatable');
                            }
                        })
                        .catch(() => {
                            if (window.Livewire) {
                                Livewire.dispatch('executeRejectComment', { id: id });
                            }
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Edit action button population
            document.addEventListener('click', function(e) {
                let editBtn = e.target.closest('.edit-action-btn');

                if (editBtn) {
                    let rowData = JSON.parse(editBtn.getAttribute('data-row'));

                    if (document.getElementById('edit_id')) document.getElementById('edit_id').value = rowData.id ?? '';
                    if (document.getElementById('edit_name')) document.getElementById('edit_name').value = rowData.name ?? '';
                    if (document.getElementById('edit_email')) document.getElementById('edit_email').value = rowData.email ?? '';
                    if (document.getElementById('edit_comment_body')) document.getElementById('edit_comment_body').value = rowData.comment_body ?? '';

                    // Select Post
                    let postSelect = document.getElementById('edit_post_id');
                    if (postSelect && rowData.post_id !== undefined && rowData.post_id !== null) {
                        postSelect.value = String(rowData.post_id);
                        Array.from(postSelect.options).forEach(opt => {
                            opt.selected = (opt.value == String(rowData.post_id));
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
                }
            });

            // Edit Form AJAX Handler
            const editForm = document.querySelector('#editCommentsModal form');
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

                    fetch(`/comments/update/${id}`, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
                            }
                        })
                        .then(response => {
                            if (!response.ok) throw response;
                            return response.json();
                        })
                        .then(data => {
                            bootstrap.Modal.getInstance(document.getElementById('editCommentsModal'))
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
