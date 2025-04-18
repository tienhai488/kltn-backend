<x-member.base-layout :scrollspy="false">

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

        @include('member.donation.filters.index')
    </x-custom.stat-box>

    <x-custom.stat-box :id="'general-settings-box'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            {{ __('Quản lý quyên góp') }}
        </x-slot:boxTitle>

        <x-slot:action>
            <div class="layout-top-spacing mx-3 col-12">
                <button type="button" id="exportButton" class="btn btn-success">
                    {{ __('Xuất excel tất cả') }}
                </button>
                <button type="button" id="studentExportButton" class="btn btn-primary">
                    {{ __('Xuất excel chỉ lấy sinh viên') }}
                </button>
            </div>
        </x-slot:action>

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
                    <th>{{ __('T/t sinh viên') }}</th>
                    <th>{{ __('Chế độ') }}</th>
                    <th class="text-center dt-no-sorting">{{ __('Thao tác') }}</th>
                </tr>
            </x-slot:tableHeader>
            <x-slot:customScript>
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "ajax": {
                "url": "{{ route('member.donation.index') }}",
                    "data": function(d) {
                        let searchParams = new URLSearchParams(window.location.search);
                        drawDT = d.draw;
                        d.limit = d.length;
                        d.page = d.start / d.length + 1;

                        d.user_id = $('#user_id').val() || searchParams.get('user_id');
                        d.projects_belong_to_user_id = @json(auth()->id());
                        d.project_id = $('#project_id').val() || searchParams.get('project_id');
                        d.department_id = $('#department_id').val() || searchParams.get('department_id');
                        d.payment_status = $('#payment_status').val() || searchParams.get('payment_status');
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
                        "data": "project",
                        "render": function (data, type, full) {
                            return `
                                <div class="d-flex">
                                    <p class="text-start me-1">{{ __('Tên dự án') }}:</p>
                                    <p class="text-primary">${data.name}</p>
                                </div>
                                <div class="d-flex">
                                    <p class="text-start me-1">{{ __('Người tạo') }}:</p>
                                    <p class="text-primary">${data.user.name}</p>
                                </div>
                                <div class="d-flex">
                                    <p class="text-start me-1">{{ __('Danh mục') }}:</p>
                                    <p class="text-primary">${data.category.name}</p>
                                </div>
                                <div class="d-flex">
                                    <p class="text-start me-1">{{ __('Loại dự án') }}:</p>
                                    <p class="text-primary">${data.type}</p>
                                </div>
                                <div class="d-flex align-items-end">
                                    <p class="text-start me-1">{{ __('Trạng thái') }}:</p>
                                    <p class="text-primary"><span class="badge badge-${data.status_badge}">${data.status_label}</span></p>
                                </div>
                                <div class="d-flex align-items-end">
                                    <p class="text-start me-1 text-primary">${data.start_date} -> ${data.end_date}</p>
                                </div>
                            `;
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
                        "class": "text-center",
                        "render": function (data, type, full) {
                            return `<span class="badge badge-${full.anonymous_status_badge}">${full.anonymous_status_label}</span>`;
                        }
                    },
                    {
                        "data": "id",
                        "class": "text-center no-content",
                        "orderable": false,
                        "render": function (data, type, full) {
                            let urlShow = `{{ route('member.donation.show', ':id') }}`.replace(':id', data);

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
        <script>
            function handleExport(isStudent = false) {
                    const userId = $('#user_id').val() || null;
                    const projectsBelongToUserId = @json(auth()->id());
                    const projectId = $('#project_id').val() || null;
                    const departmentId = $('#department_id').val() || null;
                    const isAnonymous = $('#is_anonymous').val() || null;
                    const paymentStatus = $('#payment_status').val() || null;

                    let exportUrl = @json(route('member.donation.export'));
                    const params = new URLSearchParams();

                    if (userId) params.append('user_id', userId);
                    if (projectsBelongToUserId) params.append('projects_belong_to_user_id', projectsBelongToUserId);
                    if (projectId) params.append('project_id', projectId);
                    if (departmentId) params.append('department_id', departmentId);
                    if (isAnonymous) params.append('is_anonymous', isAnonymous);
                    if (paymentStatus) params.append('payment_status', paymentStatus);
                    params.append('is_student', isStudent);
                    params.append('limit', 9999);

                    const queryString = params.toString();
                    if (queryString) {
                        exportUrl += '?' + queryString;
                    }

                    window.open(exportUrl, '_blank');
            }

            function handleChangeInput() {
                if ($('#project_id').val()) {
                    $('#exportButton').removeClass('d-none').prop('disabled', false);
                    $('#studentExportButton').removeClass('d-none').prop('disabled', false);
                } else {
                    $('#exportButton').addClass('d-none').prop('disabled', true);
                    $('#studentExportButton').addClass('d-none').prop('disabled', true);
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                $('#exportButton').on('click', function() {
                    handleExport();
                });

                $('#studentExportButton').on('click', function() {
                    handleExport(true);
                });

                $('#project_id').on('change', function() {
                    handleChangeInput();
                });

                handleChangeInput();
            });
        </script>
    </x-slot:footerFiles>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-member.base-layout>
