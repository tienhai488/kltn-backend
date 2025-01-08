<div class="form-group mb-4">
    <label for="{{ $id }}">{{ $label }} @if($isRequired) <strong class="text-danger">*</strong> @endif</label>
    <input type="{{ $type }}" name="{{ $name }}" class="form-control @error($name) is-invalid @enderror @if ($readonly) flatpickr-input @endif"
           id="{{ $id }}" placeholder="{{ $placeholder }}" value="{{ old($oldName ?: $name, $value) }}" {{ $attributes }} @readonly($readonly)>
    @error($name)
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
