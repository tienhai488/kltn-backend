<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ __('Dashboard') }}
    </x-slot:pageTitle>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/tomSelect/tom-select.default.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/apex/apexcharts.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/flatpickr/flatpickr.css')}}">

        @vite([
            'resources/scss/light/plugins/tomSelect/custom-tomSelect.scss',
            'resources/scss/dark/plugins/tomSelect/custom-tomSelect.scss',

            'resources/scss/light/assets/components/list-group.scss',
            'resources/scss/dark/assets/components/list-group.scss',

            'resources/scss/light/assets/widgets/modules-widgets.scss',
            'resources/scss/dark/assets/widgets/modules-widgets.scss',

            'resources/scss/light/plugins/apex/custom-apexcharts.scss',
            'resources/scss/dark/plugins/apex/custom-apexcharts.scss',
        ])

        <style>
            .apexcharts-title-text {
                font-family: Nunito, sans-serif !important;
                font-size: 20px;
                font-weight: 600;
            }

            @media (max-width: 768px) {
                .apexcharts-title-text {
                    font-size: 16px;
                }
                .apexcharts-tooltip {
                    left: 10px !important;
                    right: 10px !important;
                    white-space: normal !important;
                }
            }
        </style>
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot:headerFiles>
    <!-- END GLOBAL MANDATORY STYLES -->

    <x-custom.breadcrumb
        :breadcrumb-items="[
            'Dashboard' => ''
        ]"
    />

    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="row widget-statistic">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                    <div id="dashboard-partials-widget-organizations-count" wire:ignore>
                        <livewire:admin.dashboard.partials.widget-organizations-count lazy />
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                    <div id="dashboard-partials-widget-individuals-count" wire:ignore>
                        <livewire:admin.dashboard.partials.widget-individuals-count lazy />
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                    <div id="dashboard-partials-widget-projects-count" wire:ignore>
                        <livewire:admin.dashboard.partials.widget-projects-count lazy />
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                    <div id="dashboard-partials-widget-users-count" wire:ignore>
                        <livewire:admin.dashboard.partials.widget-users-count lazy />
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                    <div id="dashboard-partials-widget-donations-count" wire:ignore>
                        <livewire:admin.dashboard.partials.widget-donations-count lazy />
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                    <div id="dashboard-partials-widget-donations-sum-amount" wire:ignore>
                        <livewire:admin.dashboard.partials.widget-donations-sum-amount lazy />
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                    <div id="dashboard-partials-widget-volunteers-count" wire:ignore>
                        <livewire:admin.dashboard.partials.widget-volunteers-count lazy />
                    </div>
                </div>
            </div>

            <x-custom.stat-box :id="'user-management-filter'" :custom-col="'col-lg-12'">
                <x-slot:boxTitle>
                    {{ __('Bộ lọc') }}
                </x-slot:boxTitle>

                @include('admin.dashboard.filters.index')
            </x-custom.stat-box>

            <div class="row layout-top-spacing widget-statistic">
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <div id="dashboard-partials-widget-project-amount-percent" wire:ignore>
                        <livewire:admin.dashboard.partials.widget-project-amount-percent lazy />
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <div id="dashboard-partials-widget-project-volunteer-percent" wire:ignore>
                        <livewire:admin.dashboard.partials.widget-project-volunteer-percent lazy />
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <div id="dashboard-partials-widget-project-time-percent" wire:ignore>
                        <livewire:admin.dashboard.partials.widget-project-time-percent lazy />
                    </div>
                </div>
            </div>

            <p class="text-center mt-3">Các số liệu dưới đây có thể được lọc theo thời gian.</p>

            <div class="row widget-statistic">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                    <div id="dashboard-partials-widget-common-projects-donations-sum-amount" wire:ignore>
                        <livewire:admin.dashboard.partials.widget-common-projects-donations-sum-amount lazy />
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                    <div id="dashboard-partials-widget-common-projects-count" wire:ignore>
                        <livewire:admin.dashboard.partials.widget-common-projects-count lazy />
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                    <div id="dashboard-partials-widget-common-projects-donations-count" wire:ignore>
                        <livewire:admin.dashboard.partials.widget-common-projects-donations-count lazy />
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                    <div id="dashboard-partials-widget-common-projects-volunteers-count" wire:ignore>
                        <livewire:admin.dashboard.partials.widget-common-projects-volunteers-count lazy />
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                    <div id="dashboard-partials-widget-user-donations-sum-amount" wire:ignore>
                        <livewire:admin.dashboard.partials.widget-user-donations-sum-amount lazy />
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                    <div id="dashboard-partials-widget-user-donations-projects-count" wire:ignore>
                        <livewire:admin.dashboard.partials.widget-user-donations-projects-count lazy />
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                    <div id="dashboard-partials-widget-user-donations-count" wire:ignore>
                        <livewire:admin.dashboard.partials.widget-user-donations-count lazy />
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                    <div id="dashboard-partials-widget-user-volunteers-projects-count" wire:ignore>
                        <livewire:admin.dashboard.partials.widget-user-volunteers-projects-count lazy />
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                    <div id="dashboard-partials-widget-user-volunteers-count" wire:ignore>
                        <livewire:admin.dashboard.partials.widget-user-volunteers-count lazy />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div id="dashboard-partials-chart-donation" wire:ignore>
                <livewire:admin.dashboard.partials.chart-donation lazy />
            </div>
        </div>
    </div>

    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div id="dashboard-partials-chart-volunteer" wire:ignore>
                <livewire:admin.dashboard.partials.chart-volunteer lazy />
            </div>
        </div>
    </div>

    {{-- <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div id="dashboard-partials-chart-donation-kpi" wire:ignore>
                <livewire:admin.dashboard.partials.chart-donation-kpi lazy />
            </div>
        </div>
    </div>

    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div id="dashboard-partials-chart-volunteer-kpi" wire:ignore>
                <livewire:admin.dashboard.partials.chart-volunteer-kpi lazy />
            </div>
        </div>
    </div> --}}

    <x-custom.stat-box :id="'general-settings-box'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            {{ __('Danh sách thông tin') }}
        </x-slot:boxTitle>

        <div class="simple-pill">
            <ul class="nav nav-pills mb-3" style="padding: 20px;" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">{{ __('Danh sách dự án') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">{{ __('Danh sách quyên góp') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">{{ __('Danh sách tình nguyện viên') }}</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                    <x-table.datatable
                        :id="'sProjectTable'"
                        :menu-length="[7, 10, 50, 100, 500]"
                        :page-length="10"
                        :show-menu-length="true"
                    >
                        <x-slot:tableHeader>
                            <tr>
                                <th class="text-center">No.</th>
                                <th>{{ __('Thông tin') }}</th>
                                <th>{{ __('Người tạo') }}</th>
                                <th>{{ __('Hình ảnh') }}</th>
                                <th>{{ __('Tên dự án') }}</th>
                                <th>{{ __('Mục tiêu') }}</th>
                                <th>{{ __('Thực tế') }}</th>
                                <th>{{ __('Quyên góp') }}</th>
                                <th>{{ __('Tình nguyện viên') }}</th>
                            </tr>
                        </x-slot:tableHeader>
                        <x-slot:customScript>
                            "processing": true,
                            "serverSide": true,
                            "ordering": false,
                            "ajax": {
                            "url": "{{ route('admin.dashboard.projects') }}",
                                "data": function(d) {
                                    let searchParams = new URLSearchParams(window.location.search);
                                    drawDT = d.draw;
                                    d.limit = d.length;
                                    d.page = d.start / d.length + 1;

                                    d.user_id = $('#user_id').val() || searchParams.get('user_id');
                                    d.project_category_id = $('#project_category_id').val() || searchParams.get('project_category_id');
                                    d.project_id = $('#project_id').val() || searchParams.get('project_id');
                                    d.project_type = $('#project_type').val() || searchParams.get('project_type');
                                    d.project_status = $('#project_status').val() || searchParams.get('project_status');
                                    d.donation_volunteer_user_id = $('#donation_volunteer_user_id').val() || searchParams.get('donation_volunteer_user_id');
                                    d.donation_status = $('#donation_status').val() || searchParams.get('donation_status');
                                    d.volunteer_status = $('#volunteer_status').val() || searchParams.get('volunteer_status');
                                    d.from_date = $('#from_date').val() || searchParams.get('from_date');
                                    d.to_date = $('#to_date').val() || searchParams.get('to_date');
                                    d.donation_price_range = $('#donation_price_range').val() || searchParams.get('donation_price_range');
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
                                    "data": "id",
                                    "render": function (data, type, full) {
                                        return `
                                            <div class="d-flex">
                                                <p class="text-start me-1">{{ __('Danh mục') }}:</p>
                                                <p class="text-primary">${full.category.name}</p>
                                            </div>
                                            <div class="d-flex">
                                                <p class="text-start me-1">{{ __('Loại dự án') }}:</p>
                                                <p class="text-primary">${full.type}</p>
                                            </div>
                                            <div class="d-flex align-items-end">
                                                <p class="text-start me-1">{{ __('Trạng thái') }}:</p>
                                                <p class="text-primary"><span class="badge badge-${full.status_badge}">${full.status_label}</span></p>
                                            </div>
                                            <div class="d-flex align-items-end">
                                                <p class="text-start me-1 text-primary">${full.start_date} -> ${full.end_date}</p>
                                            </div>
                                        `;
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
                                    "data": "background_image",
                                    "class": "text-center",
                                    "render": function (data, type, full) {
                                        return `<div class="avatar me-3">
                                            <img src="${data}" alt="Image" width="64" height="64">
                                        </div>`;
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
                            ]
                        </x-slot:customScript>
                    </x-table.datatable>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                    <x-table.datatable
                        :id="'sDonationTable'"
                        :menu-length="[7, 10, 50, 100, 500]"
                        :page-length="10"
                        :show-menu-length="true"
                    >
                        <x-slot:tableHeader>
                            <tr>
                                <th class="text-center">No.</th>
                                <th>{{ __('Người tạo') }}</th>
                                <th>{{ __('Dự án') }}</th>
                                <th>{{ __('T/t chuyển khoản') }}</th>
                                <th>{{ __('T/t người chuyển') }}</th>
                                <th>{{ __('Chế độ') }}</th>
                                <th>{{ __('T/t sinh viên') }}</th>
                            </tr>
                        </x-slot:tableHeader>
                        <x-slot:customScript>
                            "processing": true,
                            "serverSide": true,
                            "ordering": false,
                            "ajax": {
                            "url": "{{ route('admin.dashboard.donations') }}",
                                "data": function(d) {
                                    let searchParams = new URLSearchParams(window.location.search);
                                    drawDT = d.draw;
                                    d.limit = d.length;
                                    d.page = d.start / d.length + 1;

                                    d.user_id = $('#user_id').val() || searchParams.get('user_id');
                                    d.project_category_id = $('#project_category_id').val() || searchParams.get('project_category_id');
                                    d.project_id = $('#project_id').val() || searchParams.get('project_id');
                                    d.project_type = $('#project_type').val() || searchParams.get('project_type');
                                    d.project_status = $('#project_status').val() || searchParams.get('project_status');
                                    d.donation_volunteer_user_id = $('#donation_volunteer_user_id').val() || searchParams.get('donation_volunteer_user_id');
                                    d.donation_status = $('#donation_status').val() || searchParams.get('donation_status');
                                    d.volunteer_status = $('#volunteer_status').val() || searchParams.get('volunteer_status');
                                    d.from_date = $('#from_date').val() || searchParams.get('from_date');
                                    d.to_date = $('#to_date').val() || searchParams.get('to_date');
                                    d.donation_price_range = $('#donation_price_range').val() || searchParams.get('donation_price_range');
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
                                            <div class="d-flex align-items-end">
                                                <p class="text-start me-1">{{ __('Trạng thái') }}:</p>
                                                <p class="text-primary"><span class="badge badge-${full.status_badge}">${full.status_label}</span></p>
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
                            ]
                        </x-slot:customScript>
                    </x-table.datatable>
                </div>
                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
                    <x-table.datatable
                        :id="'sVolunteerTable'"
                        :menu-length="[7, 10, 50, 100, 500]"
                        :page-length="10"
                        :show-menu-length="true"
                    >
                        <x-slot:tableHeader>
                            <tr>
                                <th class="text-center">No.</th>
                                <th>{{ __('Người tạo') }}</th>
                                <th>{{ __('Dự án') }}</th>
                                <th>{{ __('T/t tình nguyện viên') }}</th>
                                <th>{{ __('Trạng thái') }}</th>
                                <th>{{ __('T/t sinh viên') }}</th>
                            </tr>
                        </x-slot:tableHeader>
                        <x-slot:customScript>
                            "processing": true,
                            "serverSide": true,
                            "ordering": false,
                            "ajax": {
                            "url": "{{ route('admin.dashboard.volunteers') }}",
                                "data": function(d) {
                                    let searchParams = new URLSearchParams(window.location.search);
                                    drawDT = d.draw;
                                    d.limit = d.length;
                                    d.page = d.start / d.length + 1;

                                    d.user_id = $('#user_id').val() || searchParams.get('user_id');
                                    d.project_category_id = $('#project_category_id').val() || searchParams.get('project_category_id');
                                    d.project_id = $('#project_id').val() || searchParams.get('project_id');
                                    d.project_type = $('#project_type').val() || searchParams.get('project_type');
                                    d.project_status = $('#project_status').val() || searchParams.get('project_status');
                                    d.donation_volunteer_user_id = $('#donation_volunteer_user_id').val() || searchParams.get('donation_volunteer_user_id');
                                    d.donation_status = $('#donation_status').val() || searchParams.get('donation_status');
                                    d.volunteer_status = $('#volunteer_status').val() || searchParams.get('volunteer_status');
                                    d.from_date = $('#from_date').val() || searchParams.get('from_date');
                                    d.to_date = $('#to_date').val() || searchParams.get('to_date');
                                    d.donation_price_range = $('#donation_price_range').val() || searchParams.get('donation_price_range');
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
                                        return `<span class="badge badge-${full.status_badge}">${full.status_label}</span>`;
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
                            ]
                        </x-slot:customScript>
                    </x-table.datatable>
                </div>
            </div>

        </div>
    </x-custom.stat-box>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/tomSelect/tom-select.base.js') }}"></script>
        <script src="{{asset('plugins/apex/apexcharts.min.js')}}"></script>
        <script src="{{ asset('plugins/flatpickr/flatpickr.js') }}"></script>
        <script src="{{ asset('plugins/flatpickr/l10n/vn.js') }}"></script>
        <!-- CSRF handling script for AJAX requests -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Setup CSRF token for all AJAX requests
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': @json(csrf_token()),
                    }
                });

                // Handle session timeouts
                $(document).ajaxError(function(event, jqxhr, settings, thrownError) {
                    if (jqxhr.status === 419) {
                        location.reload();
                    }
                });
            });
        </script>
    </x-slot:footerFiles>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
