@extends('layouts.master-manager')
@section('title', 'Laporan Presensi Peserta')
@section('content')
<div class="page-body">
    <div class="container-xl">
      <div class="row row-cards">
        <div class="card">
          <div class="card-body">
            <div class="col-12 mb-3">
                <form action="/manager/report-presence/print" target="_blank" method="POST">
                    @csrf
                    <div class="row">
                      <div class="col-12 mb-3">
                        <div class="form-group">
                          <select name="month" id="month" class="form-select">
                            <option value="">Bulan</option>
                            @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ date('m') == $i ? 'selected' : '' }}>{{ $months[$i] }}</option>
                            @endfor
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-12">
                        <div class="form-group">
                          <select name="year" id="year" class="form-select">
                            <option value="">Tahun</option>
                            @php
                              $initialYear = 2023;
                              $currentYear = date('Y');
                            @endphp
                            @for ($year = $initialYear; $year <= $currentYear; $year++)
                            <option value="{{ $year }}" {{ date('Y') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-12">
                        <div class="form-group">
                          <select name="id" id="id-student" class="form-select">
                            <option value="">Pilih Peserta</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->nama_lengkap }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-6">
                        <div class="form-group">
                          <button type="submit" class="btn btn-primary w-100"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" /></svg>
                            Cetak
                          </button>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                          <button type="submit" class="btn btn-primary w-100" name="export-excel">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-spreadsheet" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M8 11h8v7h-8z" /><path d="M8 15h8" /><path d="M11 11v7" /></svg>
                            Export to Excel
                          </button>
                        </div>
                      </div>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>


<div class="page-header d-print-none">
  <div class="container-xl">
      <div class="row g-2 align-items-center">
          <div class="col">
              <h2 class="page-title">
                  Rekap Presensi Peserta
              </h2>
          </div>
      </div>
  </div>
</div>

  <div class="page-body">
    <div class="container-xl">
      <div class="row row-cards">
        <div class="card">
          <div class="card-body">

            <div class="col-12 mb-3">
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

            <div class="col-12 mb-3">
                <form action="/manager/recap-presence/print" target="_blank" method="POST">
                    @csrf
                    <div class="row">
                      <div class="col-12 mb-3">
                        <div class="form-group">
                          <select name="month" id="month" class="form-select">
                            <option value="">Bulan</option>
                            @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ date('m') == $i ? 'selected' : '' }}>{{ $months[$i] }}</option>
                            @endfor
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-12">
                        <div class="form-group">
                          <select name="year" id="year" class="form-select">
                            <option value="">Tahun</option>
                            @php
                              $initialYear = 2023;
                              $currentYear = date('Y');
                            @endphp
                            @for ($year = $initialYear; $year <= $currentYear; $year++)
                            <option value="{{ $year }}" {{ date('Y') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-6">
                        <div class="form-group">
                          <button type="submit" class="btn btn-primary w-100"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" /></svg>
                            Cetak
                          </button>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                          <button type="submit" class="btn btn-primary w-100" name="export-excel">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-spreadsheet" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M8 11h8v7h-8z" /><path d="M8 15h8" /><path d="M11 11v7" /></svg>
                            Export to Excel
                          </button>
                        </div>
                      </div>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection