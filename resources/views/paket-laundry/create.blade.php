@extends("layouts.app")

@section("content")
    <section class="section">
        <div class="section-header">
            <h1>Tambah Paket Laundry</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Buat Paket Laundry Baru</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route("paket-laundry.store") }}" method="POST"
                                class="rounded bg-white p-4 shadow">
                                @csrf

                                <div class="mb-3">
                                    <label for="nama_paket" class="form-label">Nama Paket</label>
                                    <input type="text" name="nama_paket" id="nama_paket" class="form-control" required>
                                    @error("nama_paket")
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="jenis" class="form-label">Jenis</label>
                                    <input type="text" name="jenis" id="jenis" class="form-control" required>
                                    @error("jenis")
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" id="deskripsi" class="form-control"></textarea>
                                    @error("deskripsi")
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="number" name="harga" id="harga" class="form-control" required>
                                    @error("harga")
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Tambah Paket</button>
                                <a href="{{ route("paket-laundry.index") }}" class="btn btn-secondary">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
