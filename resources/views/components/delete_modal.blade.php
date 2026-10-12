@props([
    'id',
    'action' => null,
    'title' => 'Are you sure?',
    'message' => 'Once deleted, this record cannot be recovered. Do you want to proceed?',
])

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true"
    wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">

            <!-- Close Button -->
            <div class="modal-header border-bottom-0 pb-0 justify-content-end px-3 pt-3">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body px-4 pt-0">
                <!-- Warning Icon -->
                <div class="mb-4 text-danger d-flex justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="65" height="65" fill="currentColor"
                        class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                        <path
                            d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0" />
                    </svg>
                </div>

                {{ $slot }}

                <!-- Title -->
                <h4 class="fw-bold mb-3" id="{{ $id }}Label">
                    {{ $title }}
                </h4>

                <!-- Warning Message -->
                <p class="text-muted mb-0">
                    {{ $message }}
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="modal-footer border-top-0 justify-content-center pt-3 pb-4">
                <button type="button" class="btn btn-light rounded-pill px-4 fw-medium" data-bs-dismiss="modal">
                    Cancel
                </button>

                <!-- Is button par click hone par JavaScript dispatch karega -->
                <button type="button" class="btn btn-danger rounded-pill px-4 fw-medium">
                    Confirm Delete
                </button>
            </div>

        </div>
    </div>
</div>

{{-- @props([
    'id',
    'action',
    'title' => 'Are you sure?',
    'message' => 'Once deleted, this record cannot be recovered. Do you want to proceed?',
])

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">

            <form action="{{ $action }}" method="POST">
                @csrf
                @method('DELETE')

                <!-- Close Button -->
                <div class="modal-header border-bottom-0 pb-0 justify-content-end px-3 pt-3">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body px-4 pt-0">
                    <!-- Warning Icon (Bootstrap Icon SVG) -->
                    <div class="mb-4 text-danger d-flex justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="65" height="65" fill="currentColor"
                            class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                            <path
                                d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0" />
                        </svg>
                    </div>
                    {{ $slot }}

                    <!-- Title -->
                    <h4 class="fw-bold mb-3" id="{{ $id }}Label">
                        {{ $title }}
                    </h4>

                    <!-- Warning Message -->
                    <p class="text-muted mb-0">
                        {{ $message }}
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="modal-footer border-top-0 justify-content-center pt-3 pb-4">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-medium" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4 fw-medium">
                        Confirm Delete
                    </button>
                </div>
            </form>

        </div>
    </div>
</div> --}}
