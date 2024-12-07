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

                        <!-- Tipe Pelanggan (This part will only show for Admins, not for regular users) -->
                        @if (auth()->user()->role !== "pelanggan")
                            <div class="mb-3">
                                <label for="tipe" class="form-label">Tipe Pelanggan</label>
                                <select name="tipe" id="tipe"
                                    class="form-control @error("tipe") is-invalid @enderror" onchange="toggleUserForm()">
                                    <option value="select" {{ old("tipe") == "select" ? "selected" : "" }}>Pilih Pelanggan
                                    </option>
                                    <option value="create" {{ old("tipe") == "create" ? "selected" : "" }}>Buat Pelanggan
                                        Baru</option>
                                </select>
                                @error("tipe")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        <!-- Select Existing User (Only visible if user is not a regular user) -->
                        @if (auth()->user()->role !== "pelanggan")
                            <div id="user_select" class="mb-3" style="display:none;">
                                <label for="user_id" class="form-label">Nama Pelanggan</label>
                                <select name="user_id" id="user_id"
                                    class="form-control @error("user_id") is-invalid @enderror">
                                    <option value="">Pilih Pelanggan</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old("user_id") == $user->id ? "selected" : "" }}>{{ $user->name }}
                                        </option>
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
                        @else
                            <!-- Automatically select the logged-in user if the role is 'pelanggan' -->
                            <div id="user_select" class="mb-3">
                                <label for="user_id" class="form-label">Nama Pelanggan</label>
                                <select name="user_id" id="user_id"
                                    class="form-control @error("user_id") is-invalid @enderror" disabled>
                                    <option value="{{ auth()->user()->id }}" selected>{{ auth()->user()->name }}</option>
                                </select>
                                @error("user_id")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Hidden user_id field for regular users -->
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                            <!-- Automatically set tipe for pelanggan -->
                            <input type="hidden" name="tipe" value="select">
                        @endif

                        <!-- Quantity -->
                        <!-- Quantity (Only for staff, not regular users) -->
                        @if (auth()->user()->role !== "pelanggan")
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" name="jumlah"
                                    class="form-control @error("jumlah") is-invalid @enderror" min="1" step="0.01"
                                    placeholder="Masukkan jumlah" value="{{ old("jumlah") }}">
                                @error("jumlah")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <select name="keterangan" id="keterangan" class="form-control" required>
                                <option value="">Pilih Keterangan</option>
                                <option value="Diantar" {{ old("keterangan") == "Diantar" ? "selected" : "" }}>Diantar (
                                    Pesanan akan dijemput dan diantar oleh kurir)
                                </option>
                                <option value="Diambil" {{ old("keterangan") == "Diambil" ? "selected" : "" }}>Diambil (
                                    Pesanan akan dijemput dan akan diambil sendiri)
                                <option value="Diambil Sendiri"
                                    {{ old("keterangan") == "Diambil Sendiri" ? "selected" : "" }}>Antar & Ambil sendiri (
                                    Pesanan akan diantar dan diambil sendiri )
                                </option>
                            </select>
                            @error("keterangan")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                </div>

                <!-- Location (Latitude and Longitude) -->
                <div class="mb-3">
                    <label for="location" class="form-label">Pilih Lokasi</label>
                    <div id="map" style="height: 400px; width: 100%;"></div>
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
        // Update total weight based on jumlah baju and celana
        function updateWeight() {
            var jumlahBaju = document.getElementById('jumlah_baju').value || 0;
            var jumlahCelana = document.getElementById('jumlah_celana').value || 0;

            // 0.3 kg per baju, 0.35 kg per celana
            var beratBaju = jumlahBaju * 0.3;
            var beratCelana = jumlahCelana * 0.35;

            var totalBerat = beratBaju + beratCelana;
            document.getElementById('total_berat').value = totalBerat.toFixed(2) + ' kg';
        }
        // Toggle function for showing the user selection or new user creation form
        function toggleUserForm() {
            var tipe = document.getElementById('tipe').value;
            var selectDiv = document.getElementById('user_select');
            var inputDiv = document.getElementById('user_create');

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
            const map = L.map('map').setView([-3.7889, 102.2655], 13); // Default position in Bengkulu
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Add geocoder control for searching places
            L.Control.geocoder().addTo(map);

            // Add draggable marker for customer location selection
            const destinationMarker = L.marker([-3.7889, 102.2655], {
                draggable: true
            }).addTo(map);

            // Function to update the location info
            function updateLocationInfo(lat, lng) {
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                    .then(response => response.json())
                    .then(data => {
                        const locationInfo = data && data.display_name ? data.display_name :
                            'Location information not available';
                        document.getElementById("location-info").textContent = locationInfo;
                    })
                    .catch(err => {
                        console.error("Error fetching location info:", err);
                        document.getElementById("location-info").textContent =
                            'Error fetching location information';
                    });
            }

            // Update hidden latitude and longitude fields when marker is dragged
            destinationMarker.on('dragend', function(e) {
                const {
                    lat,
                    lng
                } = destinationMarker.getLatLng();
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
                updateLocationInfo(lat, lng);
            });

            // Update location info when map is clicked
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

            // Automatically get the user's current location via Geolocation API
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;

                    // Set the map view to the user's location
                    map.setView([userLat, userLng], 13);

                    // Set the marker to the user's location
                    destinationMarker.setLatLng([userLat, userLng]);

                    // Update the latitude and longitude fields
                    document.getElementById('latitude').value = userLat;
                    document.getElementById('longitude').value = userLng;

                    // Update the location info
                    updateLocationInfo(userLat, userLng);
                }, function(error) {
                    alert("Unable to retrieve your location.");
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        });
    </script>
@endsection

@push("css")
    <!-- Include Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

    <!-- Include Leaflet Control Geocoder CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
@endpush
