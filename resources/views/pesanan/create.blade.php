@extends("layouts.app")

@section("content")
    <section class="section">
        <div class="section-header">
            <h1>Buat Pesanan Baru</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Form Pesanan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('pesanan.store') }}" method="POST">
                        @csrf

                        <!-- Paket Laundry -->
                        <div class="mb-3">
                            <label for="paket_id" class="form-label">Pilih Paket Laundry</label>
                            <select name="paket_id" id="paket_id" class="form-control @error('paket_id') is-invalid @enderror">
                                @foreach ($paket as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_paket }} - Rp {{ number_format($item->harga, 2) }}</option>
                                @endforeach
                            </select>
                            @error('paket_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Tipe (Select or Create) -->
                        <div class="mb-3">
                            <label for="tipe" class="form-label">Tipe Pelanggan</label>
                            <select name="tipe" id="tipe" class="form-control @error('tipe') is-invalid @enderror" onchange="toggleUserForm()">
                                <option value="select" {{ old('tipe') == 'select' ? 'selected' : '' }}>Pilih Pelanggan</option>
                                <option value="create" {{ old('tipe') == 'create' ? 'selected' : '' }}>Buat Pelanggan Baru</option>
                            </select>
                            @error('tipe') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Select Existing User -->
                        <div id="user_select" class="mb-3" style="display:none;">
                            <label for="user_id" class="form-label">Nama Pelanggan</label>
                            <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror">
                                <option value="">Pilih Pelanggan</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Input New User -->
                        <div id="user_create" class="mb-3" style="display:none;">
                            <label for="new_user_name" class="form-label">Nama Pelanggan Baru</label>
                            <input type="text" name="new_user_name" id="new_user_name" class="form-control @error('new_user_name') is-invalid @enderror" placeholder="Masukkan Nama Pelanggan Baru" value="{{ old('new_user_name') }}">
                            @error('new_user_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Quantity -->
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" min="1" placeholder="Masukkan jumlah" value="{{ old('jumlah') }}">
                            @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Buat Pesanan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Toggle function for showing the user selection or new user creation form
        function toggleUserForm() {
            var tipe = document.getElementById('tipe').value;
            var selectDiv = document.getElementById('user_select');
            var inputDiv = document.getElementById('user_create');

            // Toggle visibility based on selected 'tipe'
            if (tipe === 'select') {
                selectDiv.style.display = 'block';
                inputDiv.style.display = 'none';
            } else {
                selectDiv.style.display = 'none';
                inputDiv.style.display = 'block';
            }
        }

        // Initialize form state based on current selected 'tipe' value
        window.onload = function() {
            toggleUserForm();
        };
    </script>
@endsection
