<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <textarea 
        class="form-control @error($name)is-invalid @enderror @isset($class) {{ $class }} @endisset"
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows ?? 5 }}"
        placeholder="{{ $placeholder }}"
    >{!! $value !!}</textarea>
    @error($name)
    <small class="invalid-feedback text-muted">{{ $message }}</small>
    @enderror
</div>