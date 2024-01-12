@extends('layouts.master-admin')
@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
          <div class="row g-2 align-items-center">
            <div class="col">
              <h2 class="page-title">
                Data Izin / Sakit
              </h2>
            </div>
          </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <form action="/admin/pengajuan-izin" method="GET">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="input-icon mb-3">
                                                    <span class="input-icon-addon">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-month" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M7 14h.013" /><path d="M10.01 14h.005" /><path d="M13.01 14h.005" /><path d="M16.015 14h.005" /><path d="M13.015 17h.005" /><path d="M7.01 17h.005" /><path d="M10.01 17h.005" /></svg>
                                                    </span>
                                                    <input type="text" class="form-control" id="start" name="start" placeholder="Dari Tanggal" value="{{ request()->start }}" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-icon mb-3">
                                                    <span class="input-icon-addon">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-month" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M7 14h.013" /><path d="M10.01 14h.005" /><path d="M13.01 14h.005" /><path d="M16.015 14h.005" /><path d="M13.015 17h.005" /><path d="M7.01 17h.005" /><path d="M10.01 17h.005" /></svg>
                                                    </span>
                                                    <input type="text" class="form-control" id="end" name="end" placeholder="Sampai Tanggal" value="{{ request()->end }}" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="input-icon mb-3">
                                                    <span class="input-icon-addon">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" /><path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M15 8l2 0" /><path d="M15 12l2 0" /><path d="M7 16l10 0" /></svg>
                                                    </span>
                                                    <input type="text" class="form-control" id="id-student" name="id" placeholder="ID Peserta" value="{{ request()->id }}" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="input-icon mb-3">
                                                    <span class="input-icon-addon">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                                                    </span>
                                                    <input type="text" class="form-control" id="nama-lengkap" name="nama_lengkap" placeholder="Nama Peserta" value="{{ request()->nama_lengkap }}" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <select class="form-select text-muted" name="status_code">
                                                    <option value="">Status</option>
                                                    <option value="0" {{ request()->status_code == '0' ? 'selected' : '' }}>Pending</option>
                                                    <option value="1" {{ request()->status_code == '1' ? 'selected' : '' }}>Disetujui</option>
                                                    <option value="2" {{ request()->status_code == '2' ? 'selected' : '' }}>Ditolak</option>
                                                </select>
                                            </div>
                                            <div class="col-3">
                                                <button class="btn btn-primary w-100" type="submit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                                    Cari Data
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-vcenter table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>ID</th>
                                                <th>Nama</th>
                                                <th>Asal</th>
                                                <th>Status</th>
                                                <th>Keterangan</th>
                                                <th>Status Persetujuan</th>
                                                <th class="w-1"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dataIzin as $di)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($di->start_date)) }}</td>
                                                    <td>{{ $di->id }}</td>
                                                    <td>{{ $di->nama_lengkap }}</td>
                                                    <td>{{ $di->instansi }}</td>
                                                    <td>{{ $di->status == 'i' ? "Izin" : "Sakit" }}</td>
                                                    <td>{{ $di->keterangan }}</td>
                                                    <td>
                                                        @if ($di->status_code == 1)
                                                            <span class="badge bg-success text-light">Disetujui</span>
                                                        @elseif($di->status_code == 2)
                                                            <span class="badge bg-danger text-light">Ditolak</span>
                                                        @else
                                                            <span class="badge bg-warning text-light">Pending</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-list flex-nowrap">
                                                            @if ($di->status_code == 0)
                                                            <a href="#" class="btn-primary btn btn-sm" id="status-code" id_pengajuan_izin="{{ $di->id }}">
                                                                Validasi
                                                            </a>
                                                            @else
                                                            <a href="/admin/pengajuan-izin/{{ $di->id }}" class="btn btn-danger btn-sm">
                                                                Batalkan
                                                            </a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $dataIzin->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="modal-izin-student" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Izin / Sakit</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/admin/pengajuan-izin/update" method="POST">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="id" id="id-pengajuan-izin-form">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <select class="form-select" name="status_code" id="status-code">
                                    <option value="1">Setujui</option>
                                    <option value="2">Tolak</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button class="btn btn-primary w-100" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                            Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
@endsection
@push('master-admin-script')
    <script>
        $(function() {
            $("#status-code").click(function(e) {
                e.preventDefault();
                const id = $(this).attr("id_pengajuan_izin");
                $("#id-pengajuan-izin-form").val(id);
                $("#modal-izin-student").modal("show");
            });

            $("#start, #end").datepicker({ 
                autoclose: true, 
                todayHighlight: true,
                format: "yyyy-mm-dd",
            });
        });
    </script>
@endpush