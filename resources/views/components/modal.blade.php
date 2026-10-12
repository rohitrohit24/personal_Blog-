@props(['id', 'title', 'action' => null, 'method' => 'POST', 'width' => null])
<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label"
    aria-hidden="true">

    <!-- Yahan modal-dialog par width apply ki gayi hai -->
    <div class="modal-dialog modal-dialog-centered"
        @if ($width) style="max-width: {{ $width }};" @endif>

        <div class="modal-content">
            @if ($action)
                <form action="{{ $action }}" method="{{ $method === 'GET' ? 'GET' : 'POST' }}"
                    enctype="multipart/form-data">
                    @if ($method !== 'GET' && $method !== 'POST')
                        @method($method)
                    @endif
                    @csrf
            @endif

            <div class="modal-header border-bottom-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-bold" id="{{ $id }}Label">
                    {{ $title }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body px-4 py-4">
                {{ $slot }}
            </div>

            <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
                @if (isset($buttons))
                    {{ $buttons }}
                @else
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-medium"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-medium">Save</button>
                @endif
            </div>

            @if ($action)
                </form>
            @endif
        </div>
    </div>
</div>
