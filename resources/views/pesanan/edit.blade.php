@extends("layouts.app")

@section("content")
    <section class="section">
        <div class="section-header">
            <h1>Edit Pesanan</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Form Edit Pesanan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route("pesanan.update", $pesanan->id) }}" method="POST">
                        @csrf
                        @method("PUT")

                        <div class="mb-3">
                            <label for="paket_id" class="form-label">Paket Laundry</label>
                            <select name="paket_id" id="paket_id"
                                class="form-control @error("paket_id") is-invalid @enderror" required>
                                @foreach ($paket as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $item->id == $pesanan->paket_id ? "selected" : "" }}>
                                        {{ $item->nama_paket }} - Rp {{ number_format($item->harga, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            @error("paket_id")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input untuk memilih pelanggan (user_id) -->
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Nama Pelanggan</label>
                            <select name="user_id" id="user_id"
                                class="form-control @error("user_id") is-invalid @enderror" required>
                                <option value="">Pilih Pelanggan</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $user->id == $pesanan->user_id ? "selected" : "" }}>
                                        {{ $user->name }} <!-- Menampilkan nama pelanggan -->
                                    </option>
                                @endforeach
                            </select>
                            @error("user_id")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control @error("jumlah") is-invalid @enderror"
                                value="{{ old("jumlah", $pesanan->jumlah) }}" min="1" required>
                            @error("jumlah")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
