@extends("layouts.app")

@section("content")
    <section class="section">
        <div class="section-header">
            <h1>Daftar Pesanan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">Dashboard</div>
                <div class="breadcrumb-item">Pesanan</div>
            </div>
        </div>

        <!-- Button Add New Order -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <h4 class="mb-0">Pesanan</h4>
                        <a href="{{ route("pesanan.create") }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Pesanan Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- Tabel Header -->
                        <div class="card-header justify-content-between">
                            <h4>Tabel Pesanan</h4>
                            <div class="card-header-form">
                                <!-- Form Pencarian -->
                                <form method="GET" action="{{ route("pesanan.index") }}">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Cari Nama Pengguna" value="{{ request("search") }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary">
                                                <i class="fas fa-search"></i> Cari
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Tabel Body -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table-striped table-bordered table-hover mb-0 table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Paket Laundry</th>
                                            <th class="text-center">Pengguna</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-center">Total Harga</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Pembayaran</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pesanan as $item)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $loop->iteration + ($pesanan->currentPage() - 1) * $pesanan->perPage() }}
                                                </td>
                                                <td class="text-center">{{ $item->paket->nama_paket }}</td>
                                                <td class="text-center">{{ $item->user->name }}</td>
                                                <td class="text-center">{{ $item->jumlah }}</td>
                                                <td class="text-center">Rp
                                                    {{ number_format($item->total_harga, 2, ",", ".") }}</td>
                                                <td class="text-center">
                                                    <form action="{{ route("pesanan.update-status", $item->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method("PATCH")
                                                        <select name="status" class="form-control form-control-lg"
                                                            style="width: 100%; max-width: 200px;"
                                                            onchange="this.form.submit()">
                                                            <option value="1"
                                                                {{ $item->status == 1 ? "selected" : "" }}
                                                                class="status-dijemput">Dijemput</option>
                                                            <option value="2"
                                                                {{ $item->status == 2 ? "selected" : "" }}>Cuci</option>
                                                            <option value="3"
                                                                {{ $item->status == 3 ? "selected" : "" }}>Kering</option>
                                                            <option value="4"
                                                                {{ $item->status == 4 ? "selected" : "" }}>Lipat</option>
                                                            <option value="5"
                                                                {{ $item->status == 5 ? "selected" : "" }}
                                                                class="status-diantar">Diantar</option>
                                                            <option value="6"
                                                                {{ $item->status == 6 ? "selected" : "" }}>Selesai</option>
                                                        </select>
                                                    </form>
                                                </td>

                                                <td class="text-center">
                                                    {{ $item->pembayaran ? ucfirst($item->pembayaran->status) : "Belum Dibayar" }}
                                                </td>

                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <a href="{{ route("pesanan.show", $item->id) }}"
                                                            class="btn btn-info btn-sm" title="Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </a>

                                                        @if (auth()->user()->role == "staff")
                                                            <a href="{{ route("pesanan.edit", $item->id) }}"
                                                                class="btn btn-warning btn-sm" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route("pesanan.destroy", $item->id) }}"
                                                                method="POST" class="delete-form d-inline">
                                                                @csrf
                                                                @method("DELETE")
                                                                <button type="submit" class="btn btn-danger btn-sm"
                                                                    title="Hapus">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endif

                                                        @if ($item->pembayaran ? $item->pembayaran->status != "berhasil" : false)
                                                            <a href="{{ route("pesanan.acc_payment", $item->id) }}"
                                                                class="btn btn-success btn-sm"
                                                                title="Konfirmasi Pembayaran">
                                                                <i class="fas fa-check"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="card-footer d-flex justify-content-center">
                            {{ $pesanan->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SweetAlert2 Script for Delete Confirmation -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
    <script>
        // SweetAlert for Delete confirmation
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Data yang dihapus tidak dapat dipulihkan!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
