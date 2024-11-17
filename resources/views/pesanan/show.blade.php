@extends("layouts.app")

@section("content")
    <div class="section-header">
        <h1>Detail Pesanan</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Detail Pesanan</h4>
            </div>
            <div class="card-body">
                <p><strong>ID Pesanan:</strong> {{ $pesanan->id }}</p>
                <p><strong>Nama Paket:</strong> {{ $pesanan->paket->nama_paket }}</p>
                <p><strong>Jumlah:</strong> {{ $pesanan->jumlah }}</p>
                <p><strong>Total Harga:</strong> Rp {{ number_format($pesanan->total_harga, 2) }}</p>
                <a href="{{ route("pesanan.edit", $pesanan->id) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route("pesanan.index") }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection
