<div class="col-lg-12 p-4">
    <div id="filterBody" class="row align-items-center">
        <div class="col-md-6">
            <x-form.form-select
                :id="'sCategory'"
                :label="__('Danh mục')"
                :data-values="$categories"
                :select-value-attribute="'id'"
                :select-value-label="'name'"
                :name="'category_id'"
                :multiple="false"
                :placeholder="__('Chọn danh mục')"
                :is-filter="true"
            />
        </div>
        <div class="col-md-6">
            <x-form.form-select
                :id="'sUser'"
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
                :id="'sType'"
                :label="__('Loại dự án')"
                :data-values="App\Enum\ProjectType::options(true)"
                :select-value-attribute="'value'"
                :select-value-label="'value'"
                :name="'type'"
                :multiple="false"
                :placeholder="__('Chọn loại dự án')"
                :is-filter="true"
            />
        </div>
        <div class="col-md-6">
            <x-form.form-select
                :id="'sStatus'"
                :label="__('Trạng thái')"
                :data-values="App\Enum\ProjectStatus::options(true)"
                :select-value-attribute="'value'"
                :select-value-label="'label'"
                :name="'status'"
                :multiple="false"
                :placeholder="__('Chọn trạng thái')"
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
            $('#sProjectTable').DataTable().ajax.reload();
        });
    </script>
@endpush
