<div id="map"></div>
<script>
    let getLatitude = "{{ $presence->latitude }}";
    let getLongitude = "{{ $presence->longitude }}";
    
    const map = L.map('map').setView([getLatitude, getLongitude], 16);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    const marker = L.marker([getLatitude, getLongitude]).addTo(map);
    const circle = L.circle([1.4811136, 124.84608], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 20
    }).addTo(map);
    const popup = L.popup()
    .setLatLng([getLatitude, getLongitude])
    .setContent("{{ $presence->nama_lengkap }}")
    .openOn(map);
</script>