<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Register</title>
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
                                <h4>Welcome!</h4>
                                <h6 class="font-weight-light">Daftar untuk membuat akun.</h6>

                                <!-- Form Start -->
                                <form method="POST" action="{{ route("register") }}" class="pt-3">
                                    @csrf

                                    <!-- Name -->
                                    <div class="form-group">
                                        <input type="text" id="name" class="form-control form-control-lg"
                                            name="name" :value="old('name')" required autofocus
                                            placeholder="Nama Lengkap">
                                        @error("name")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="form-group">
                                        <input type="email" id="email" class="form-control form-control-lg"
                                            name="email" :value="old('email')" required placeholder="Email">
                                        @error("email")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Phone -->
                                    <div class="form-group">
                                        <input type="text" id="phone" class="form-control form-control-lg"
                                            name="phone" :value="old('phone')" required placeholder="Nomor HP"
                                            pattern="[0-9]+" title="Masukkan nomor telepon yang valid.">
                                        @error("phone")
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

                                    <!-- Confirm Password -->
                                    <div class="form-group">
                                        <input type="password" id="password_confirmation"
                                            class="form-control form-control-lg" name="password_confirmation" required
                                            placeholder="Konfirmasi Password">
                                        @error("password_confirmation")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Register Button -->
                                    <div class="mt-3">
                                        <button type="submit"
                                            class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                                            DAFTAR
                                        </button>
                                    </div>

                                    <!-- Login Link -->
                                    <div class="font-weight-light mt-4 text-center">
                                        Sudah punya akun? <a href="{{ route("login") }}" class="text-primary">Masuk</a>
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
