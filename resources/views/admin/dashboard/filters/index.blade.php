<div class="col-lg-12">
    <div id="filterBody" class="row align-items-center">
        <div class="col-md-4">
            <x-form.form-select
                :id="'sCampaignSelect'"
                :label="__('general.common.campaign')"
                :data-values="$campaigns"
                :select-value-attribute="'id'"
                :select-value-label="'name'"
                :name="'campaign_id'"
                :multiple="false"
                :placeholder="__('general.common.campaign')"
                :is-filter="true"
            />
        </div>

        <div class="col-md-4">
            <x-form.form-select
                :id="'sChannels'"
                :label="__('Kênh')"
                :data-values="$channels"
                :select-value-attribute="'id'"
                :select-value-label="'name'"
                :placeholder="__('Kênh')"
                :name="'channel_ids'"
                :multiple="true"
                :is-filter="true"
            />
        </div>

        <div class="col-md-4">
            <x-form.form-select
                :id="'sAreas'"
                :label="__('Khu vực')"
                :data-values="$areas"
                :select-value-attribute="'id'"
                :select-value-label="'name'"
                :placeholder="__('Khu vực')"
                :name="'area_ids'"
                :multiple="true"
                :is-filter="true"
            />
        </div>

        <div class="col-md-4">
            <x-form.form-select
                :id="'sProvinces'"
                :label="__('Tỉnh thành')"
                :data-values="$provinces"
                :select-value-attribute="'id'"
                :select-value-label="'name'"
                :placeholder="__('Tỉnh thành')"
                :name="'province_ids'"
                :multiple="true"
                :is-filter="true"
            />
        </div>

        <div class="col-md-4">
            <x-form.form-select
                :id="'sAddress'"
                :label="__('Địa chỉ')"
                :data-values="$addresses"
                :select-value-attribute="'id'"
                :select-value-label="'name'"
                :placeholder="__('Địa chỉ')"
                :name="'address_ids'"
                :multiple="true"
                :is-filter="true"
            />
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <x-form.form-date-picker
                        :id="'sFromDateSelect'"
                        :label="__('general.common.from_date')"
                        :name="'from_date'"
                        :maxDate="''"
                        :placeholder="__('general.common.from_date')"
                        :isRequired="false"
                    />
                </div>
                <div class="col-md-4">
                    <x-form.form-date-picker
                        :id="'sToDateSelect'"
                        :label="__('general.common.to_date')"
                        :name="'to_date'"
                        :maxDate="''"
                        :placeholder="__('general.common.to_date')"
                        :isRequired="false"
                    />
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <x-form.form-select
                :id="'sAdmins'"
                :label="__('Project Leader')"
                :data-values="$admins"
                :select-value-attribute="'id'"
                :select-value-label="'name'"
                :placeholder="__('Project Leader')"
                :name="'admin_ids'"
                :multiple="true"
                :is-filter="true"
            />
        </div>

        <div class="col-md-4">
            <x-form.form-select
                :id="'sSupervisor'"
                :label="__('Sup')"
                :data-values="$supervisors"
                :select-value-attribute="'id'"
                :select-value-label="'name'"
                :placeholder="__('Sup')"
                :name="'supervisor_ids'"
                :multiple="true"
                :is-filter="true"
            />
        </div>

        <div class="col-md-4">
            <x-form.form-select
                :id="'sStaff'"
                :label="__('PG/PB')"
                :data-values="$staffs"
                :select-value-attribute="'id'"
                :select-value-label="'name'"
                :placeholder="__('PG/PB')"
                :name="'staff_ids'"
                :multiple="true"
                :is-filter="true"
            />
        </div>

    </div>
    <hr>
    <div class="filter-header row align-items-center">
        <div class="col-12 col-md-auto mb-2 mb-md-0">
            <button type="button" class="btn btn-light-dark w-100" id="select-all-btn">Chọn tất cả</button>
        </div>

        <div class="col-6 col-md-auto mb-md-0 ms-auto ">
            <button type="button" class="btn btn-secondary w-100" id="filter-btn">{{ __('Lọc') }}</button>
        </div>

        <div class="col-6 col-md-auto">
            <button type="button" class="btn btn-light-secondary w-100" id="remove-filter-btn">{{ __('Xoá bộ lọc') }}</button>
        </div>
    </div>

</div>

@push('footerFiles')
    <script>
        function checkHasItems() {
            const hasItems = $('.has-items').length > 0;
            const filterBtn = $('#filter-btn');
            const fromDateRaw = $('#sFromDateSelect').val();
            const toDateRaw = $('#sToDateSelect').val();

            if (!fromDateRaw && !toDateRaw && !hasItems) {
                filterBtn.prop('disabled', true);
            } else {
                filterBtn.prop('disabled', false);
            }
        }

        $('select').on('change', function() {
            checkHasItems();
        });

        $('#sFromDateSelect, #sToDateSelect').on('input', function() {
            checkHasItems();
        });

        $(document).ready(function() {
            checkHasItems();

            let allSelected = true;

            $('select').each(function() {
                if (this.id !== 'sCampaignSelect' && this.tomselect) {
                    const selectedValues = this.tomselect.getValue();
                    const allValues = Object.keys(this.tomselect.options);

                    if (selectedValues.length !== allValues.length) {
                        allSelected = false;
                    }
                }
            });

            if (allSelected) {
                updateAllText();
            }
        });

        $('#filter-btn').on('click', function () {
            const fromDateRaw = $('#sFromDateSelect').val();
            const toDateRaw = $('#sToDateSelect').val();

            $('.widget-one_hybrid').removeClass('d-none');

            Livewire.dispatch('filterDashboard');
            Livewire.dispatch('filterDashboardShowCampaign', {
                fromDate: fromDateRaw.split('/').reverse().join('-'),
                toDate: toDateRaw.split('/').reverse().join('-'),
                campaignId: $('#sCampaignSelect').val(),
                areaIds: $('#sAreas').val(),
                provinceIds: $('#sProvinces').val(),
                addressIds: $('#sAddress').val(),
                adminIds: $('#sAdmins').val(),
                supervisorIds: $('#sSupervisor').val(),
                staffIds: $('#sStaff').val(),
                channelIds: $('#sChannels').val(),
            });
        });

        $('#remove-filter-btn').on('click', function () {
            $('#sFromDateSelect').val(null).trigger('change');
            $('#sToDateSelect').val(null).trigger('change');
            checkHasItems();
        });

        $('#select-all-btn').on('click', function () {
            updateAllText();
            checkHasItems();
        });

        function updateAllText() {
            $('select').each(function () {
                const selectElement = this;

                if (selectElement.id !== 'sCampaignSelect' && selectElement.tomselect) {
                    const allValues = Object.keys(selectElement.tomselect.options);

                    selectElement.tomselect.setValue(allValues);

                    const items = selectElement.tomselect.wrapper.querySelectorAll('.item');

                    items.forEach((item, index) => {
                        if (index === 0) {
                            item.textContent = 'Tất cả';
                        } else {
                            item.style.display = 'none';
                        }
                    });

                    selectElement.tomselect.refreshOptions();
                }
            });
        }

    </script>
@endpush
