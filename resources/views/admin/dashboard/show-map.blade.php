<div id="map"></div>
<script>
    let getLatitude = "{{ $presence->latitude }}";
    let getLongitude = "{{ $presence->longitude }}";
    
    let map = L.map('map').setView([getLatitude, getLongitude], 18);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    let marker = L.marker([getLatitude, getLongitude]).addTo(map);
    // ubah dengan lat dan longitude kantor
    let circle = L.circle([0.5561403, 123.1333622], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: 40
        }).addTo(map);
        
    let popup = L.popup()
    .setLatLng([getLatitude, getLongitude])
    .setContent("{{ $presence->nama_lengkap }}")
    .openOn(map);
</script>