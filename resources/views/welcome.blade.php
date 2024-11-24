<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Laundry Lubis</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link
            href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@400;500&display=swap"
            rel="stylesheet">

        <style>
            /* Global Styles */
            body {
                font-family: 'Roboto', sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f7f7f7;
            }

            h1,
            h2,
            h3,
            p {
                font-family: 'Open Sans', sans-serif;
            }

            .container {
                padding: 0;
                max-width: 1200px;
            }

            /* Navbar */
            .navbar {
                background-color: #2c3e50;
                padding: 15px 0;
            }

            .navbar-brand {
                font-size: 24px;
                color: #fff;
                font-weight: 600;
            }

            .navbar-nav .nav-link {
                color: #fff;
                margin-left: 20px;
                font-size: 18px;
                transition: all 0.3s ease;
            }

            .navbar-nav .nav-link:hover {
                color: #f39c12;
            }

            /* Hero Section */
            .hero {
                background-image: url('https://via.placeholder.com/1500x800');
                /* Replace with a good image */
                background-size: cover;
                background-position: center;
                color: #fff;
                text-align: center;
                padding: 100px 0;
            }

            .hero h1 {
                font-size: 50px;
                font-weight: 700;
                margin-bottom: 20px;
            }

            .hero p {
                font-size: 20px;
                margin-bottom: 30px;
                max-width: 700px;
                margin-left: auto;
                margin-right: auto;
            }

            .hero .btn-primary {
                background-color: #f39c12;
                border: none;
                font-size: 18px;
                padding: 12px 30px;
                border-radius: 5px;
                transition: background-color 0.3s ease;
            }

            .hero .btn-primary:hover {
                background-color: #e67e22;
            }

            /* Services Section */
            .services {
                background-color: #fff;
                padding: 60px 0;
            }

            .services h2 {
                text-align: center;
                margin-bottom: 40px;
                font-size: 36px;
                font-weight: 600;
            }

            .services .card {
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                border: none;
                transition: transform 0.3s ease;
            }

            .services .card:hover {
                transform: translateY(-10px);
            }

            .services .card img {
                width: 100%;
                border-radius: 5px;
            }

            .services .card-body {
                text-align: center;
            }

            /* Testimonial Section */
            .testimonials {
                background-color: #ecf0f1;
                padding: 80px 0;
            }

            .testimonials h2 {
                text-align: center;
                margin-bottom: 40px;
                font-size: 36px;
                font-weight: 600;
            }

            .testimonial-card {
                background-color: #fff;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                padding: 30px;
                border-radius: 10px;
                margin: 20px 0;
                text-align: center;
                transition: transform 0.3s ease;
            }

            .testimonial-card:hover {
                transform: translateY(-10px);
            }

            .testimonial-card img {
                width: 80px;
                height: 80px;
                border-radius: 50%;
                margin-bottom: 15px;
            }

            .testimonial-card p {
                font-style: italic;
                color: #7f8c8d;
            }

            .testimonial-card h3 {
                font-size: 22px;
                font-weight: 600;
                color: #34495e;
            }

            /* Contact Section */
            .contact {
                padding: 60px 0;
                background-color: #2c3e50;
                color: #fff;
            }

            .contact h2 {
                text-align: center;
                margin-bottom: 40px;
                font-size: 36px;
                font-weight: 600;
            }

            .contact-form input,
            .contact-form textarea {
                width: 100%;
                padding: 15px;
                margin: 10px 0;
                border: 1px solid #ccc;
                border-radius: 5px;
                font-size: 16px;
            }

            .contact-form button {
                background-color: #f39c12;
                color: #fff;
                padding: 15px 30px;
                border: none;
                border-radius: 5px;
                font-size: 18px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .contact-form button:hover {
                background-color: #e67e22;
            }
        </style>
    </head>

    <body>

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="#">Laundry Lubis</a>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Testimoni</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Kontak</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero">
            <div class="container">
                <h1>Selamat Datang di Laundry Lubis</h1>
                <p>Layanan laundry terbaik untuk kebersihan dan kenyamanan pakaian Anda. Mudah, cepat, dan terpercaya.
                </p>
                <a href="#contact" class="btn-primary">Hubungi Kami Sekarang</a>
            </div>
        </section>

        <!-- Services Section -->
        <section id="services" class="services">
            <div class="container">
                <h2>Layanan Kami</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/300" alt="Cuci Kering">
                            <div class="card-body">
                                <h5 class="card-title">Cuci Kering</h5>
                                <p>Cuci kering untuk pakaian Anda yang membutuhkan perawatan lebih hati-hati.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/300" alt="Setrika">
                            <div class="card-body">
                                <h5 class="card-title">Setrika</h5>
                                <p>Layanan setrika dengan hasil rapi dan sempurna untuk penampilan yang maksimal.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/300" alt="Cuci Sepatu">
                            <div class="card-body">
                                <h5 class="card-title">Cuci Sepatu</h5>
                                <p>Menjaga sepatu Anda tetap bersih dan nyaman dengan layanan cuci sepatu kami.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section id="testimonials" class="testimonials">
            <div class="container">
                <h2>Apa Kata Pelanggan Kami</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="testimonial-card">
                            <img src="https://via.placeholder.com/80" alt="Testimonial 1">
                            <p>"Layanan laundry cepat dan hasilnya sangat memuaskan. Sangat recommended!"</p>
                            <h3>Andi Susanto</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="testimonial-card">
                            <img src="https://via.placeholder.com/80" alt="Testimonial 2">
                            <p>"Laundry Lubis adalah pilihan terbaik untuk perawatan pakaian saya."</p>
                            <h3>Siti Aisyah</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="testimonial-card">
                            <img src="https://via.placeholder.com/80" alt="Testimonial 3">
                            <p>"Saya selalu puas dengan hasil cuci dan setrika di Laundry Lubis!"</p>
                            <h3>Rudi Firmansyah</h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="contact">
            <div class="container">
                <h2>Hubungi Kami</h2>
                <form class="contact-form">
                    <input type="text" placeholder="Nama Anda" required>
                    <input type="email" placeholder="Email Anda" required>
                    <textarea placeholder="Pesan Anda" required></textarea>
                    <button type="submit">Kirim Pesan</button>
                </form>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-dark py-3 text-center text-white">
            <p>&copy; 2024 Laundry Lubis | Semua Hak Cipta Dilindungi</p>
        </footer>

        <!-- Bootstrap JS and dependencies -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    </body>

</html>
