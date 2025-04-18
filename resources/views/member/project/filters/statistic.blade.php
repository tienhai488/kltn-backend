<div class="col-lg-12 p-4">
    <div id="filterBody" class="row align-items-center">
        {{-- <div class="col-md-4">
            <x-form.form-select
                :id="'project_category_id'"
                :label="__('Danh mục dự án')"
                :data-values="$categories"
                :select-value-attribute="'id'"
                :select-value-label="'name'"
                :name="'project_category_id'"
                :multiple="false"
                :placeholder="__('Chọn danh mục')"
                :is-filter="true"
            />
        </div> --}}
        {{-- <div class="col-md-4">
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
        </div> --}}
        {{-- <div class="col-md-4">
            <x-form.form-select
                :id="'project_type'"
                :label="__('Loại dự án')"
                :data-values="App\Enum\ProjectType::options(true)"
                :select-value-attribute="'value'"
                :select-value-label="'value'"
                :name="'project_type'"
                :multiple="false"
                :placeholder="__('Chọn loại dự án')"
                :is-filter="true"
            />
        </div> --}}
        {{-- <div class="col-md-4">
            <x-form.form-select
                :id="'project_status'"
                :label="__('Trạng thái dự án')"
                :data-values="App\Enum\ProjectStatus::options(true)"
                :select-value-attribute="'value'"
                :select-value-label="'label'"
                :name="'project_status'"
                :multiple="false"
                :placeholder="__('Chọn trạng thái')"
                :is-filter="true"
            />
        </div> --}}
        {{-- <div class="col-md-4">
            <x-form.form-select
                :id="'project_frontend_status'"
                :label="__('Trạng thái dự án khi được chấp nhận')"
                :data-values="App\Enum\ProjectFrontStatus::options(true)"
                :select-value-attribute="'value'"
                :select-value-label="'label'"
                :name="'project_frontend_status'"
                :multiple="false"
                :placeholder="__('Chọn trạng thái')"
                :is-filter="true"
            />
        </div> --}}
        <div class="col-md-4">
            <x-form.form-select
                :id="'donation_volunteer_user_id'"
                :label="__('Người dùng (Quyên góp/ Tình nguyện viên)')"
                :data-values="$users"
                :select-value-attribute="'id'"
                :select-value-label="'name'"
                :name="'donation_volunteer_user_id'"
                :multiple="false"
                :placeholder="__('Chọn người dùng')"
                :is-filter="true"
            />
        </div>
        <div class="col-md-4">
            <x-form.form-select
                :id="'donation_status'"
                :label="__('Trạng thái quyên góp')"
                :data-values="App\Enum\PaymentStatus::options(true)"
                :select-value-attribute="'value'"
                :select-value-label="'label'"
                :name="'donation_status'"
                :multiple="false"
                :placeholder="__('Chọn trạng thái')"
                :is-filter="true"
            />
        </div>
        <div class="col-md-4">
            <x-form.form-select
                :id="'volunteer_status'"
                :label="__('Trạng thái tình nguyện viên')"
                :data-values="App\Enum\VolunteerStatus::options(true)"
                :select-value-attribute="'value'"
                :select-value-label="'label'"
                :name="'volunteer_status'"
                :multiple="false"
                :placeholder="__('Chọn trạng thái')"
                :is-filter="true"
            />
        </div>
        <div class="col-md-4">
            <x-form.form-select
                :id="'donation_price_range'"
                :label="__('Khoảng tiền quyên góp')"
                :data-values="App\Enum\PriceRangeFilter::options(true)"
                :select-value-attribute="'value'"
                :select-value-label="'label'"
                :name="'donation_price_range'"
                :multiple="false"
                :placeholder="__('Chọn khoảng tiền quyên góp')"
                :is-filter="true"
            />
        </div>
        <div class="col-md-4">
            <x-form.form-date-picker
                :id="'from_date'"
                :label="__('Ngày bắt đầu')"
                :name="'from_date'"
                :maxDate="''"
                :placeholder="__('Ngày bắt đầu')"
                :isRequired="false"
            />
        </div>
        <div class="col-md-4">
            <x-form.form-date-picker
                :id="'to_date'"
                :label="__('Ngày kết thúc')"
                :name="'to_date'"
                :maxDate="''"
                :placeholder="__('Ngày kết thúc')"
                :isRequired="false"
            />
        </div>
    </div>
    <hr>
    <div class="filter-header row align-items-center">
        <div class="col-6 col-md-auto mb-md-0 ms-auto">
            <button type="button" class="btn btn-light-secondary w-100" id="remove-filter-btn">{{ __('Xoá bộ lọc') }}</button>
        </div>
        <div class="col-6 col-md-auto">
            <button type="button" class="btn btn-secondary w-100" id="filter-btn">{{ __('Lọc') }}</button>
        </div>
    </div>
</div>

@push('footerFiles')
    <script>
        function debounce(func, timeout = 500){
            let timer;
            return (...args) => {
                clearTimeout(timer);
                timer = setTimeout(() => { func.apply(this, args); }, timeout);
            };
        }

        const processChange = debounce(() => {
            $('#sProjectTable').DataTable().ajax.reload();
            $('#sDonationTable').DataTable().ajax.reload();
            $('#sVolunteerTable').DataTable().ajax.reload();

            Livewire.dispatch('initFilter');
            Livewire.dispatch('filterDataForStatistic', {
                search: $('.search-form-control').val(),
                userId: @json($project->user_id),
                projectCategoryId: @json($project->category_id),
                projectId: @json($project->id),
                projectType: @json($project->type->value),
                projectStatus: @json($project->status->value),
                donationVolunteerUserId: $('#donation_volunteer_user_id').val(),
                donationStatus: $('#donation_status').val(),
                volunteerStatus: $('#volunteer_status').val(),
                fromDate: $('#from_date').val(),
                toDate: $('#to_date').val(),
                donationPriceRange: $('#donation_price_range').val(),
            });
        });

        processChange();

        $('#filter-btn').on('click', function () {
            processChange();
        });

        $('#remove-filter-btn').on('click', function () {
            $('#from_date').val(null);
            $('#to_date').val(null);

            $('select').each(function () {
                if (this.tomselect) {
                    this.tomselect.setValue([]);
                }
            });
        });
    </script>
@endpush
