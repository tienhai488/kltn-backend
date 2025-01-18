<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ $title }}
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

    <x-custom.breadcrumb :breadcrumb-items="['Người dùng' => '', $title => '']"/>

    <x-custom.stat-box :id="'campaign-schedule-management-filter'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            {{ __('Bộ lọc') }}
        </x-slot:boxTitle>

        @include('admin.user.filters.index')
    </x-custom.stat-box>

    <x-custom.stat-box :id="'general-settings-box'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            {{ __('Quản lý người dùng') }}
        </x-slot:boxTitle>
        @can(Acl::PERMISSION_USER_ADD)
        <x-slot:action>
            <div class="layout-top-spacing mx-3 col-12">
                <x-buttons.button-link
                    :label="__('Tạo mới người dùng')"
                    :url="route('admin.user.create')"
                />
            </div>
        </x-slot:action>
        @endcan

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

                            return `
                                <ul class="table-controls d-flex justify-content-center">
                                    <x-table.actions.edit-action
                                        :permission="Acl::PERMISSION_USER_EDIT"
                                        :url="'${urlEdit}'"
                                    />
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
    </x-slot:footerFiles>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
