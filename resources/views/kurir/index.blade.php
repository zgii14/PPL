@extends("layouts.app")

@section("content")
    <section class="section">
        <div class="section-header">
            <h1>Daftar Pesanan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">Dashboard</div>
                <div class="breadcrumb-item">Pesanan Kurir</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tabel Pesanan</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table-striped table-bordered table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Paket Laundry</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pesanan as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->paket->nama_paket }}</td>
                                                <td>{{ $item->status_text }}</td>
                                                <td>
                                                    @if ($item->status == 1)
                                                        <!-- Status 'jemput' -->
                                                        <form action="{{ route("kurir.pesanan.updateStatus", $item->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method("PATCH")
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm">Antar</button>
                                                        </form>
                                                    @elseif($item->status == 5)
                                                        <!-- Status 'diantar' -->
                                                        <form
                                                            action="{{ route("kurir.pesanan.storeBuktiTransaksi", $item->id) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="file" name="bukti_transaksi" required>
                                                            <button type="submit" class="btn btn-primary btn-sm">Tambah
                                                                Bukti</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer">
                            {{ $pesanan->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
