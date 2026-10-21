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
                            <h4 class="fw-bold mb-1">Tags Management</h4>
                            <p class="text-muted mb-0">Create, edit, and organize your blog topics</p>
                        </div>
                    </div>
                </div>
                <div class="header-action">
                    <x-button.modal-trigger target="createtagsModal" text="Add Tags" color="primary" icon="plus"
                        class="shadow-sm px-4 py-2"></x-button.modal-trigger>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body p-4">
                <livewire:tags-table />
            </div>
        </div>

    </div>
    {{-- data store modal --}}
    <x-modal id="createtagsModal" title="Add New Tags" action="{{ route('tags.store') }}" width="600px" method="POST">

        <x-form.input type="text" id="name" name="name" label="Tags Name" placeholder="e.g. Web Development"
            required="true" />

        <x-form.input type="text" id="slug" name="slug" label="URL Slug"
            placeholder="Auto-generated based on name" readonly="true" />

        <x-slot name="buttons">
            <x-button.simple type="button" text="Cancel" color="light" data-bs-dismiss="modal" />
            <x-button.simple type="submit" text="Save Tags" color="primary" icon="save" />
        </x-slot>

    </x-modal>
    {{-- edit modal --}}
    <x-modal id="editTagsModal" title="Edit Tags" action="#" width="600px" method="PUT">

        <input type="hidden" id="edit_id" name="id">

        <x-form.input type="text" id="edit_name" name="name" label="Category Name" required="true" />
        <x-form.input type="text" id="edit_slug" name="slug" label="URL Slug" readonly="true" />

        <x-slot name="buttons">
            <x-button.simple type="button" text="Cancel" color="light" data-bs-dismiss="modal" />
            <x-button.simple type="submit" text="Update Tags" color="primary" icon="save" />
        </x-slot>

    </x-modal>
    {{-- delete modal --}}
    <x-delete_modal id="deleteTagsModal" title="Delete Tags?">
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
                let confirmBtn = e.target.closest('#deleteTagsModal .btn-danger');
                if (confirmBtn) {
                    let id = document.getElementById('delete_id').value;
                    if (id) {
                        Livewire.dispatch('executeDeleteTag', {
                            id: id
                        });
                    }
                }
            });

            // Livewire se signal aane par modal band karein
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
            // Edit action button
            document.addEventListener('click', function(e) {
                let editBtn = e.target.closest('.edit-action-btn');

                if (editBtn) {
                    let rowData = JSON.parse(editBtn.getAttribute('data-row'));

                    document.getElementById('edit_id').value = rowData.id;
                    document.getElementById('edit_name').value = rowData.name;
                    document.getElementById('edit_slug').value = rowData.slug;
                }
            });

            const editForm = document.querySelector('#editTagsModal form');
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

                    fetch(`/tags/update/${id}`, {
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
                            bootstrap.Modal.getInstance(document.getElementById('editTagsModal'))
                                .hide();
                            Livewire.dispatch('refreshDatatable');
                        })
                        .catch(async error => {
                            if (error.status === 422) {
                                let response = await error.json();
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
