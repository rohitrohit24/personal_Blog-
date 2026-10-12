@props(['name', 'label' => null, 'type' => 'text', 'value' => '', 'placeholder' => '', 'required' => false, 'id' => null])
@php $id = $id ?? $name; @endphp
<div class="mb-3">
    @if($label)
        <label for="{{ $id }}" class="form-label fw-medium">{{ $label }} @if($required)<span class="text-danger">*</span>@endif</label>
    @endif
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}" value="{{ old($name, $value) }}" class="form-control rounded-3 @error($name) is-invalid @enderror" placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }} {{ $attributes }}>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
