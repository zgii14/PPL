@extends("layouts.app")

@section("content")
    <section class="section">
        <div class="section-header">
            <h1>Daftar Paket Laundry</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">Dashboard</div>
                <div class="breadcrumb-item">Paket Laundry</div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route("paket-laundry.create") }}" class="btn btn-primary">Tambah Paket Baru</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tabel Paket Laundry</h4>
                            <div class="card-header-form">
                                <form method="GET" action="{{ route("paket-laundry.index") }}">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Cari Nama Paket" value="{{ request("search") }}">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary">Cari</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>

                        <div class="card-body p-3">
                            <div class="table-responsive">
                                <table class="table-striped table-bordered table">
                                    <thead>
                                        <tr>
                                            <th class="p-1 text-center">No</th> <!-- Serial number header -->
                                            <th class="p-1 text-center">Nama</th>
                                            <th class="p-1 text-center">Jenis</th>
                                            <th class="p-1 text-center">Harga</th>
                                            <th class="p-1 text-center">Aksi</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        @foreach ($paket as $item)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $loop->iteration + ($paket->currentPage() - 1) * $paket->perPage() }}
                                                </td> <!-- Serial number -->
                                                <td class="text-center">{{ $item->nama_paket }}</td>
                                                <td class="text-center">{{ $item->jenis }}</td>
                                                <td class="text-center">Rp {{ $item->harga }}</td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center">
                                                        <a href="{{ route("paket-laundry.show", $item->id) }}"
                                                            class="btn btn-info mx-1">Detail</a>
                                                        <a href="{{ route("paket-laundry.edit", $item->id) }}"
                                                            class="btn btn-warning mx-1">Edit</a>
                                                        <form action="{{ route("paket-laundry.destroy", $item->id) }}"
                                                            method="POST" class="delete-alertbox" style="display:inline;">
                                                            @csrf
                                                            @method("DELETE")
                                                            <button type="submit"
                                                                class="btn btn-danger mx-1">Hapus</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>

                            <div class="d-flex justify-content-center mt-3">
                                {{ $paket->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
