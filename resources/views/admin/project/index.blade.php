<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ __('Quản lý dự án') }}
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

    <x-custom.breadcrumb :breadcrumb-items="['dự án' => '', 'Quản lý dự án' => '']"/>

    <x-custom.stat-box :id="'project-management-filter'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            {{ __('Bộ lọc') }}
        </x-slot:boxTitle>

        @include('admin.project.filters.index')
    </x-custom.stat-box>

    <x-custom.stat-box :id="'general-settings-box'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            {{ __('Quản lý dự án') }}
        </x-slot:boxTitle>
        @can(Acl::PERMISSION_PROJECT_ADD)
        <x-slot:action>
            <div class="layout-top-spacing mx-3 col-12">
                <x-buttons.button-link
                    :label="__('Tạo mới dự án')"
                    :url="route('admin.project.create')"
                />
            </div>
        </x-slot:action>
        @endcan

        <x-table.datatable
            :id="'sProjectTable'"
            :menu-length="[7, 10, 50, 100, 500]"
            :page-length="10"
            :show-menu-length="true"
        >
            <x-slot:tableHeader>
                <tr>
                    <th class="text-center">No.</th>
                    <th>{{ __('Danh mục') }}</th>
                    <th>{{ __('Người tạo') }}</th>
                    <th>{{ __('Tên dự án') }}</th>
                    <th>{{ __('Mục tiêu') }}</th>
                    <th>{{ __('Thực tế') }}</th>
                    <th>{{ __('Quyên góp') }}</th>
                    <th>{{ __('Tình nguyện viên') }}</th>
                    <th>{{ __('Thời gian') }}</th>
                    <th>{{ __('Loại dự án') }}</th>
                    <th>{{ __('Trạng thái') }}</th>
                    <th class="text-center dt-no-sorting">{{ __('Thao tác') }}</th>
                </tr>
            </x-slot:tableHeader>
            <x-slot:customScript>
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "ajax": {
                "url": "{{ route('admin.project.index') }}",
                    "data": function(d) {
                        let searchParams = new URLSearchParams(window.location.search);
                        drawDT = d.draw;
                        d.limit = d.length;
                        d.page = d.start / d.length + 1;

                        d.status = $('#sStatus').val() || searchParams.get('status');
                        d.type = $('#sType').val() || searchParams.get('type');
                        d.user_id = $('#sUser').val() || searchParams.get('user_id');
                        d.category_id = $('#sCategory').val() || searchParams.get('category_id');
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
                        "data": "category",
                        "class": "text-center",
                        "render": function (data, type, full) {
                            return `<span class="badge badge-primary">${data.name}</span>`;
                        }
                    },
                    {
                        "data": "user",
                        "render": function (data, type, full) {
                            return `
                                <div class="d-flex">
                                    <p class="text-start me-1">{{ __('Tên') }}:</p>
                                    <p class="text-primary">${data.name}</p>
                                </div>
                                <div class="d-flex">
                                    <p class="text-start me-1">{{ __('Email') }}:</p>
                                    <p class="text-primary">${data.email}</p>
                                </div>
                                <div class="d-flex">
                                    <p class="text-start me-1">{{ __('Số điện thoại') }}:</p>
                                    <p class="text-primary">${data.phone_number ?? 'N/A'}</p>
                                </div>
                            `;
                        }
                    },
                    {
                        "data": "name",
                    },
                    {
                        "data": "id",
                        "render": function (data, type, full) {
                            return `
                                <div class="d-flex justify-content-between">
                                    <p class="text-start me-1">{{ __('Số tiền') }}:</p>
                                    <p class="text-primary">${full.donation_target}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="text-start me-1">{{ __('Tình nguyện viên') }}:</p>
                                    <p class="text-primary">${full.volunteer_quantity}</p>
                                </div>
                            `;
                        }
                    },
                    {
                        "data": "id",
                        "render": function (data, type, full) {
                            return `
                                <div class="d-flex justify-content-between">
                                    <p class="text-start me-1">{{ __('Số tiền') }}:</p>
                                    <p class="text-primary">${full.donations_sum_amount}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="text-start me-1">{{ __('Tình nguyện viên') }}:</p>
                                    <p class="text-primary">${full.volunteers_without_canceled_count}</p>
                                </div>
                            `;
                        }
                    },
                    {
                        "data": "donations_count",
                        "class": "text-center",
                        "render": function (data, type, full) {
                            let url = `{{ route('admin.donation.index') }}?project_id=${full.id}`;

                            return `<a class="btn btn-success text-nowrap p-1" href="${url}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye p-1 br-6 mb-1"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>
                            </svg> (${data})</a>`;
                        }
                    },
                    {
                        "data": "volunteers_count",
                        "class": "text-center",
                        "render": function (data, type, full) {
                            let url = `{{ route('admin.volunteer.index') }}?project_id=${full.id}`;

                            return `<a class="btn btn-success text-nowrap p-1" href="${url}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye p-1 br-6 mb-1"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>
                            </svg> (${data})</a>`;
                        }
                    },
                    {
                        "data": "id",
                        "class": "text-center",
                        "render": function (data, type, full) {
                            return `${full.start_date} - ${full.end_date}`;
                        }
                    },
                    {
                        "data": "type",
                        "class": "text-center",
                        "render": function (data, type, full) {
                            return `<span class="badge badge-info">${data}</span>`;
                        }
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
                            let urlShow = `{{ route('admin.project.show', ':id') }}`.replace(':id', data);
                            let urlEdit = `{{ route('admin.project.edit', ':id') }}`.replace(':id', data);
                            let urlDestroy = `{{ route('admin.project.destroy', ':id') }}`.replace(':id', data);

                            return `
                                <ul class="table-controls d-flex justify-content-center">
                                    <x-table.actions.show-action
                                        :permission="Acl::PERMISSION_PROJECT_LIST"
                                        :url="'${urlShow}'"
                                    />
                                    <x-table.actions.edit-action
                                        :permission="Acl::PERMISSION_PROJECT_EDIT"
                                        :url="'${urlEdit}'"
                                    />
                                    {{-- <x-table.actions.delete-action
                                        :permission="Acl::PERMISSION_PROJECT_DELETE"
                                        :url="'${urlDestroy}'"
                                        dataTableId="#sProjectTable"
                                    /> --}}
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
