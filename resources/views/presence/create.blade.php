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
<div class="section" style="margin-top: 70px">
    <div class="row">
        <div class="col">
            <input type="text" id="latitude">
            <input type="text" id="longitude">
            <div class="my_camera"></div>
        </div>
    </div>
    <div class="jam-digital-malasngoding">
        <p>{{ date('d-m-Y') }}</p>
        <p id="jam"></p>
        <p>{{ $workingHour->name }}</p>
        <p>Mulai Presensi: {{ date('H:i', strtotime($workingHour->start_check_in))  }}</p>
        <p>Jam Masuk: {{ date('H:i', strtotime($workingHour->jam_in)) }}</p>
        <p>Akhir Presensi: {{ date('H:i', strtotime($workingHour->end_check_in)) }}</p>
        <p>Jam Pulang: {{ date('H:i', strtotime($workingHour->jam_out)) }}</p>
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
@push('master-user-css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
@endpush
@push('master-user-script')
<script type="text/javascript">
    window.onload = function() {
        jam();
    }

    function jam() {
        let e = document.getElementById('jam')
        , d = new Date()
        , h, m, s;
        h = d.getHours();
        m = set(d.getMinutes());
        s = set(d.getSeconds());

        e.innerHTML = h + ':' + m + ':' + s;

        setTimeout('jam()', 1000);
    }

    function set(e) {
        e = e < 10 ? '0' + e : e;
        return e;
    }
</script>
<script>
    Webcam.set({
        width: 320,
        height: 240,
        image_format: 'jpeg',
        jpeg_quality: 90,
    });
    
    Webcam.attach('.my_camera');

    let getLatitude = document.getElementById('latitude');
    let getLongitude = document.getElementById('longitude');

    if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showLocation, showError)
    }

    function showLocation(position) {
        let latitude = position.coords.latitude;
        let longitude = position.coords.longitude;
        getLatitude.value = latitude;
        getLongitude.value = longitude;
        let map = L.map('map').setView([latitude, longitude], 18);

        L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
        maxZoom: 20,
        subdomains:['mt0','mt1','mt2','mt3']
        }).addTo(map);

        let marker = L.marker([latitude, longitude]).addTo(map);
        let circle = L.circle([1.4778368, 124.8493568], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: 500
        }).addTo(map);
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
                if(response.hasOwnProperty('error')) {
                    Swal.fire({
                        title: 'Error!',
                        text: response.error,
                        icon: 'error',
                    });
                } else if(response.hasOwnProperty('message')) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message,
                        icon: 'success',
                    });
                    setTimeout("location.href='/dashboard'", 3000);
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Invalid response from server',
                        icon: 'error',
                    });
                }
            },
            error: (xhr, status, error) => {
                console.error(error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Something went wrong. Please try again later.',
                    icon: 'error',
                });
            }
        });
    });
</script>
@endpush