@extends('layouts.master-user')
@section('header')
<!-- App Header -->
 <div class="appHeader bg-danger text-light">
    <div class="pageTitle">Data Izin / Sakit</div>
    <div class="right"></div>
</div>
<!-- * App Header -->
@endsection
@section('content')
<div class="section content-master-user">
    <div class="row">
        <div class="col">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col">
            @foreach ($dataIzin as $d)
            @php
                if($d->status == 'i') {
                    $status = 'Izin';
                } else if ($d->status == 's') {
                    $status = 'Sakit';
                } else {
                    $status = 'Not Found';
                }
            @endphp
                <div class="card mt-2">
                    <div class="card-body">
                        <div class="pengajuan-izin-content">
                            <div class="icon-presence">
                                @if ($d->status == 'i')
                                <ion-icon name="calendar-outline" style="font-size: 48px; color: red"></ion-icon>
                                @elseif($d->status == 's')
                                <ion-icon name="medkit-outline" style="font-size: 48px; color: red"></ion-icon>
                                @endif
                            </div>
                            <div class="data-presence">
                                <h3 style="line-height: 30px">{{ date('d-m-Y', strtotime($d->from_date_at)) }}  ({{ $status }})
                                </h3>
                                <small>{{ date('d-m-Y', strtotime($d->from_date_at)) }} s.d {{ date('d-m-Y', strtotime($d->to_date_at)) }}</small>
                                <p>
                                    {{ $d->keterangan }}
                                    <br>
                                    @if (!empty($d->file_sid))
                                        <span style="color: blue">
                                            <ion-icon name="document-attach-outline"></ion-icon>
                                            Lihat Surat Izin Dokter
                                        </span>
                                    @endif
                                </p>
                            </div>
                            <div class="status">
                                @if ($d->status_approved == 0)
                                    <span class="badge bg-warning">Pending</span>
                                @elseif ($d->status_approved == 1)
                                    <span class="badge bg-success">Approved</span>
                                @elseif($d->status_approved == 2)
                                    <span class="badge bg-danger">Decline</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="fab-button animate bottom-right" style="margin-bottom: 70px">
        <a href="#" class="fab bg-danger" data-toggle="dropdown">
            <ion-icon name="add-outline" aria-label="add outline" class="md hydrated"></ion-icon>
        </a>

        <div class="dropdown-menu">
            <a href="/pengajuan-izin/absen" class="dropdown-item bg-danger">
                <ion-icon name="document-outline" class="md hydrated"></ion-icon>
                <p>Absen</p>
            </a>

            <a href="/pengajuan-izin/sakit" class="dropdown-item bg-danger">
                <ion-icon name="document-outline" class="md hydrated"></ion-icon>
                <p>Sakit</p>
            </a>
        </div>
    </div>

</div>
@endsection

@push('pengajuan-izin-style')
<style>
     .pengajuan-izin-content {
        display: flex;
        gap: 1px;
     }

     .data-presence {
        margin-left: 10px;
     }

     .status {
        position: absolute;
        right: 20px;
     }
</style>
@endpush