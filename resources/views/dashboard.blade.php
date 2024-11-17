@extends("layouts.app")

@section("title")
    lorem
@endsection

@section("content")
    <section class="section">
        <div class="section-header">
            <h1>Dashboard Laundry</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">Dashboard</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Selamat Datang, Pemilik Laundry!</h2>
            <p class="section-lead">Lihat ringkasan pesanan dan pendapatan.</p>

            <div class="row">
                <!-- Card Pesanan Hari Ini -->
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Pesanan Hari Ini</h4>
                            </div>
                            <div class="card-body">
                                25 <!-- Jumlah Pesanan (contoh) -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Pesanan Selesai -->
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Pesanan Selesai</h4>
                            </div>
                            <div class="card-body">
                                50 <!-- Jumlah Pesanan Selesai (contoh) -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Pendapatan Bulanan -->
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Pendapatan Bulanan</h4>
                            </div>
                            <div class="card-body">
                                Rp 5.000.000 <!-- Total Pendapatan (contoh) -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Pesanan Terbaru -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Status Pesanan Terbaru</h4>
                        </div>
                        <div class="card-body p-5">
                            <table class="table-striped table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>John Doe</td>
                                        <td><span class="badge badge-success">Selesai</span></td>
                                        <td>2024-11-17</td>
                                        <td>Rp 50,000</td>
                                    </tr>
                                    <!-- Tambahkan data lainnya -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
