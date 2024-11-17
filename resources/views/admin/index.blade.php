@extends("layouts.app")

@section("content")
    <section class="section">
        <div class="section-header">
            <h1>Daftar Pengguna</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route("admin.users.create") }}" class="btn btn-primary">Tambah Pengguna</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tabel Pengguna</h4>
                            <div class="card-header-form">
                                <div class="input-group-btn">
                                    {{-- Optional export or filter buttons can go here --}}
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <form method="GET" action="{{ route("admin.users.index") }}" class="mb-4">
                                <div class="row d-flex justify-content-end">
                                    <div class="col-md-3">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Cari nama atau email" value="{{ request("search") }}">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="role" class="form-control">
                                            <option value="">Pilih Role</option>
                                            <option value="{{ \App\Models\User::ROLE_ADMIN }}"
                                                {{ request("role") == \App\Models\User::ROLE_ADMIN ? "selected" : "" }}>
                                                Admin
                                            </option>
                                            <option value="{{ \App\Models\User::ROLE_STAFF }}"
                                                {{ request("role") == \App\Models\User::ROLE_STAFF ? "selected" : "" }}>
                                                User
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="{{ route("admin.users.index") }}" class="btn btn-secondary">Reset</a>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table-striped table-bordered table">
                                    <thead>
                                        <tr>
                                            <th class="p-1 text-center">ID</th>
                                            <th class="p-1 text-center">Nama</th>
                                            <th class="p-1 text-center">Email</th>
                                            <th class="p-1 text-center">Role</th>
                                            <th class="p-1 text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td class="text-center">{{ $user->id }}</td>
                                                <td class="text-center">{{ $user->name }}</td>
                                                <td class="text-center">{{ $user->email }}</td>

                                                <td class="text-center">
                                                    <span
                                                        class="badge badge-success">{{ ucwords(strtolower($user->role)) }}</span>
                                                </td>

                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center">
                                                        <a href="{{ route("admin.users.show", $user->id) }}"
                                                            class="btn btn-info mx-1">Lihat</a>
                                                        <a href="{{ route("admin.users.edit", $user->id) }}"
                                                            class="btn btn-warning mx-1">Update</a>
                                                        <form action="{{ route("admin.users.destroy", $user->id) }}"
                                                            method="POST" class="delete-alertbox">
                                                            @csrf
                                                            @method("DELETE")
                                                            <input type="submit" class="btn btn-danger mx-1"
                                                                value="Hapus" />
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
