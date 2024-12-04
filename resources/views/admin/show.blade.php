@extends("layouts.app")

@section("content")
    <section class="section">
        <div class="section-header">
            <h1>Detail Pengguna</h1>
            <div class="section-header-breadcrumb">
                {{-- <div class="breadcrumb-item"><a href="{{ route("admin.dashboard") }}">Dashboard</a></div> --}}
                <div class="breadcrumb-item"><a href="{{ route("admin.users.index") }}">Pengguna</a></div>
                <div class="breadcrumb-item active">{{ $user->name }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $user->name }}</h4>
                        </div>
                        <div class="card-body">
                            <p><strong>Nama:</strong> {{ $user->name }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Role:</strong>
                                @if ($user->role === "admin")
                                    <span class="badge badge-danger">{{ ucwords(strtolower($user->role)) }}</span>
                                @elseif ($user->role === "staff")
                                    <span class="badge badge-primary">{{ ucwords(strtolower($user->role)) }}</span>
                                @elseif ($user->role === "kurir")
                                    <span class="badge badge-warning">{{ ucwords(strtolower($user->role)) }}</span>
                                @else
                                    <span class="badge badge-success">{{ ucwords(strtolower($user->role)) }}</span>
                                @endif
                            </p>

                            <a href="{{ route("admin.users.index") }}" class="btn btn-secondary mt-4">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Orders Section -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Pesanan Pengguna</h4>
                        </div>
                        <div class="card-body">
                            <p>Data Pesanan Pengguna</p>
                            {{-- Orders table --}}
                            <div class="table-responsive">
                                <table class="table-striped table">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Paket</th>
                                            <th>Status</th>
                                            <th>Total Harga</th>
                                            <th>Waktu Selesai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user->pesanan as $pesanan)
                                            <tr>
                                                <td>{{ $pesanan->id }}</td>
                                                <td>{{ $pesanan->paket->nama_paket }}</td>
                                                <td>{{ $pesanan->status_label }}</td>
                                                <td>{{ number_format($pesanan->total_harga, 0, ",", ".") }}</td>
                                                <td>{{ $pesanan->waktu_selesai }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
