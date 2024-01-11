@extends('layouts.master-user')
@section('header')
<!-- App Header -->
 <div class="appHeader bg-danger text-light">
    <div class="left">
        <a href="{{ route('pengajuan-izin') }}" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Form Edit Izin Sakit</div>
    <div class="right"></div>
</div>
<!-- * App Header -->
@endsection
@section('content')
<div class="section content-master-user">
    <div class="row">
        <div class="col">
            <form action="/pengajuan-izin/sakit/{{ $dataIzin->kode_izin }}/update" method="POST" id="form-izin-sakit" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control datepicker" placeholder="Dari Tanggal" id="start_date" value="{{ $dataIzin->start_date }}" name="start_date" autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control datepicker" placeholder="Sampai Tanggal" value="{{ $dataIzin->end_date }}" id="end_date" name="end_date" autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Lama izin (dalam hari)" id="number_of_days" name="number_of_days" readonly>
                </div>
                @if ($dataIzin->file_surat_dokter != null)
                    <div class="row">
                        <div class="col-12">
                            @php
                                $fileSuratDokter = Storage::url('/uploads/suratDokter/' . $dataIzin->file_surat_dokter );
                            @endphp
                            <img src="{{ url($fileSuratDokter) }}" alt="" width="100px">
                        </div>
                    </div>
                @endif
                <div class="custom-file-upload form-group" id="fileUpload1" style="height: 100px !important">
                    <input type="file" name="file_surat_dokter" id="fileUploadInput" accept=".png, .jpg, .jpeg">
                    <label for="fileUploadInput">
                        <span>
                            <strong>
                                <ion-icon name="cloud-upload-outline" class="md hydrated"></ion-icon>
                                <i>Tap to upload Surat Izin Dokter</i>
                            </strong>
                        </span>
                    </label>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Keterangan" id="keterangan" name="keterangan" value="{{ $dataIzin->keterangan }}" autocomplete="off">
                </div>
                <div class="form-group">
                    <button class="btn btn-success w-100">
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('master-user-css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" />
@endpush

@push('master-user-script')
<script>
     $(document).ready(function() {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd'    
            });

            function loadJumlahHari() {
                const startDate = $('#start_date').val();
                const endDate = $('#end_date').val();
                const date1 = new Date(startDate);
                const date2 = new Date(endDate);

                // to calculate the time different of two dates
                const differenceInTime = date2.getTime() - date1.getTime();

                // to calculate the no of days between two dates
                const differenceInDays = differenceInTime / (1000 * 3600 * 24);

                let numberOfDays;

                if(startDate === '' || endDate === '') {
                    numberOfDays = 0;
                } else {
                    numberOfDays = differenceInDays + 1;
                }

                $('#number_of_days').val(numberOfDays + " Hari");
            }

            loadJumlahHari(); 

            $('#start_date, #end_date').change(function(e) {
                loadJumlahHari(); 
            });

            $('#izinAt').change(function(e) {
                const izinAt = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: '/pengajuan-izin/check',
                    data: {
                        _token: '{{ csrf_token() }}',
                        izinAt: izinAt
                    },
                    success: (response) => {
                        if(response == 1) {
                            Swal.fire({
                                title: 'Oops!',
                                text: 'Anda sudah melakukan pengajuan izin pada tanggal tersebut',
                                icon: 'warning',
                            }).then((result) => {
                                $('#izinAt').val('');
                            });
                        }
                    }
                });
            });

            $('#form-izin-sakit').submit(function() {
                const startDate = $('#start_date').val();
                const endDate = $('#end_date').val();
                const keterangan = $('#keterangan').val();

                if(startDate === '' || endDate === '') {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Tanggal harus diisi',
                        icon: 'warning',
                    });
                    return false;
                } else if(keterangan === '') {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Keterangan harus diisi',
                        icon: 'warning',
                    });
                    return false;
                }
            });
        });
</script>
@endpush