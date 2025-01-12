@push('headerFiles')
    <link rel="stylesheet" href="{{asset('plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet"
          href="{{asset('plugins/table/datatable/extensions/col-reorder/col-reorder.datatables.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('plugins/table/datatable/extensions/fixed-columns/fixed-columns.datatables.min.css')}}">
    @vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss'])
    @vite(['resources/scss/light/plugins/table/datatable/custom_dt_custom.scss'])
    @vite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss'])
    @vite(['resources/scss/dark/plugins/table/datatable/custom_dt_custom.scss'])
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/sweetalerts2/sweetalerts2.css')}}">
    @vite([
        'resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss',
        'resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss',
    ])
    {{ isset($customStyle) ? $customStyle : '' }}
@endpush

@if(isset($tableFilter))
    @section('currentPageFilter')
        <div class="container-fluid">
            <div class="row">
                {{ $tableFilter }}
            </div>
        </div>
    @endsection
@endif

<table id="{{ $id }}" class="table style-3 dt-table-hover" {{ $attributes }} style="width:100%">
    <thead>
    {{ $tableHeader }}
    </thead>
    @if(isset($tableBody))
        <tbody>
        {{ $tableBody }}
        </tbody>
    @endif
    @if(isset($tableFooter))
        <tfoot>
        {{ $tableFooter }}
        </tfoot>
    @endif
</table>

@push('footerFiles')
    @vite(['resources/assets/js/custom.js'])
    <script type="module" src="{{asset('plugins/table/datatable/datatables.js')}}"></script>
    <script type="module"
            src="{{asset('plugins/table/datatable/extensions/col-reorder/col-reorder.datatables.min.js')}}"></script>
    <script type="module"
            src="{{asset('plugins/table/datatable/extensions/fixed-columns/fixed-columns.datatables.min.js')}}"></script>
            <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>
    </script>
    <script type="module">
        let drawDT = 0;

        const c1 = $('#{{ $id }}').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'{{ $showMenuLength ? 'l' : '' }}><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "{{ __('Hiển thị') }}  _PAGE_ {{ __('trên') }} _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "{{ __('Tìm kiếm') }}...",
                "sLengthMenu": "{{ __('Số lượng') }} :  _MENU_",
                "sInfoFiltered": "({{ __('Lọc từ tổng số') }} _MAX_ {{ 'bản ghi' }})",
                "sZeroRecords": "{{ __('Không có bản ghi nào trùng khớp') }}",
                "sProcessing": "{{ __('Đang xử lý') }}...",
                "sLengthMenu": "{{ __('Kết quả') }} :  _MENU_",
                "sEmptyTable": "{{ __('không có dữ liệu trong bảng') }}",
                "sInfoEmpty": "{{ __('Hiển thị 0 đến 0 trong 0 mục') }}",
            },
            "stripeClasses": [],
            "lengthMenu": {{ json_encode($menuLength) }},
            "pageLength": {{ $pageLength }},
            {{ isset($customScript) ? $customScript : '' }}
        });

        multiCheck(c1);

        function debounce(func, timeout = 300) {
            let timer;
            return (...args) => {
                clearTimeout(timer);
                timer = setTimeout(() => {
                    func.apply(this, args);
                }, timeout);
            };
        }

        const processHandle = debounce((value) => c1.search(value).draw());

        $(document).on('keyup', '.search-bar .search-form-control', function() {
            processHandle(this.value);
        });

        $('.search-bar .search-close').on('click', function(e) {
            c1.search('').draw();
        });
    </script>

    <script type="module">
        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            let url = $(this).data('url');
            let dataTableId = $(this).data('datatable-id');
            deleteItemDataTable(dataTableId, url);
        });

        function deleteItemDataTable(dataTableId, url) {
            Swal.fire({
                title: "{{ __('Bạn chắc chắn chưa?') }}",
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
                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        data: {
                            _token: @json(@csrf_token())
                        },
                        success: function(response) {
                            Snackbar.show({
                                text: response.message,
                                textColor: '#ddf5f0',
                                backgroundColor: '#00ab55',
                                actionText: '{{ __('Bỏ qua') }}',
                                actionTextColor: '#3b3f5c'
                            });
                            if (dataTableId) {
                                $(dataTableId).DataTable().ajax.reload(null, false);
                            } else {
                                location.reload();
                            }
                        },
                        error: function(response) {
                            Snackbar.show({
                                text: '{{ __('Xóa lựa chọn thất bại.') }}',
                                textColor: '#fbeced',
                                backgroundColor: '#e7515a',
                                actionText: '{{ __('Bỏ qua') }}',
                                actionTextColor: '#3b3f5c'
                            });
                        }
                    });
                }
            })
        }
    </script>
@endpush

