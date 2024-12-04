@extends("layouts.app")

@section("content")
    <section class="section">
        <div class="section-header">
            <h1>Edit Pesanan</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Form Edit Pesanan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route("pesanan.update", $pesanan->id) }}" method="POST">
                        @csrf
                        @method("PUT")

                        <!-- Paket Laundry -->
                        <div class="mb-3">
                            <label for="paket_id" class="form-label">Paket Laundry</label>
                            <select name="paket_id" id="paket_id"
                                class="form-control @error("paket_id") is-invalid @enderror" required>
                                @foreach ($paket as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $item->id == $pesanan->paket_id ? "selected" : "" }}>
                                        {{ $item->nama_paket }} - Rp {{ number_format($item->harga, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            @error("paket_id")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Pelanggan -->
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Nama Pelanggan</label>
                            <select name="user_id" id="user_id"
                                class="form-control @error("user_id") is-invalid @enderror" required>
                                <option value="">Pilih Pelanggan</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $user->id == $pesanan->user_id ? "selected" : "" }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error("user_id")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jumlah -->
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control @error("jumlah") is-invalid @enderror"
                                value="{{ old("jumlah", $pesanan->jumlah) }}" min="1" required>
                            @error("jumlah")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Lokasi (Map) -->
                        <div class="mb-3">
                            <label for="location" class="form-label">Pilih Lokasi</label>
                            <div id="map" style="height: 300px; width: 100%;"></div>
                            <input type="hidden" id="latitude" name="latitude"
                                value="{{ old("latitude", $pesanan->latitude) }}">
                            <input type="hidden" id="longitude" name="longitude"
                                value="{{ old("longitude", $pesanan->longitude) }}">
                            <p><strong>Lokasi Terkini:</strong> <span id="location-info">Click on the map to get the
                                    location information</span></p>
                        </div>

                        <!-- Keterangan (Diantar / Diambil) -->
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <select name="keterangan" id="keterangan"
                                class="form-control @error("keterangan") is-invalid @enderror" required>
                                <option value="Diambil" {{ $pesanan->keterangan == "Diambil" ? "selected" : "" }}>Diambil
                                </option>
                                <option value="Diantar" {{ $pesanan->keterangan == "Diantar" ? "selected" : "" }}>Diantar
                                </option>
                                <option value="Diambil Sendiri"
                                    {{ $pesanan->keterangan == "Diambil Sendiri" ? "selected" : "" }}>Diambil Sendiri
                                </option>
                            </select>
                            @error("keterangan")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route("pesanan.index") }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const initialLat = parseFloat(document.getElementById('latitude').value) || -3.7889;
            const initialLng = parseFloat(document.getElementById('longitude').value) || 102.2655;

            const map = L.map('map').setView([initialLat, initialLng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            L.Control.geocoder().addTo(map);

            const destinationMarker = L.marker([initialLat, initialLng], {
                draggable: true
            }).addTo(map);

            function updateLocationInfo(lat, lng) {
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                    .then(response => response.json())
                    .then(data => {
                        const locationInfo = data?.display_name || 'Location information not available';
                        document.getElementById('location-info').textContent = locationInfo;
                    })
                    .catch(err => {
                        console.error('Error fetching location info:', err);
                        document.getElementById('location-info').textContent =
                            'Error fetching location information';
                    });
            }

            destinationMarker.on('dragend', function(e) {
                const {
                    lat,
                    lng
                } = destinationMarker.getLatLng();
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
                updateLocationInfo(lat, lng);
            });

            map.on('click', function(e) {
                const {
                    lat,
                    lng
                } = e.latlng;
                destinationMarker.setLatLng([lat, lng]);
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
                updateLocationInfo(lat, lng);
            });

            updateLocationInfo(initialLat, initialLng);
        });
    </script>
@endsection

@push("css")
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
@endpush
