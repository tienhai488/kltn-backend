<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ __('Dashboard') }}
    </x-slot:pageTitle>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/tomSelect/tom-select.default.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/apex/apexcharts.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/flatpickr/flatpickr.css')}}">

        @vite([
            'resources/scss/light/plugins/tomSelect/custom-tomSelect.scss',
            'resources/scss/dark/plugins/tomSelect/custom-tomSelect.scss',

            'resources/scss/light/assets/components/list-group.scss',
            'resources/scss/dark/assets/components/list-group.scss',

            'resources/scss/light/assets/widgets/modules-widgets.scss',
            'resources/scss/dark/assets/widgets/modules-widgets.scss',

            'resources/scss/light/plugins/apex/custom-apexcharts.scss',
            'resources/scss/dark/plugins/apex/custom-apexcharts.scss',
        ])

        <style>
            .apexcharts-title-text {
                font-family: Nunito, sans-serif !important;
                font-size: 20px;
                font-weight: 600;
            }

            @media (max-width: 768px) {
                .apexcharts-title-text {
                    font-size: 16px;
                }
                .apexcharts-tooltip {
                    left: 10px !important;
                    right: 10px !important;
                    white-space: normal !important;
                }
            }
        </style>
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot:headerFiles>
    <!-- END GLOBAL MANDATORY STYLES -->

    <x-custom.breadcrumb
        :breadcrumb-items="[
            'Dashboard' => ''
        ]"
    />

    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="row widget-statistic">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                    <livewire:admin.dashboard.partials.widget-organizations-count lazy />
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                    <livewire:admin.dashboard.partials.widget-individuals-count lazy />
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                    <livewire:admin.dashboard.partials.widget-projects-count lazy />
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                    <livewire:admin.dashboard.partials.widget-users-count lazy />
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                    <livewire:admin.dashboard.partials.widget-donations-count lazy />
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                    <livewire:admin.dashboard.partials.widget-donations-sum-amount lazy />
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                    <livewire:admin.dashboard.partials.widget-volunteers-count lazy />
                </div>
            </div>

            <x-custom.stat-box :id="'user-management-filter'" :custom-col="'col-lg-12'">
                <x-slot:boxTitle>
                    {{ __('Bộ lọc') }}
                </x-slot:boxTitle>

                @include('admin.dashboard.filters.index')
            </x-custom.stat-box>

            <div class="row layout-top-spacing widget-statistic">
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <livewire:admin.dashboard.partials.widget-project-amount-percent lazy />
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <livewire:admin.dashboard.partials.widget-project-volunteer-percent lazy />
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <livewire:admin.dashboard.partials.widget-project-time-percent lazy />
                </div>
            </div>

            <p class="text-center mt-3">Các số liệu dưới đây có thể được lọc theo thời gian.</p>
        </div>
    </div>

    <x-custom.stat-box :id="'general-settings-box'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            {{ __('Danh sách thông tin') }}
        </x-slot:boxTitle>
    </x-custom.stat-box>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/tomSelect/tom-select.base.js') }}"></script>
        <script src="{{asset('plugins/apex/apexcharts.min.js')}}"></script>
        <script src="{{ asset('plugins/flatpickr/flatpickr.js') }}"></script>
        <script src="{{ asset('plugins/flatpickr/l10n/vn.js') }}"></script>
        @vite([
            'resources/assets/js/widgets/_wSix.js',
            'resources/assets/js/widgets/_wChartThree.js',
            'resources/assets/js/widgets/_wHybridOne.js',
            'resources/assets/js/widgets/_wActivityFive.js',
        ])
    </x-slot:footerFiles>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
