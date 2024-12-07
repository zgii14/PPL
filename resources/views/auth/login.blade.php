<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Login</title>
        <!-- plugins:css -->
        <link rel="stylesheet" href="{{ asset("asset/vendors/feather/feather.css") }}">
        <link rel="stylesheet" href="{{ asset("asset/vendors/ti-icons/css/themify-icons.css") }}">
        <link rel="stylesheet" href="{{ asset("asset/vendors/css/vendor.bundle.base.css") }}">

        <!-- endinject -->
        <!-- inject:css -->
        <link rel="stylesheet" href="{{ asset("asset/css/vertical-layout-light/style.css") }}">
        <!-- endinject -->
        <link href="{{ asset("asset/images/laundry_lubis.png") }}" rel="shortcut icon">
    </head>

    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth px-0">
                    <div class="row w-100 mx-0">
                        <div class="col-lg-4 mx-auto">
                            <div class="auth-form-light px-sm-5 px-4 py-5 text-left">
                                <div class="brand-logo">
                                    <div class="mb-4 text-center">
                                        <img src="{{ asset("asset/images/laundry_lubis.png") }}" alt="logo"
                                            class="logo-center" style="width: 230px; height: auto;">

                                    </div>
                                </div>
                                <h4>Hello! Ayo Masuk</h4>
                                <h6 class="font-weight-light">Login untuk melanjutkan.</h6>

                                <!-- Form Start -->
                                <form method="POST" action="{{ route("login") }}" class="pt-3">
                                    @csrf

                                    <!-- Email Address -->
                                    <div class="form-group">
                                        <input type="text" id="email" class="form-control form-control-lg"
                                            name="email" :value="old('email')" required autofocus
                                            placeholder="Email">
                                        @error("email")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="form-group">
                                        <input type="password" id="password" class="form-control form-control-lg"
                                            name="password" required placeholder="Password">
                                        @error("password")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Remember Me -->
                                    {{-- <div class="form-check">
                  <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input" name="remember">
                    Keep me signed in
                  </label>
                </div> --}}

                                    <!-- Login Button -->
                                    <div class="mt-3">
                                        <button type="submit"
                                            class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                                            MASUK
                                        </button>
                                    </div>

                                    <!-- Forgot Password -->
                                    <div class="d-flex justify-content-between align-items-center my-2">
                                        @if (Route::has("password.request"))
                                            <a class="auth-link text-black" href="{{ route("password.request") }}">
                                                Forgot password?
                                            </a>
                                        @endif
                                    </div>

                                    <!-- Social Login -->
                                    {{-- <div class="mb-2">
                  <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                    <i class="ti-facebook mr-2"></i>Connect using Facebook
                  </button>
                </div> --}}

                                    <!-- Register Link -->
                                    <div class="font-weight-light mt-4 text-center">
                                        Belum Punya Akun? <a href="{{ route("register") }}"
                                            class="text-primary">Buat</a>
                                    </div>
                                </form>
                                <!-- Form End -->

                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->

        <!-- plugins:js -->
        <script src="{{ asset("asset/vendors/js/vendor.bundle.base.js") }}"></script>
        <!-- endinject -->
        <!-- inject:js -->

        <script src="{{ asset("asset/js/off-canvas.js") }}"></script>
        <script src="{{ asset("asset/js/hoverable-collapse.js") }}"></script>
        <script src="{{ asset("asset/js/template.js") }}"></script>
        <script src="{{ asset("asset/js/settings.js") }}"></script>
        <script src="{{ asset("js/todolist.js") }}"></script>
        <!-- endinject -->
    </body>

</html>
