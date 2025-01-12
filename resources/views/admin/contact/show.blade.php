<x-base-layout :scrollspy="false">
    <x-slot:pageTitle>
        {{ __('Chi tiết liên hệ') }}
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
            __('Liên hệ') => '',
            __('Danh sách liên hệ') => route('admin.contact.index'),
            __('Chi tiết liên hệ') => ''
        ]"/>
    <x-custom.stat-box :id="'contact-management'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            <div class="d-flex justify-content-between align-items-center">
                {{ __('Chi tiết liên hệ') }}
                @can(Acl::PERMISSION_CONTACT_EDIT)
                <button
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#contactStatusModal"
                >
                    {{ __('Chỉnh sửa trạng thái') }}
                </button>
                @endcan
            </div>
        </x-slot:boxTitle>

        <x-slot:action>
        </x-slot:action>

        <div class="col-xl-12 row" style="padding: 16px 15px 0; border-top: 1px solid #e3e6f0;">
            <div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Người dùng') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        @if($contact->user)
                            <a href="{{ route('admin.user.edit', $contact->user) }}" target="_blank" class="text-primary">
                                {{ $contact->user->name }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-external-link p-1 br-6 mb-1"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                            </a>
                        @else
                            <p> {{ __('N/A') }} </p>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Tên') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $contact->name }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Email') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $contact->email }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Số điện thoại') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $contact->phone_number }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Trạng thái') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <span class="badge badge-{{ $contact->status->getBadge() }}">{{ $contact->status->getLabel() }}</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Tiêu đề') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p> {{ $contact->subject }} </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label col-form-label-sm">{{ __('Nội dung') }}:</label>
                </div>
                <div class="text-anywhere">
                    <p>{{ $contact->content }}</p>
                </div>
            </div>
        </div>
    </x-custom.stat-box>

    @can(Acl::PERMISSION_CONTACT_EDIT)
    <input type="hidden" id="contact-status" value="{{ $contact->status }}">

    <livewire:admin.contact.partials.edit-contact-status-modal :contact="$contact" />
    @endcan

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>
    </x-slot:footerFiles>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
