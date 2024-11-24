<!doctype html>
<html>

    <head>
        <title>@yield("title")</title>
        <!-- General CSS Files -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
            integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
        <!-- SweetAlert2 CDN -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>

        <!-- Template CSS -->
        <link rel="stylesheet" href="{{ asset("css/style.css") }}" />
        <link rel="stylesheet" href="{{ asset("css/components.css") }}" />
        <link rel="stylesheet" href="{{ asset("css/custom.css") }}" />
        
        @stack('css')
    </head>

    <body>
        <div id="app">
            <div class="main-wrapper">
                <div class="navbar-bg"></div>
                <nav class="navbar navbar-expand-lg main-navbar">
                    <div class="form-inline mr-auto">
                        <ul class="navbar-nav mr-3">
                            <li>
                                <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i
                                        class="fas fa-bars"></i></a>
                            </li>
                        </ul>
                    </div>
                    <ul class="navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown"
                                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                <img alt="image" src="{{ asset("assets/images/avatar/avatar-1.png") }}"
                                    class="rounded-circle mr-1" />
                                <div class="d-sm-none d-lg-inline-block">
                                    Hi,{{ Auth::user()->name }}
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-title">Logged in </div>
                                <a href="" class="dropdown-item has-icon"><i class="far fa-user"></i> Profile</a>
                                <div class="dropdown-divider"></div>
                                <form action="{{ route("logout") }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="dropdown-item has-icon text-danger small d-flex align-items-center"><i
                                            class="fas fa-sign-out-alt"></i> Logout</button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </nav>
                <div class="main-sidebar">
                    <aside id="sidebar-wrapper">
                        <div class="sidebar-brand">
                            <a href="#">Mail</a>
                        </div>
                        <div class="sidebar-brand sidebar-brand-sm">
                            <a href="#">M</a>
                        </div>
                        @include("layouts.menu")
                    </aside>
                </div>
                <!-- Main Content -->
                <div class="main-content">
                    @yield("content")
                </div>
                <footer class="main-footer">
                    <div class="footer-left">
                        Copyright &copy; 2024<div class="bullet"></div>By <a href="https://github.com/Anjasfedo/"
                            target="_blank">Anjasfedo</a>
                    </div>
                </footer>
            </div>
        </div>
        <!-- General JS Scripts -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
        <!-- Template JS File -->
        <script src="{{ asset("js/scripts.js") }}"></script>
        <script src="{{ asset("js/custom.js") }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.addEventListener("submit", function(event) {
                    if (event.target && event.target.classList.contains("delete-alertbox")) {
                        console.log("Submit event fired");
                        event.preventDefault();
                        const form = event.target; // Store the form that triggered the event

                        Swal.fire({
                            title: "Are you sure?",
                            text: "You won't be able to revert this!",
                            icon: "warning",
                            showCancelButton: true,
                            cancelButtonColor: "#3085d6",
                            confirmButtonColor: "#d33",
                            confirmButtonText: "Yes, delete it!",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit(); // Submit the stored form
                            }
                        });
                    }
                });
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });

            // Check for the session success message and show it in a toast
            @if (session("success"))
                Toast.fire({
                    icon: "success",
                    title: "{{ session("success") }}"
                });
            @elseif (session("error"))
                Toast.fire({
                    icon: "error",
                    title: "{{ session("error") }}"
                });
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    Toast.fire({
                        icon: "error",
                        title: "{{ $error }}"
                    });
                @endforeach
            @endif
        </script>

        @stack("scripts")
    </body>

</html>
