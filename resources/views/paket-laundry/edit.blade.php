@extends("layouts.app")

@section("content")
    <h1>Edit Paket</h1>
    <form action="{{ route("paket-laundry.update", $paketLaundry->id) }}" method="POST">
        @csrf
        @method("PUT")

        <!-- Input Nama Paket -->
        <div class="form-group">
            <label>Nama Paket</label>
            <input type="text" name="nama_paket" class="form-control" value="{{ $paketLaundry->nama_paket }}" required>
        </div>

        <!-- Input Jenis Paket -->
        <div class="form-group">
            <label>Jenis</label>
            <input type="text" name="jenis" class="form-control" value="{{ $paketLaundry->jenis }}" required>
        </div>

        <!-- Input Deskripsi Paket -->
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ $paketLaundry->deskripsi }}</textarea>
        </div>

        <!-- Input Harga Paket -->
        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" value="{{ $paketLaundry->harga }}" required>
        </div>

<!-- Input Waktu Paket -->
<div class="form-group">
    <label>Waktu Penyelesaian</label>
    <input type="datetime-local" name="waktu" class="form-control" value="{{ \Carbon\Carbon::parse($paketLaundry->waktu)->format('Y-m-d\TH:i') }}" required>
</div>


        <!-- Tombol Submit dan Batal -->
        <button type="submit" class="btn btn-primary">Simpan Perubahans</button>
        <a href="{{ route("paket-laundry.index") }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection
