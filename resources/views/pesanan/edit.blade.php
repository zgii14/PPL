@extends("layouts.app")

@section("content")
    <div class="section-header">
        <h1>Edit Pesanan</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Edit Data Pesanan</h4>
            </div>
            <div class="card-body">
                <form action="{{ route("pesanan.update", $pesanan->id) }}" method="POST">
                    @csrf
                    @method("PUT")

                    <div class="form-group">
                        <label for="paket_id">Paket Laundry</label>
                        <select name="paket_id" id="paket_id" class="form-control" required>
                            @foreach ($paket_laundries as $paket)
                                <option value="{{ $paket->id }}"
                                    {{ $paket->id == $pesanan->paket_id ? "selected" : "" }}>
                                    {{ $paket->nama_paket }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control"
                            value="{{ old("jumlah", $pesanan->jumlah) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="total_harga">Total Harga</label>
                        <input type="number" name="total_harga" id="total_harga" class="form-control"
                            value="{{ old("total_harga", $pesanan->total_harga) }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Perbarui Pesanan</button>
                    <a href="{{ route("pesanan.index") }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
