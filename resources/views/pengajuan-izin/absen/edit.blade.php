@extends('layouts.master-user')
@section('header')
<!-- App Header -->
 <div class="appHeader bg-danger text-light">
    <div class="left">
        <a href="{{ route('pengajuan-izin') }}" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Form Edit Izin Absen</div>
    <div class="right"></div>
</div>
<!-- * App Header -->
@endsection
@section('content')
<div class="section content-master-user">
    <div class="row">
        <div class="col">
            <form action="/pengajuan-izin/absen/{{ $dataIzin->kode_izin }}/update" method="POST" id="form-izin-absen">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control datepicker" placeholder="Dari Tanggal" value="{{ $dataIzin->start_date }}" id="start_date" name="start_date" autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control datepicker" placeholder="Sampai Tanggal" value="{{ $dataIzin->end_date }}" id="end_date" name="end_date" autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Lama izin (dalam hari)" id="number_of_days" name="number_of_days" readonly>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" value="{{ $dataIzin->keterangan }}" placeholder="Keterangan" id="keterangan" name="keterangan" autocomplete="off">
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

            $('#form-izin-absen').submit(function() {
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