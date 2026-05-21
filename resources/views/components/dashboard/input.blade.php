<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <input
        type="{{ $type ?? 'text' }}"
        id="{{ $name }}"
        name="{{$name}}"
        @isset($value)
        value="{{ $value }}"
        @endisset
        @isset($inputmode)
        inputmode="{{ $inputmode }}"
        @endisset
        @isset($pattern)
        pattern="^{{ $pattern }}"
        @endisset
        @isset($maxlength)
        maxlength="{{ $maxlength }}"
        @endisset
        @isset($autocomplete)
        autocomplete="{{ $autocomplete }}"
        @endisset
        class="form-control @error($name) is-invalid @enderror"
        @isset($placeholder)
        placeholder="{{ $placeholder }}"
        @endisset
        >
    @error($name)
    <small class="invalid-feedback">{{ $message }}</small>
    @enderror
</div>
