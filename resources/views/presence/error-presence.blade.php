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
           <div class="alert alert-warning">
            <p>
               Maaf, Anda tidak memiliki Jadwal Kerja pada hari ini, Silahkan hubungi Admin. 
            </p>
           </div>
        </div>
    </div>
</div>
@endsection