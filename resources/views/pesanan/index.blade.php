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
                    <div class="card-header">
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
                        <div class="card-header">
                            <h4>Tabel Pesanan</h4>
                            <div class="card-header-form">
                                <!-- Form Pencarian -->
                                <form method="GET" action="{{ route("pesanan.index") }}">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Cari Nama Pengguna" value="{{ request("search") }}">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary">
                                                <i class="fas fa-search"></i> Cari
                                            </button>
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
                                            <th class="p-1 text-center">NO</th>
                                            <th class="p-1 text-center">PAKET LAUNDRY</th>
                                            <th class="p-1 text-center">PENGGUNA</th>
                                            <th class="p-1 text-center">JUMLAH</th>
                                            <th class="p-1 text-center">TOTAL HARGA</th>
                                            <th class="p-1 text-center">TANGGAL PEMESANAN</th>
                                            <th class="p-1 text-center">STATUS</th>
                                            <th class="p-1 text-center">AKSI</th>
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
                                                    {{ $item->created_at->format("d-m-Y H:i") }}
                                                </td>
                                                <td class="text-center">
                                                    <!-- Dropdown Status -->
                                                    <form action="{{ route("pesanan.update-status", $item->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method("PATCH")
                                                        <select name="status" class="form-control"
                                                            onchange="this.form.submit()">
                                                            <option value="1"
                                                                {{ $item->status == 1 ? "selected" : "" }}>Penjemputan
                                                            </option>
                                                            <option value="2"
                                                                {{ $item->status == 2 ? "selected" : "" }}>Cuci</option>
                                                            <option value="3"
                                                                {{ $item->status == 3 ? "selected" : "" }}>Kering</option>
                                                            <option value="4"
                                                                {{ $item->status == 4 ? "selected" : "" }}>Lipat</option>
                                                            <option value="5"
                                                                {{ $item->status == 5 ? "selected" : "" }}>Pengantaran
                                                            </option>
                                                            <option value="6"
                                                                {{ $item->status == 6 ? "selected" : "" }}>Selesai
                                                            </option>
                                                        </select>
                                                    </form>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route("pesanan.show", $item->id) }}"
                                                        class="btn btn-info btn-sm mx-1">
                                                        <i class="fas fa-eye"></i> Detail
                                                    </a>
                                                    <a href="{{ route("pesanan.edit", $item->id) }}"
                                                        class="btn btn-warning btn-sm mx-1">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form action="{{ route("pesanan.destroy", $item->id) }}" method="POST"
                                                        class="delete-form d-inline">
                                                        @csrf
                                                        @method("DELETE")
                                                        <button type="submit" class="btn btn-danger btn-sm mx-1">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-3">
                                {{ $pesanan->links() }}
                            </div>
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
