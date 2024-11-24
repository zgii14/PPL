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

                        <!-- Input untuk memilih pelanggan (user_id) -->
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

                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control @error("jumlah") is-invalid @enderror"
                                value="{{ old("jumlah", $pesanan->jumlah) }}" min="1" required>
                            @error("jumlah")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Map Integration -->
                        <div class="mb-3">
                            <label for="location" class="form-label">Pilih Lokasi</label>
                            <div id="map" style="height: 300px; width: 100%;"></div>
                            <input type="hidden" id="latitude" name="latitude" value="{{ $pesanan->latitude }}">
                            <input type="hidden" id="longitude" name="longitude" value="{{ $pesanan->longitude }}">
                            <p><strong>Location Information:</strong> <span id="location-info"></span></p>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const initialPosition = [
        {{ $pesanan->latitude / 1000000 }},
        {{ $pesanan->longitude / 1000000 }}
    ];
            const map = L.map('map').setView(initialPosition, 13);

            L.tileLayer(
                'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="https://www.esri.com">Esri</a>, Earthstar Geographics'
                }).addTo(map);

            const marker = L.marker(initialPosition, { draggable: true }).addTo(map);

            marker.on('dragend', function(e) {
                const { lat, lng } = marker.getLatLng();
                document.getElementById("latitude").value = lat;
                document.getElementById("longitude").value = lng;
            });

            map.on('click', function(e) {
                const { lat, lng } = e.latlng;
                marker.setLatLng(e.latlng);
                document.getElementById("latitude").value = lat;
                document.getElementById("longitude").value = lng;
            });
        });
    </script>
@endsection

@push("css")
    <!-- Include Leaflet CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <!-- Include Leaflet Control Geocoder CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
@endpush
