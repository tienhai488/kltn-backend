<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ __('Chỉnh sửa') }}
    </x-slot:pageTitle>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/tomSelect/tom-select.default.min.css')}}">

        @vite([
            'resources/scss/light/plugins/tomSelect/custom-tomSelect.scss',
            'resources/scss/dark/plugins/tomSelect/custom-tomSelect.scss',
        ])
    </x-slot:headerFiles>
    <!-- END GLOBAL MANDATORY STYLES -->

    <x-custom.breadcrumb
        :breadcrumb-items="[
            'Danh mục' => '',
            'Danh sách danh mục' => route('admin.category.index'),
            'Chỉnh sửa danh mục' => ''
        ]"/>

    <x-custom.stat-box :id="'category-management'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            {{ __('Chỉnh sửa danh mục') }}
        </x-slot:boxTitle>

        <x-form.form-layout
            :form-id="'general-settings'"
            :form-url="route('admin.category.update', $category)"
            :form-method="'PUT'"
        >
            <x-form.form-input
                :id="'name'"
                :label="'Tên danh mục'"
                :name="'name'"
                :placeholder="'Nhập tên danh mục'"
                :isRequired="true"
                :value="$category->name"
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
                :values="$category->status->value"
            />
            <x-form.form-textarea
                :id="'sDescription'"
                :label="__('Mô tả')"
                :name="'description'"
                :placeholder="__('Mô tả')"
                :isRequired="true"
                :rows="5"
                :value="$category->description"
            />
            <x-buttons.submit :label="__('Hoàn tất')"/>
        </x-form.form-layout>
    </x-custom.stat-box>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{asset('plugins/tomSelect/tom-select.base.js')}}"></script>
    </x-slot:footerFiles>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
