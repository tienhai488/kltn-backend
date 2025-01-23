<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ __('Quản lý quyên góp') }}
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

    <x-custom.breadcrumb :breadcrumb-items="['quyên góp' => '', 'Quản lý quyên góp' => '']"/>

    <x-custom.stat-box :id="'donation-management-filter'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            {{ __('Bộ lọc') }}
        </x-slot:boxTitle>

        @include('admin.donation.filters.index')
    </x-custom.stat-box>

    <x-custom.stat-box :id="'general-settings-box'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            {{ __('Quản lý quyên góp') }}
        </x-slot:boxTitle>

        <x-table.datatable
            :id="'sDonationTable'"
            :menu-length="[7, 10, 50, 100, 500]"
            :page-length="10"
            :show-menu-length="true"
        >
            <x-slot:tableHeader>
                <tr>
                    <th class="text-center">No.</th>
                    <th>{{ __('Người dùng') }}</th>
                    <th>{{ __('Dự án') }}</th>
                    <th>{{ __('T/t chuyển khoản') }}</th>
                    <th>{{ __('T/t người chuyển') }}</th>
                    <th>{{ __('Chế độ') }}</th>
                    <th>{{ __('T/t sinh viên') }}</th>
                    <th class="text-center dt-no-sorting">{{ __('Thao tác') }}</th>
                </tr>
            </x-slot:tableHeader>
            <x-slot:customScript>
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "ajax": {
                "url": "{{ route('admin.donation.index') }}",
                    "data": function(d) {
                        let searchParams = new URLSearchParams(window.location.search);
                        drawDT = d.draw;
                        d.limit = d.length;
                        d.page = d.start / d.length + 1;

                        d.user_id = $('#user_id').val() || searchParams.get('user_id');
                        d.project_id = $('#project_id').val() || searchParams.get('project_id');
                        d.department_id = $('#department_id').val() || searchParams.get('department_id');
                        d.is_anonymous = $('#is_anonymous').val() || searchParams.get('is_anonymous');
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
                        "data": "user",
                        "render": function (data, type, full) {
                            return data?.name ?? 'N/A';
                        }
                    },
                    {
                        "data": "project",
                        "render": function (data, type, full) {
                            return data.name;
                        }
                    },
                    {
                        "data": "id",
                        "render": function (data, type, full) {
                            return `
                                <div class="d-flex">
                                    <p class="text-start me-1">{{ __('Số TK') }}:</p>
                                    <p class="text-primary">${full.account_number}</p>
                                </div>
                                <div class="d-flex">
                                    <p class="text-start me-1">{{ __('Tên TK') }}:</p>
                                    <p class="text-primary">${full.account_name}</p>
                                </div>
                                <div class="d-flex">
                                    <p class="text-start me-1">{{ __('Mã GD') }}:</p>
                                    <p class="text-primary">${full.code}</p>
                                </div>
                                <div class="d-flex">
                                    <p class="text-start me-1">{{ __('Số tiền') }}:</p>
                                    <p class="text-primary">${full.amount}</p>
                                </div>
                                <div class="d-flex">
                                    <p class="text-start me-1">{{ __('Thời gian') }}:</p>
                                    <p class="text-primary">${full.created_at}</p>
                                </div>
                            `;
                        }
                    },
                    {
                        "data": "id",
                        "render": function (data, type, full) {
                            return `
                                <div class="d-flex">
                                    <p class="text-start me-1">{{ __('Họ tên') }}:</p>
                                    <p class="text-primary">${full.name ?? 'N/A'}</p>
                                </div>
                                <div class="d-flex">
                                    <p class="text-start me-1">{{ __('Email') }}:</p>
                                    <p class="text-primary">${full.email ?? 'N/A'}</p>
                                </div>
                                <div class="d-flex">
                                    <p class="text-start me-1">{{ __('SĐT') }}:</p>
                                    <p class="text-primary">${full.phone_number ?? 'N/A'}</p>
                                </div>
                            `;
                        }
                    },
                    {
                        "data": "id",
                        "class": "text-center",
                        "render": function (data, type, full) {
                            return `<span class="badge badge-${full.anonymous_status_badge}">${full.anonymous_status_label}</span>`;
                        }
                    },
                    {
                        "data": "id",
                        "render": function (data, type, full) {
                            return `
                                <div class="d-flex">
                                    <p class="text-start me-1">{{ __('Khoa') }}:</p>
                                    <p class="text-primary">${full.department?.name ?? 'N/A'}</p>
                                </div>
                                <div class="d-flex">
                                    <p class="text-start me-1">{{ __('Lớp') }}:</p>
                                    <p class="text-primary">${full.class ?? 'N/A'}</p>
                                </div>
                                <div class="d-flex">
                                    <p class="text-start me-1">{{ __('MSSV') }}:</p>
                                    <p class="text-primary">${full.student_code ?? 'N/A'}</p>
                                </div>
                            `;
                        }
                    },
                    {
                        "data": "id",
                        "class": "text-center no-content",
                        "orderable": false,
                        "render": function (data, type, full) {
                            let urlShow = `{{ route('admin.donation.show', ':id') }}`.replace(':id', data);

                            return `
                                <ul class="table-controls d-flex justify-content-center">
                                    <x-table.actions.show-action
                                        :permission="Acl::PERMISSION_DONATION_LIST"
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
