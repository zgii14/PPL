@extends("layouts.app")

@section("content")
    <section class="section">
        <div class="section-header">
            <h1>Detail Pesanan</h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Pesanan</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label><strong>ID Pesanan:</strong></label>
                        <p>{{ $pesanan->id }}</p>
                    </div>

                    <div class="form-group">
                        <label><strong>Nama Paket:</strong></label>
                        <p>{{ $pesanan->paket->nama_paket }}</p>
                    </div>

                    <div class="form-group">
                        <label><strong>Jumlah:</strong></label>
                        <p>{{ $pesanan->jumlah }}</p>
                    </div>

                    <div class="form-group">
                        <label><strong>Total Harga:</strong></label>
                        <p>Rp {{ number_format($pesanan->total_harga, 2, ",", ".") }}</p>
                    </div>

                    <div class="form-group">
                        <label><strong>Tanggal Pemesanan:</strong></label>
                        <p>{{ $pesanan->created_at->format("d-m-Y H:i") }}</p>
                    </div>

                    <div class="form-group">
                        <label><strong>Durasi:</strong></label>
                        <p>{{ $pesanan->created_at->diffForHumans() }}</p>
                    </div>

                    <div class="form-group">
                        <label><strong>Waktu Selesai:</strong></label>
                        <p>{{ $pesanan->waktu_selesai }}</p>
                    </div>

                    @if ($pesanan->pembayaran)
                        <div>
                            <strong>Bukti Bayar:</strong>
                        </div>
                        <div>
                            <img src="{{ $pesanan->pembayaran->bukti_bayar }}" alt="Bukti Bayar" class="img-fluid"
                                style="max-width: 400px; max-height: 400px;">
                        </div>
                    @else
                        <p>No payment proof available</p>
                    @endif

                    <div class="form-group">
                        <label><strong>Status Pesanan:</strong></label>
                        <p>
                            @switch($pesanan->status)
                                @case(0)
                                    <span class="badge badge-warning">Penjemputan</span>
                                @break

                                @case(1)
                                    <span class="badge badge-info">Penjemputan</span>
                                @break

                                @case(2)
                                    <span class="badge badge-danger">Cuci</span>
                                @break

                                @case(3)
                                    <span class="badge badge-danger">Kering</span>
                                @break

                                @case(4)
                                    <span class="badge badge-danger">Lipat</span>
                                @break

                                @case(5)
                                    <span class="badge badge-info">Pengantaran</span>
                                @break

                                @case(6)
                                    <span class="badge badge-success">Selesai dan Dibayar</span>
                                @break

                                @default
                                    <span class="badge badge-light">Status Tidak Diketahui</span>
                            @endswitch
                        </p>
                    </div>

                    <!-- Lokasi -->
                    <div class="form-group" id="tampilkan-rute">
                        <label><strong>Lokasi:</strong></label>
                        <div id="map" style="height: 300px; width: 100%;"></div>
                        <p><strong>Informasi Lokasi:</strong> <span id="location-info">Memuat lokasi...</span></p>
                    </div>

                    <!-- Show 'Tampilkan Rute' button only if the user is Kurir -->
                    @if (auth()->user()->role == "kurir")
                        <!-- Button to Show Route -->
                        <div class="form-group">
                            <button id="showRouteButton" class="btn btn-primary">Tampilkan Rute</button>
                        </div>
                    @endif

                    <!-- Tombol Cetak Struk PDF hanya untuk staff -->
                    @if (auth()->user()->role == "staff")
                        <a href="{{ route("pesanan.cetak-pdf", $pesanan->id) }}" class="btn btn-primary" target="_blank">
                            Cetak Struk PDF
                        </a>
                    @endif

                    <a href="{{ route("pesanan.index") }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </section>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/lrm-translation-id.min.js"></script> <!-- Indonesian Translation -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Kurir's default position (for example purposes, you can modify this if needed)
            const kurirPosition = [-3.7603971992778313, 102.27822456249069];

            // User's location from the pesanan model
            const userPosition = [
                {{ $pesanan->latitude / 1000000 }},
                {{ $pesanan->longitude / 1000000 }}
            ];

            // User's name from the model
            const userName =
                "{{ $pesanan->user->name }}"; // Assuming you have a user object related to the pesanan

            const map = L.map('map').setView(kurirPosition, 13);
            L.tileLayer(
                'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

            // Add marker for kurir only if the logged-in user is Kurir
            @if (auth()->user()->role == "kurir")
                const kurirMarker = L.marker(kurirPosition).addTo(map).bindPopup(
                    "<strong>Laundry Lubis</strong><br>" +
                    "Laundry Lubis Center"
                );
            @endif

            // Add marker for user with the user's name
            const userMarker = L.marker(userPosition).addTo(map).bindPopup(
                "<strong>" + userName + "</strong><br>" +
                "Rumah " + userName
            );

            let routeControl;

            // Function to calculate and display the route
            function showRoute() {
                // If a route already exists, remove it
                if (routeControl) {
                    routeControl.remove();
                }

                // Add a route from kurir to user
                routeControl = L.Routing.control({
                    waypoints: [
                        L.latLng(kurirPosition),
                        L.latLng(userPosition)
                    ],
                    routeWhileDragging: true,
                }).addTo(map);
            }

            // Event listener for the button click (only visible for Kurir)
            const showRouteButton = document.getElementById("showRouteButton");
            if (showRouteButton) {
                showRouteButton.addEventListener("click", function() {
                    showRoute();
                });
            }

            // Update location information for user
            updateLocationInfo(userPosition[0], userPosition[1]);
        });

        // Function to fetch location details and display
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
                    document.getElementById("location-info").textContent = 'Error fetching location information';
                });
        }
    </script>
@endsection

@push("css")
    <!-- Include Leaflet CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <!-- Include Leaflet Control Geocoder CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <!-- Include Leaflet Routing Machine CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
@endpush
