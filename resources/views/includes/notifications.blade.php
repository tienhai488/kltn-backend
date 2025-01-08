<script>
    function showSuccess(msg, options = {}) {
        Snackbar.show({
            text: msg,
            textColor: '#ddf5f0',
            backgroundColor: '#00ab55',
            actionText: '{{ __('Bỏ qua') }}',
            actionTextColor: '#3b3f5c',
            ...options
        });
    }

    function showError(msg, options = {}) {
        Snackbar.show({
            text: msg,
            textColor: '#fbeced',
            backgroundColor: '#e7515a',
            actionText: '{{ __('Bỏ qua') }}',
            actionTextColor: '#3b3f5c',
            ...options
        });
    }

    @if (session()->has(\App\Enum\NotificationType::NOTIFICATION_SUCCESS->value))
    showSuccess('{{ session()->get(\App\Enum\NotificationType::NOTIFICATION_SUCCESS->value) }}')
    @endif

    @if (session()->has(\App\Enum\NotificationType::NOTIFICATION_ERROR->value))
    showError('{{ session()->get(\App\Enum\NotificationType::NOTIFICATION_ERROR->value) }}')
    @endif

    window.addEventListener('notification', event => {
        eventDetail = event.detail[0];
        if (eventDetail.type === 'error') {
            showError(eventDetail.message)
        }

        if (eventDetail.type === 'success') {
            showSuccess(eventDetail.message)
        }
    })
</script>
