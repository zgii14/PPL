@extends("layouts.app")

@section("content")
    <section class="section">
        <div class="section-header">
            <h1>Detail Pengguna</h1>
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
                            <p><strong>Saldo:</strong> Rp{{ number_format($user->saldo, 2) }}</p>
                            <p><strong>Role:</strong>
                                @if ($user->role === \App\Models\User::ROLE_ADMIN)
                                    <span class="badge badge-success">Admin</span>
                                @else
                                    <span class="badge badge-primary">User</span>
                                @endif
                            </p>

                            <a href="{{ route("admin.users.index") }}" class="btn btn-secondary mt-4">
                                Kembali ke Daftar Pengguna
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Activity Section -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Aktivitas Pengguna</h4>
                        </div>
                        <div class="card-body">
                            <p>Data Transaksi Pengguna</p>
                            {{-- Example table of user activities --}}
                            <div class="table-responsive">
                                <table class="table-striped table">
                                    <thead>
                                        <tr>
                                            <th>Aktivitas</th>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Dummy content --}}
                                        <tr>
                                            <td>Pembelian Tiket</td>
                                            <td>2024-11-17</td>
                                            <td>Tiket Konser Rp100.000</td>
                                        </tr>
                                        <tr>
                                            <td>Top-up Saldo</td>
                                            <td>2024-11-15</td>
                                            <td>Rp500.000</td>
                                        </tr>
                                        {{-- Add dynamic content here if necessary --}}
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
