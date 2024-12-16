@extends("layouts.app")

@section("content")
    <section class="section">
        <div class="section-header">
            <h1>Tambah Pengguna</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Buat Pengguna Baru</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route("admin.users.store") }}" method="POST"
                                class="rounded bg-white p-4 shadow">
                                @csrf

                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old("name") }}" required>
                                    @error("name")
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        value="{{ old("email") }}" required>
                                    @error("email")
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Nomor HP</label>
                                    <input type="text" name="phone" id="phone" class="form-control"
                                        value="{{ old("phone") }}" placeholder="Contoh: 081234567890" required>
                                    @error("phone")
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                    @error("password")
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select name="role" id="role" class="form-control" required>
                                        <option value="{{ \App\Models\User::ROLE_ADMIN }}">Admin</option>
                                        <option value="{{ \App\Models\User::ROLE_STAFF }}">Staff</option>
                                        <option value="{{ \App\Models\User::ROLE_PELANGGAN }}">Pelanggan</option>
                                        <option value="{{ \App\Models\User::ROLE_KURIR }}">Kurir</option>
                                    </select>
                                    @error("role")
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    Tambah Pengguna
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
