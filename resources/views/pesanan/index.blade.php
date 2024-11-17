@extends("layouts.app")

@section("content")
    <section class="section">
        <div class="section-header">
            <h1>Daftar Pesanan</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route("pesanan.create") }}" class="btn btn-primary">Tambah Pesanan Baru</a>
                        </div>
                        <div class="card-body">
                            <table class="table-striped table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Paket</th>
                                        <th>User</th>
                                        <th>Jumlah</th>
                                        <th>Total Harga</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pesanan as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->paket->nama_paket }}</td>
                                            <td>{{ $item->user->name }}</td>
                                            <td>{{ $item->jumlah }}</td>
                                            <td>Rp {{ number_format($item->total_harga, 2) }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>
                                                <a href="{{ route("pesanan.show", $item->id) }}"
                                                    class="btn btn-info">Detail</a>
                                                <form action="{{ route("pesanan.destroy", $item->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method("DELETE")
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {{ $pesanan->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
