<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ __('Cài đặt phương thức thanh toán MoMo') }}
    </x-slot:pageTitle>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
    </x-slot:headerFiles>
    <!-- END GLOBAL MANDATORY STYLES -->

    <x-custom.breadcrumb
        :breadcrumb-items="[
            __('Quản lý phương thức thanh toán') => route('admin.payment_method.index'),
            __('Cài đặt phương thức thanh toán MoMo') => '',
        ]"
    />

    <x-custom.stat-box :id="'role-management'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            {{ __('Cài đặt phương thức thanh toán MoMo') }}
        </x-slot:boxTitle>

        <x-form.form-layout
            :form-id="'momo-form'"
            :form-url="route('admin.payment_method.setting', $paymentMethod)"
            customCol="col-lg-12"
            :formMethod="'PUT'"
        >
            <div class="col-md-6">
                <x-form.form-input
                    :id="'endpoint'"
                    :label="__('Đường dẫn thanh toán')"
                    :name="'endpoint'"
                    :placeholder="__('Đường dẫn thanh toán')"
                    :isRequired="true"
                    :value="$apiConfig->endpoint"
                />
            </div>
            <div class="col-md-6">
                <x-form.form-input
                    :id="'partnerCode'"
                    :label="__('Mã đối tác')"
                    :name="'partnerCode'"
                    :placeholder="__('Mã đối tác')"
                    :isRequired="true"
                    :value="$apiConfig->partnerCode"
                />
            </div>
            <div class="col-md-6">
                <x-form.form-input
                    :id="'accessKey'"
                    :label="__('Access Key')"
                    :name="'accessKey'"
                    :placeholder="__('Access Key')"
                    :isRequired="true"
                    :value="$apiConfig->accessKey"
                />
            </div>
            <div class="col-md-6">
                <x-form.form-input
                    :id="'secretKey'"
                    :label="__('Secret Key')"
                    :name="'secretKey'"
                    :placeholder="__('Secret Key')"
                    :isRequired="true"
                    :value="$apiConfig->secretKey"
                />
            </div>

            <div class="col-md-6">
                <x-form.form-input
                    :id="'returnUrl'"
                    :label="__('Đường dẫn trả về sau khi thanh toán (Bạn có thể dùng các biến sau: {:project_id}, {:project_slug}, {:donation_id})')"
                    :name="'returnUrl'"
                    :placeholder="__('Đường dẫn trả về sau khi thanh toán')"
                    :isRequired="true"
                    :value="$apiConfig->returnUrl"
                />
            </div>

            <x-buttons.submit :label="__('Hoàn tất')"/>
        </x-form.form-layout>
    </x-custom.stat-box>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
    </x-slot:footerFiles>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
