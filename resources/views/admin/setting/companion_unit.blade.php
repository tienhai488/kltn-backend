<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ __('Cài Đặt đơn vị đồng hành') }}
    </x-slot:pageTitle>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/filepond/filepond.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/filepond/FilePondPluginImagePreview.min.css')}}">

        @vite([
            'resources/scss/light/plugins/filepond/custom-filepond.scss',
            'resources/scss/dark/plugins/filepond/custom-filepond.scss',
        ])
    </x-slot:headerFiles>
    <!-- END GLOBAL MANDATORY STYLES -->

    <x-custom.breadcrumb :breadcrumb-items="['Cài đặt' => '', __('Cài đặt đơn vị đồng hành') => '']"/>

    <x-custom.stat-box :id="'role-management'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            {{ __('Cài đặt đơn vị đồng hành') }}
        </x-slot:boxTitle>

        <x-form.form-layout
            :form-id="'setting-terms-form'"
            :form-url="route('admin.setting.companion_unit')"
            customCol="col-lg-12"
        >
            <div class="col-md-12">
                <x-form.form-upload
                    :label="'Đơn vị đồng hành'"
                    :id="'sCompanionUnit'"
                    :name="'images'"
                    :multiple="true"
                    :isRequired="true"
                />
            </div>

            <x-buttons.submit :label="__('Hoàn tất')"/>
        </x-form.form-layout>
    </x-custom.stat-box>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/filepond/filepond.min.js') }}"></script>
        <script src="{{ asset('plugins/filepond/FilePondPluginFileValidateType.min.js') }}"></script>
        <script src="{{ asset('plugins/filepond/FilePondPluginImageExifOrientation.min.js') }}"></script>
        <script src="{{ asset('plugins/filepond/FilePondPluginImagePreview.min.js') }}"></script>
        <script src="{{ asset('plugins/filepond/FilePondPluginImageCrop.min.js') }}"></script>
        <script src="{{ asset('plugins/filepond/FilePondPluginImageResize.min.js') }}"></script>
        <script src="{{ asset('plugins/filepond/FilePondPluginImageTransform.min.js') }}"></script>
        <script src="{{ asset('plugins/filepond/filepondPluginFileValidateSize.min.js') }}"></script>
        <script src="{{ asset('plugins/filepond/filepond-plugin-file-encode.js') }}"></script>

        <script>
            FilePond.registerPlugin(
                FilePondPluginImagePreview,
                FilePondPluginImageExifOrientation,
                FilePondPluginFileValidateSize,
                FilePondPluginImageTransform,
                FilePondPluginFileEncode,
                FilePondPluginFileValidateType,
                FilePondPluginImageResize,
            );

            const companionUnits = FilePond.create(
                document.querySelector('#sCompanionUnit'),
                {
                    acceptedFileTypes: ['image/*'],
                    labelFileTypeNotAllowed: 'sai định dạng',
                    fileValidateTypeLabelExpectedTypes: 'phải là hình ảnh',
                    maxFileSize: '20MB',
                    labelMaxFileSizeExceeded: 'Tệp quá lớn',
                    labelMaxFileSize: 'Kích thước ảnh tối đa 20MB',
                    labelIdle: 'Kéo & thả hoặc <span class="filepond--label-action">chọn từ thiết bị</span>',
                    imageTransformOutputMimeType: 'image/jpeg',
                    imageResizeTargetWidth: 1024,
                    server: {
                        process: {
                            url: @json(route('api.file_upload.upload')),
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': @json(csrf_token())
                            },
                            timeout: 7000,
                            onload: (response) => response,
                            onerror: (response) => response,
                            ondata: (formData) => formData
                        },
                        revert: @json(route('api.file_upload.revert')),
                    },
                }
            );

            @if($companionUnit->images)
                const data = JSON.parse('{!! json_encode($companionUnit->images) !!}');

                companionUnits.addFiles(Object.entries(data).map(([key, value]) => {
                    return value.original_url;
                }));
            @endif
        </script>
    </x-slot:footerFiles>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
