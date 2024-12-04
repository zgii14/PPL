<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Laundry Lubis</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="Free HTML Templates" name="keywords">
        <meta content="Free HTML Templates" name="description">

        <!-- Favicon -->
        <link href="asset2/img/favicon.ico" rel="icon">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;800&display=swap" rel="stylesheet">

        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="asset2/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

        <!-- Customized Bootstrap Stylesheet -->
        <link href="asset2/css/style.css" rel="stylesheet">
    </head>

    <body>
        <!-- Topbar Start -->
        <div class="container-fluid bg-primary py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-lg-left mb-lg-0 mb-2 text-center">
                        <div class="d-inline-flex align-items-center">
                            <a class="pr-3 text-white" href="">FAQs</a>
                            <span class="text-white">|</span>
                            <a class="px-3 text-white" href="">Help</a>
                            <span class="text-white">|</span>
                            <a class="pl-3 text-white" href="">Support</a>
                        </div>
                    </div>
                    <div class="col-md-6 text-lg-right text-center">
                        <div class="d-inline-flex align-items-center">
                            <a class="px-3 text-white" href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="px-3 text-white" href="">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="px-3 text-white" href="">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="px-3 text-white" href="">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a class="pl-3 text-white" href="">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Topbar End -->

        <!-- Navbar Start -->
        <!-- Navbar Start -->
        <div class="container-fluid position-relative nav-bar p-0">
            <div class="container-lg position-relative px-lg-3 p-0" style="z-index: 9;">
                <nav class="navbar navbar-expand-lg navbar-light py-lg-0 pl-lg-5 bg-white py-3 pl-3">
                    <a href="" class="navbar-brand">
                        <h1 class="text-secondary m-0"><span class="text-primary">Laundry</span>Lubis</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="navbar-collapse justify-content-between collapse px-3" id="navbarCollapse">
                        <div class="navbar-nav ml-auto py-0">
                            <div class="navbar-collapse collapse" id="navbarNav">
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#about">Tentang Kami</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#features">Fitur Kami</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#working-process">Proses Laundry</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#pricing-plan">Harga</a>
                                    </li>
                                    <li class="nav-item"></li>
                                    <a class="nav-link" href="#contact">Kontak</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route("login") }}">Login</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                </nav>
            </div>
        </div>
        <!-- Navbar End -->

        <!-- Navbar End -->

        <!-- Carousel Start -->
        <div class="container-fluid p-0">
            <div id="header-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="w-100" src="asset2/img/carousel-1.jpg" alt="Gambar">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style="max-width: 900px;">
                                <h4 class="text-uppercase mb-md-3 text-white">Laundry Lubis</h4>
                                <h1 class="display-3 mb-md-4 text-white">Terbaik Untuk Layanan Laundry</h1>
                                <a href="{{ route("login") }}" class="btn btn-primary py-md-3 px-md-5 mt-2">Pelajari
                                    Lebih
                                    Lanjut</a>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="w-100" src="asset2/img/carousel-2.jpg" alt="Gambar">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style="max-width: 900px;">
                                <h4 class="text-uppercase mb-md-3 text-white">Laundry & Pembersihan Kering</h4>
                                <h1 class="display-3 mb-md-4 text-white">Staf yang Sangat Profesional</h1>
                                <a href="" class="btn btn-primary py-md-3 px-md-5 mt-2">Pelajari Lebih
                                    Lanjut</a>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                    <div class="btn btn-secondary" style="width: 45px; height: 45px;">
                        <span class="carousel-control-prev-icon mb-n2"></span>
                    </div>
                </a>
                <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                    <div class="btn btn-secondary" style="width: 45px; height: 45px;">
                        <span class="carousel-control-next-icon mb-n2"></span>
                    </div>
                </a>
            </div>
        </div>

        <!-- Carousel End -->

        <!-- Contact Info Start -->
        <div id ="contact"class="container-fluid contact-info mb-4 mt-5">
            <div class="container" style="padding: 0 30px;">
                <div class="row">
                    <div class="col-md-4 d-flex align-items-center justify-content-center bg-secondary mb-lg-0 mb-4"
                        style="height: 100px;">
                        <div class="d-inline-flex">
                            <i class="fa fa-2x fa-map-marker-alt m-0 mr-3 text-white"></i>
                            <div class="d-flex flex-column">
                                <h5 class="font-weight-medium text-white">Lokasi Kami</h5>
                                <p class="m-0 text-white">Jl. WR. Supratman, Kandang Limun, Bengkulu</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-center bg-primary mb-lg-0 mb-4"
                        style="height: 100px;">
                        <div class="d-inline-flex text-left">
                            <i class="fa fa-2x fa-envelope m-0 mr-3 text-white"></i>
                            <div class="d-flex flex-column">
                                <h5 class="font-weight-medium text-white">Kirim Email</h5>
                                <p class="m-0 text-white">laundrylubis@gmail.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-center bg-secondary mb-lg-0 mb-4"
                        style="height: 100px;">
                        <div class="d-inline-flex text-left">
                            <i class="fa fa-2x fa-phone-alt m-0 mr-3 text-white"></i>
                            <div class="d-flex flex-column">
                                <h5 class="font-weight-medium text-white">Hubungi Kami</h5>
                                <p class="m-0 text-white">+6283173289305</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Info End -->

        <!-- About Start -->
        <div id="about" class="container-fluid py-5">
            <div class="pt-lg-4 container pt-0">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <img class="img-fluid" src="asset2/img/about.jpg" alt="Tentang Kami">
                    </div>
                    <div class="col-lg-7 mt-lg-0 pl-lg-5 mt-5">
                        <h6 class="text-secondary text-uppercase font-weight-medium mb-3">Kenali Kami Lebih Dekat</h6>
                        <h1 class="mb-4">Penyedia Layanan Laundry Terpercaya di Kota Anda</h1>
                        <h5 class="font-weight-medium font-italic mb-4">Layanan terbaik dengan sentuhan yang penuh
                            perhatian, mengutamakan kualitas dan kenyamanan.</h5>
                        <p class="mb-2">Kami hadir untuk memberikan solusi laundry yang nyaman dan terpercaya.
                            Layanan kami dirancang untuk memenuhi kebutuhan Anda dengan harga yang terjangkau dan
                            kualitas yang tak tertandingi. Pengalaman lebih dari sekadar mencuci - kami memastikan
                            pakaian Anda terlihat dan terasa sempurna.</p>
                        <div class="row">
                            <div class="col-sm-6 pt-3">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-check text-primary mr-2"></i>
                                    <p class="text-secondary font-weight-medium m-0">Layanan Laundry Berkualitas Tinggi
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-6 pt-3">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-check text-primary mr-2"></i>
                                    <p class="text-secondary font-weight-medium m-0">Pengiriman Cepat & Ekspres</p>
                                </div>
                            </div>
                            <div class="col-sm-6 pt-3">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-check text-primary mr-2"></i>
                                    <p class="text-secondary font-weight-medium m-0">Staf Profesional & Ramah</p>
                                </div>
                            </div>
                            <div class="col-sm-6 pt-3">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-check text-primary mr-2"></i>
                                    <p class="text-secondary font-weight-medium m-0">Jaminan Kepuasan 100%</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->

        <!-- Features Start -->
        <div id="features"class="container-fluid py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 my-lg-5 pt-lg-5 pr-lg-5 m-0 pt-0">
                        <h6 class="text-secondary text-uppercase font-weight-medium mb-3">Fitur Kami</h6>
                        <h1 class="mb-4">Mengapa Memilih Kami</h1>
                        <p>Kami memiliki pengalaman bertahun-tahun dalam memberikan layanan laundry berkualitas. Dengan
                            staf yang ahli dan profesional, kami memastikan setiap pakaian yang Anda percayakan
                            mendapatkan perlakuan terbaik. Kami berkomitmen untuk memberikan hasil yang memuaskan dan
                            pengiriman yang tepat waktu.</p>
                        <div class="row">
                            <div class="col-sm-6 mb-4">
                                <h1 class="text-secondary" data-toggle="counter-up">10</h1>
                                <h5 class="font-weight-bold">Tahun Pengalaman</h5>
                            </div>
                            <div class="col-sm-6 mb-4">
                                <h1 class="text-secondary" data-toggle="counter-up">250</h1>
                                <h5 class="font-weight-bold">Pekerja Ahli</h5>
                            </div>
                            <div class="col-sm-6 mb-4">
                                <h1 class="text-secondary" data-toggle="counter-up">1250</h1>
                                <h5 class="font-weight-bold">Klien Puas</h5>
                            </div>
                            <div class="col-sm-6 mb-4">
                                <h1 class="text-secondary" data-toggle="counter-up">9550</h1>
                                <h5 class="font-weight-bold">Pembersihan Kering</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div
                            class="d-flex flex-column align-items-center justify-content-center bg-secondary h-100 px-3 py-5">
                            <i class="fa fa-5x fa-certificate mb-5 text-white"></i>
                            <h1 class="display-1 mb-3 text-white">10+</h1>
                            <h1 class="m-0 text-white">Tahun Pengalaman</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features End -->

        <!-- Working Process Start -->
        <div id="working-process" class="container-fluid pt-5">
            <div class="container">
                <h6 class="text-secondary text-uppercase font-weight-medium mb-3 text-center">Proses Laundry</h6>
                <h1 class="display-4 mb-5 text-center">Cara Kami Bekerja</h1>
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex flex-column align-items-center justify-content-center mb-5 text-center">
                            <div class="d-inline-flex align-items-center justify-content-center border-light rounded-circle mb-4 border bg-white shadow"
                                style="width: 150px; height: 150px; border-width: 15px !important;">
                                <h2 class="display-2 text-secondary m-0">1</h2>
                            </div>
                            <h3 class="font-weight-bold m-0 mt-2">Tempatkan Pesanan</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex flex-column align-items-center justify-content-center mb-5 text-center">
                            <div class="d-inline-flex align-items-center justify-content-center border-light rounded-circle mb-4 border bg-white shadow"
                                style="width: 150px; height: 150px; border-width: 15px !important;">
                                <h2 class="display-2 text-secondary m-0">2</h2>
                            </div>
                            <h3 class="font-weight-bold m-0 mt-2">Ambil Gratis</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex flex-column align-items-center justify-content-center mb-5 text-center">
                            <div class="d-inline-flex align-items-center justify-content-center border-light rounded-circle mb-4 border bg-white shadow"
                                style="width: 150px; height: 150px; border-width: 15px !important;">
                                <h2 class="display-2 text-secondary m-0">3</h2>
                            </div>
                            <h3 class="font-weight-bold m-0 mt-2">Dry Cleaning</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex flex-column align-items-center justify-content-center mb-5 text-center">
                            <div class="d-inline-flex align-items-center justify-content-center border-light rounded-circle mb-4 border bg-white shadow"
                                style="width: 150px; height: 150px; border-width: 15px !important;">
                                <h2 class="display-2 text-secondary m-0">4</h2>
                            </div>
                            <h3 class="font-weight-bold m-0 mt-2">Pengantaran Gratis</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Working Process End -->

        <!-- Pricing Plan Start -->
        <div id="pricing-plan" class="container-fluid pb-3 pt-5">
            <div class="container">
                <h6 class="text-secondary text-uppercase font-weight-medium mb-3 text-center">Paket Laundry Kami</h6>
                <h1 class="display-4 mb-5 text-center">Harga Terbaik</h1>
                <div class="row">
                    <!-- Paket Cuci Lipat -->
                    <div class="col-lg-4 mb-4">
                        <div class="bg-light rounded p-4 text-center shadow">
                            <div class="d-inline-flex flex-column align-items-center justify-content-center bg-secondary rounded-circle mb-4 mt-2 shadow-sm"
                                style="width: 120px; height: 120px; border: 10px solid #ffffff;">
                                <h3 class="text-white" style="font-size: 20px;">C/L</h3>
                                <!-- Singkatan untuk Cuci Lipat -->
                            </div>
                            <h3 class="font-weight-bold mb-3">Paket Cuci Lipat</h3>
                            <div class="d-flex flex-column align-items-center py-3">
                                <p style="font-size: 15px;">Cuci pakaian dan dilipat rapi.</p>
                                <p style="font-size: 14px; color: #777;">Durasi: 24 Jam</p>
                            </div>
                            <h4 class="font-weight-bold mb-4">Rp 15.000 / Pakaian</h4>
                            <a href="{{ route("login") }}" class="btn btn-secondary px-4 py-2">Pesan Sekarang</a>
                        </div>
                    </div>
                    <!-- Paket Cuci Kering -->
                    <div class="col-lg-4 mb-4">
                        <div class="bg-light rounded p-4 text-center shadow">
                            <div class="d-inline-flex flex-column align-items-center justify-content-center bg-primary rounded-circle mb-4 mt-2 shadow-sm"
                                style="width: 120px; height: 120px; border: 10px solid #ffffff;">
                                <h3 class="text-white" style="font-size: 20px;">C/K</h3>
                                <!-- Singkatan untuk Cuci Kering -->
                            </div>
                            <h3 class="font-weight-bold mb-3">Paket Cuci Kering</h3>
                            <div class="d-flex flex-column align-items-center py-3">
                                <p style="font-size: 15px;">Pakaian dicuci dan dikeringkan.</p>
                                <p style="font-size: 14px; color: #777;">Durasi: 24 Jam</p>
                            </div>
                            <h4 class="font-weight-bold mb-4">Rp 20.000 / Pakaian</h4>
                            <a href="{{ route("login") }}" class="btn btn-primary px-4 py-2">Pesan Sekarang</a>
                        </div>
                    </div>
                    <!-- Paket Express Cuci Kering Lipat -->
                    <div class="col-lg-4 mb-4">
                        <div class="bg-light rounded p-4 text-center shadow">
                            <div class="d-inline-flex flex-column align-items-center justify-content-center bg-secondary rounded-circle mb-4 mt-2 shadow-sm"
                                style="width: 120px; height: 120px; border: 10px solid #ffffff;">
                                <h3 class="text-white" style="font-size: 20px;">E/C/L</h3>
                                <!-- Singkatan untuk Express Cuci Kering Lipat -->
                            </div>
                            <h3 class="font-weight-bold mb-3">Paket Express CKL</h3>
                            <div class="d-flex flex-column align-items-center py-3">
                                <p style="font-size: 15px;">Layanan express cuci, kering, dan lipat.</p>
                                <p style="font-size: 14px; color: #777;">Durasi: 6 Jam</p>
                            </div>
                            <h4 class="font-weight-bold mb-4">Rp 30.000 / Pakaian</h4>
                            <a href="{{ route("login") }}" class="btn btn-secondary px-4 py-2">Pesan Sekarang</a>
                        </div>
                    </div>
                    <!-- Paket Cuci Setrika -->
                    <div class="col-lg-4 mb-4">
                        <div class="bg-light rounded p-4 text-center shadow">
                            <div class="d-inline-flex flex-column align-items-center justify-content-center bg-secondary rounded-circle mb-4 mt-2 shadow-sm"
                                style="width: 120px; height: 120px; border: 10px solid #ffffff;">
                                <h3 class="text-white" style="font-size: 20px;">C/S</h3>
                                <!-- Singkatan untuk Cuci Setrika -->
                            </div>
                            <h3 class="font-weight-bold mb-3">Paket Cuci Setrika</h3>
                            <div class="d-flex flex-column align-items-center py-3">
                                <p style="font-size: 15px;">Pakaian dicuci dan disetrika.</p>
                                <p style="font-size: 14px; color: #777;">Durasi: 24 Jam</p>
                            </div>
                            <h4 class="font-weight-bold mb-4">Rp 25.000 / Pakaian</h4>
                            <a href="{{ route("login") }}" class="btn btn-secondary px-4 py-2">Pesan Sekarang</a>
                        </div>
                    </div>
                    <!-- Paket Premium -->
                    <div class="col-lg-4 mb-4">
                        <div class="bg-light rounded p-4 text-center shadow">
                            <div class="d-inline-flex flex-column align-items-center justify-content-center bg-primary rounded-circle mb-4 mt-2 shadow-sm"
                                style="width: 120px; height: 120px; border: 10px solid #ffffff;">
                                <h3 class="text-white" style="font-size: 20px;">P</h3>
                                <!-- Singkatan untuk Premium -->
                            </div>
                            <h3 class="font-weight-bold mb-3">Paket Premium</h3>
                            <div class="d-flex flex-column align-items-center py-3">
                                <p style="font-size: 15px;">Layanan cuci, setrika, dan parfum khusus.</p>
                                <p style="font-size: 14px; color: #777;">Durasi: 48 Jam</p>
                            </div>
                            <h4 class="font-weight-bold mb-4">Rp 40.000 / Pakaian</h4>
                            <a href="{{ route("login") }}" class="btn btn-primary px-4 py-2">Pesan Sekarang</a>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4">
                        <div class="bg-light rounded p-4 text-center shadow">
                            <div class="d-inline-flex flex-column align-items-center justify-content-center bg-secondary rounded-circle mb-4 mt-2 shadow-sm"
                                style="width: 120px; height: 120px; border: 10px solid #ffffff;">
                                <h3 class="text-white" style="font-size: 20px;">C/S/P</h3>
                            </div>
                            <h3 class="font-weight-bold mb-3">Paket Khusus </h3>
                            <div class="d-flex flex-column align-items-center py-3">
                                <p style="font-size: 15px;">Cuci, setrika, dan tambahkan parfum .</p>
                                <p style="font-size: 14px; color: #777;">Durasi: 24 Jam</p>
                            </div>
                            <h4 class="font-weight-bold mb-4">Rp 30.000 / Pakaian</h4>
                            <a href="/login" class="btn btn-secondary px-4 py-2">Pesan Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pricing Plan End -->

        <!-- Footer Start -->
        <div class="container-fluid bg-primary px-sm-3 px-md-5 mt-5 pt-5 text-white">
            <div class="row pt-5">
                <div class="col-lg-3 col-md-6 mb-5">
                    <a href="">
                        <h1 class="text-secondary mb-3"><span class="text-white">Laundry</span> Lubis</h1>
                    </a>
                    <p>Layanan laundry berkualitas tinggi untuk kebutuhan Anda. Kami memberikan solusi cepat, mudah, dan
                        terpercaya untuk semua jenis cucian Anda. Percayakan pada kami untuk perawatan terbaik pakaian
                        Anda.</p>
                    <div class="d-flex justify-content-start mt-4">
                        <a class="btn btn-outline-light rounded-circle mr-2 px-0 text-center"
                            style="width: 38px; height: 38px;" href="#"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light rounded-circle mr-2 px-0 text-center"
                            style="width: 38px; height: 38px;" href="#"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light rounded-circle mr-2 px-0 text-center"
                            style="width: 38px; height: 38px;" href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a class="btn btn-outline-light rounded-circle mr-2 px-0 text-center"
                            style="width: 38px; height: 38px;" href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-5">
                    <h4 class="mb-4 text-white">Hubungi Kami</h4>
                    <p>Jika Anda memiliki pertanyaan atau ingin menggunakan layanan kami, jangan ragu untuk menghubungi
                        kami. Kami siap melayani Anda dengan sepenuh hati.</p>
                    <p><i class="fa fa-map-marker-alt mr-2"></i>Jl. WR. Supratman, Kandang Limun, Bengkulu</p>
                    <p><i class="fa fa-phone-alt mr-2"></i>+6283173289305</p>
                    <p><i class="fa fa-envelope mr-2"></i>laundrylubis@gmail.com</p>
                </div>
                <div class="col-lg-3 col-md-6 mb-5">
                    <h4 class="mb-4 text-white">Tautan Cepat</h4>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="mb-2 text-white" href="#"><i class="fa fa-angle-right mr-2"></i>Beranda</a>
                        <a class="mb-2 text-white" href="#"><i class="fa fa-angle-right mr-2"></i>Tentang
                            Kami</a>
                        <a class="mb-2 text-white" href="#"><i class="fa fa-angle-right mr-2"></i>Layanan</a>
                        <a class="mb-2 text-white" href="#"><i class="fa fa-angle-right mr-2"></i>Harga</a>
                        <a class="text-white" href="#"><i class="fa fa-angle-right mr-2"></i>Kontak Kami</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-5">
                    <h4 class="mb-4 text-white">Newsletter</h4>
                    <form action="">
                        <div class="form-group">
                            <input type="text" class="form-control border-0" placeholder="Nama Anda"
                                required="required" />
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control border-0" placeholder="Email Anda"
                                required="required" />
                        </div>
                        <div>
                            <button class="btn btn-lg btn-secondary btn-block border-0" type="submit">Kirim
                                Sekarang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container-fluid bg-dark px-sm-3 px-md-5 py-4 text-white">
            <p class="m-0 text-center text-white">
                &copy; <a class="font-weight-medium text-white" href="#">Laundry Lubis</a>. All Rights
                Reserved.
            </p>
        </div>
        <!-- Footer End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="asset2/lib/easing/easing.min.js"></script>
        <script src="asset2/lib/waypoints/waypoints.min.js"></script>
        <script src="asset2/lib/counterup/counterup.min.js"></script>
        <script src="asset2/lib/owlcarousel/owl.carousel.min.js"></script>

        <!-- Contact Javascript File -->
        <script src="asset2/mail/jqBootstrapValidation.min.js"></script>
        <script src="asset2/mail/contact.js"></script>

        <!-- Template Javascript -->
        <script src="asset2/js/main.js"></script>
    </body>

</html>
