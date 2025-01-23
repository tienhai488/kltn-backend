<x-base-layout :scrollspy="false">
    <x-slot:pageTitle>
        {{ __('Chi tiết quyên góp') }}
    </x-slot:pageTitle>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/sweetalerts2/sweetalerts2.css')}}">
        @vite([
            'resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss',
            'resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss',
        ])
    </x-slot:headerFiles>
    <!-- END GLOBAL MANDATORY STYLES -->
    <x-custom.breadcrumb
        :breadcrumb-items="[
            __('quyên góp') => '',
            __('Danh sách quyên góp') => route('admin.volunteer.index'),
            __('Chi tiết quyên góp') => ''
        ]"/>
    <x-custom.stat-box :id="'contact-management'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            <div class="d-flex justify-content-between align-items-center">
                {{ __('Chi tiết quyên góp') }}
            </div>
        </x-slot:boxTitle>

        <div class="col-xl-12 row" style="padding: 16px 15px 0; border-top: 1px solid #e3e6f0;">
            <div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Người dùng') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $donation->user?->name ?: 'N/A' }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Dự án') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $donation->project?->name ?: 'N/A' }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Số TK') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $donation->account_number ?? 'N/A' }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Tên TK') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $donation->account_name ?? 'N/A' }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Mã GD') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $donation->code ?? 'N/A' }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Số tiền') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ customFormatPrice($donation->amount) }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Họ tên') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $donation->name }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Email') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $donation->email ?? 'N/A' }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Số điện thoại') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $donation->phone_number ?? 'N/A' }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Phòng ban') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $donation->department?->name ?? 'N/A' }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Lớp') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $donation->class ?? 'N/A' }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('MSSV') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $donation->student_code ?? 'N/A' }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Chế độ') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <span class="badge badge-{{ $donation->is_anonymous->getBadge() }}">{{ $donation->is_anonymous->getLabel() }}</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label col-form-label-sm">{{ __('Ghi chú') }}:</label>
                </div>
                <div class="text-anywhere">
                    <p>{{ $donation->note }}</p>
                </div>
            </div>
        </div>
    </x-custom.stat-box>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>
    </x-slot:footerFiles>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
