<button type="submit" {{ $attributes->merge(['class' => 'btn btn-'.$type, 'id' => 'submit-button']) }}>
    {{ $label }}
</button>
