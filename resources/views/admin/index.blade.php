@extends("layouts.app")

@section("content")
    <section class="section">
        <div class="section-header">
            <h1>Daftar Pengguna</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">Dashboard</div>
                <div class="breadcrumb-item active">Pengguna</div>
            </div>
        </div>

        <!-- Add New User Button -->
        @if (auth()->user()->role === "admin")
            <div class="row mb-3">
                <div class="col-12 text-right">
                    <a href="{{ route("admin.users.create") }}" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Tambah Pengguna
                    </a>

                </div>
            </div>
        @endif

        <!-- Filter and Search Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Filter Pengguna</h4>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route("admin.users.index") }}">
                            <div class="row align-items-center">
                                <div class="col-md-4 mb-md-0 mb-3">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Cari nama atau email" value="{{ request("search") }}">
                                </div>
                                <div class="col-md-3 mb-md-0 mb-3">
                                    <select name="role" class="form-control">
                                        <option value="">Pilih Role</option>
                                        <option value="{{ \App\Models\User::ROLE_ADMIN }}"
                                            {{ request("role") == \App\Models\User::ROLE_ADMIN ? "selected" : "" }}>
                                            Admin
                                        </option>
                                        <option value="{{ \App\Models\User::ROLE_STAFF }}"
                                            {{ request("role") == \App\Models\User::ROLE_STAFF ? "selected" : "" }}>
                                            Staff
                                        </option>
                                        <option value="{{ \App\Models\User::ROLE_KURIR }}"
                                            {{ request("role") == \App\Models\User::ROLE_KURIR ? "selected" : "" }}>
                                            Kurir
                                        </option>
                                        <option value="{{ \App\Models\User::ROLE_PELANGGAN }}"
                                            {{ request("role") == \App\Models\User::ROLE_PELANGGAN ? "selected" : "" }}>
                                            Pelanggan
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Filter
                                    </button>
                                    <a href="{{ route("admin.users.index") }}" class="btn btn-secondary">
                                        <i class="fas fa-redo"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tabel Pengguna</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table-striped table-hover table-bordered mb-0 table">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Role</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        @if (auth()->user()->role !== "pelanggan" || auth()->user()->id === $user->id)
                                            <tr>
                                                <td class="text-center">{{ $user->id }}</td>
                                                <td class="text-center">{{ $user->name }}</td>
                                                <td class="text-center">{{ $user->email }}</td>
                                                <td class="text-center">
                                                    @if ($user->role === "admin")
                                                        <span class="badge badge-danger">
                                                            {{ ucwords(strtolower($user->role)) }}
                                                        </span>
                                                    @elseif($user->role === "staff")
                                                        <span class="badge badge-primary">
                                                            {{ ucwords(strtolower($user->role)) }}
                                                        </span>
                                                    @elseif($user->role === "kurir")
                                                        <span class="badge badge-warning">
                                                            {{ ucwords(strtolower($user->role)) }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-success">
                                                            {{ ucwords(strtolower($user->role)) }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <a href="{{ route("admin.users.show", $user->id) }}"
                                                            class="btn btn-info btn-sm" title="Lihat">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        @if (auth()->user()->role === "admin" ||
                                                                (auth()->user()->role === "staff" && !in_array($user->role, ["admin"])) ||
                                                                auth()->user()->id === $user->id)
                                                            <a href="{{ route("admin.users.edit", $user->id) }}"
                                                                class="btn btn-warning btn-sm" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            @if (auth()->user()->role !== "pelanggan")
                                                                <form
                                                                    action="{{ route("admin.users.destroy", $user->id) }}"
                                                                    method="POST" class="d-inline delete-form">
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
                                        @endif
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer d-flex justify-content-center">
                        {{ $users->links() }}
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
