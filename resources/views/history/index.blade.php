@extends('layouts.master-user')
@section('header')
<!-- App Header -->
<div class="appHeader bg-danger text-light">
    <div class="pageTitle">Riwayat Presensi</div>
    <div class="right"></div>
</div>
<!-- * App Header -->
@endsection
@section('content')
<div class="section content-master-user">
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <select name="month" id="month" class="form-control selectmaterialize">
                    <option value="">Bulan</option>
                    @for ($i = 1; $i <= 12; $i++)
                    <option {{ Request('month') == $i ? 'selected' : '' }} value="{{ $i }}">{{ $months[$i] }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <select name="year" id="year" class="form-control selectmaterialize">
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
            <div class="form-group">
                <button class="btn btn-success btn-block"  id="search-history-presence">
                    <ion-icon name="search-outline"></ion-icon>Search
                </button>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col" id="show-history">

        </div>
    </div>
</div>
@endsection
@push('master-user-script')
    <script>
        $(function() {
            $("#search-history-presence").click(function(e) {
                const month = $("#month").val();
                const year = $("#year").val();
                $.ajax({
                    type: 'POST',
                    url: '/history',
                    data: {
                        _token: "{{ csrf_token() }}",
                        month: month,
                        year: year,
                    },
                    success: (response) => {
                        $("#show-history").html(response);
                    }
                });
            });
        });
    </script>
@endpush