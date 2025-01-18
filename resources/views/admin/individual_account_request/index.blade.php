<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ __('Quản lý yêu cầu tài khoản cá nhân') }}
    </x-slot:pageTitle>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/tomSelect/tom-select.default.min.css') }}">
        @vite([
            'resources/scss/light/plugins/tomSelect/custom-tomSelect.scss',
            'resources/scss/dark/plugins/tomSelect/custom-tomSelect.scss'
        ])
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot:headerFiles>
    <!-- END GLOBAL MANDATORY STYLES -->

    <x-custom.breadcrumb :breadcrumb-items="['yêu cầu tài khoản cá nhân' => '', 'Quản lý yêu cầu tài khoản cá nhân' => '']"/>

    <x-custom.stat-box :id="'individual-management-filter'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            {{ __('Bộ lọc') }}
        </x-slot:boxTitle>

        @include('admin.individual_account_request.filters.index')
    </x-custom.stat-box>

    <x-custom.stat-box :id="'general-settings-box'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            {{ __('Quản lý yêu cầu tài khoản cá nhân') }}
        </x-slot:boxTitle>

        <x-table.datatable
            :id="'sIndividualTable'"
            :menu-length="[7, 10, 50, 100, 500]"
            :page-length="10"
            :show-menu-length="true"
        >
            <x-slot:tableHeader>
                <tr>
                    <th class="text-center">No.</th>
                    <th>{{ __('Họ tên') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Số điện thoại') }}</th>
                    <th>{{ __('Ngày sinh') }}</th>
                    <th>{{ __('Tên CLB') }}</th>
                    <th>{{ __('Trạng thái') }}</th>
                    <th class="text-center dt-no-sorting">{{ __('Thao tác') }}</th>
                </tr>
            </x-slot:tableHeader>
            <x-slot:customScript>
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "ajax": {
                "url": "{{ route('admin.individual_account_request.index') }}",
                    "data": function(d) {
                        let searchParams = new URLSearchParams(window.location.search);
                        drawDT = d.draw;
                        d.limit = d.length;
                        d.page = d.start / d.length + 1;

                        d.status = $('#sStatus').val() || searchParams.get('status');
                    },
                    "dataSrc": function(res) {
                        res.draw = drawDT;
                        res.recordsTotal = res.meta.total;
                        res.recordsFiltered = res.meta.total;
                        return res.data;
                    }
                },
                "columns": [
                    {
                        "class": "text-center",
                        "render": (data, type, row, meta) =>  meta.row + 1 + meta.settings._iDisplayStart,
                    },
                    {
                        "data": "name",
                    },
                    {
                        "data": "email",
                    },
                    {
                        "data": "phone_number",
                    },
                    {
                        "data": "birth",
                    },
                    {
                        "data": "club_name",
                    },
                    {
                        "data": "status_label",
                        "class": "text-center",
                        "render": function (data, type, full) {
                            return `<span class="badge badge-${full.status_badge}">${data}</span>`;
                        }
                    },
                    {
                        "data": "id",
                        "class": "text-center no-content",
                        "orderable": false,
                        "render": function (data, type, full) {
                            let urlCreate = `{{ route('admin.individual_account_request.create') }}?id=:id`.replace(':id', data);
                            let urlShow = `{{ route('admin.individual_account_request.show', ':id') }}`.replace(':id', data);

                            return `
                                <ul class="table-controls d-flex justify-content-center">
                                    @can(Acl::PERMISSION_USER_ADD)
                                    <li>
                                        <a
                                            href="${urlCreate}"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="{{ __('Thêm') }}"
                                            data-original-title="{{ __('Thêm') }}"
                                            class="bs-tooltip"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle p-1 br-6 mb-1"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                        </a>
                                    </li>
                                    @endcan
                                    <x-table.actions.show-action
                                        :permission="Acl::PERMISSION_ACCOUNT_REQUEST_LIST"
                                        :url="'${urlShow}'"
                                    />
                                </ul>`;
                        }
                    },
                ]
            </x-slot:customScript>
        </x-table.datatable>
    </x-custom.stat-box>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/tomSelect/tom-select.base.js') }}"></script>
    </x-slot:footerFiles>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
