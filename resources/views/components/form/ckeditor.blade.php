<div class="form-group mb-4">
    @if($label)
        <label for="{{ $id }}">{{ $label }}@if($isRequired) <strong class="text-danger">*</strong> @endif</label>
    @endif
    <textarea
        id="{{ $id }}"
        name="{{ $name }}"
        class="form-control"
        placeholder="{{ $placeholder }}"
        {{ $attributes }}
    >
        {{ old($oldName ?: $name, $value) }}
    </textarea>
    @error($oldName ?: $name)
    <span class="invalid-feedback" style="display:block" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
