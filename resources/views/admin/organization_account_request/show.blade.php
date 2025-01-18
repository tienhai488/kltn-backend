<x-base-layout :scrollspy="false">
    <x-slot:pageTitle>
        {{ __('Chi tiết yêu cầu tài khoản tổ chức') }}
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
            __('Yêu cầu tài khoản tổ chức') => '',
            __('Danh sách yêu cầu tài khoản tổ chức') => route('admin.organization_account_request.index'),
            __('Chi tiết yêu cầu tài khoản tổ chức') => ''
        ]"/>
    <x-custom.stat-box :id="'organization-management'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            <div class="d-flex justify-content-between align-items-center">
                {{ __('Chi tiết yêu cầu tài khoản tổ chức') }}
                <div class="d-flex">
                    @can(Acl::PERMISSION_USER_ADD)
                <a
                    href="{{ route('admin.organization_account_request.create', ['id' => $organizationAccountRequest->id]) }}"
                    class="btn btn-success"
                >
                    {{ __('Thêm tài khoản tổ chức') }}
                </a>
                @endcan
                @can(Acl::PERMISSION_ACCOUNT_REQUEST_EDIT)
                <button
                    class="btn btn-primary ms-2"
                    data-bs-toggle="modal"
                    data-bs-target="#organizationAccountRequestStatusModal"
                >
                    {{ __('Chỉnh sửa trạng thái') }}
                </button>
                @endcan
                </div>
            </div>
        </x-slot:boxTitle>

        <div class="col-xl-12 row" style="padding: 16px 15px 0; border-top: 1px solid #e3e6f0;">
            <div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Tên tổ chức') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $organizationAccountRequest->name }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Ngày thành lập') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ customFormatDate($organizationAccountRequest->birth, 'd/m/Y') }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Website') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <a href="{{ $organizationAccountRequest->website }}" target="_blank" class="text-primary">
                            {{ $organizationAccountRequest->website }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-external-link p-1 br-6 mb-1"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                        </a>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Lĩnh vực hoạt động') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $organizationAccountRequest->field }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Địa chỉ') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $organizationAccountRequest->address }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Tên tài khoản người dùng') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $organizationAccountRequest->username }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Tên người đại diện') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $organizationAccountRequest->representative_name }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Email người đại diện') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $organizationAccountRequest->representative_email }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Số điện thoại người đại diện') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $organizationAccountRequest->representative_phone_number }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Trạng thái') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <span class="badge badge-{{ $organizationAccountRequest->status->getBadge() }}">{{ $organizationAccountRequest->status->getLabel() }}</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label col-form-label-sm">{{ __('Thông tin giới thiệu') }}:</label>
                </div>
                <div class="text-anywhere">
                    <p>{{ $organizationAccountRequest->information }}</p>
                </div>
            </div>
        </div>
    </x-custom.stat-box>

    @can(Acl::PERMISSION_ACCOUNT_REQUEST_EDIT)
    <input type="hidden" id="organization-account-request-status" value="{{ $organizationAccountRequest->status }}">

    <livewire:admin.organization-account-request.partials.edit-organization-account-request-status-modal
        :organization-account-request="$organizationAccountRequest"
    />
    @endcan

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>
    </x-slot:footerFiles>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
