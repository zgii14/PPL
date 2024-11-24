<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Select Location</title>

        <!-- Include Leaflet CSS and JS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

        <!-- Include Leaflet Control Geocoder CSS and JS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
        <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

        <style>
            #map {
                height: 400px;
                width: 100%;
            }
        </style>
    </head>

    <body>

        <h2>Select Your Location</h2>

        <form>
            @csrf
            <div id="map"></div>
            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">
            <button type="submit">Save Location</button>
        </form>

        <!-- Display location information -->
        <p><strong>Location Information:</strong> <span id="location-info">Click on the map to get the location
                information</span></p>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Set the initial position to Bengkulu province
                const initialPosition = [-3.7889, 102.2655]; // Bengkulu position [latitude, longitude]

                // Initialize Leaflet map
                const map = L.map('map').setView(initialPosition, 13);

                // Add ESRI World Imagery tiles for satellite/forest view
                L.tileLayer(
                    'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                        maxZoom: 19,
                        attribution: '&copy; <a href="https://www.esri.com">Esri</a>, Earthstar Geographics'
                    }).addTo(map);

                // Initialize the geocoder
                const geocoder = L.Control.Geocoder.nominatim();

                // Create a draggable marker at the initial position
                const marker = L.marker(initialPosition, {
                    draggable: true
                }).addTo(map);

                // Function to update location information using reverse geocoding
                function updateLocationInfo(lat, lng) {
                    geocoder.reverse({
                        lat,
                        lng
                    }, map.options.crs.scale(map.getZoom()), function(results) {
                        if (results && results.length > 0) {
                            document.getElementById("location-info").textContent = results[0].name;
                        } else {
                            document.getElementById("location-info").textContent =
                                "Location information not available";
                        }
                    });
                }

                // Update hidden input fields and location information with the marker's position when dragged
                marker.on('dragend', function(e) {
                    const {
                        lat,
                        lng
                    } = marker.getLatLng();
                    document.getElementById("latitude").value = lat;
                    document.getElementById("longitude").value = lng;
                    updateLocationInfo(lat, lng);
                });

                // Update marker position, hidden inputs, and location information when map is clicked
                map.on('click', function(e) {
                    const {
                        lat,
                        lng
                    } = e.latlng;
                    marker.setLatLng(e.latlng); // Move the marker to the clicked position
                    document.getElementById("latitude").value = lat;
                    document.getElementById("longitude").value = lng;
                    updateLocationInfo(lat, lng);
                });

                // Initialize hidden input fields with the initial marker position
                document.getElementById("latitude").value = initialPosition[0];
                document.getElementById("longitude").value = initialPosition[1];
                updateLocationInfo(initialPosition[0], initialPosition[1]);

                // Add Leaflet Control Geocoder for address search
                L.Control.geocoder({
                    defaultMarkGeocode: false
                }).on('markgeocode', function(e) {
                    const {
                        lat,
                        lng
                    } = e.geocode.center;
                    map.setView([lat, lng], 13); // Center the map on the found location
                    marker.setLatLng([lat, lng]); // Move the marker to the found location
                    document.getElementById("latitude").value = lat;
                    document.getElementById("longitude").value = lng;
                    updateLocationInfo(lat, lng);
                }).addTo(map);
            });
        </script>

    </body>

</html>