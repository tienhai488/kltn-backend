<div class="modal fade" id="contactStatusModal" tabindex="-1" role="dialog" aria-labelledby="contactStatusModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactStatusModalLabel" style="color: #3b3f5c;">
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
                            @foreach ($contactStatuses as $item)
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
        $('#contactStatusModal').on('show.bs.modal', function (e) {
            $('#contactStatusModal .modal-body .alert').remove();
            $('#contactStatusModal #status').val($('#contact-status').val());

            let invalidFeedbacks = document.querySelectorAll('#contactStatusModal .invalid-feedback');
            invalidFeedbacks.forEach(item => {
                item.remove();
            });

            let formSelects = document.querySelectorAll('#contactStatusModal .form-select');
            formSelects.forEach(item => {
                item.classList.remove('is-invalid');
            });
        });
    </script>
@endpush


