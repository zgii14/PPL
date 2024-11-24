@extends("layouts.app")

@section("content")
    <section class="section">
        <div class="section-header">
            <h1>Detail Pesanan</h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Pesanan</h4>
                </div>
                <div class="card-body">
                    <!-- ID Pesanan -->
                    <div class="form-group">
                        <label for="id_pesanan"><strong>ID Pesanan:</strong></label>
                        <p>{{ $pesanan->id }}</p>
                    </div>

                    <!-- Paket Laundry -->
                    <div class="form-group">
                        <label for="paket_id"><strong>Nama Paket:</strong></label>
                        <p>{{ $pesanan->paket->nama_paket }}</p>
                    </div>

                    <!-- Jumlah -->
                    <div class="form-group">
                        <label for="jumlah"><strong>Jumlah:</strong></label>
                        <p>{{ $pesanan->jumlah }}</p>
                    </div>

                    <!-- Total Harga -->
                    <div class="form-group">
                        <label for="total_harga"><strong>Total Harga:</strong></label>
                        <p>Rp {{ number_format($pesanan->total_harga, 2) }}</p>
                    </div>

                    <!-- Status Pesanan -->
                    <div class="form-group">
                        <label for="status"><strong>Status Pesanan:</strong></label>
                        <p>{{ ucfirst($pesanan->status) }}</p>
                    </div>

                    <!-- Tombol Kembali -->
                    <div class="d-flex justify-content-start">
                        <a href="{{ route("pesanan.index") }}" class="btn btn-secondary mx-1">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
