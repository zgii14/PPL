@extends("layouts.app")

@section("content")
    <h1>Edit Paket</h1>
    <form action="{{ route('paket-laundry.update', $paketLaundry->id) }}" method="POST">
        @csrf
        @method("PUT")

        <!-- Input Nama Paket -->
        <div class="form-group">
            <label>Nama Paket</label>
            <input type="text" name="nama_paket" class="form-control" value="{{ old('nama_paket', $paketLaundry->nama_paket) }}" required>
            @error('nama_paket')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <!-- Input Jenis Paket -->
        <div class="form-group">
            <label>Jenis</label>
            <input type="text" name="jenis" class="form-control" value="{{ old('jenis', $paketLaundry->jenis) }}" required>
            @error('jenis')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <!-- Input Deskripsi Paket -->
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ old('deskripsi', $paketLaundry->deskripsi) }}</textarea>
            @error('deskripsi')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <!-- Input Harga Paket -->
        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" value="{{ old('harga', $paketLaundry->harga) }}" required>
            @error('harga')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <!-- Input Waktu Paket -->
        <div class="form-group">
            <label>Waktu Penyelesaian (Jam)</label>
            <input type="number" name="waktu" class="form-control" value="{{ old('waktu', $paketLaundry->waktu) }}" required>
            @error('waktu')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <!-- Tombol Submit dan Batal -->
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('paket-laundry.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection
