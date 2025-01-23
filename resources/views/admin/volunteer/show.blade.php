<x-base-layout :scrollspy="false">
    <x-slot:pageTitle>
        {{ __('Chi tiết tình nguyện viên') }}
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
            __('tình nguyện viên') => '',
            __('Danh sách tình nguyện viên') => route('admin.volunteer.index'),
            __('Chi tiết tình nguyện viên') => ''
        ]"/>
    <x-custom.stat-box :id="'contact-management'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            <div class="d-flex justify-content-between align-items-center">
                {{ __('Chi tiết tình nguyện viên') }}
                @can(Acl::PERMISSION_VOLUNTEER_EDIT)
                <button
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#volunteerStatusModal"
                >
                    {{ __('Chỉnh sửa trạng thái') }}
                </button>
                @endcan
            </div>
        </x-slot:boxTitle>

        <div class="col-xl-12 row" style="padding: 16px 15px 0; border-top: 1px solid #e3e6f0;">
            <div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Người dùng') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $volunteer->user?->name ?: 'N/A' }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Dự án') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $volunteer->project?->name ?: 'N/A' }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Tên') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $contact->name ?? 'N/A' }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Email') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $contact->email ?? 'N/A' }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Số điện thoại') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $contact->phone_number ?? 'N/A' }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Phòng ban') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $volunteer->department?->name ?? 'N/A' }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Lớp') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $volunteer->class ?? 'N/A' }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('MSSV') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $volunteer->student_code ?? 'N/A' }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Trạng thái') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <span class="badge badge-{{ $volunteer->status->getBadge() }}">{{ $volunteer->status->getLabel() }}</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label col-form-label-sm">{{ __('Ghi chú') }}:</label>
                </div>
                <div class="text-anywhere">
                    <p>{{ $volunteer->note }}</p>
                </div>
            </div>
        </div>
    </x-custom.stat-box>

    @can(Acl::PERMISSION_VOLUNTEER_EDIT)
    <input type="hidden" id="volunteer-status" value="{{ $volunteer->status }}">

    <livewire:admin.volunteer.partials.edit-volunteer-status-modal :volunteer="$volunteer" />
    @endcan

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>
    </x-slot:footerFiles>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
