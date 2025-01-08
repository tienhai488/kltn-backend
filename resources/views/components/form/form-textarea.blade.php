<div class="form-group mb-4">
    @if($label)
    <label for="{{ $id }}">{{ $label }} @if($isRequired) <strong class="text-danger">*</strong> @endif</label>
    @endif
    <textarea name="{{ $name }}" class="form-control  @error($oldName ?: $name) is-invalid @enderror" id="{{ $id }}" placeholder="{{ $placeholder }}" {{ $attributes }} rows="{{ $rows }}">{{ old($oldName ?: $name, $value) }}</textarea>
    @error($oldName ?: $name)
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

