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
                            <form action="/admin/config/set-work-hour/store" method="POST">
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
                                        <tr>
                                            <td>Senin
                                                <input type="hidden" name="day[]" value="Senin">
                                            </td>
                                            <td>
                                                <select name="working_hour_id[]" id="id-jam-kerja" class="form-select">
                                                    <option value="">Jam Kerja</option>
                                                    @foreach ($workHours as $wh)
                                                        <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Selasa
                                                <input type="hidden" name="day[]" value="Selasa">
                                            </td>
                                            <td>
                                                <select name="working_hour_id[]" id="id-jam-kerja" class="form-select">
                                                    <option value="">Jam Kerja</option>
                                                    @foreach ($workHours as $wh)
                                                        <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Rabu
                                                <input type="hidden" name="day[]" value="Rabu">
                                            </td>
                                            <td>
                                                <select name="working_hour_id[]" id="id-jam-kerja" class="form-select">
                                                    <option value="">Jam Kerja</option>
                                                    @foreach ($workHours as $wh)
                                                        <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Kamis
                                                <input type="hidden" name="day[]" value="Kamis">
                                            </td>
                                            <td>
                                                <select name="working_hour_id[]" id="id-jam-kerja" class="form-select">
                                                    <option value="">Jam Kerja</option>
                                                    @foreach ($workHours as $wh)
                                                        <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jumat
                                                <input type="hidden" name="day[]" value="Jumat">
                                            </td>
                                            <td>
                                                <select name="working_hour_id[]" id="id-jam-kerja" class="form-select">
                                                    <option value="">Jam Kerja</option>
                                                    @foreach ($workHours as $wh)
                                                        <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Sabtu
                                                <input type="hidden" name="day[]" value="Sabtu">
                                            </td>
                                            <td>
                                                <select name="working_hour_id[]" id="id-jam-kerja" class="form-select">
                                                    <option value="">Jam Kerja</option>
                                                    @foreach ($workHours as $wh)
                                                        <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button class="btn btn-primary w-100" type="submit">Simpan</button>
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
                                    <th>Awal Jam Masuk</th>
                                    <th>Jam Masuk</th>
                                    <th>Akhir Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @foreach ($workHours as $wh)
                                    <tr>
                                        <td>{{ $wh->id }}</td>
                                        <td>{{ $wh->name }}</td>
                                        <td>{{ $wh->start_check_in }}</td>
                                        <td>{{ $wh->check_in }}</td>
                                        <td>{{ $wh->end_check_in }}</td>
                                        <td>{{ $wh->check_out }}</td>
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