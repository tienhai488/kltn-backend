<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ __('Quản lý liên hệ') }}
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

    <x-custom.breadcrumb :breadcrumb-items="['Liên hệ' => '', 'Quản lý liên hệ' => '']"/>

    <x-custom.stat-box :id="'contact-management-filter'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            {{ __('Bộ lọc') }}
        </x-slot:boxTitle>

        @include('admin.contact.filters.index')
    </x-custom.stat-box>

    <x-custom.stat-box :id="'general-settings-box'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            {{ __('Quản lý liên hệ') }}
        </x-slot:boxTitle>
        @can(Acl::PERMISSION_CONTACT_EDIT)
        <x-slot:action>
            <div class="layout-top-spacing mx-3 col-12">
                <button
                    class="btn btn-primary d-none"
                    id="btn-edit-all"
                    data-bs-toggle="modal"
                    data-bs-target="#contactStatusModal"
                >
                    {{ __('Chỉnh sửa trạng thái') }}
                </button>
            </div>
        </x-slot:action>
        @endcan

        <x-table.datatable
            :id="'sContactTable'"
            :menu-length="[7, 10, 50, 100, 500]"
            :page-length="10"
            :show-menu-length="true"
        >
            <x-slot:tableHeader>
                <tr>
                    @can(Acl::PERMISSION_CONTACT_EDIT)
                    <th class="text-center dt-no-sorting">
                        <div class="form-check form-check-primary d-block new-control">
                            <input class="form-check-input chk-parent" type="checkbox" id="form-check-default">
                        </div>
                    </th>
                    @endcan
                    <th class="text-center">No.</th>
                    <th>{{ __('Thông tin') }}</th>
                    <th>{{ __('Tiêu đề') }}</th>
                    <th>{{ __('Trạng thái') }}</th>
                    <th class="text-center dt-no-sorting">{{ __('Thao tác') }}</th>
                </tr>
            </x-slot:tableHeader>
            <x-slot:customScript>
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "ajax": {
                "url": "{{ route('admin.contact.index') }}",
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
                    @can(Acl::PERMISSION_CONTACT_EDIT)
                    {
                        "data": "id",
                        "orderable": false,
                        "class": "checkbox-td",
                        "render": function(data, type, full) {
                            return `<div class="form-check form-check-primary d-block new-control">
                                <input class="form-check-input child-chk" data-item-contact-id="${data}" type="checkbox" id="form-check-default-${data}">
                            </div>`;
                        }
                    },
                    @endcan
                    {
                        "class": "text-center",
                        "render": (data, type, row, meta) =>  meta.row + 1 + meta.settings._iDisplayStart,
                    },
                    {
                        "data": "name",
                        "render": function (data, type, full) {
                            return `
                                <div class="d-flex">
                                    <p class="text-start me-1">{{ __('Tên') }}:</p>
                                    <p class="text-primary">${data}</p>
                                </div>
                                <div class="d-flex">
                                    <p class="text-start me-1">{{ __('Email') }}:</p>
                                    <p class="text-primary">${full.email}</p>
                                </div>
                                <div class="d-flex">
                                    <p class="text-start me-1">{{ __('Số điện thoại') }}:</p>
                                    <p class="text-primary">${full.phone_number}</p>
                                </div>
                            `;
                        }
                    },
                    {
                        "data": "subject",
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
                            let urlShow = `{{ route('admin.contact.show', ':id') }}`.replace(':id', data);

                            return `
                                <ul class="table-controls d-flex justify-content-center">
                                    <x-table.actions.show-action
                                        :permission="Acl::PERMISSION_CONTACT_LIST"
                                        :url="'${urlShow}'"
                                    />
                                </ul>`;
                            }
                    },
                ]
            </x-slot:customScript>
        </x-table.datatable>
    </x-custom.stat-box>

    @can(Acl::PERMISSION_CONTACT_EDIT)
    <livewire:admin.contact.partials.edit-multiple-contact-status-modal />
    @endcan

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/tomSelect/tom-select.base.js') }}"></script>

        <script>
            $(document).ready(function() {
                $(document).on('change', '.chk-parent', function() {
                    $(this).is(':checked') && $('.child-chk:checked').length
                    ? $('#btn-edit-all').removeClass('d-none')
                    : $('#btn-edit-all').addClass('d-none');
                });

                $(document).on('change', '.child-chk', function() {
                    $('.child-chk:checked').length
                    ? $('#btn-edit-all').removeClass('d-none')
                    : $('#btn-edit-all').addClass('d-none');
                });

                $('#sContactTable').DataTable().on('draw.dt', function() {
                    $('#btn-edit-all').addClass('d-none');

                    $('.chk-parent').prop('checked', false);
                });
            });
        </script>
    </x-slot:footerFiles>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
