<script>
    function toggleStatus(url) {
        $.ajax({
            type: 'PUT',
            url: url,
            data: {
                _token: @json(@csrf_token())
            },
            success: function (response) {
                if (response) {
                    Snackbar.show({
                        text: '{{ __('Thay đổi trạng thái thành công.') }}',
                        textColor: '#ddf5f0',
                        backgroundColor: '#00ab55',
                        actionText: '{{ __('Bỏ qua') }}',
                        actionTextColor: '#3b3f5c'
                    });
                }
            },
            error: function (response) {
                Snackbar.show({
                    text: '{{ __('Thay đổi trạng thái thất bại.') }}',
                    textColor: '#fbeced',
                    backgroundColor: '#e7515a',
                    actionText: '{{ __('Bỏ qua') }}',
                    actionTextColor: '#3b3f5c'
                });
            }
        });
    }
</script>
