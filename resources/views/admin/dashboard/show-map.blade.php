<div id="map"></div>
<script>
    let getLatitude = "{{ $presence->latitude }}";
    let getLongitude = "{{ $presence->longitude }}";
    
    let map = L.map('map').setView([getLatitude, getLongitude], 18);

    L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
        maxZoom: 20,
        subdomains:['mt0','mt1','mt2','mt3']
    }).addTo(map);

    let marker = L.marker([getLatitude, getLongitude]).addTo(map);
    marker.bindPopup("{{ $presence->fullname }}").openPopup();
</script>