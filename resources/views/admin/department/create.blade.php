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
            'Phòng ban' => '',
            'Danh sách phòng ban' => route('admin.department.index'),
            'Tạo mới phòng ban' => ''
        ]"/>

    <x-custom.stat-box :id="'department-management'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            {{ __('Thêm mới phòng ban') }}
        </x-slot:boxTitle>

        <x-form.form-layout :form-id="'general-settings'" :form-url="route('admin.department.store')">
            <x-form.form-upload
                :label="'Hình ảnh'"
                :id="'sThumbnail'"
                :name="'department_thumbnail'"
            />
            <x-form.form-input
                :id="'code'"
                :label="'Mã phòng ban'"
                :name="'code'"
                :placeholder="'Nhập mã phòng ban'"
                :isRequired="true"
            />
            <x-form.form-input
                :id="'name'"
                :label="'Tên phòng ban'"
                :name="'name'"
                :placeholder="'Nhập tên phòng ban'"
                :isRequired="true"
            />
            <x-form.form-select
                :id="'sStatusSelect'"
                :label="'Trạng thái'"
                :data-values="$statuses"
                :name="'status'"
                :select-value-attribute="'value'"
                :select-value-label="'label'"
                :placeholder="__('Trạng thái')"
                :isRequired="true"
            />
            <x-form.form-textarea
                :id="'sDescription'"
                :label="__('Mô tả')"
                :name="'description'"
                :placeholder="__('Mô tả')"
                :isRequired="true"
                :rows="5"
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

            const thumbnail = FilePond.create(
                document.querySelector('#sThumbnail'),
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
