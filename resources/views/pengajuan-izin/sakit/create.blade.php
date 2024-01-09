@extends('layouts.master-user')
@section('header')
<!-- App Header -->
 <div class="appHeader bg-danger text-light">
    <div class="left">
        <a href="{{ route('pengajuan-izin') }}" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Form Izin Sakit</div>
    <div class="right"></div>
</div>
<!-- * App Header -->
@endsection
@section('content')
<div class="section content-master-user">
    <div class="row">
        <div class="col">
            <form action="/pengajuan-izin/sakit/store" method="POST" id="form-pengajuan-izin" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control datepicker" placeholder="Dari Tanggal" id="from_date" name="from_date" autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control datepicker" placeholder="Sampai Tanggal" id="to_date" name="to_date" autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Jumlah Hari" id="jumlah_hari" name="jumlah_hari" readonly>
                </div>
                <div class="custom-file-upload form-group" id="fileUpload1" style="height: 100px !important">
                    <input type="file" name="file_sid" id="fileUploadInput" accept=".png, .jpg, .jpeg">
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
                    <textarea name="keterangan" id="keterangan" class="form-control" cols="30" rows="5" placeholder="Keterangan"></textarea>
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

@push('pengajuan-izin-stylesheet')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" />
@endpush

@push('pengajuan-izin-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js" integrity="sha512-NiWqa2rceHnN3Z5j6mSAvbwwg3tiwVNxiAQaaSMSXnRRDh5C2mk/+sKQRw8qjV1vN4nf8iK2a0b048PnHbyx+Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
     $(document).ready(function() {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd'    
            });

            function loadJumlahHari() {
                const fromDate = $('#from_date').val();
                const toDate = $('#to_date').val();
                const date1 = new Date(fromDate);
                const date2 = new Date(toDate);

                // to calculate the time different of two dates
                const differenceInTime = date2.getTime() - date1.getTime();

                // to calculate the no of days between two dates
                const differenceInDays = differenceInTime / (1000 * 3600 * 24);

                let jumlahHari;

                if(fromDate === '' || toDate === '') {
                    jumlahHari = 0;
                } else {
                    jumlahHari = differenceInDays + 1;
                }

                $('#jumlah_hari').val(jumlahHari + " Hari");
            }

            $('#from_date, #to_date').change(function(e) {
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

            $('#form-pengajuan-izin').submit(function() {
                const fromDate = $('#from_date').val();
                const toDate = $('#to_date').val();
                const keterangan = $('#keterangan').val();

                if(fromDate === '' || toDate === '') {
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