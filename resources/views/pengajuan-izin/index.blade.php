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
        <div class="col mb-3">
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
        <div class="col mb-3">
            <form action="{{ route('pengajuan-izin') }}" method="GET">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <select name="month" id="month" class="form-control">
                                <option value="">Bulan</option>
                                @for ($i = 1; $i <= 12; $i++)
                                <option {{ Request('month') == $i ? 'selected' : '' }} value="{{ $i }}">{{ $months[$i] }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <select name="year" id="year" class="form-control">
                                <option value="">Tahun</option>
                                @php
                                    $initialYear = 2023 ;
                                    $currentYear =  date('Y');
                                    for ($i = $initialYear; $i <= $currentYear; $i++) { 
                                        if(Request('year') == $i) {
                                            $selected = 'selected';
                                        } else {
                                            $selected = '';
                                        }
                                        echo "<option $selected value='$i'>$i</option>";
                                    }
                                @endphp
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button class="btn btn-danger w-100">Cari Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col">
            @foreach ($dataIzin as $d)
            @php
                if($d->status == 'I') {
                    $status = 'Izin';
                } else if ($d->status == 'S') {
                    $status = 'Sakit';
                } else {
                    $status = 'Tidak ditemukan';
                }
            @endphp
                <div class="card mt-2 card-izin" status_code="{{ $d->status_code }}" id_izin="{{ $d->id }}"  data-toggle="modal" data-target="#actionSheetIconed">
                    <div class="card-body">
                        <div class="pengajuan-izin-content">
                            <div class="icon-presence">
                                @if ($d->status == 'I')
                                <ion-icon name="calendar-outline" style="font-size: 48px; color: blue"></ion-icon>
                                @elseif($d->status == 'S')
                                <ion-icon name="medkit-outline" style="font-size: 48px; color: red"></ion-icon>
                                @endif
                            </div>
                            <div class="data-presence">
                                <h3 style="line-height: 3px">{{ date('d-m-Y', strtotime($d->start_date)) }}  ({{ $status }})
                                </h3>
                                <small>{{ date('d-m-Y', strtotime($d->start_date)) }} s.d {{ date('d-m-Y', strtotime($d->end_date)) }}</small>
                                <p>
                                    {{ $d->keterangan_izin }}
                                    <br>
                                    @if (!empty($d->file_surat_dokter))
                                        <span style="color: blue">
                                            <ion-icon name="document-attach-outline"></ion-icon>
                                            Lihat Surat Izin Dokter
                                        </span>
                                    @endif
                                </p>
                            </div>
                            <div class="status">
                                @if ($d->status_code == 0)
                                    <span class="badge bg-warning">Pending</span>
                                @elseif ($d->status_code == 1)
                                    <span class="badge bg-success">Approved</span>
                                @elseif($d->status_code == 2)
                                    <span class="badge bg-danger">Rejected</span>
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

    <div class="modal fade action-sheet" id="actionSheetIconed" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Aksi</h5>
                </div>

                <div class="modal-body" id="showact"></div>
            </div>
        </div>
    </div>

    <div class="modal fade dialogbox" id="deleteConfirm" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Yakin Ingin Menghapus?</h5>
                </div>
                <div class="modal-body">
                    Data Pengajuan Izin akan Dihapus
                </div>
                <div class="modal-footer">
                    <div class="btn-inline">
                        <a href="#" class="btn btn-text-secondary" data-dismiss="modal">Batal</a>
                        <a href="" class="btn btn-text-primary" id="hapus-pengajuan">
                            Hapus
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('master-user-script')
    <script>
        $(function() {
            $('.card-izin').click(function(e) {
                const idIzin = $(this).attr("id_izin");
                const statusCode = $(this).attr("status_code");

                if(statusCode == 1) {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Data sudah disetujui, Tidak dapat diubah!',
                        icon: 'warning',
                    });
                } else  {
                    $("#showact").load("/pengajuan-izin/" + idIzin + "/showact");
                }
            });
        });
    </script>
@endpush