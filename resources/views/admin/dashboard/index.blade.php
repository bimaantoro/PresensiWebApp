{{-- @extends('layouts.master-admin')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-lg-12 col-md-12 order-1">
      <div class="row">
        <div class="col-lg-3 col-md-12 col-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <i class="bx bx-fingerprint"></i>
                </div>
              </div>
              <span class="fw-medium d-block mb-1">Hadir</span>
              <h3 class="card-title mb-2">{{ $dataPresence->jmlh_hadir != null ? $dataPresence->jmlh_hadir : 0 }} Karyawan</h3>
              <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +72.80%</small>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-12 col-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <i class="bx bx-time"></i>
                </div>
              </div>
              <span class="fw-medium d-block mb-1">Terlambat</span>
              <h3 class="card-title text-nowrap mb-1">{{ $dataPresence->jmlh_terlambat != null ? $dataPresence->jmlh_terlambat : 0 }} Karyawan</h3>
              <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.42%</small>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-12 col-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <i class="bx bx-calendar"></i>
                </div>
              </div>
              <span class="fw-medium d-block mb-1">Izin</span>
              <h3 class="card-title text-nowrap mb-1">{{ $dataIzin->jmlh_izin != null ? $dataIzin->jmlh_izin : 0 }} Karyawan</h3>
              <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.42%</small>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-12 col-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <i class="bx bx-plus-medical"></i>
                </div>
              </div>
              <span class="fw-medium d-block mb-1">Sakit</span>
              <h3 class="card-title text-nowrap mb-1">{{ $dataIzin->jmlh_sakit != null ? $dataIzin->jmlh_sakit : 0 }} Karyawan</h3>
              <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.42%</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection --}}
@section('content')
@extends('layouts.master-admin')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">
            Dashboard
          </h2>
        </div>
      </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            {{-- <div class="col-md-3 col-xl-3">
                <div class="card card-sm">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-auto">
                          <span class="bg-primary text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
                          </span>
                        </div>
                        <div class="col">
                          <div class="font-weight-medium">
                            0
                          </div>
                          <div class="text-secondary">
                            Karyawan
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div> --}}
            <div class="col-md-3 col-xl-3">
                <div class="card card-sm">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-auto">
                          <span class="bg-success text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-fingerprint" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18.9 7a8 8 0 0 1 1.1 5v1a6 6 0 0 0 .8 3" /><path d="M8 11a4 4 0 0 1 8 0v1a10 10 0 0 0 2 6" /><path d="M12 11v2a14 14 0 0 0 2.5 8" /><path d="M8 15a18 18 0 0 0 1.8 6" /><path d="M4.9 19a22 22 0 0 1 -.9 -7v-1a8 8 0 0 1 12 -6.95" /></svg>
                          </span>
                        </div>
                        <div class="col">
                          <div class="font-weight-medium">
                            {{ $dataPresence->jmlh_hadir != null ? $dataPresence->jmlh_hadir : 0 }} Pegawai
                          </div>
                          <div class="text-secondary">
                            Hadir
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xl-3">
                <div class="card card-sm">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-auto">
                          <span class="bg-warning text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 7v5l3 3" /></svg>
                          </span>
                        </div>
                        <div class="col">
                          <div class="font-weight-medium">
                            {{ $dataPresence->jmlh_terlambat != null ? $dataPresence->jmlh_terlambat : 0 }} Pegawai
                          </div>
                          <div class="text-secondary">
                            Terlambat
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xl-3">
                <div class="card card-sm">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-auto">
                          <span class="bg-primary text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-month" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M7 14h.013" /><path d="M10.01 14h.005" /><path d="M13.01 14h.005" /><path d="M16.015 14h.005" /><path d="M13.015 17h.005" /><path d="M7.01 17h.005" /><path d="M10.01 17h.005" /></svg>
                          </span>
                        </div>
                        <div class="col">
                          <div class="font-weight-medium">
                            {{ $dataIzin->jmlh_izin != null ? $dataIzin->jmlh_izin : 0 }} Pegawai
                          </div>
                          <div class="text-secondary">
                            Izin
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div><div class="col-md-3 col-xl-3">
                <div class="card card-sm">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-auto">
                          <span class="bg-danger text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mood-sick" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 21a9 9 0 1 1 0 -18a9 9 0 0 1 0 18z" /><path d="M9 10h-.01" /><path d="M15 10h-.01" /><path d="M8 16l1 -1l1.5 1l1.5 -1l1.5 1l1.5 -1l1 1" /></svg>
                        </div>
                        <div class="col">
                          <div class="font-weight-medium">
                            {{ $dataIzin->jmlh_sakit != null ? $dataIzin->jmlh_sakit : 0 }} Pegawai
                          </div>
                          <div class="text-secondary">
                            Sakit
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@endsection