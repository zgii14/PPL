@extends("layouts.app")

@section("content")
    <h1>Detail Paket Laundry</h1>
    <p><strong>Nama Paket:</strong> {{ $paketLaundry->nama_paket }}</p>
    <p><strong>Jenis:</strong> {{ $paketLaundry->jenis }}</p>
    <p><strong>Deskripsi:</strong> {{ $paketLaundry->deskripsi }}</p>
    <p><strong>Harga:</strong> Rp {{ number_format($paketLaundry->harga, 2) }}</p>
    <a href="{{ route("paket-laundry.index") }}" class="btn btn-secondary">Kembali</a>
@endsection
