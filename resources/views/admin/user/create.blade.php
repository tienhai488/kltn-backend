<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ __('Tạo mới') }}
    </x-slot:pageTitle>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/tomSelect/tom-select.default.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/filepond/filepond.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/filepond/FilePondPluginImagePreview.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/flatpickr/flatpickr.css')}}">

        @vite([
            'resources/scss/light/plugins/tomSelect/custom-tomSelect.scss',
            'resources/scss/dark/plugins/tomSelect/custom-tomSelect.scss',

            'resources/scss/light/plugins/filepond/custom-filepond.scss',
            'resources/scss/dark/plugins/filepond/custom-filepond.scss',
        ])
    </x-slot:headerFiles>
    <!-- END GLOBAL MANDATORY STYLES -->

    <x-custom.breadcrumb
        :breadcrumb-items="[
            'Người dùng' => '',
            'Danh sách người dùng' => route('admin.user.index'),
            'Tạo mới người dùng' => ''
        ]"/>

    <x-custom.stat-box :id="'role-management'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            {{ __('Thêm mới người dùng') }}
        </x-slot:boxTitle>

        <x-form.form-layout :form-id="'general-settings'" :form-url="route('admin.user.store')">
            <x-form.form-upload
                :label="'Ảnh đại diện'"
                :id="'sAvatar'"
                :name="'user_avatar'"
            />
            <x-form.form-input
                :id="'name'"
                :label="'Họ tên người dùng'"
                :name="'name'"
                :placeholder="'Nhập họ tên người dùng'"
                :isRequired="true"
            />
            <x-form.form-input
                :id="'email'"
                :label="'Email'"
                :name="'email'"
                :placeholder="'Nhập Email'"
                :isRequired="true"
            />
            <x-form.form-select
                :id="'sStatusSelect'"
                :label="'Trạng thái hoạt động'"
                :data-values="$statuses"
                :name="'status'"
                :select-value-attribute="'value'"
                :select-value-label="'label'"
                :placeholder="__('Trạng thái hoạt động')"
                :isRequired="true"
            />
            <x-form.form-input
                :id="'phone_number'"
                :label="'Số điện thoại'"
                :name="'phone_number'"
                :placeholder="'Số điện thoại'"
                :isRequired="true"
            />
            <x-form.form-date-picker
                id="birth_of_date"
                label="{{ __('Ngày tháng năm sinh') }}"
                name="birth_of_date"
                placeholder="{{ __('Ngày tháng năm sinh') }}"
                isRequired="true"
                :max-date="$maxDate"
                :min-date="$minDate"
            />
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
            />
            <x-form.form-input
                :id="'address'"
                :label="'Địa chỉ'"
                :name="'address'"
                :placeholder="'Địa chỉ'"
                :isRequired="true"
            />
            <x-form.form-input
                :id="'password'"
                :label="'Mật khẩu'"
                :name="'password'"
                :placeholder="'Mật khẩu'"
                :type="'password'"
                :isRequired="true"
            />
            <x-form.form-input
                :id="'password_confirmation'"
                :label="'Xác nhận mật khẩu'"
                :name="'password_confirmation'"
                :placeholder="'Xác nhận mật khẩu'"
                :type="'password'"
                :isRequired="true"
            />
            <x-form.form-select
                :id="'sRoleSelect'"
                :label="'Vai trò trong hệ thống'"
                :data-values="$roles"
                :name="'roles'"
                :multiple="true"
                :placeholder="__('Chọn vai trò')"
                :isRequired="true"
            />
            <x-buttons.submit :label="__('Hoàn tất')"/>
        </x-form.form-layout>
    </x-custom.stat-box>

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
                document.querySelector('#sAvatar'),
                {
                    acceptedFileTypes: ['image/*'],
                    labelFileTypeNotAllowed: 'sai định dạng',
                    fileValidateTypeLabelExpectedTypes: 'phải là hình ảnh',
                    maxFileSize: '5MB',
                    labelMaxFileSizeExceeded: 'Tệp quá lớn',
                    labelMaxFileSize: 'Kích thước ảnh tối đa 5MB',
                    labelIdle: 'Kéo & thả hoặc <span class="filepond--label-action">chọn từ thiết bị</span>',
                    allowPaste: false,
                }
            );
        </script>
    </x-slot:footerFiles>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
