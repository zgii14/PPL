@extends("layouts.app")

@section("content")
    <section class="section">
        <div class="section-header">
            <h1>Edit Pengguna</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Informasi Pengguna</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route("admin.users.update", $user->id) }}" method="POST"
                                class="rounded bg-white p-4 shadow">
                                @csrf
                                @method("PUT")

                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old("name", $user->name) }}" required>
                                    @error("name")
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        value="{{ old("email", $user->email) }}" required>
                                    @error("email")
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password (Opsional)</label>
                                    <input type="password" name="password" id="password" class="form-control">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                                    @error("password")
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select name="role" id="role" class="form-control" required>
                                        <option value="{{ \App\Models\User::ROLE_ADMIN }}"
                                            {{ $user->role === \App\Models\User::ROLE_ADMIN ? "selected" : "" }}>
                                            {{ ucfirst(strtolower(\App\Models\User::ROLE_ADMIN)) }}
                                        </option>
                                        <option value="{{ \App\Models\User::ROLE_STAFF }}"
                                            {{ $user->role === \App\Models\User::ROLE_STAFF ? "selected" : "" }}>
                                            {{ ucfirst(strtolower(\App\Models\User::ROLE_STAFF)) }}
                                        </option>
                                        <option value="{{ \App\Models\User::ROLE_PELANGGAN }}"
                                            {{ $user->role === \App\Models\User::ROLE_PELANGGAN ? "selected" : "" }}>
                                            {{ ucfirst(strtolower(\App\Models\User::ROLE_PELANGGAN)) }}
                                        </option>
                                        <option value="{{ \App\Models\User::ROLE_KURIR }}"
                                            {{ $user->role === \App\Models\User::ROLE_KURIR ? "selected" : "" }}>
                                            {{ ucfirst(strtolower(\App\Models\User::ROLE_KURIR)) }}
                                        </option>
                                    </select>
                                    @error("role")
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    Update Pengguna
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
