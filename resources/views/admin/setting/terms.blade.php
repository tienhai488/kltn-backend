<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ __('Cài Đặt điều khoản') }}
    </x-slot:pageTitle>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
    </x-slot:headerFiles>
    <!-- END GLOBAL MANDATORY STYLES -->

    <x-custom.breadcrumb :breadcrumb-items="['Cài đặt' => '', __('Cài đặt điều khoản') => '']"/>

    <x-custom.stat-box :id="'role-management'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            {{ __('Cài đặt điều khoản') }}
        </x-slot:boxTitle>

        <x-form.form-layout
            :form-id="'setting-terms-form'"
            :form-url="route('admin.setting.terms')"
            customCol="col-lg-12"
        >
            <div class="col-md-12">
                <x-form.ckeditor
                    :id="'editorContent'"
                    :label="__('Nội dung')"
                    :name="'terms'"
                    :placeholder="__('Nội dung')"
                    :isRequired="true"
                    :value="$terms->value"
                />
            </div>

            <x-buttons.submit :label="__('Hoàn tất')"/>
        </x-form.form-layout>
    </x-custom.stat-box>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        @include('admin.setting.partials.editor')
    </x-slot:footerFiles>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
