@props(['id', 'editTarget', 'deleteTarget', 'showTarget' => null, 'row' => null])

<div class="d-flex gap-2">
    <!-- Show / View Button -->
    @if ($showTarget)
        <button type="button" class="btn btn-sm btn-outline-success show-action-btn" data-bs-toggle="modal"
            data-bs-target="#{{ $showTarget }}"
            @if ($row) data-row="{{ json_encode($row) }}" @endif>
            <i class="fa-solid fa-eye"></i>
        </button>
    @endif

    <!-- Edit Button -->
    <button type="button" class="btn btn-sm btn-outline-primary edit-action-btn" data-bs-toggle="modal"
        data-bs-target="#{{ $editTarget }}"
        @if ($row) data-row="{{ json_encode($row) }}" @endif>
        <i class="fa-solid fa-pen-to-square"></i>
    </button>

    <!-- Delete Button -->
    <button type="button" class="btn btn-sm btn-outline-danger delete-action-btn" data-bs-toggle="modal"
        data-bs-target="#{{ $deleteTarget }}"
        @if ($row) data-row="{{ json_encode($row) }}" @endif>
        <i class="fa-solid fa-trash"></i>
    </button>
</div>
