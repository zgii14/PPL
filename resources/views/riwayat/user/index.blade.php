@extends("layouts.app")

@section("content")
    <section class="section">
        <!-- Header Bagian Atas dengan Breadcrumb -->
        <div class="section-header">
            <h1>Riwayat Pesanan Saya</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route("dashboard") }}">Dashboard</a></div>
                <div class="breadcrumb-item active">Riwayat Pesanan Saya</div>
            </div>
        </div>

        <!-- Bagian Body dengan Tabel -->
        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Riwayat Pesanan Anda</h4>
                </div>

                <div class="card-body">
                    <!-- Bagian Tabel Riwayat Pesanan Pengguna -->
                    <div class="table-responsive">
                        <table class="table-striped table-bordered table-hover mb-0 table">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Paket Laundry</th>
                                    <th>Jumlah (kg)</th>
                                    <th>Total Harga</th>
                                    <th>Status</th>
                                    <th>Pembayaran</th>
                                    <th>Tanggal Pemesanan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($riwayats as $riwayat)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $riwayat->paket ? $riwayat->paket->nama_paket : "Unknown" }}</td>
                                        <td>{{ $riwayat->jumlah }} kg</td>
                                        <td>Rp {{ number_format($riwayat->total_harga, 0, ",", ".") }}</td>
                                        <td>{{ $riwayat->status }}</td>
                                        <td>{{ ucfirst($riwayat->pembayaran_status) ?? "Belum Dibayar" }}</td>
                                        <td>{{ $riwayat->created_at->format("d-m-Y H:i") }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Anda belum memiliki riwayat pesanan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $riwayats->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
