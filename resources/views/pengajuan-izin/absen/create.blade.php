@extends('layouts.master-user')
@section('header')
<!-- App Header -->
 <div class="appHeader bg-danger text-light">
    <div class="left">
        <a href="{{ route('pengajuan-izin') }}" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Form Izin Absen</div>
    <div class="right"></div>
</div>
<!-- * App Header -->
@endsection
@section('content')
<div class="section content-master-user">
    <div class="row">
        <div class="col">
            <form action="/pengajuan-izin/absen/store" method="POST" id="form-izin-absen">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control datepicker" placeholder="Dari Tanggal" id="start-date" name="start_date" autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control datepicker" placeholder="Sampai Tanggal" id="end-date" name="end_date" autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Lama izin (dalam hari)" id="jumlah-izin" name="jumlah_izin" readonly autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Keterangan" id="keterangan" name="keterangan_izin" autocomplete="off">
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
                const startDate = $('#start-date').val();
                const endDate = $('#end-date').val();
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

                $('#jumlah-izin').val(numberOfDays);
            }

            $('#start-date, #end-date').change(function(e) {
                loadJumlahHari(); 
            });

            $('#form-izin-absen').submit(function() {
                const startDate = $('#start-date').val();
                const endDate = $('#end-date').val();
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