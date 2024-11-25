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
                        <p>Rp {{ number_format($pesanan->total_harga, 2) }}</p>
                    </div>

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

                    <!-- Map for Viewing Location -->
                    <div class="form-group">
                        <label><strong>Lokasi:</strong></label>
                        <div id="map" style="height: 300px; width: 100%;"></div>
                        <p><strong>Informasi Lokasi:</strong> <span id="location-info">Memuat lokasi...</span></p>
                    </div>

                    <a href="{{ route("pesanan.cetak-pdf", $pesanan->id) }}" class="btn btn-primary" target="_blank">
                        Cetak Struk PDF
                    </a>

                    <a href="{{ route("pesanan.index") }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </section>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Latitude and Longitude from the pesanan object
            const position = [
                {{ $pesanan->latitude / 1000000 }},
                {{ $pesanan->longitude / 1000000 }}
            ];

            // Initialize map
            const map = L.map('map').setView(position, 13);
            L.tileLayer(
                'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="https://www.esri.com">Esri</a>, Earthstar Geographics'
                }).addTo(map);

            // Add marker
            const marker = L.marker(position).addTo(map);

            // Initialize geocoder
            const geocoder = L.Control.Geocoder.nominatim();

            // Update location information using reverse geocoding
            function updateLocationInfo(lat, lng) {
                geocoder.reverse({
                    lat,
                    lng
                }, map.options.crs.scale(map.getZoom()), function(results) {
                    if (results && results.length > 0) {
                        document.getElementById("location-info").textContent = results[0].name;
                    } else {
                        document.getElementById("location-info").textContent =
                            "Informasi lokasi tidak tersedia.";
                    }
                });
            }

            // Update location information based on marker's position
            updateLocationInfo(position[0], position[1]);
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
