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
                        @if (auth()->user()->role !== "kurir" && auth()->user()->role !== "admin")
                            <a href="{{ route("pesanan.create") }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Pesanan Baru
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header justify-content-between">
                            <h4>Tabel Pesanan</h4>
                            <div class="card-header-form d-flex align-items-center">
                                @if (auth()->user()->role == "staff")
                                    <!-- Button to Toggle Visibility -->
                                    <button id="toggleSelesai" class="btn btn-warning btn-sm ml-2">
                                        <i class="fas fa-eye-slash"></i>
                                    </button>
                                @endif

                                <form method="GET" action="{{ route("pesanan.index") }}" class="ml-3">
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
                                    <tbody id="pesananTableBody">
                                        @foreach ($pesanan as $item)
                                            @if (auth()->user()->role == "kurir" && $item->keterangan == "Diambil Sendiri")
                                                @continue
                                            @elseif (auth()->user()->role == "admin" && $item->keterangan == "Diambil Sendiri")
                                            @endif

                                            <tr
                                                class="pesanan-row {{ $item->status == 6 ? "pesanan-selesai" : "" }} {{ $item->pembayaran && $item->pembayaran->status == "berhasil" ? "pembayaran-berhasil" : "" }}">
                                                <td class="text-center">
                                                    {{ $loop->iteration + ($pesanan->currentPage() - 1) * $pesanan->perPage() }}
                                                </td>
                                                <td class="text-center">{{ $item->paket->nama_paket }}</td>
                                                <td class="text-center">{{ $item->user->name }}</td>
                                                <td class="text-center">
                                                    @if (auth()->user()->role === "staff")
                                                        <form action="{{ route("pesanan.update-jumlah", $item->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method("PATCH")
                                                            <div class="d-flex justify-content-center align-items-center">
                                                                <input type="number" name="jumlah"
                                                                    value="{{ $item->jumlah ?? "" }}"
                                                                    class="form-control form-control-sm text-center"
                                                                    style="width: 70px;" placeholder="-" step="0.01"
                                                                    onblur="this.form.submit()" required />

                                                                @if (!empty($item->jumlah))
                                                                    <span
                                                                        style="font-size: 14px; margin-left: 5px; font-weight: bold;">kg</span>
                                                                @endif

                                                                <input type="hidden" name="total_harga"
                                                                    id="total_harga_{{ $item->id }}"
                                                                    value="{{ $item->total_harga ?? $item->paket->harga * ($item->jumlah ?? 1) }}">
                                                            </div>
                                                        </form>
                                                    @else
                                                        {{ $item->jumlah ?? "Tidak Diketahui" }}
                                                        @if (!empty($item->jumlah))
                                                            kg
                                                        @endif
                                                    @endif
                                                </td>

                                                <td class="text-center">Rp
                                                    {{ number_format($item->total_harga, 0, ",", ".") }}</td>
                                                <td class="text-center">
                                                    @if (auth()->user()->role === "pelanggan")
                                                        @switch($item->status)
                                                            @case(1)
                                                                <span class="badge badge-info">Proses</span>
                                                            @break

                                                            @case(2)
                                                                <span class="badge badge-primary">Dijemput</span>
                                                            @break

                                                            @case(3)
                                                                <span class="badge badge-warning">Cuci</span>
                                                            @break

                                                            @case(4)
                                                                <span class="badge badge-secondary">Lipat</span>
                                                            @break

                                                            @case(5)
                                                                <span class="badge badge-success">Diantar</span>
                                                            @break

                                                            @case(6)
                                                                <span class="badge badge-success">Selesai</span>
                                                            @break

                                                            @default
                                                                <span class="badge badge-light">Status Tidak Diketahui</span>
                                                        @endswitch
                                                    @else
                                                        <!-- Hanya tampilkan dropdown status jika bukan admin -->
                                                        @if (auth()->user()->role !== "admin")
                                                            <form action="{{ route("pesanan.update-status", $item->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method("PATCH")
                                                                <select name="status" class="form-control form-control-lg"
                                                                    style="width: 100%; max-width: 200px;"
                                                                    onchange="this.form.submit()">
                                                                    <option value="1"
                                                                        {{ $item->status == 1 ? "selected" : "" }}>Proses
                                                                    </option>
                                                                    <option value="2"
                                                                        {{ $item->status == 2 ? "selected" : "" }}>Dijemput
                                                                    </option>
                                                                    <option value="3"
                                                                        {{ $item->status == 3 ? "selected" : "" }}>Cuci
                                                                    </option>
                                                                    <option value="4"
                                                                        {{ $item->status == 4 ? "selected" : "" }}>Lipat
                                                                    </option>
                                                                    <option value="5"
                                                                        {{ $item->status == 5 ? "selected" : "" }}>Diantar
                                                                    </option>
                                                                    <option value="6"
                                                                        {{ $item->status == 6 ? "selected" : "" }}>Selesai
                                                                    </option>
                                                                </select>
                                                            </form>
                                                        @else
                                                            <!-- Jika admin, tampilkan status saja tanpa dropdown -->
                                                            <span class="badge badge-success">Selesai</span>
                                                        @endif
                                                    @endif
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

                                                        @if (auth()->user()->role == "kurir")
                                                            <a href="{{ route("pesanan.show", $item->id) }}#tampilkan-rute"
                                                                class="btn btn-primary btn-sm" title="Tampilkan Rute">
                                                                <i class="fas fa-route"></i>
                                                            </a>
                                                        @endif

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
    <script>
        function updateTotalPrice(input, hargaPaket) {
            var jumlah = parseFloat(input.value) || 0;
            var totalHarga = hargaPaket * jumlah;

            // Update hidden field untuk total harga
            var totalHargaField = document.getElementById('total_harga_' + input.name);
            totalHargaField.value = totalHarga;

            // Update tampilan harga di form
            var displayPrice = document.getElementById('display_price_' + input.name);
            displayPrice.textContent = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(totalHarga);
        }
    </script>
    <script>
        // Toggle visibility of completed orders and successful payments
        document.getElementById('toggleSelesai').addEventListener('click', function() {
            // Seleksi semua baris dengan kelas 'pesanan-selesai' dan pembayaran 'berhasil'
            const rows = document.querySelectorAll('.pesanan-selesai.pembayaran-berhasil');

            // Loop untuk toggle visibilitas
            rows.forEach(row => {
                row.classList.toggle('d-none'); // Menyembunyikan atau menampilkan baris
            });

            // Ganti ikon berdasarkan status tombol
            const button = document.getElementById('toggleSelesai');
            const isHidden = button.innerHTML.includes(
                'fa-eye-slash'); // Cek apakah tombol menunjukkan ikon 'mata tertutup'

            if (isHidden) {
                button.innerHTML = '<i class="fas fa-eye"></i>'; // Ganti dengan ikon mata terbuka
            } else {
                button.innerHTML = '<i class="fas fa-eye-slash"></i>'; // Ganti dengan ikon mata tertutup
            }
        });
    </script>
@endsection
