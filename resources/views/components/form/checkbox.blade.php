@props(['name', 'label', 'checked' => false, 'value' => '1', 'id' => null])
@php $id = $id ?? $name; @endphp
<div class="form-check mb-3">
    <input type="hidden" name="{{ $name }}" value="0">
    <input type="checkbox" name="{{ $name }}" id="{{ $id }}" value="{{ $value }}"
        class="form-check-input @error($name) is-invalid @enderror" {{ old($name, $checked) ? 'checked' : '' }}
        {{ $attributes }}>
    <label class="form-check-label fw-medium" for="{{ $id }}">
        {{ $label }}
    </label>
    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
