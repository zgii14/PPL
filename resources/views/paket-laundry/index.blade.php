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

        <!-- Button Add New Package -->
        @if (auth()->user()->role !== "pelanggan")
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header justify-content-between">
                            <h4 class="mb-0">Paket Laundry</h4>
                            <a href="{{ route("paket-laundry.create") }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Paket Baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header justify-content-between">
                            <h4>Tabel Paket Laundry</h4>
                            <div class="card-header-form">
                                <form method="GET" action="{{ route("paket-laundry.index") }}">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Cari Nama Paket" value="{{ request("search") }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary">
                                                <i class="fas fa-search"></i> Cari
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table-striped table-bordered table-hover mb-0 table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nama</th>
                                            <th class="text-center">Jenis</th>
                                            <th class="text-center">Harga/Kg</th>
                                            <th class="text-center">Waktu</th>
                                            <th class="text-center">Deskripsi</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($paket as $item)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $loop->iteration + ($paket->currentPage() - 1) * $paket->perPage() }}
                                                </td>
                                                <td class="text-center">{{ $item->nama_paket }}</td>
                                                <td class="text-center">{{ $item->jenis }}</td>
                                                <td class="text-center">Rp {{ number_format($item->harga, 0, ",", ".") }}
                                                </td>
                                                <td class="text-center">{{ $item->waktu_formatted }}</td>
                                                <td class="text-center">
                                                    {{ Str::limit($item->deskripsi, 30, "...") }}
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <!-- Show button is always available -->
                                                        <a href="{{ route("paket-laundry.show", $item->id) }}"
                                                            class="btn btn-info btn-sm" title="Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </a>

                                                        <!-- Edit and Delete buttons are hidden for pelanggan -->
                                                        @if (auth()->user()->role !== "kurir" && auth()->user()->role !== "staf")
                                                            @if (auth()->user()->role == "admin")
                                                                <a href="{{ route("paket-laundry.edit", $item->id) }}"
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
                            {{ $paket->links() }}
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
