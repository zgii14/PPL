@extends("layouts.app")

@section("content")
    <section class="section">
        <!-- Header Bagian Atas dengan Breadcrumb -->
        <div class="section-header">
            <h1>Daftar Riwayat Pesanan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route("dashboard") }}">Dashboard</a></div>
                <div class="breadcrumb-item active">Daftar Riwayat</div>
            </div>
        </div>

        <!-- Bagian Body dengan Form dan Tabel -->
        <div class="section-body">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Filter dan Pencarian Riwayat</h4>
                    <div class="d-flex">
                        <!-- Form Pencarian -->
                        <form method="GET" action="{{ route("riwayat.index") }}" class="form-inline">
                            <input type="text" name="search" class="form-control form-control-sm"
                                placeholder="Cari nama pengguna" value="{{ request("search") }}">
                            <button type="submit" class="btn btn-primary btn-sm ml-2">Cari</button>
                        </form>

                        <!-- Filter berdasarkan Tanggal -->
                        <form method="GET" action="{{ route("riwayat.index") }}" class="form-inline ml-2">
                            <input type="date" name="tanggal" class="form-control form-control-sm"
                                value="{{ request("tanggal") }}">
                            <button type="submit" class="btn btn-info btn-sm ml-2">Cari Tanggal</button>
                        </form>

                        @if (auth()->user()->role == "admin")
                            <!-- Cetak Laporan Bulanan hanya untuk Admin -->
                            <form method="GET" action="{{ route("laporan.bulanan") }}" class="form-inline ml-2">
                                <select name="bulan" class="form-control form-control-sm">
                                    <option value="" disabled selected>Bulan</option>
                                    @foreach ([1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "Mei", 6 => "Jun", 7 => "Jul", 8 => "Ags", 9 => "Sep", 10 => "Okt", 11 => "Nov", 12 => "Des"] as $bulan => $namaBulan)
                                        <option value="{{ $bulan }}">{{ $namaBulan }}</option>
                                    @endforeach
                                </select>
                                <select name="tahun" class="form-control form-control-sm ml-2">
                                    <option value="" disabled selected>Tahun</option>
                                    @for ($i = now()->year; $i >= 2000; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                <button type="submit" class="btn btn-success btn-sm ml-2">Cetak Laporan</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card-body">
                <!-- Bagian Tabel Riwayat Pesanan -->
                <div class="table-responsive">
                    <table class="table-striped table-bordered table-hover mb-0 table">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Paket Laundry</th>
                                <th>Pengguna</th>
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
                                    <td>{{ $riwayat->user ? $riwayat->user->name : "Unknown" }}</td>
                                    <td>{{ $riwayat->jumlah }} kg</td>
                                    <td>Rp {{ number_format($riwayat->total_harga, 0, ",", ".") }}</td>
                                    <td>{{ $riwayat->status }}</td>
                                    <td>{{ ucfirst($riwayat->pembayaran_status) ?? "Belum Dibayar" }}</td>
                                    <td>{{ $riwayat->created_at->format("d-m-Y H:i") }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada riwayat pesanan yang tersedia</td>
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
    </section>
@endsection
