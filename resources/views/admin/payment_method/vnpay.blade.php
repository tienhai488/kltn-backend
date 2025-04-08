<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ __('Cài đặt phương thức thanh toán VNPAY') }}
    </x-slot:pageTitle>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
    </x-slot:headerFiles>
    <!-- END GLOBAL MANDATORY STYLES -->

    <x-custom.breadcrumb
        :breadcrumb-items="[
            __('Quản lý phương thức thanh toán') => route('admin.payment_method.index'),
            __('Cài đặt phương thức thanh toán VNPAY') => '',
        ]"
    />

    <x-custom.stat-box :id="'role-management'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            {{ __('Cài đặt phương thức thanh toán VNPAY') }}
        </x-slot:boxTitle>

        <x-form.form-layout
            :form-id="'vnpay-form'"
            :form-url="route('admin.payment_method.setting', $paymentMethod)"
            customCol="col-lg-12"
            :formMethod="'PUT'"
        >
            <div class="col-md-6">
                <x-form.form-input
                    :id="'vnpTmnCode'"
                    :label="__('Terminal ID')"
                    :name="'vnpTmnCode'"
                    :placeholder="__('Terminal ID')"
                    :isRequired="true"
                    :value="$apiConfig->vnpTmnCode"
                />
            </div>
            <div class="col-md-6">
                <x-form.form-input
                    :id="'vnpHashSecret'"
                    :label="__('Secret Key')"
                    :name="'vnpHashSecret'"
                    :placeholder="__('Secret Key')"
                    :isRequired="true"
                    :value="$apiConfig->vnpHashSecret"
                />
            </div>
            <div class="col-md-6">
                <x-form.form-input
                    :id="'vnpUrl'"
                    :label="__('Đường dẫn thanh toán')"
                    :name="'vnpUrl'"
                    :placeholder="__('Đường dẫn thanh toán')"
                    :isRequired="true"
                    :value="$apiConfig->vnpUrl"
                />
            </div>
            <div class="col-md-6">
                <x-form.form-input
                    :id="'vnpReturnUrl'"
                    :label="__('Đường dẫn trả về sau khi thanh toán (Bạn có thể dùng các biến sau: {:project_id}, {:project_slug}, {:donation_id})')"
                    :name="'vnpReturnUrl'"
                    :placeholder="__('Đường dẫn trả về sau khi thanh toán')"
                    :isRequired="true"
                    :value="$apiConfig->vnpReturnUrl"
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
