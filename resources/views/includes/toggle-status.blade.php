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
                        text: '{{ __('success.toggle_status') }}',
                        textColor: '#ddf5f0',
                        backgroundColor: '#00ab55',
                        actionText: '{{ __('general.common.dismiss') }}',
                        actionTextColor: '#3b3f5c'
                    });
                }
            },
            error: function (response) {
                Snackbar.show({
                    text: '{{ __('error.toggle_status') }}',
                    textColor: '#fbeced',
                    backgroundColor: '#e7515a',
                    actionText: '{{ __('general.common.dismiss') }}',
                    actionTextColor: '#3b3f5c'
                });
            }
        });
    }
</script>
