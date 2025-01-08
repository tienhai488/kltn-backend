<x-base-layout :scrollspy="false" :disable-header="true">

    <x-slot:pageTitle>
        Login
    </x-slot:pageTitle>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/light/assets/authentication/auth-boxed.scss'])
        @vite(['resources/scss/dark/assets/authentication/auth-boxed.scss'])
        <style>
            #load_screen {
                display: none;
            }
        </style>

        <!--  END CUSTOM STYLE FILE  -->
    </x-slot:headerFiles>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="auth-container d-flex">

        <div class="container mx-auto align-self-center">

            <div class="row">

                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center mx-auto">
                    <div class="card mt-3 mb-3">
                        <div class="card-body">

                            <form action="{{ route('auth.login') }}" method="POST">
                                @method('POST')
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 mb-3">

                                        <h2>Đăng nhập</h2>
                                        <p>Nhập email và mật khẩu của bạn để đăng nhập</p>

                                    </div>
                                    <div class="col-md-12">
                                        <x-form.form-input
                                            :id="'email'"
                                            :label="'Email'"
                                            :name="'email'"
                                            :placeholder="'Nhập Email'"
                                            :isRequired="true"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <x-form.form-input
                                            :id="'password'"
                                            :label="'Mật khẩu'"
                                            :name="'password'"
                                            :placeholder="'Mật khẩu'"
                                            :type="'password'"
                                            :isRequired="true"
                                        />
                                    </div>
                                    <input type="hidden" name="status" value="{{ 1 }}">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <div class="form-check form-check-primary form-check-inline">
                                                <input class="form-check-input me-3" type="checkbox"
                                                       id="form-check-default" name="remember">
                                                <label class="form-check-label" for="form-check-default">
                                                    Nhớ mật khẩu
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-4">
                                            <button class="btn btn-secondary w-100">ĐĂNG NHẬP</button>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="text-center">
                                            <p class="mb-0">
                                                Bạn chưa có tài khoản? Vui lòng liên hệ với quản lý của bạn!
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>
        <script src="{{ asset('plugins/notification/snackbar/snackbar.min.js') }}"></script>
        @include('includes.notifications')

    </x-slot:footerFiles>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
