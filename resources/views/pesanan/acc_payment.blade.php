@extends("layouts.app")

@section("content")
    <section class="section">
        <div class="section-header">
            <h1>Konfirmasi Pembayaran Pesanan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">Dashboard</div>
                <div class="breadcrumb-item">Pesanan</div>
                <div class="breadcrumb-item">Konfirmasi Pembayaran</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Konfirmasi Pembayaran</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('pesanan.process_payment', $pesanan->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="metode_pembayaran">Metode Pembayaran</label>
                                    <select name="metode_pembayaran" id="metode_pembayaran" class="form-control" required>
                                        <option value="transfer">Transfer</option>
                                        <option value="cash">Cash</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="bukti_bayar">Bukti Pembayaran</label>
                                    <input type="file" name="bukti_bayar" id="bukti_bayar" class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Konfirmasi Pembayaran</button>
                                <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
