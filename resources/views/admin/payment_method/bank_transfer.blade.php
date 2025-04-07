<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ __('Cài đặt phương thức thanh toán chuyển khoản ngân hàng') }}
    </x-slot:pageTitle>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/tomSelect/tom-select.default.min.css')}}">

        @vite([
            'resources/scss/dark/plugins/tomSelect/custom-tomSelect.scss',
            'resources/scss/light/plugins/tomSelect/custom-tomSelect.scss',
        ])

        <style>
            .ts-wrapper.form-control-lg .ts-control {
                font-size: 15px;
            }

            .ts-dropdown {
                font-size: 15px;
            }
        </style>
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot:headerFiles>
    <!-- END GLOBAL MANDATORY STYLES -->

    <x-custom.breadcrumb
        :breadcrumb-items="[
            __('Quản lý phương thức thanh toán') => route('admin.payment_method.index'),
            __('Cài đặt phương thức thanh toán chuyển khoản ngân hàng') => '',
        ]"
    />

    <x-custom.stat-box
        :id="'users-box'"
        :custom-col="'col-lg-12'"
        :box_of_datatable="true"
    >
        <x-slot:boxTitle>
            {{ __('Cài đặt phương thức thanh toán chuyển khoản ngân hàng') }}
        </x-slot:boxTitle>

        <x-form.form-layout
            :form-id="'general-settings'"
            :form-url="''"
            :form-method="'PUT'"
            :custom-col="'col-lg-12'"
        >
            <div class="col-lg-6">
                <div class="form-group mb-4">
                    <label for="pin_code">{{ __('Ngân hàng') }} <strong class="text-danger">*</strong>
                    </label>
                    <select
                        id="sPinCode"
                        name = "pin_code"
                        class="form-control form-control-lg @error('pin_code') is-invalid @enderror"
                        placeholder="{{ __('Ngân hàng') }}"
                        >
                        <option value="">{{ __('Chọn ngân hàng') }}</option>
                        @foreach ($banks as $item)
                            <option value="{{ $item['bin'] }}"
                            data-name="{{ $item['shortName'] }}"
                            data-logo="{{ $item['logo'] }}"
                            @if ($apiConfig->pinCode == $item['bin']) selected @endif
                            >
                            ({{ $item['shortName'] }}) {{ $item['name'] }}</option>
                        @endforeach
                    </select>
                    @error('pin_code')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <img id="bankLogo" src="" alt="Bank Logo" style="max-width: 300px; display: none; margin-bottom: 30px">

                <x-form.form-input
                    :id="'sBankName'"
                    :label="__('Tên ngân hàng')"
                    :name="'bank_name'"
                    :placeholder="__('Tên ngân hàng')"
                    :isRequired="true"
                    :value="$apiConfig->bankName"
                    readonly
                />

                <x-form.form-input
                    :id="'sBankNumber'"
                    :label="__('Số tài khoản ngân hàng')"
                    :name="'bank_number'"
                    :placeholder="__('Nhập số tài khoản ngân hàng')"
                    :isRequired="true"
                    :value="$apiConfig->bankNumber"
                />


                <x-form.form-input
                    :id="'sAccountName'"
                    :label="__('Tên tài khoản')"
                    :name="'account_name'"
                    :placeholder="__('Tên tài khoản')"
                    :isRequired="true"
                    :value="$apiConfig->accountName"
                />

                <input type="hidden" name="qr_image_src" id="sQrImageSrc" value="">
            </div>
            <x-buttons.submit :label="__('Hoàn tất')"/>

        </x-form.form-layout>

        <hr>

        @include('admin.payment_method.info_account.index')
    </x-custom.stat-box>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{asset('plugins/tomSelect/tom-select.base.js')}}"></script>
        <script>
            const formatCurrency = (value) => {
                value = value.replace(/,/g, '');
                return !isNaN(value) && value.length > 0 ? Number(value).toLocaleString('en') : '';
            };

            function generateAndAddQuickLink() {
                const bankNumber = $('#sBankNumber').val();
                const shortName = $('#sBankName').val();
                const accountName = encodeURIComponent($('#sAccountName').val());

                if (shortName && bankNumber) {
                    const quickLink = `https://img.vietqr.io/image/${shortName}-${bankNumber}-print.png?accountName=${accountName}`;
                    $('#sQrImageSrc').val(quickLink);
                }
            }

            function updateBankLogo() {
                const $selectedOption = $('select[name="pin_code"] option:selected');
                const $bankLogo = $('#bankLogo');

                if ($selectedOption.length) {
                    const logoUrl = $selectedOption.data('logo') || '';
                    const bankName = $selectedOption.data('name') || '';

                    $bankLogo.attr('src', logoUrl);
                    logoUrl ? $bankLogo.show() : $bankLogo.hide();
                    $('#sBankName').val(bankName);
                }
            }

            $(document).ready(function() {
                // init
                updateBankLogo();
                generateAndAddQuickLink();

                $('#sPinCode').on('change', function() {
                    updateBankLogo();
                    generateAndAddQuickLink();
                });

                $('#sBankNumber').on('input', generateAndAddQuickLink);
                $('#sAccountName').on('input', generateAndAddQuickLink);
            });

            let select = new TomSelect("#sPinCode", {
                    maxItems: 1,
                    closeAfterSelect: 1,
                    placeholder: 'Chọn ngân hàng',
                    persist: false,
                    render: {
                        no_results: function(data, escape) {
                            return '<div class="no-results">{{ __('Không tìm thấy kết quả nào') }}</div>';
                        }
                    },
                });
        </script>
    </x-slot:footerFiles>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
