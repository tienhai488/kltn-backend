<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ __('Quản lý phương thức thanh toán') }}
    </x-slot:pageTitle>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot:headerFiles>
    <!-- END GLOBAL MANDATORY STYLES -->

    <x-custom.breadcrumb :breadcrumb-items="['phương thức thanh toán' => '', __('Quản lý phương thức thanh toán') => '']"/>

    <x-custom.stat-box :id="'general-settings-box'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            {{ __('Quản lý phương thức thanh toán') }}
        </x-slot:boxTitle>

        <x-table.datatable
            :id="'sPaymentMethodTable'"
            :menu-length="[7, 10, 50, 100, 500]"
            :page-length="10"
            :show-menu-length="true"
        >
            <x-slot:tableHeader>
                <tr>
                    <th class="text-center">No.</th>
                    <th>{{ __('Tên phương thức thanh toán') }}</th>
                    <th>{{ __('Thứ tự') }}</th>
                    <th>{{ __('Trạng thái') }}</th>
                    <th class="text-center dt-no-sorting">{{ __('Thao tác') }}</th>
                </tr>
            </x-slot:tableHeader>
            <x-slot:customScript>
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "ajax": {
                "url": "{{ route('admin.payment_method.index') }}",
                    "data": function(d) {
                        let searchParams = new URLSearchParams(window.location.search);
                        drawDT = d.draw;
                        d.limit = d.length;
                        d.page = d.start / d.length + 1;
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
                        "render": function (data, type, full) {
                            let url = @json(asset(':id')).replace('/:id', full.icon_url);
                            return `<img src="${url}" alt="${data}" class="me-2" width="30" height="30">${data}`;
                        },
                    },
                    {
                        "data": "sort_order",
                        "class": "text-center",
                    },
                    {
                        "data": "status",
                        "className": "text-center",
                        "render": function (data, type, full) {
                            let isChecked = data ? 'checked' : '';
                            return `<div class="form-check form-switch form-check-inline form-switch-primary">
                                <input class="form-check-input toggle-status" type="checkbox" role="switch" id="status" ${isChecked} data-id="${full.id}" data-name="status">
                                <label class="form-check-label" for="status"></label>
                            </div>`;
                        }
                    },
                    {
                        "data": "id",
                        "class": "text-center no-content",
                        "orderable": false,
                        "render": function (data, type, full) {
                            let urlEdit = `{{ route('admin.payment_method.edit', ':id') }}`.replace(':id', data);

                            return `
                                <ul class="table-controls d-flex justify-content-center">
                                    @can(Acl::PERMISSION_PAYMENT_METHOD_EDIT)
                                    <li>
                                        <a
                                            class="bs-tooltip btn-update-payment-method"
                                            data-payment-method-id="${data}"
                                            data-payment-method-sort-order="${full.sort_order}"
                                            data-bs-placement="top"
                                            data-original-title="{{ __('Chỉnh sửa phương thức thanh toán') }}"
                                            title="{{ __('Chỉnh sửa phương thức thanh toán') }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#updatePaymentMethodModal"
                                        >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-edit-2 p-1 br-6 mb-1">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                            </path>
                                        </svg>
                                        </a>
                                    </li>
                                    @endcan
                                </ul>`;
                            }
                    },
                ]
            </x-slot:customScript>
        </x-table.datatable>
    </x-custom.stat-box>

    <div class="modal fade" id="updatePaymentMethodModal" tabindex="-1" role="dialog" aria-labelledby="updatePaymentMethodModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updatePaymentMethodModalLabel">Chỉnh sửa phương thức thanh toán</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                      <svg> ... </svg>
                    </button>
                </div>
                <form id="form-payment-method" action="{{ route('admin.payment_method.update', ':id') }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="payment_method_id">
                        <x-form.form-input
                            :id="'sort_order'"
                            :label="__('Thứ tự')"
                            :name="'sort_order'"
                            :placeholder="__('Thứ tự')"
                            isRequired="true"
                        />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn btn-light-dark" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Hủy bỏ</button>
                        <button type="submit" class="btn btn-primary">Hoàn tất</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        @include('includes.toggle-status')
        <script>
            $(document).on('change', '.toggle-status', function(e) {
                e.preventDefault();
                let id = $(this).data('id');

                let url = `{{ route('admin.payment_method.toggle_status', [
                    'paymentMethod' => ':id'
                ]) }}`.replace(':id', id);

                toggleStatus(url);
            });

            $(document).on('click', '.btn-update-payment-method', function(e) {
                $('#form-payment-method').find('input').removeClass('is-invalid');
                $('#form-payment-method').find('.invalid-feedback').remove();

                let paymentMethodId = $(this).data('payment-method-id');
                let paymentMethodSortOrder = $(this).data('payment-method-sort-order');

                $('#payment_method_id').val(paymentMethodId);
                $('#sort_order').val(paymentMethodSortOrder);

                let url = '{{ route('admin.payment_method.update', ':id') }}'.replace(':id', paymentMethodId);

                $('#form-payment-method').attr('action', url);
            });

            $('#form-payment-method').on('submit', function (e) {
                e.preventDefault();

                $(this).find('button[type="submit"]').prop('disabled', true);

                let formData = new FormData();
                $(this).serializeArray().forEach(item => {
                    formData.append(item.name, item.value);
                });

                let url = '{{ route('admin.payment_method.update', ':id') }}'.replace(':id', $('#payment_method_id').val());

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        window.location.replace("{{ route('admin.payment_method.index') }}");
                    },
                    error: function (res) {
                        $('#form-payment-method').find('input').removeClass('is-invalid');
                        $('#form-payment-method').find('.invalid-feedback').remove();

                        Object.entries(res.responseJSON.errors).forEach(error => {
                            showMessage($(`[name="${convertToNestedArrayString(error[0])}"]`), error[1], false);
                        })
                        $('#form-payment-method').find('button[type="submit"]').prop('disabled', false);
                        Snackbar.show({
                            text: "{{ __('Đã có lỗi xảy ra') }}",
                            textColor: '#fbeced',
                            backgroundColor: '#e7515a',
                            actionText: '{{ __('Bỏ qua') }}',
                            actionTextColor: '#3b3f5c'
                        });
                    }
                });
            })

            function showMessage(dom, msg, isSelect) {
                dom.addClass('is-invalid');
                let nextSpan = dom.next('span.invalid-feedback');
                if (isSelect) {
                    nextSpan = dom.next('div.ts-wrapper').next('span.invalid-feedback');
                }
                if (nextSpan.length) {
                    nextSpan.remove();
                }
                let spanMsgHtml = `
                    <span class="invalid-feedback" role="alert">
                        <strong>${msg}</strong>
                    </span>`;
                if (isSelect) {
                    dom.next('div.ts-wrapper').after(spanMsgHtml);
                } else {
                    dom.after(spanMsgHtml);
                }
            }

            function convertToNestedArrayString(str) {
                if (str.includes('.')) {
                    return str.replace(/\.(?=\d+)/g, '[').replace(/\./g, '][') + ']';
                }

                return str;
            }
        </script>
    </x-slot:footerFiles>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
