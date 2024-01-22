@extends('layouts.master-user')
@section('header')
     <!-- App Header -->
     <div class="appHeader bg-danger text-light">
        <div class="pageTitle">Presensi</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection
@section('content')
<div class="section content-master-user">
    <div class="row">
        <div class="col">
            <input type="hidden" id="latitude">
            <input type="hidden" id="longitude">
            <div id="my_camera"></div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col">
        @if ($checkIsPresence > 0)
            <button id="btn-check-in" class="btn btn-danger btn-block">
                <ion-icon name="camera-outline"></ion-icon> Presensi Pulang
            </button>
        @else
            <button id="btn-check-in" class="btn btn-success btn-block">
                <ion-icon name="camera-outline"></ion-icon> Presensi Masuk
            </button>
        @endif
        </div>
    </div>
    <div class="row mt-2">
        <div class="col">
            <div id="map"></div>
        </div>
    </div>
</div>
@endsection
@push('map-style')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
@endpush
@push('webcam-script')
<script language="JavaScript">
    Webcam.set({
        width: 320,
        height: 240,
        image_format: 'jpeg',
        jpeg_quality: 90,
    });
    
    Webcam.attach('#my_camera');

    const getLatitude = document.getElementById('latitude');
    const getLongitude = document.getElementById('longitude');

    if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showLocation, showError)
    }

    function showLocation(position) {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;
        getLatitude.value = latitude;
        getLongitude.value = longitude;
        const map = L.map('map').setView([latitude, longitude], 13);

        L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
        maxZoom: 20,
        subdomains:['mt0','mt1','mt2','mt3']
        }).addTo(map);

        const marker = L.marker([latitude, longitude]).addTo(map)
    }

    function showError() {}

    $("#btn-check-in").click(function(e) {
        Webcam.snap(function(data_uri) {
            image = data_uri;
        });
        const latitude = $("#latitude").val();
        const longitude = $("#longitude").val();
        $.ajax({
            type: 'POST',
            url: '/presence/store',
            data: {
                _token: "{{ csrf_token() }}",
                image: image,
                latitude: latitude,
                longitude: longitude,
            },
            success: (response) => {
                const status = response.split('|');
                
                if(status[0] === 'success') {
                    Swal.fire({
                    title: 'Berhasil!',
                    text: status[1],
                    icon: 'success',
                });
                setTimeout("location.href='/dashboard'", 3000);
                } else {
                    Swal.fire({
                    title: 'Error!',
                    text: status[1],
                    icon: 'error',
                });
                }
            }
        })
    });
</script>
@endpush