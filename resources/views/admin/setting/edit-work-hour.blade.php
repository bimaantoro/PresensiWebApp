@extends('layouts.master-admin')
@section('title', 'Set Jam Kerja Peserta')
@section('content')
<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="card">
              <div class="card-body">

                <div class="col-12 mb-3">
                    <div class="table-responsive">
                      <table class="table table-vcenter table-striped">
                        <tr>
                            <th>ID Peserta</th>
                            <td>{{ $student->id }}</td>
                        </tr>
                        <tr>
                            <th>Nama Peserta</th>
                            <td>{{ $student->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <th>Asal Instansi</th>
                            <td>{{ $student->instansi }}</td>
                        </tr>
                      </table>
                    </div> 
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <div class="table-responsive">
                            <form action="/admin/setting/work-hour/update" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $student->id }}">
                                <table class="table table-vcenter table-striped">
                                    <thead>
                                        <tr>
                                            <th>Hari</th>
                                            <th>Jam Kerja</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($setWorkingHour as $swh)
                                        <tr>
                                            <td>{{ $swh->day }}
                                                <input type="hidden" name="day[]" value="{{ $swh->day }}">
                                            </td>
                                            <td>
                                                <select name="working_hour_id[]" id="id-jam-kerja" class="form-select">
                                                    <option value="">Jam Kerja</option>
                                                    @foreach ($workHours as $wh)
                                                        <option {{ $wh->id == $swh->working_hour_id ? 'selected' : '' }} value="{{ $wh->id }}">{{ $wh->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <button class="btn btn-primary w-100" type="submit">Update</button>
                            </form>
                        </div> 
                    </div>

                    <div class="col-6 mb-3">
                        <div class="table-responsive">
                            <table class="table table-vcenter table-striped">
                              <thead>
                                  <tr>
                                      <th colspan="6">Master Jam Kerja</th>
                                  </tr>
                                  <tr>
                                    <th>Kode Jam Kerja</th>
                                    <th>Nama Jam Kerja</th>
                                    <th>Awal Jam Presensi</th>
                                    <th>Jam Masuk</th>
                                    <th>Akhir Jam Presensi</th>
                                    <th>Jam Pulang</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @foreach ($workHours as $wh)
                                    <tr>
                                        <td>{{ $wh->id }}</td>
                                        <td>{{ $wh->name }}</td>
                                        <td>{{ $wh->start_check_in }}</td>
                                        <td>{{ $wh->jam_in }}</td>
                                        <td>{{ $wh->end_check_in }}</td>
                                        <td>{{ $wh->jam_out }}</td>
                                    </tr>
                                @endforeach
                              </tbody>
                            </table>
                        </div> 
                    </div>    
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection 