<div class="modal fade" id="individualAccountRequestStatusModal" tabindex="-1" role="dialog" aria-labelledby="individualAccountRequestStatusModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="individualAccountRequestStatusModalLabel" style="color: #3b3f5c;">
                    {{ __('Chỉnh sửa trạng thái') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>

            <form>
                <div class="modal-body pb-2">
                    <div class="form-group mb-4">
                        <label for="status">{{ __('Trạng thái') }} <strong class="text-danger">*</strong>
                        </label>
                        <select
                            id="status"
                            class="form-select @error('status') is-invalid @enderror"
                            placeholder="{{ __('Trạng thái') }}"
                            wire:model='status'
                        >
                            <option value="">{{ __('Chọn trạng thái') }}</option>
                            @foreach ($accountRequestStatuses as $item)
                                <option value="{{ $item['value'] }}">{{ $item['label'] }}</option>
                            @endforeach
                        </select>
                        @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-dark" data-bs-dismiss="modal">
                        {{ __('Hủy bỏ') }}
                    </button>

                    <button
                        type="button"
                        class="btn btn-primary btn-submit-modal"
                        wire:click='update'
                    >
                        {{ __('Hoàn tất') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('footerFiles')
    <script>
        $('#individualAccountRequestStatusModal').on('show.bs.modal', function (e) {
            $('#individualAccountRequestStatusModal .modal-body .alert').remove();
            $('#individualAccountRequestStatusModal #status').val($('#individual-account-request-status').val());

            let invalidFeedbacks = document.querySelectorAll('#individualAccountRequestStatusModal .invalid-feedback');
            invalidFeedbacks.forEach(item => {
                item.remove();
            });

            let formSelects = document.querySelectorAll('#individualAccountRequestStatusModal .form-select');
            formSelects.forEach(item => {
                item.classList.remove('is-invalid');
            });
        });
    </script>
@endpush


