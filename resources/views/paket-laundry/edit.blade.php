@extends("layouts.app")

@section("content")
    <h1>Edit Paket</h1>
    <form action="{{ route("paket-laundry.update", $paketLaundry->id) }}" method="POST">
        @csrf
        @method("PUT")
        <div class="form-group">
            <label>Nama Paket</label>
            <input type="text" name="nama_paket" class="form-control" value="{{ $paketLaundry->nama_paket }}" required>
        </div>
        <div class="form-group">
            <label>Jenis</label>
            <input type="text" name="jenis" class="form-control" value="{{ $paketLaundry->jenis }}" required>
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ $paketLaundry->deskripsi }}</textarea>
        </div>
        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" value="{{ $paketLaundry->harga }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route("paket-laundry.index") }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection
