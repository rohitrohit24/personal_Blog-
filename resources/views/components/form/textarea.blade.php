@props(['name', 'label' => null, 'value' => '', 'placeholder' => '', 'required' => false, 'rows' => 4, 'id' => null])
@php $id = $id ?? $name; @endphp
<div class="mb-3">
    @if($label)
        <label for="{{ $id }}" class="form-label fw-medium">{{ $label }} @if($required)<span class="text-danger">*</span>@endif</label>
    @endif
    <textarea name="{{ $name }}" id="{{ $id }}" rows="{{ $rows }}" class="form-control rounded-3 @error($name) is-invalid @enderror" placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }} {{ $attributes }}>{{ old($name, $value) }}</textarea>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
