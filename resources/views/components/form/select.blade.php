@props(['name', 'label' => null, 'options' => [], 'value' => '', 'required' => false, 'id' => null])
@php $id = $id ?? $name; @endphp
<div class="mb-3">
    @if($label)
        <label for="{{ $id }}" class="form-label fw-medium">{{ $label }} @if($required)<span class="text-danger">*</span>@endif</label>
    @endif
    <select name="{{ $name }}" id="{{ $id }}" class="form-select rounded-3 @error($name) is-invalid @enderror" {{ $required ? 'required' : '' }} {{ $attributes }}>
        <option value="">-- Select --</option>
        @foreach($options as $key => $text)
            <option value="{{ $key }}" {{ old($name, $value) == $key ? 'selected' : '' }}>{{ $text }}</option>
        @endforeach
    </select>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
