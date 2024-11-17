@extends("layouts.app")

@section("content")
    <section class="section">
        <div class="section-header">
            <h1>Buat Pesanan Baru</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Pesanan</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route("pesanan.store") }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="paket_id" class="form-label">Pilih Paket Laundry</label>
                                    <select name="paket_id" id="paket_id" class="form-control" required>
                                        @foreach ($paket as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_paket }} - Rp
                                                {{ number_format($item->harga, 2) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="jumlah" class="form-label">Jumlah</label>
                                    <input type="number" name="jumlah" class="form-control" min="1" required>
                                </div>

                                <div class="mb-3">
                                    <label for="user_id" class="form-label">User</label>
                                    <select name="user_id" id="user_id" class="form-control" required>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Buat Pesanan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
