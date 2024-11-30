@extends("layouts.app")

@section("title")
    Dashboard Laundry
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
            <h2 class="section-title">Selamat Datang, {{ auth()->user()->name }}!</h2>
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
                                {{ $pesananHariIni }} <!-- Jumlah Pesanan Hari Ini -->
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
                                {{ $pesananSelesai }} <!-- Jumlah Pesanan Selesai -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Pendapatan Bulanan -->
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-money-bill-wave"></i> <!-- Optional icon change -->
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Pendapatan Bulanan</h4>
                            </div>
                            <div class="card-body">
                                Rp {{ number_format($pendapatanBulanan, 0, ",", ".") }} <!-- Changed $ to Rp -->
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
                                    @foreach ($latestPesanan as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->user->name }}</td>
                                            <td>
                                                <span
                                                    class="badge @if ($item->status == 6) badge-success
                                                    @elseif($item->status == 5) badge-warning
                                                    @elseif($item->status == 4) badge-info
                                                    @elseif($item->status == 3) badge-primary
                                                    @elseif($item->status == 2) badge-secondary
                                                    @elseif($item->status == 1) badge-danger
                                                    @else badge-dark @endif">
                                                    {{ $item->status == 6 ? "Selesai" : ($item->status == 5 ? "Diantar" : ($item->status == 4 ? "Lipat" : ($item->status == 3 ? "Kering" : ($item->status == 2 ? "Cuci" : "Dijemput")))) }}
                                                </span>
                                            </td>
                                            <td>{{ $item->created_at->format("Y-m-d") }}</td>
                                            <td>Rp {{ number_format($item->total_harga, 0, ",", ".") }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination for Latest Orders -->
            <div class="card-footer d-flex justify-content-center">
                {{ $latestPesanan->links() }}
            </div>
        </div>
    </section>
@endsection
