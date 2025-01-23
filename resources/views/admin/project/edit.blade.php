<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ __('Chỉnh sửa') }}
    </x-slot:pageTitle>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/tomSelect/tom-select.default.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/flatpickr/flatpickr.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/filepond/filepond.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/filepond/FilePondPluginImagePreview.min.css')}}">

        @vite([
            'resources/scss/light/plugins/tomSelect/custom-tomSelect.scss',
            'resources/scss/dark/plugins/tomSelect/custom-tomSelect.scss',

            'resources/scss/light/plugins/filepond/custom-filepond.scss',
            'resources/scss/dark/plugins/filepond/custom-filepond.scss',
        ])

        <style>
            .ck-editor__editable[role="textbox"] {
                min-height: 450px;
            }
            .ck-content .image {
                max-width: 80%;
                margin: 20px auto;
            }
            .ck.ck-voice-label {
                display: none !important;
            }
            .widget.box .widget-header {
                border-bottom: 1px solid #e0e6ed;
            }
            .flatpickr-calendar .flatpickr-monthDropdown-months {
                display: inline-block;
                width: auto;
            }
            .flatpickr-calendar .flatpickr-current-month {
                display: flex;
                justify-content: space-between;
            }
            .flatpickr-calendar {
                z-index: 1050 !important;
            }
            .dropdown.show .flatpickr-calendar {
                position: absolute;
                top: 100%;
            }
        </style>
    </x-slot:headerFiles>
    <!-- END GLOBAL MANDATORY STYLES -->

    <x-custom.breadcrumb
        :breadcrumb-items="[
            'Dự án' => '',
            'Danh sách dự án' => route('admin.project.index'),
            'Chỉnh sửa dự án' => ''
        ]"/>

    <x-custom.stat-box :id="'category-management'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            {{ __('Chình sửa dự án') }}
        </x-slot:boxTitle>

        <x-form.form-layout
            :form-id="'general-settings'"
            :form-url="route('admin.project.update', $project)"
            customCol="col-lg-12"
        >
            @method('PUT')
            <div class="row">
                <div class="col-lg-12">
                    <x-form.form-upload
                        :label="'Ảnh nền dự án'"
                        :id="'sBackgroundImage'"
                        :name="'background_image'"
                        :isRequired="true"
                    />
                </div>
                <div class="col-lg-12">
                    <x-form.form-upload
                        :label="'Hình ảnh liên quan'"
                        :id="'sRelatedImages'"
                        :name="'related_images[]'"
                        :multiple="true"
                    />
                </div>
                <div class="col-lg-6">
                    <x-form.form-select
                        :id="'category_id'"
                        :label="'Danh mục'"
                        :data-values="$categories"
                        :name="'category_id'"
                        :select-value-attribute="'id'"
                        :select-value-label="'name'"
                        :placeholder="__('Chọn danh mục')"
                        :isRequired="true"
                        :values="$project->category_id"
                    />
                </div>
                <div class="col-lg-6">
                    <x-form.form-input
                        :id="'name'"
                        :label="'Tên dự án'"
                        :name="'name'"
                        :placeholder="'Nhập tên dự án'"
                        :isRequired="true"
                        :value="$project->name"
                    />
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <x-form.form-select
                        :id="'sType'"
                        :label="'Loại dự án'"
                        :data-values="App\Enum\ProjectType::options(true)"
                        :name="'type'"
                        :select-value-attribute="'value'"
                        :select-value-label="'value'"
                        :placeholder="__('Loại dự án')"
                        :isRequired="true"
                        :values="$project->type->value"
                    />
                </div>
                <div class="col-md-6">
                    <x-form.form-select
                        :id="'sStatusSelect'"
                        :label="'Trạng thái'"
                        :data-values="App\Enum\ProjectStatus::options(true)"
                        :name="'status'"
                        :select-value-attribute="'value'"
                        :select-value-label="'label'"
                        :placeholder="__('Trạng thái')"
                        :isRequired="true"
                        :values="$project->status->value"
                    />
                </div>
                <div id="donation_target_group" class="col-lg-6">
                    <x-form.form-input
                        :id="'donation_target'"
                        :label="'Số tiền quyên góp'"
                        :name="'donation_target'"
                        :placeholder="'Nhập số tiền quyên góp'"
                        :isRequired="true"
                        :value="round($project->donation_target)"
                    />
                </div>
                <div id="volunteer_quantity_group" class="col-lg-6">
                    <x-form.form-input
                        :id="'volunteer_quantity'"
                        :label="'Số lượng tình nguyện viên'"
                        :name="'volunteer_quantity'"
                        :placeholder="'Nhập số lượng tình nguyện viên'"
                        :isRequired="true"
                        :value="$project->volunteer_quantity"
                    />
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <x-form.form-input
                        id="start_date"
                        label="{{ __('Thời gian bắt đầu') }}"
                        name="start_date"
                        placeholder="{{ __('Thời gian bắt đầu') }}"
                        :value="$project->start_date->format('Y-m-d H:i')"
                        :isRequired="true"
                    />
                </div>
                <div class="col-md-6">
                    <x-form.form-input
                        id="end_date"
                        label="{{ __('Thời gian kết thúc') }}"
                        name="end_date"
                        placeholder="{{ __('Thời gian kết thúc') }}"
                        :value="$project->end_date->format('Y-m-d H:i')"
                        :isRequired="true"
                    />
                </div>
                <div class="col-md-12">
                    <x-form.ckeditor
                        :id="'editorContent'"
                        :label="__('Nội dung')"
                        :name="'content'"
                        :placeholder="__('Nội dung')"
                        :isRequired="true"
                        :value="$project->content"
                    />
                </div>
            </div>
            <x-buttons.submit :label="__('Hoàn tất')"/>
        </x-form.form-layout>
    </x-custom.stat-box>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        @include('admin.project.partials.editor')
        <script src="{{ asset('plugins/filepond/filepond.min.js') }}"></script>
        <script src="{{ asset('plugins/filepond/FilePondPluginFileValidateType.min.js') }}"></script>
        <script src="{{ asset('plugins/filepond/FilePondPluginImageExifOrientation.min.js') }}"></script>
        <script src="{{ asset('plugins/filepond/FilePondPluginImagePreview.min.js') }}"></script>
        <script src="{{ asset('plugins/filepond/FilePondPluginImageCrop.min.js') }}"></script>
        <script src="{{ asset('plugins/filepond/FilePondPluginImageResize.min.js') }}"></script>
        <script src="{{ asset('plugins/filepond/FilePondPluginImageTransform.min.js') }}"></script>
        <script src="{{ asset('plugins/filepond/filepondPluginFileValidateSize.min.js') }}"></script>
        <script src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.js"></script>
        <script src="{{asset('plugins/tomSelect/tom-select.base.js')}}"></script>
        <script src="{{ asset('plugins/flatpickr/flatpickr.js') }}"></script>
        <script src="{{ asset('plugins/flatpickr/l10n/vn.js') }}"></script>
        <script>
            flatpickr("#start_date", {
                dateFormat: "Y-m-d H:i",
                maxDate: "features",
                locale: "vn",
                enableTime: true,
                onOpen: function(selectedDates, dateStr, instance) {
                    instance.calendarContainer.addEventListener('click', function (e) {
                        e.stopPropagation();
                    });
                }
            });

            flatpickr("#end_date", {
                dateFormat: "Y-m-d H:i",
                maxDate: "features",
                locale: "vn",
                enableTime: true,
                onOpen: function(selectedDates, dateStr, instance) {
                    instance.calendarContainer.addEventListener('click', function (e) {
                        e.stopPropagation();
                    });
                }
            });

            const toggleFields = () => {
                switch ($('#sType').val()) {
                    case '{{ App\Enum\ProjectType::DONATION->value }}':
                        $('#donation_target_group').removeClass('d-none');
                        $('#donation_target').prop('disabled', false);
                        // $('label[for="donation_target"]').find('strong').removeClass('d-none');

                        $('#volunteer_quantity_group').addClass('d-none');
                        $('#volunteer_quantity').prop('disabled', true).val('');
                        // $('label[for="volunteer_quantity"]').find('strong').addClass('d-none');
                        break;
                    case '{{ App\Enum\ProjectType::VOLUNTEER->value }}':
                        $('#donation_target_group').addClass('d-none');
                        $('#donation_target').prop('disabled', true).val('');
                        // $('label[for="donation_target"]').find('strong').addClass('d-none');

                        $('#volunteer_quantity_group').removeClass('d-none');
                        $('#volunteer_quantity').prop('disabled', false);
                        // $('label[for="volunteer_quantity"]').find('strong').removeClass('d-none');
                        break;
                    default:
                        $('#donation_target_group').removeClass('d-none');
                        $('#donation_target').prop('disabled', false);
                        // $('label[for="donation_target"]').find('strong').removeClass('d-none');

                        $('#volunteer_quantity_group').removeClass('d-none');
                        $('#volunteer_quantity').prop('disabled', false);
                        // $('label[for="volunteer_quantity"]').find('strong').removeClass('d-none');
                        break;
                }
            }

            toggleFields();

            $('#sType').on('change', toggleFields);

            FilePond.registerPlugin(
                FilePondPluginImagePreview,
                FilePondPluginImageExifOrientation,
                FilePondPluginFileValidateSize,
                FilePondPluginImageTransform,
                FilePondPluginFileEncode,
                FilePondPluginFileValidateType
            );

            const backgroundImage = FilePond.create(
                document.querySelector('#sBackgroundImage'),
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

            @if($project->background_image)
            backgroundImage.addFile('{{ $project->background_image }}');
            @endif

            const relatedImages = FilePond.create(
                document.querySelector('#sRelatedImages'),
                {
                    acceptedFileTypes: ['image/*'],
                    labelFileTypeNotAllowed: 'sai định dạng',
                    fileValidateTypeLabelExpectedTypes: 'phải là hình ảnh',
                    maxFileSize: '20MB',
                    labelMaxFileSizeExceeded: 'Tệp quá lớn',
                    labelMaxFileSize: 'Kích thước ảnh tối đa 20MB',
                    labelIdle: 'Kéo & thả hoặc <span class="filepond--label-action">chọn từ thiết bị</span>',
                    allowPaste: false,
                }
            );

            @if($project->related_images)
            const data = JSON.parse('{!! json_encode($project->related_images) !!}');

            relatedImages.addFiles(Object.entries(data).map(([key, value]) => {
                return value.original_url;
            }));
            @endif
        </script>
    </x-slot:footerFiles>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
