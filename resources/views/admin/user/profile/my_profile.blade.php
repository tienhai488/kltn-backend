<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ __('Thông tin cá nhân') }}
    </x-slot:pageTitle>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        {{-- @vite(['resources/scss/light/assets/components/timeline.scss']) --}}
        <link rel="stylesheet" href="{{asset('plugins/filepond/filepond.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/filepond/FilePondPluginImagePreview.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/notification/snackbar/snackbar.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/sweetalerts2/sweetalerts2.css')}}">

        @vite(['resources/scss/light/plugins/filepond/custom-filepond.scss'])
        @vite(['resources/scss/light/assets/components/tabs.scss'])
        @vite(['resources/scss/light/assets/elements/alert.scss'])
        @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
        @vite(['resources/scss/light/plugins/notification/snackbar/custom-snackbar.scss'])
        @vite(['resources/scss/light/assets/forms/switches.scss'])
        @vite(['resources/scss/light/assets/components/list-group.scss'])
        @vite(['resources/scss/light/assets/users/account-setting.scss'])

        @vite(['resources/scss/dark/plugins/filepond/custom-filepond.scss'])
        @vite(['resources/scss/dark/assets/components/tabs.scss'])
        @vite(['resources/scss/dark/assets/elements/alert.scss'])
        @vite(['resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss'])
        @vite(['resources/scss/dark/plugins/notification/snackbar/custom-snackbar.scss'])
        @vite(['resources/scss/dark/assets/forms/switches.scss'])
        @vite(['resources/scss/dark/assets/components/list-group.scss'])
        @vite(['resources/scss/dark/assets/users/account-setting.scss'])
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/flatpickr/flatpickr.css')}}">

        <link rel="stylesheet" type="text/css" href="{{asset('plugins/tomSelect/tom-select.default.min.css')}}">
        @vite([
            'resources/scss/light/plugins/tomSelect/custom-tomSelect.scss',
            'resources/scss/dark/plugins/tomSelect/custom-tomSelect.scss',
        ])

        <!--  END CUSTOM STYLE FILE  -->
    </x-slot:headerFiles>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BREADCRUMB -->
    <x-custom.breadcrumb
        :breadcrumb-items="[__('Hồ sơ') => '', __('Thông tin cá nhân') => '']"
    />
    <!-- /BREADCRUMB -->

    <div class="layout-top-spacing">
        <div class="row mb-3">
            <div class="col-md-12">
                <h2 @class(['text-capitalize'])>{{ __('Thông tin cá nhân') }}</h2>
            </div>
        </div>
    </div>

    <div class="account-settings-container">
        <div class="account-content">
            <div class="row mb-3">
                <div class="col-md-12">
                    <ul class="nav nav-pills" id="animateLine" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="animated-underline-home-tab"
                                    data-bs-toggle="tab" href="#animated-underline-home" role="tab"
                                    aria-controls="animated-underline-home" aria-selected="true" name="home">
                                <i data-feather="home"></i>
                                {{ __('Thông tin cá nhân') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="animated-underline-password-tab" data-bs-toggle="tab"
                                    href="#animated-underline-password" role="tab"
                                    aria-controls="animated-underline-password" aria-selected="false"
                                    tabindex="-1" name="password">
                                <i data-feather="lock"></i>
                                {{ __('Đổi mật khẩu') }}
                            </button>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="tab-content" id="animateLineContent-4">
                <div class="tab-pane fade show active" id="animated-underline-home" role="tabpanel"
                     aria-labelledby="animated-underline-home-tab" name="home">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <div class="section general-info">
                                <div class="info">
                                    <h6 class="">{{ __('Thông tin') }}</h6>
                                    <div class="row">
                                        <div class="col-lg-11 mx-auto">
                                            <div class="row">
                                                <x-form.form-layout
                                                    :custom-col="'col-lg-12'"
                                                    :form-id="'general-settings'"
                                                    :form-method="'PUT'"
                                                    :form-url="route('admin.user.update_profile')"
                                                    :enctype="'multipart/form-data'"
                                                >

                                                <div class="info">
                                                    <div class="row">
                                                        <div class="col-lg-11 mx-auto">
                                                            <div class="row">
                                                                <div class="col-xl-2 col-lg-12 col-md-4">
                                                                    <div class="profile-image  mt-4 pe-md-4">
                                                                        <div class="img-uploader-content">
                                                                            <x-form.form-upload
                                                                                :id="'sAvatar'"
                                                                                :name="'user_avatar'"
                                                                                :isRequired="'true'"
                                                                            />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                                                    <div class="form">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <x-form.form-input
                                                                                    :id="'name'"
                                                                                    :isRequired="'true'"
                                                                                    :label="__('Họ tên người dùng ')"
                                                                                    :name="'name'"
                                                                                    :placeholder="__('Họ tên người dùng ')"
                                                                                    :value="auth()->user()->name"
                                                                                />
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <x-form.form-input
                                                                                    :id="'email'"
                                                                                    :label="__('Email')"
                                                                                    :name="'email'"
                                                                                    :placeholder="__('Email')"
                                                                                    :value="auth()->user()->email"
                                                                                    :readonly="true"
                                                                                />
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <x-form.form-input
                                                                                    :id="'phone_number'"
                                                                                    :label="__('Số điện thoại')"
                                                                                    :isRequired="true"
                                                                                    :name="'phone_number'"
                                                                                    :placeholder="__('Số điện thoại')"
                                                                                    :value="auth()->user()->phone_number"
                                                                                />
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <x-form.form-date-picker
                                                                                    id="birth_of_date"
                                                                                    label="{{ __('Ngày tháng năm sinh') }}"
                                                                                    name="birth_of_date"
                                                                                    placeholder="{{ __('Ngày tháng năm sinh') }}"
                                                                                    isRequired="true"
                                                                                    :max-date="$maxDate"
                                                                                    :min-date="$minDate"
                                                                                    :value="auth()->user()->birth_of_date ?? ''"
                                                                                />
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <x-form.form-select
                                                                                    :id="'sGendersSelect'"
                                                                                    :label="__('Giới tính')"
                                                                                    :name="'gender'"
                                                                                    :data-values="App\Enum\Gender::options(true)"
                                                                                    :select-value-attribute="'value'"
                                                                                    :select-value-label="'value'"
                                                                                    :multiple="false"
                                                                                    :placeholder="__('Giới tính')"
                                                                                    :isRequired="'true'"
                                                                                    :values="auth()->user()?->gender?->value ?? ''"
                                                                                />
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <x-form.form-input
                                                                                    :id="'address'"
                                                                                    :label="__('Địa chỉ')"
                                                                                    :isRequired="true"
                                                                                    :name="'address'"
                                                                                    :placeholder="__('Địa chỉ')"
                                                                                    :value="auth()->user()->address"
                                                                                />
                                                                            </div>
                                                                        </div>

                                                                        <input type="hidden" id="discount_percent" name="discount_percent"
                                                                        value="{{ auth()->user()->discount_percent }}">

                                                                        <div class="col-md-12 mt-1">
                                                                            <div class="form-group text-end">
                                                                                <x-buttons.submit :label="__('Hoàn tất')"/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </x-form.form-layout>
                                                <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="animated-underline-password" role="tabpanel"
                    aria-labelledby="animated-underline-password-tab" name="password">
                     <x-custom.stat-box :custom-col="'col-lg-12'" :id="'user-management'">
                        <x-slot:boxTitle>
                            {{ __('Đổi mật khẩu') }}
                        </x-slot:boxTitle>
                        <x-form.form-layout
                          :form-id="'general-settings'"
                          :form-method="'PUT'"
                          :form-url="route('admin.user.update_password')"
                        >
                            <div class="info">
                                <x-form.form-input
                                    :id="'current_password'"
                                    :isRequired="true"
                                    :label="__('Mật khẩu hiện tại')"
                                    :name="'current_password'"
                                    :placeholder="__('Mật khẩu hiện tại')"
                                    :type="'password'"
                                />
                                <x-form.form-input
                                    :id="'password'"
                                    :isRequired="true"
                                    :label="__('Mật khẩu mới')"
                                    :name="'password'"
                                    :placeholder="__('Mật khẩu mới')"
                                    :type="'password'"
                                />
                                <x-form.form-input
                                    :id="'password_confirmation'"
                                    :isRequired="true"
                                    :label="__('Xác nhận mật khẩu')"
                                    :name="'password_confirmation'"
                                    :placeholder="__('Xác nhận mật khẩu')"
                                    :type="'password'"
                                />
                                <x-buttons.submit :label="__('Hoàn tất')" />
                            </div>
                        </x-form.form-layout>
                    </x-custom.stat-box>
                </div>
            </div>
        </div>
    </div>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{asset('plugins/tomSelect/tom-select.base.js')}}"></script>
        <script src="{{ asset('plugins/filepond/filepond.min.js') }}"></script>
        <script src="{{ asset('plugins/filepond/FilePondPluginFileValidateType.min.js') }}"></script>
        <script src="{{ asset('plugins/filepond/FilePondPluginImageExifOrientation.min.js') }}"></script>
        <script src="{{ asset('plugins/filepond/FilePondPluginImagePreview.min.js') }}"></script>
        <script src="{{ asset('plugins/filepond/FilePondPluginImageCrop.min.js') }}"></script>
        <script src="{{ asset('plugins/filepond/FilePondPluginImageResize.min.js') }}"></script>
        <script src="{{ asset('plugins/filepond/FilePondPluginImageTransform.min.js') }}"></script>
        <script src="{{ asset('plugins/filepond/filepondPluginFileValidateSize.min.js') }}"></script>
        <script src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.js"></script>
        <script src="{{asset('plugins/notification/snackbar/snackbar.min.js')}}"></script>
        <script src="{{asset('plugins/sweetalerts2/sweetalerts2.min.js')}}"></script>
        <script src="{{ asset('plugins/flatpickr/flatpickr.js') }}"></script>
        <script src="{{ asset('plugins/flatpickr/l10n/vn.js') }}"></script>

        <script>
            FilePond.registerPlugin(
                FilePondPluginImagePreview,
                FilePondPluginImageExifOrientation,
                FilePondPluginFileValidateSize,
                FilePondPluginImageTransform,
                FilePondPluginFileEncode,
                FilePondPluginFileValidateType
            );
            const userAvatar = FilePond.create(
                document.querySelector('#sAvatar'), {
                    acceptedFileTypes: ['image/*'],
                    labelFileTypeNotAllowed: 'sai định dạng',
                    fileValidateTypeLabelExpectedTypes: 'phải là hình ảnh',
                    maxFileSize: '5MB',
                    stylePanelLayout: 'compact circle',
                    labelMaxFileSizeExceeded: 'Tệp quá lớn',
                    labelMaxFileSize: 'Kích thước ảnh tối đa 5MB',
                    labelIdle: 'Kéo & thả hoặc <span class="filepond--label-action">chọn từ thiết bị</span>',
                }
            );

            @if (auth()->user()->getFirstMediaUrl(App\Enum\UserAvatar::COLLECTION->value))
                userAvatar.addFile(
                    '{{ Storage::url(auth()->user()->getFirstMedia(App\Enum\UserAvatar::COLLECTION->value)->getPathRelativeToRoot()) }}'
                );
            @endif

            $(function() {
                let searchParams = new URLSearchParams(window.location.search);
                let tab = searchParams.get('tab');

                if (tab === 'password') {
                    $('#animated-underline-password-tab').tab(
                        'show', );
                }
                $('#animated-underline-home-tab').on('show.bs.tab',
                    function() {

                        appendAvatar();

                    });

                $('#animated-underline-password-tab').on(
                    'show.bs.tab',
                    function() {
                        let currentUrl = new URL(window.location);
                        currentUrl.searchParams.set('tab',
                            'password');
                        window.history.pushState({}, '', currentUrl);
                    }).on('hide.bs.tab', function() {
                    let currentUrl = new URL(window.location);
                    currentUrl.searchParams.delete('tab');
                    window.history.pushState({}, '', currentUrl);
                });

                appendAvatar();

                function appendAvatar() {
                    @if (auth()->user()->getFirstMediaUrl(App\Enum\UserAvatar::COLLECTION->value))
                        userAvatar.addFile(
                            '{{ auth()->user()->avatar_url }}'
                        );
                    @endif
                }
            });
        </script>
    </x-slot:footerFiles>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
