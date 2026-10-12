@props(['name', 'label', 'value', 'checked' => false, 'id' => null])
@php $id = $id ?? $name . '_' . $value; @endphp
<div class="form-check mb-3">
    <input type="radio" name="{{ $name }}" id="{{ $id }}" value="{{ $value }}" class="form-check-input @error($name) is-invalid @enderror" {{ old($name, $checked) == $value ? 'checked' : '' }} {{ $attributes }}>
    <label class="form-check-label fw-medium" for="{{ $id }}">
        {{ $label }}
    </label>
    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
