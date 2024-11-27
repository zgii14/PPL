@extends("layouts.app")

@section("content")
    <section class="section">
        <div class="section-header">
            <h1>Detail Paket Laundry</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Informasi Paket Laundry</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="nama_paket" class="form-label"><strong>Nama Paket</strong></label>
                                <p>{{ $paketLaundry->nama_paket }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="jenis" class="form-label"><strong>Jenis</strong></label>
                                <p>{{ $paketLaundry->jenis }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label"><strong>Deskripsi</strong></label>
                                <p>{{ $paketLaundry->deskripsi }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="harga" class="form-label"><strong>Harga</strong></label>
                                <p>Rp {{ number_format($paketLaundry->harga, 2) }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="waktu" class="form-label"><strong>Waktu Penyelesaian</strong></label>
                                <p>{{ $paketLaundry->waktu_formatted }}</p>
                            </div>

                            <a href="{{ route("paket-laundry.index") }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
