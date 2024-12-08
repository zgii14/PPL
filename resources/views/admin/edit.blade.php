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

                                <!-- Nama -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error("name") is-invalid @enderror"
                                        value="{{ old("name", $user->name) }}" required>
                                    @error("name")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error("email") is-invalid @enderror"
                                        value="{{ old("email", $user->email) }}" required>
                                    @error("email")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Nomor HP -->
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Nomor HP</label>
                                    <input type="text" name="phone" id="phone"
                                        class="form-control @error("phone") is-invalid @enderror"
                                        value="{{ old("phone", $user->phone) }}" required
                                        placeholder="Contoh: 081234567890">
                                    @error("phone")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password (Opsional)</label>
                                    <input type="password" name="password" id="password"
                                        class="form-control @error("password") is-invalid @enderror"
                                        placeholder="Kosongkan jika tidak ingin mengubah password">
                                    @error("password")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah
                                        password.</small>
                                </div>

                                <!-- Role -->
                                @if (Auth::user()->role === \App\Models\User::ROLE_ADMIN)
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Role</label>
                                        <select name="role" id="role"
                                            class="form-control @error("role") is-invalid @enderror" required>
                                            <option value="{{ \App\Models\User::ROLE_ADMIN }}"
                                                {{ old("role", $user->role) === \App\Models\User::ROLE_ADMIN ? "selected" : "" }}>
                                                Admin
                                            </option>
                                            <option value="{{ \App\Models\User::ROLE_STAFF }}"
                                                {{ old("role", $user->role) === \App\Models\User::ROLE_STAFF ? "selected" : "" }}>
                                                Staff
                                            </option>
                                            <option value="{{ \App\Models\User::ROLE_PELANGGAN }}"
                                                {{ old("role", $user->role) === \App\Models\User::ROLE_PELANGGAN ? "selected" : "" }}>
                                                Pelanggan
                                            </option>
                                            <option value="{{ \App\Models\User::ROLE_KURIR }}"
                                                {{ old("role", $user->role) === \App\Models\User::ROLE_KURIR ? "selected" : "" }}>
                                                Kurir
                                            </option>
                                        </select>
                                        @error("role")
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif
                                @if (Auth::user()->role !== \App\Models\User::ROLE_ADMIN)
                                    <input type="hidden" name="role" value="{{ $user->role }}">
                                @endif

                                <!-- Submit -->
                                <button type="submit" class="btn btn-primary">
                                    Update Pengguna
                                </button>
                                <a href="{{ route("pesanan.index") }}" class="btn btn-secondary">Kembali</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
