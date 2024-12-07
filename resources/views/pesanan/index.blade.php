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

        <!-- Form Laporan Bulanan -->
        @if (auth()->user()->role == "admin")
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">Laporan Bulanan</h4>
                        </div>
                        <div class="card-body">
                            @if (session("error"))
                                <div class="alert alert-danger">
                                    {{ session("error") }}
                                </div>
                            @endif

                            <form method="GET" action="{{ route("laporan.bulanan") }}">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="bulan">Pilih Bulan</label>
                                        <select name="bulan" id="bulan" class="form-control" required>
                                            <option value="1">Januari</option>
                                            <option value="2">Februari</option>
                                            <option value="3">Maret</option>
                                            <option value="4">April</option>
                                            <option value="5">Mei</option>
                                            <option value="6">Juni</option>
                                            <option value="7">Juli</option>
                                            <option value="8">Agustus</option>
                                            <option value="9">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">Desember</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="tahun">Pilih Tahun</label>
                                        <select name="tahun" id="tahun" class="form-control" required>
                                            @for ($i = now()->year; $i >= 2000; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Unduh Laporan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif

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
                            <div class="card-header-form">
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
                                            <th class="text-center">Keterangan</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Pembayaran</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pesanan as $item)
                                            @if (auth()->user()->role == "kurir" && $item->keterangan == "Diambil Sendiri")
                                                <!-- Jika role adalah kurir dan keterangan adalah 'Diambil Sendiri', lewati pesanan ini -->
                                                @continue
                                            @endif

                                            <tr>
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
                                                                <!-- Input jumlah -->
                                                                <input type="number" name="jumlah"
                                                                    value="{{ $item->jumlah ?? "" }}"
                                                                    class="form-control form-control-sm text-center"
                                                                    style="width: 70px;" placeholder="-" step="0.01"
                                                                    onblur="this.form.submit()" required />

                                                                <!-- Tampilkan 'kg' hanya jika jumlah tidak kosong -->
                                                                @if (!empty($item->jumlah))
                                                                    <span
                                                                        style="font-size: 14px; margin-left: 5px; font-weight: bold;">kg</span>
                                                                @endif

                                                                <!-- Hidden input untuk total harga -->
                                                                <input type="hidden" name="total_harga"
                                                                    id="total_harga_{{ $item->id }}"
                                                                    value="{{ $item->total_harga ?? $item->paket->harga * ($item->jumlah ?? 1) }}">
                                                            </div>
                                                        </form>
                                                    @else
                                                        <!-- Tampilkan jumlah dan 'kg' hanya jika jumlah ada -->
                                                        {{ $item->jumlah ?? "Tidak Diketahui" }}
                                                        @if (!empty($item->jumlah))
                                                            kg
                                                        @endif
                                                    @endif
                                                </td>

                                                <td class="text-center">Rp
                                                    {{ number_format($item->total_harga, 0, ",", ".") }}</td>
                                                <td class="text-center">{{ $item->keterangan ?? "Tidak Ada" }}</td>
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
                                                        <form action="{{ route("pesanan.update-status", $item->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method("PATCH")
                                                            <select name="status" class="form-control form-control-lg"
                                                                style="width: 100%; max-width: 200px;"
                                                                onchange="this.form.submit()">
                                                                <option value="1"
                                                                    {{ $item->status == 1 ? "selected" : "" }}
                                                                    class="status-dijemput">Proses</option>
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
                                                                    {{ $item->status == 5 ? "selected" : "" }}
                                                                    class="status-diantar">Diantar</option>
                                                                <option value="6"
                                                                    {{ $item->status == 6 ? "selected" : "" }}>Selesai
                                                                </option>
                                                            </select>
                                                        </form>
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

@endsection
