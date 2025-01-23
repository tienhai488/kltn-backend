<div class="modal fade" id="volunteerStatusModal" tabindex="-1" role="dialog" aria-labelledby="volunteerStatusModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="volunteerStatusModalLabel" style="color: #3b3f5c;">
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
                            @foreach ($volunteerStatuses as $item)
                                <option value="{{ $item['value'] }}">{{ $item['label'] }}</option>
                            @endforeach
                        </select>
                        @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label for="note">{{ __('Ghi chú') }} <strong class="text-danger">*</strong>
                        </label>
                        <textarea
                            id="note"
                            class="form-control @error('note') is-invalid @enderror"
                            placeholder="{{ __('Ghi chú') }}"
                            wire:model='note'
                            rows="5"
                        ></textarea>
                        @error('note')
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
        $('#volunteerStatusModal').on('show.bs.modal', function (e) {
            $('#volunteerStatusModal .modal-body .alert').remove();
            $('#volunteerStatusModal #status').val($('#volunteer-status').val());

            let invalidFeedbacks = document.querySelectorAll('#volunteerStatusModal .invalid-feedback');
            invalidFeedbacks.forEach(item => {
                item.remove();
            });

            let formSelects = document.querySelectorAll('#volunteerStatusModal .form-select');
            formSelects.forEach(item => {
                item.classList.remove('is-invalid');
            });
        });
    </script>
@endpush


