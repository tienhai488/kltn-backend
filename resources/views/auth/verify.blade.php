<x-base-layout :scrollspy="false" :disable-header="true">

    <x-slot:pageTitle>
        Xác minh địa chỉ email
    </x-slot:pageTitle>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <style>
            #load_screen {
                display: none;
            }
        </style>

        <!--  END CUSTOM STYLE FILE  -->
    </x-slot:headerFiles>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h3 class="card-header">{{ __('Xác minh địa chỉ email của bạn') }}</h3>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ session('resent') }}
                            </div>
                        @endif

                        <p>{{ __('Trước khi tiếp tục, vui lòng kiểm tra email của bạn để biết liên kết xác minh.') }}
                            {{ __('Nếu bạn không nhận được email') }},
                            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('nhấp vào đây để yêu cầu một email khác') }}</button>.
                            </form>
                        </p>
                    </div>

                    <div class="card-footer">
                        <a class="btn btn-primary" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                            {{ __('Đăng nhập bằng tài khoản khác') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('auth.logout') }}" method="POST"
            class="d-none">
        @csrf
    </form>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>

    </x-slot:footerFiles>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>

