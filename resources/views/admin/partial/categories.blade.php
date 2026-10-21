@extends('admin.layout.main_layout')

@section('content')
    <div class="container-fluid px-0">
        <div class="custom-page-header mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-content">
                    <div class="d-flex align-items-center gap-3">
                        <div class="header-icon">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1">Categories Management</h4>
                            <p class="text-muted mb-0">Create, edit, and organize your blog topics</p>
                        </div>
                    </div>
                </div>
                <div class="header-action">
                    <x-button.modal-trigger target="createCategoryModal" text="Add Category" color="primary" icon="plus"
                        class="shadow-sm px-4 py-2"></x-button.modal-trigger>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body p-4">
                <livewire:categories-table />
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <x-modal id="createCategoryModal" title="Add New Category" action="{{ route('categories.store') }}" width="600px"
        method="POST">
        <x-form.input type="text" id="name" name="name" label="Category Name" placeholder="e.g. Web Development"
            required="true" />
        <x-form.input type="text" id="slug" name="slug" label="URL Slug"
            placeholder="Auto-generated based on name" readonly="true" />
        <x-form.textarea type="text" id="description" name="description" label="Description"
            placeholder="Write a short description..." rows="3" />
        <x-slot name="buttons">
            <x-button.simple type="button" text="Cancel" color="light" data-bs-dismiss="modal" />
            <x-button.simple type="submit" text="Save Category" color="primary" icon="save" />
        </x-slot>
    </x-modal>

    <!-- Edit Modal -->
    <x-modal id="editCategoryModal" title="Edit Category" action="#" width="600px" method="PUT">
        <input type="hidden" id="edit_id" name="id">
        <x-form.input type="text" id="edit_name" name="name" label="Category Name" required="true" />
        <x-form.input type="text" id="edit_slug" name="slug" label="URL Slug" readonly="true" />
        <x-form.textarea id="edit_description" name="description" label="Description" rows="3" />
        <x-slot name="buttons">
            <x-button.simple type="button" text="Cancel" color="light" data-bs-dismiss="modal" />
            <x-button.simple type="submit" text="Update Category" color="primary" icon="save" />
        </x-slot>
    </x-modal>

    {{-- delete modal --}}
    <x-delete_modal id="deleteCategoryModal" title="Delete Category?">
        <input type="hidden" id="delete_id" name="id">
    </x-delete_modal>
@endsection

@push('scripts')
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
                let confirmBtn = e.target.closest('#deleteCategoryModal .btn-danger');
                if (confirmBtn) {
                    let id = document.getElementById('delete_id').value;
                    if (id) {
                        Livewire.dispatch('executeDeleteCategory', {
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');

            if (nameInput && slugInput) {
                nameInput.addEventListener('input', function() {
                    let slug = this.value.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
                    slugInput.value = slug;
                });
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Edit action button population
            document.addEventListener('click', function(e) {
                let editBtn = e.target.closest('.edit-action-btn');

                if (editBtn) {
                    let rowData = JSON.parse(editBtn.getAttribute('data-row'));

                    document.getElementById('edit_id').value = rowData.id;
                    document.getElementById('edit_name').value = rowData.name;
                    document.getElementById('edit_slug').value = rowData.slug;
                    document.getElementById('edit_description').value = rowData.description || '';
                }
            });

            // Edit Form AJAX Handler (Remains unchanged)
            const editForm = document.querySelector('#editCategoryModal form');
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

                    fetch(`/categories/update/${id}`, {
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
                            bootstrap.Modal.getInstance(document.getElementById('editCategoryModal'))
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

            // Listen to Livewire event to automatically close the Bootstrap modal without page refresh
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
@endpush
