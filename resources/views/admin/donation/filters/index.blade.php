 <div class="col-lg-12 p-4">
    <div id="filterBody" class="row align-items-center">
        <div class="col-md-6">
            <x-form.form-select
                :id="'user_id'"
                :label="__('Người dùng')"
                :data-values="$users"
                :select-value-attribute="'id'"
                :select-value-label="'name'"
                :name="'user_id'"
                :multiple="false"
                :placeholder="__('Chọn người dùng')"
                :is-filter="true"
            />
        </div>
        <div class="col-md-6">
            <x-form.form-select
                :id="'project_id'"
                :label="__('Dự án')"
                :data-values="$projects"
                :select-value-attribute="'id'"
                :select-value-label="'name'"
                :name="'project_id'"
                :multiple="false"
                :placeholder="__('Chọn dự án')"
                :is-filter="true"
            />
        </div>
        <div class="col-md-6">
            <x-form.form-select
                :id="'department_id'"
                :label="__('Phòng ban')"
                :data-values="$departments"
                :select-value-attribute="'id'"
                :select-value-label="'name'"
                :name="'department_id'"
                :multiple="false"
                :placeholder="__('Chọn phòng ban')"
                :is-filter="true"
            />
        </div>
        <div class="col-md-6">
            <x-form.form-select
                :id="'is_anonymous'"
                :label="__('Chế độ')"
                :data-values="App\Enum\AnonymousStatus::options(true)"
                :select-value-attribute="'value'"
                :select-value-label="'label'"
                :name="'is_anonymous'"
                :multiple="false"
                :placeholder="__('Chọn chế độ')"
                :is-filter="true"
            />
        </div>
    </div>
    <hr>
    <div class="filter-header d-flex justify-content-end align-items-center">
        <button type="button" class="btn btn-secondary me-2" id="filter-btn">{{ __('Lọc') }}</button>
        <button type="button" class="btn btn-light-secondary" id="remove-filter-btn">{{ __('Xoá bộ lọc') }}</button>
    </div>
</div>

@push('footerFiles')
    <script>
        $('#filter-btn').on('click', function () {
            $('#sDonationTable').DataTable().ajax.reload();
        });
    </script>
@endpush
