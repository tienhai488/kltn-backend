<x-base-layout :scrollspy="false">
    <x-slot:pageTitle>
        {{ __('Chi tiết dự án') }}
    </x-slot:pageTitle>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/sweetalerts2/sweetalerts2.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/splide/splide.min.css')}}">
        <link rel="stylesheet" href="{{ asset('plugins/glightbox/glightbox.min.css') }}">

        @vite([
            'resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss',
            'resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss',

            'resources/scss/light/plugins/splide/custom-splide.min.scss',
            'resources/scss/dark/plugins/splide/custom-splide.min.scss',
        ])
    </x-slot:headerFiles>
    <!-- END GLOBAL MANDATORY STYLES -->
    <x-custom.breadcrumb
        :breadcrumb-items="[
            __('Dự án') => '',
            __('Danh sách dự án') => route('admin.project.index'),
            __('Chi tiết dự án') => ''
        ]"/>
    <x-custom.stat-box :id="'contact-management'" :custom-col="'col-lg-12'">
        <x-slot:boxTitle>
            <div class="d-flex justify-content-between align-items-center">
                {{ __('Chi tiết dự án') }}
                @can(Acl::PERMISSION_PROJECT_EDIT)
                <button
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#projectStatusModal"
                >
                    {{ __('Chỉnh sửa trạng thái') }}
                </button>
                @endcan
            </div>
        </x-slot:boxTitle>

        <x-slot:action>
        </x-slot:action>

        <div class="col-xl-12 row" style="padding: 16px 15px 0; border-top: 1px solid #e3e6f0;">
            <div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Người tạo') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <a href="{{ route('admin.user.edit', $project->user) }}" target="_blank" class="text-primary">
                            {{ $project->user->name }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-external-link p-1 br-6 mb-1"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                        </a>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Tên dự án') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p>{{ $project->name }}</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Danh mục') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <p><span class="badge badge-primary">{{ $project->category->name }}</span></p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Mục tiêu') }}:</label>
                    <div class="col-sm-10">
                        <div class="d-flex">
                            <p class="text-start me-1">{{ __('Số tiền') }}:</p>
                            <p class="text-primary">{{ customFormatPrice($project->donation_target) }}</p>
                        </div>
                        <div class="d-flex">
                            <p class="text-start me-1">{{ __('Tình nguyện viên') }}:</p>
                            <p class="text-primary">{{ $project->volunteer_quantity }}</p>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Thực tế') }}:</label>
                    <div class="col-sm-10">
                        <div class="d-flex">
                            <p class="text-start me-1">{{ __('Số tiền') }}:</p>
                            <p class="text-primary">{{ customFormatPrice($project->donations_sum_amount) }}</p>
                        </div>
                        <div class="d-flex">
                            <p class="text-start me-1">{{ __('Tình nguyện viên') }}:</p>
                            <p class="text-primary">{{ $project->volunteers_count }}</p>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Thời gian') }}:</label>
                    <div class="col-sm-10">
                        <p>{{ customFormatDate($project->start_date) }} - {{ customFormatDate($project->end_date) }}</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Loại dự án') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <span class="badge badge-info">{{ $project->type }}</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Trạng thái') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <span class="badge badge-{{ $project->status->getBadge() }}">{{ $project->status->getLabel() }}</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Ảnh nền dự án') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <img src="{{ $project->background_image }}" alt="" width="50%">
                    </div>
                </div>
                @if (count($project->related_images))
                <div class="form-group row mt-4">
                    <label for="" class="col-sm-2 col-form-label col-form-label-sm">{{ __('Hình ảnh liên quan') }}:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <div class="row">
                            <div id="splider_Thumbnails" class="col-lg-12 col-md-12 layout-spacing">
                                <div class="statbox widget box box-shadow">
                                    <div
                                        class="widget-content widget-content-area"
                                        @style([
                                            'border: 1px solid #e0e6ed;',
                                            'border-radius: 8px;',
                                        ])
                                    >
                                        <div class="position-relative">
                                            <div class="container" style="max-width: 700px">
                                                <div class="splide-mainThubnail splide--fade splide--ltr splide--draggable is-active is-initialized" id="splide04">
                                                    <div class="splide__track" id="splide04-track" style="padding-left: 0px; padding-right: 0px;">
                                                        <ul class="splide__list" id="splide04-list">
                                                            @foreach ($project->related_images as $index => $image)
                                                            <li
                                                                class="splide__slide is-active is-visible"
                                                                id="splide04-slide{{ $index + 1 }}"
                                                                style="width: calc(100%); height: 500px; transition: opacity 400ms cubic-bezier(0.25, 1, 0.5, 1);"
                                                                tabindex="0"
                                                            >
                                                                <a href="{{ $image->original_url }}" class="glightbox">
                                                                    <img alt="slider-image" src="{{ $image->original_url }}" >
                                                                </a>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                  </div>

                                                <div id="thumbnail-slider" class="splide splide--slide splide--ltr splide--draggable splide--nav is-active is-initialized">
                                                    <div class="splide__arrows"><button class="splide__arrow splide__arrow--prev" type="button" aria-controls="thumbnail-slider-track" aria-label="Go to last slide"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" width="40" height="40"><path d="m15.5 0.932-4.3 4.38 14.5 14.6-14.5 14.5 4.3 4.4 14.6-14.6 4.4-4.3-4.4-4.4-14.6-14.6z"></path></svg></button><button class="splide__arrow splide__arrow--next" type="button" aria-controls="thumbnail-slider-track" aria-label="Next slide"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" width="40" height="40"><path d="m15.5 0.932-4.3 4.38 14.5 14.6-14.5 14.5 4.3 4.4 14.6-14.6 4.4-4.3-4.4-4.4-14.6-14.6z"></path></svg></button></div><div class="splide__track" id="thumbnail-slider-track" style="padding-left: 0px; padding-right: 0px;">
                                                        <ul class="splide__list" id="thumbnail-slider-list" role="menu" aria-orientation="horizontal" style="transform: translateX(2.00003px);">
                                                            @foreach ($project->related_images as $index => $image)
                                                            <li
                                                                aria-controls="splide04"
                                                                aria-current="true"
                                                                aria-label="Go to slide {{ $index + 1 }}"
                                                                class="splide__slide is-active is-visible"
                                                                id="thumbnail-slider-slide{{ $index + 1 }}"
                                                                role="menuitem"
                                                                style="margin-right: 10px; width: 104px; height: 58px; background: url('{{ $image->original_url }}') center center / cover no-repeat;"
                                                                tabindex="0"
                                                            >
                                                                <img alt="slider-image" src="{{ $image->original_url }}" style="display: none;">
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label col-form-label-sm">{{ __('Nội dung') }}:</label>
                </div>
                <div class="text-anywhere">
                    <p>{!! $project->content !!}</p>
                </div>
            </div>
        </div>
    </x-custom.stat-box>

    @can(Acl::PERMISSION_PROJECT_EDIT)
    <input type="hidden" id="project-status" value="{{ $project->status }}">

    <livewire:admin.project.partials.edit-project-status-modal :project="$project" />
    @endcan

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>
        <script src="{{ asset('plugins/splide/custom-splide.js') }}"></script>
        <script src="{{ asset('plugins/splide/splide.min.js') }}"></script>
        <script src="{{ asset('plugins/glightbox/glightbox.min.js') }}"></script>
        <script src="{{ asset('plugins/glightbox/custom-glightbox.min.js') }}"></script>
        <script>
            var main = new Splide( '.splide-mainThubnail', {
                type       : 'fade',
                heightRatio: 0.5,
                pagination : false,
                arrows     : false,
                cover      : true,
                fixedHeight: 500,
            } );

            var thumbnails = new Splide( '#thumbnail-slider', {
                rewind          : true,
                fixedWidth      : 104,
                fixedHeight     : 58,
                isNavigation    : true,
                gap             : 10,
                focus           : 'center',
                pagination      : false,
                cover           : true,
                dragMinThreshold: {
                    mouse: 4,
                    touch: 10,
                },
                breakpoints : {
                    640: {
                    fixedWidth  : 66,
                    fixedHeight : 38,
                    },
                },
            } );

            main.sync( thumbnails );
            main.mount();
            thumbnails.mount();

            let lightboxCheckin = GLightbox({
                selector: '.glightbox',
            });
        </script>
    </x-slot:footerFiles>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
