@extends("layouts.app")

@section("content")
    <section class="section">
        <div class="section-header">
            <h1>Edit Paket Laundry</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Edit Paket Laundry</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route("paket-laundry.update", $paketLaundry->id) }}" method="POST">
                                @csrf
                                @method("PUT")

                                <!-- Input Nama Paket -->
                                <div class="form-group">
                                    <label for="nama_paket"><strong>Nama Paket</strong></label>
                                    <input type="text" id="nama_paket" name="nama_paket" class="form-control"
                                        value="{{ old("nama_paket", $paketLaundry->nama_paket) }}" required>
                                    @error("nama_paket")
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Input Jenis Paket -->
                                <div class="form-group">
                                    <label for="jenis"><strong>Jenis</strong></label>
                                    <input type="text" id="jenis" name="jenis" class="form-control"
                                        value="{{ old("jenis", $paketLaundry->jenis) }}" required>
                                    @error("jenis")
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Input Deskripsi Paket -->
                                <div class="form-group">
                                    <label for="deskripsi"><strong>Deskripsi</strong></label>
                                    <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3">{{ old("deskripsi", $paketLaundry->deskripsi) }}</textarea>
                                    @error("deskripsi")
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Input Harga Paket -->
                                <div class="form-group">
                                    <label for="harga"><strong>Harga</strong></label>
                                    <input type="number" id="harga" name="harga" class="form-control"
                                        value="{{ old("harga", $paketLaundry->harga) }}" required>
                                    @error("harga")
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Input Waktu Penyelesaian -->
                                <div class="form-group">
                                    <label for="waktu"><strong>Waktu Penyelesaian (Jam)</strong></label>
                                    <input type="number" id="waktu" name="waktu" class="form-control"
                                        value="{{ old("waktu", $paketLaundry->waktu) }}" required>
                                    @error("waktu")
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tombol Submit dan Batal -->
                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    <a href="{{ route("paket-laundry.index") }}" class="btn btn-secondary">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
