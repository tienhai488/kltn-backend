<script src="{{ asset('plugins/editors/ckeditor/ckeditor.js') }}"></script>
<script>
    ClassicEditor
    .create(document.querySelector('#editorContent'), {
        simpleUpload: {
            uploadUrl: '{{ route('admin.editor_upload', ['_token' => csrf_token()]) }}'
        },
    })
    @if (isset($isEdit) && !$isEdit)
    .then(editor => {
        editor.enableReadOnlyMode('');
    })
    @endif
    .catch(error => {
        Snackbar.show({
            text: error.message,
            textColor: '#fbeced',
            backgroundColor: '#e7515a',
            actionText: '{{ __('Bỏ qua') }}',
            actionTextColor: '#3b3f5c',
        });
        console.error(error);
    });
</script>

