<x-guest-layout>
    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay">
                 <x-auth-session-status class="mb-4" :status="session('status')" />
            </div>
            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="index.html" class="d-inline-block auth-logo">
                                    <img src="assets/images/logo-light.png" alt="" height="20">
                                </a>
                            </div>
                            <p class="mt-3 fs-15 fw-medium">Ngon Ba Miền (Chuyên cung cấp các loại Đặc sản, Món ăn ngon, Sạch sẻ, Giá tốt)</p>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h1 class="text-primary">Đăng nhập</h1>
                                    <p class="text-muted">Đăng nhập để thực hiện tiếp thao tác</p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <x-input-label for="email" value="Tài khoản" />
                                            <x-text-input id="email" class="form-control" id="username" placeholder="Nhập Tài khoản" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        </div>
                                        <div class="mb-3">
                                            <div class="float-end">
                                                @if (Route::has('password.request'))
                                                    <a href="{{ route('password.request') }}" class="text-muted">Quên mật khẩu?</a>
                                                @endif
                                            </div>
                                            <x-input-label class="form-label" for="password" value="Mật khẩu" />
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <x-text-input class="form-control pe-5 password-input" placeholder="Nhập Mật khẩu" id="password-input"
                                                              type="password"
                                                              name="password"
                                                              required autocomplete="current-password" />
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="auth-remember-check" name="remember">
                                            <label class="form-check-label" for="auth-remember-check">Ghi nhớ</label>
                                        </div>

                                        <div class="mt-4">
                                            <x-primary-button class="btn btn-success w-100" >
                                                Đăng nhập
                                            </x-primary-button>
                                        </div>

                                        <div class="mt-4 text-center">
                                            <div class="signin-other-title">
                                                <h5 class="fs-13 mb-4 title">Đăng nhập bằng tài khoản</h5>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-primary btn-icon waves-effect waves-light">
                                                    <i class="ri-facebook-fill fs-16"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-icon waves-effect waves-light">
                                                    <i class="ri-google-fill fs-16"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="mt-4 text-center">
                            <p class="mb-0">Bạn chưa có tài khoản hãy đăng ký?
                                <a href="{{Request::root()}}/dang-ky" class="fw-semibold text-primary text-decoration-underline">Đăng Ký</a>
                            </p>
                            <p class="mt-1">
                                <a href="{{Request::root()}}" class="fw-semibold text-primary text-decoration-underline">Trang Chủ</a>
                            </p>
                        </div>

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy;
                                <script>document.write(new Date().getFullYear())</script> website <i class="mdi mdi-heart text-danger"></i> Ngon Ba Miền
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
</x-guest-layout>
