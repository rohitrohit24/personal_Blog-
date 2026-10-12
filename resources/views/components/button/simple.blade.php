@props(['text', 'type' => 'button', 'color' => 'primary', 'icon' => null])
<button type="{{ $type }}" {{ $attributes->merge(['class' => 'btn btn-' . $color . ' rounded-pill px-4 fw-medium']) }}>
    @if($icon)<i class="fa-solid fa-{{ $icon }} me-2"></i>@endif
    {{ $text }}
</button>
