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
                    <form action="{{ route("pesanan.store") }}" method="POST">
                        @csrf

                        <!-- Paket Laundry -->
                        <div class="mb-3">
                            <label for="paket_id" class="form-label">Pilih Paket Laundry</label>
                            <select name="paket_id" id="paket_id"
                                class="form-control @error("paket_id") is-invalid @enderror">
                                @foreach ($paket as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_paket }} - Rp
                                        {{ number_format($item->harga, 2) }} ({{ $item->waktu_formatted }})</option>
                                @endforeach
                            </select>
                            @error("paket_id")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tipe (Select or Create) -->
                        <div class="mb-3">
                            <label for="tipe" class="form-label">Tipe Pelanggan</label>
                            <select name="tipe" id="tipe" class="form-control @error("tipe") is-invalid @enderror"
                                onchange="toggleUserForm()">
                                <option value="select" {{ old("tipe") == "select" ? "selected" : "" }}>Pilih Pelanggan
                                </option>
                                <option value="create" {{ old("tipe") == "create" ? "selected" : "" }}>Buat Pelanggan Baru
                                </option>
                            </select>
                            @error("tipe")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Select Existing User -->
                        <div id="user_select" class="mb-3" style="display:none;">
                            <label for="user_id" class="form-label">Nama Pelanggan</label>
                            <select name="user_id" id="user_id"
                                class="form-control @error("user_id") is-invalid @enderror">
                                <option value="">Pilih Pelanggan</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old("user_id") == $user->id ? "selected" : "" }}>
                                        {{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error("user_id")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input New User -->
                        <div id="user_create" class="mb-3" style="display:none;">
                            <label for="new_user_name" class="form-label">Nama Pelanggan Baru</label>
                            <input type="text" name="new_user_name" id="new_user_name"
                                class="form-control @error("new_user_name") is-invalid @enderror"
                                placeholder="Masukkan Nama Pelanggan Baru" value="{{ old("new_user_name") }}">
                            @error("new_user_name")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Quantity -->
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control @error("jumlah") is-invalid @enderror"
                                min="1" placeholder="Masukkan jumlah" value="{{ old("jumlah") }}">
                            @error("jumlah")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Location (Latitude and Longitude) -->
                        <div class="mb-3">
                            <label for="location" class="form-label">Pilih Lokasi</label>
                            <div id="map" style="height: 300px; width: 100%;"></div>
                            <input type="hidden" id="latitude" name="latitude" value="{{ old("latitude") }}">
                            <input type="hidden" id="longitude" name="longitude" value="{{ old("longitude") }}">
                            <p><strong>Location Information:</strong> <span id="location-info">Click on the map to get the
                                    location information</span></p>
                            @error("latitude")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @error("longitude")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Buat Pesanan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

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

        // Initialize Leaflet map
        document.addEventListener("DOMContentLoaded", function() {
            const initialPosition = [-3.7889, 102.2655]; // Bengkulu position [latitude, longitude]

            const map = L.map('map').setView(initialPosition, 13);
            L.tileLayer(
                'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="https://www.esri.com">Esri</a>, Earthstar Geographics'
                }).addTo(map);

            const geocoder = L.Control.Geocoder.nominatim();
            const marker = L.marker(initialPosition, {
                draggable: true
            }).addTo(map);

            function updateLocationInfo(lat, lng) {
                // Reverse geocode using Nominatim
                fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.display_name) {
                            document.getElementById("location-info").textContent = data
                                .display_name; // Show full address
                        } else {
                            document.getElementById("location-info").textContent =
                                "Location information not available";
                        }
                    })
                    .catch(err => {
                        console.error("Error fetching location info:", err);
                        document.getElementById("location-info").textContent =
                            "Error fetching location information";
                    });
            }

            marker.on('dragend', function(e) {
                const {
                    lat,
                    lng
                } = marker.getLatLng();

                // Validate latitude and longitude before assigning
                if (lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
                    document.getElementById("latitude").value = lat;
                    document.getElementById("longitude").value = lng;
                    updateLocationInfo(lat, lng);
                } else {
                    alert("Invalid latitude or longitude values.");
                }
            });

            map.on('click', function(e) {
                const {
                    lat,
                    lng
                } = e.latlng;

                // Validate latitude and longitude before assigning
                if (lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
                    marker.setLatLng(e.latlng); // Move marker to clicked position
                    document.getElementById("latitude").value = lat;
                    document.getElementById("longitude").value = lng;
                    updateLocationInfo(lat, lng);
                } else {
                    alert("Invalid latitude or longitude values.");
                }
            });

            // Initialize hidden input fields with the initial marker position
            document.getElementById("latitude").value = initialPosition[0];
            document.getElementById("longitude").value = initialPosition[1];
            updateLocationInfo(initialPosition[0], initialPosition[1]);

            // Add Leaflet Control Geocoder for address search
            L.Control.geocoder({
                    defaultMarkGeocode: false
                })
                .on('markgeocode', function(e) {
                    const {
                        lat,
                        lng
                    } = e.geocode.center;
                    map.setView([lat, lng], 13); // Center the map on the found location
                    marker.setLatLng([lat, lng]); // Move the marker to the found location
                    document.getElementById("latitude").value = lat;
                    document.getElementById("longitude").value = lng;
                    updateLocationInfo(lat, lng);
                })
                .addTo(map);
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
