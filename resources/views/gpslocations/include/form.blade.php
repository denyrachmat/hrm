@push('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.locatecontrol/dist/L.Control.Locate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
@endpush

<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="gpc-location-name">{{ __('Gpc Location Name') }}</label>
            <input type="text" name="gpc_location_name" id="gpc-location-name"
                class="form-control @error('gpc_location_name') is-invalid @enderror"
                value="{{ isset($gpslocation) ? $gpslocation->gpc_location_name : old('gpc_location_name') }}"
                placeholder="{{ __('Gpc Location Name') }}" required />
            @error('gpc_location_name')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="latitude">{{ __('Latitude') }}</label>
            <input type="text" name="latitude" id="latitude"
                class="form-control @error('latitude') is-invalid @enderror" readonly
                value="{{ isset($gpslocation) ? $gpslocation->latitude : old('latitude') }}"
                placeholder="{{ __('Latitude') }}" required />
            @error('latitude')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="longitude">{{ __('Longitude') }}</label>
            <input type="text" name="longitude" id="longitude"
                class="form-control @error('longitude') is-invalid @enderror" readonly
                value="{{ isset($gpslocation) ? $gpslocation->longitude : old('longitude') }}"
                placeholder="{{ __('Longitude') }}" required />
            @error('longitude')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="radius">{{ __('Radius') }} (meter)</label>
            <input type="number" name="radius" id="radius"
                class="form-control @error('radius') is-invalid @enderror"
                value="{{ isset($gpslocation) ? $gpslocation->radius : old('radius') }}"
                placeholder="{{ __('Radius') }}" required />
            @error('radius')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-12">
        <div id="map" style="height: 400px;"></div>
    </div>
</div>

@push('js')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script src="https://unpkg.com/leaflet.locatecontrol/dist/L.Control.Locate.min.js"></script>
<script>
    var map = L.map('map').setView([-6.2088, 106.8456], 13); // Set initial map view

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var marker = L.marker([-6.2088, 106.8456]).addTo(map);
    var circle = L.circle(marker.getLatLng(), { radius: 0 }).addTo(map);

    // Add search control
    var searchControl = L.Control.geocoder({
        defaultMarkGeocode: false,
        placeholder: 'Search for a location...',
        showResultIcons: true,
        collapsed: true
    }).on('markgeocode', function(e) {
        var location = e.geocode.center;
        map.setView(location, 13); // Set map view to the selected location
        marker.setLatLng(location); // Move the marker to the selected location
        updateCircle(); // Update circle based on marker location and radius

        // Fill latitude and longitude inputs
        document.getElementById('latitude').value = location.lat;
        document.getElementById('longitude').value = location.lng;

        // Update Gpc Location Name input if available in the result
        if (e.geocode.name) {
            document.getElementById('gpc-location-name').value = e.geocode.name;
        }
    }).addTo(map);

    // Listen for radius input change
    document.getElementById('radius').addEventListener('input', function() {
        updateCircle();
    });

    // Listen for map click
    map.on('click', function(e) {
        var location = e.latlng;
        marker.setLatLng(location); // Move the marker to the clicked location
        updateCircle(); // Update circle based on marker location and radius

        // Fill latitude and longitude inputs
        document.getElementById('latitude').value = location.lat;
        document.getElementById('longitude').value = location.lng;

        // Reverse geocode to get location name
        searchControl.reverse(location, map.options.crs.scale(map.getZoom()), function(results) {
            if (results && results.length > 0) {
                document.getElementById('gpc-location-name').value = results[0].name;
            }
        });
    });

    // Add button for current location
    L.control.locate({
        icon: 'fas fa-location-arrow',
        strings: {
            title: 'Show My Location'
        }
    }).addTo(map);

    // Handle location found event
    map.on('locationfound', function(e) {
        var location = e.latlng;
        map.setView(location, 13); // Set map view to the current location
        marker.setLatLng(location); // Move the marker to the current location
        updateCircle(); // Update circle based on marker location and radius

        // Fill latitude and longitude inputs
        document.getElementById('latitude').value = location.lat;
        document.getElementById('longitude').value = location.lng;
    });

    // Function to update map based on data (latitude, longitude, radius)
    function updateMap(data) {
        var location = L.latLng(data.latitude, data.longitude);
        map.setView(location, 13); // Set map view to the location
        marker.setLatLng(location); // Move the marker to the location

        document.getElementById('latitude').value = data.latitude;
        document.getElementById('longitude').value = data.longitude;
        document.getElementById('gpc-location-name').value = data.gpc_location_name;
        document.getElementById('radius').value = data.radius;

        updateCircle(); // Update circle based on marker location and radius
    }

    // Function to update circle based on marker location and radius
    function updateCircle() {
        var radius = parseInt(document.getElementById('radius').value);
        circle.setLatLng(marker.getLatLng()).setRadius(radius || 0);
    }

    // Check if latitude, longitude, and radius have values in the form
    var initialLatitude = parseFloat(document.getElementById('latitude').value);
    var initialLongitude = parseFloat(document.getElementById('longitude').value);
    var initialRadius = parseInt(document.getElementById('radius').value);

    if (!isNaN(initialLatitude) && !isNaN(initialLongitude)) {
        // If values exist, update the map
        updateMap({
            latitude: initialLatitude,
            longitude: initialLongitude,
            gpc_location_name: document.getElementById('gpc-location-name').value,
            radius: initialRadius
        });
    }
</script>
@endpush
