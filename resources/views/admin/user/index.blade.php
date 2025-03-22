<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ __('Quản lý người dùng') }}
    </x-slot:pageTitle>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/tomSelect/tom-select.default.min.css')}}">
        @vite([
            'resources/scss/light/plugins/tomSelect/custom-tomSelect.scss',
            'resources/scss/dark/plugins/tomSelect/custom-tomSelect.scss'
        ])
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot:headerFiles>
    <!-- END GLOBAL MANDATORY STYLES -->

    <x-custom.breadcrumb :breadcrumb-items="['Người dùng' => '', __('Quản lý người dùng') => '']"/>

    <x-custom.stat-box :id="'user-management-filter'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            {{ __('Bộ lọc') }}
        </x-slot:boxTitle>

        @include('admin.user.filters.index')
    </x-custom.stat-box>

    <x-custom.stat-box :id="'general-settings-box'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            {{ __('Quản lý người dùng') }}
        </x-slot:boxTitle>
        <x-slot:action>
            <div class="layout-top-spacing mx-3 col-12">
                <x-buttons.button-link
                    :label="__('Thêm mới người dùng')"
                    :url="route('admin.user.create')"
                />
            </div>
        </x-slot:action>

        <x-table.datatable
            :id="'sUserTable'"
            :menu-length="[7, 10, 50, 100, 500]"
            :page-length="10"
            :show-menu-length="true"
        >
            <x-slot:tableHeader>
                <tr>
                    <th class="text-center">No.</th>
                    <th>{{ __('Tên người dùng') }}</th>
                    <th>{{ __('Tên tài khoản') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Số điện thoại') }}</th>
                    <th>{{ __('Trạng thái') }}</th>
                    <th>{{ __('Vai trò') }}</th>
                    <th class="text-center dt-no-sorting">{{ __('Thao tác') }}</th>
                </tr>
            </x-slot:tableHeader>
            <x-slot:customScript>
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "ajax": {
                "url": "{{ route('admin.user.index') }}",
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
                        "data": "username",
                    },
                    {
                        "data": "email",
                    },
                    {
                        "data": "phone_number",
                        "render": function (data, type, full) {
                            return data ? data : 'N/A';
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
                        "data": "roles",
                        "class": "block-td",
                        "render": function (data, type, full) {
                            let roles = data;
                            let roleBadges = `<strong class="d-none">Vai trò: </strong>`;

                            for (let i = 0; i < roles.length; i++) {
                                roleBadges += `
                                    <span class="badge badge-secondary">
                                        ${roles[i].name}
                                    </span>
                                `;
                            }

                            return roleBadges;
                        }
                    },
                    {
                        "data": "id",
                        "class": "text-center no-content",
                        "orderable": false,
                        "render": function (data, type, full) {
                            let urlEdit = `{{ route('admin.user.edit', ':id') }}`.replace(':id', data);
                            let urlDestroy = `{{ route('admin.user.destroy', ':id') }}`.replace(':id', data);
                            let urlToggleStatus = `{{ route('admin.user.toggle_status', ':id') }}`.replace(':id', data);

                            if (full.is_super_admin) {
                                return ``;
                            }

                            if (full.is_current_user) {
                                return `
                                    <ul class="table-controls d-flex justify-content-center">
                                        <x-table.actions.edit-action
                                            :permission="Acl::PERMISSION_USER_EDIT"
                                            :url="'${urlEdit}'"
                                        />
                                    </ul>`;
                            }

                            let icon = full.is_locked ? '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-unlock p-1 br-6 mb-1"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 9.9-1"></path></svg>'
                            : '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock p-1 br-6 mb-1"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>';

                            return `
                                <ul class="table-controls d-flex justify-content-center">
                                    <x-table.actions.edit-action
                                        :permission="Acl::PERMISSION_USER_EDIT"
                                        :url="'${urlEdit}'"
                                    />
                                    @can(Acl::PERMISSION_USER_EDIT)
                                        <li>
                                            <a
                                                class="bs-tooltip toggle-status"
                                                data-url="${urlToggleStatus}"
                                                data-datatable-id="sUserTable"
                                                data-is-locked="${full.is_locked}"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="{{ __('Chỉnh sửa trạng thái') }}"
                                                data-bs-original-title="{{ __('Chỉnh sửa trạng thái') }}"
                                            >
                                                ${icon}
                                            </a>
                                        </li>
                                    @endcan
                                    {{-- <x-table.actions.delete-action
                                        :permission="Acl::PERMISSION_USER_DELETE"
                                        :url="'${urlDestroy}'"
                                        dataTableId="#sUserTable"
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
        <script>
            $(document).on('click', '.toggle-status', function(e) {
                e.preventDefault();
                let url = $(this).data('url');
                let dataTableId = $(this).data('datatable-id');
                let isLocked = $(this).data('is-locked');
                let message = isLocked ? "{{ __('Bạn chắc chắn muốn mở khóa người dùng này?') }}" : "{{ __('Bạn chắc chắn muốn khóa người dùng này?') }}";

                Swal.fire({
                    title: message,
                    text: "{{ __('Bạn sẽ không thể hoàn lại thao tác này!') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "{{ __('Xác nhận') }}",
                    cancelButtonText: "{{ __('Hủy bỏ') }}",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        toggleStatus(dataTableId, url);
                    }
                });
            });

            function toggleStatus(dataTableId, url) {
                $.ajax({
                    type: 'PUT',
                    url: url,
                    data: {
                        _token: @json(@csrf_token())
                    },
                    success: function (response) {
                        if (response) {
                            Snackbar.show({
                                text: '{{ __('Chỉnh sửa trạng thái thành công.') }}',
                                textColor: '#ddf5f0',
                                backgroundColor: '#00ab55',
                                actionText: '{{ __('Hủy bỏ') }}',
                                actionTextColor: '#3b3f5c'
                            });

                            $(`#${dataTableId}`).DataTable().ajax.reload(null, false);
                        }
                    },
                    error: function (response) {
                        Snackbar.show({
                            text: '{{ __('Chỉnh sửa trạng thái thất bại.') }}',
                            textColor: '#fbeced',
                            backgroundColor: '#e7515a',
                            actionText: '{{ __('Hủy bỏ') }}',
                            actionTextColor: '#3b3f5c'
                        });
                    }
                });
            }
        </script>
    </x-slot:footerFiles>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
