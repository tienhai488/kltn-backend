<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ __('Cài Đặt chính sách') }}
    </x-slot:pageTitle>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
    </x-slot:headerFiles>
    <!-- END GLOBAL MANDATORY STYLES -->

    <x-custom.breadcrumb :breadcrumb-items="['Cài đặt' => '', __('Cài đặt chính sách') => '']"/>

    <x-custom.stat-box :id="'role-management'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            {{ __('Cài đặt chính sách') }}
        </x-slot:boxTitle>

        <x-form.form-layout
            :form-id="'setting-policy-form'"
            :form-url="route('admin.setting.policy')"
            customCol="col-lg-12"
        >
            <div class="col-md-12">
                <x-form.ckeditor
                    :id="'editorContent'"
                    :label="__('Nội dung')"
                    :name="'policy'"
                    :placeholder="__('Nội dung')"
                    :isRequired="true"
                    :value="$policy->value"
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
