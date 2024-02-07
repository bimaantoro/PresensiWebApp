<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Laporan Presensi</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>
  @page { 
    size: A4
  }

  #title {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 16px;
    font-weight: bold;
  }

  .table-data-student {
    margin-top: 40px;
  }

  .table-data-student td {
    padding: 5px;
  }

  .table-presence {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
  }

  .table-presence tr th {
    border: 1px solid black;
    padding: 8px;
    background: #9f9d9d;
  }

  .table-presence tr td {
    border: 1px solid black;
    padding: 5px;
    font-size: 12px;
  }

  .photo {
    width: 50px;
    height: 50px;
  }
  
  </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4">

  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">
    <table style="width: 100%">
        <tr>
            <td style="width: 30px">
                <img src="{{ asset('assets/img/logo-telkom.png') }}" alt="" width="100" height="100">
            </td>
            <td>
                <span id="title">
                    LAPORAN PRESENSI PKL / MAGANG<br>
                    PERIODE {{ strtoupper($months[$month]) }} {{ $year }}<br>
                    PT. TELKOM WITEL GORONTALO<br>
                </span>
                <span>
                  <i>Jl. Jaksa Agung Suprapto No.22, Limba U Dua, Kota Sel., Kota Gorontalo, Gorontalo</i>
                 </span>
            </td>
        </tr>
    </table>

    <table class="table-data-student">
        {{-- <tr>
            <td rowspan="4">
              @if ($student->avatar != null)
                <img src="{{ asset('storage/uploads/student/' . $student->avatar) }}" alt="" width="120" height="150">
              @else
                <img src="{{ asset('assets/img/no-image.png') }}" alt="" width="120" height="150">
              @endif
            </td>
        </tr> --}}
        <tr>
            <td>ID Peserta</td>
            <td>:</td>
            <td>{{ $student->id }}</td>
        </tr>
        <tr>
            <td>Nama Lengkap</td>
            <td>:</td>
            <td>{{ $student->nama_lengkap }}</td>
        </tr>
        <tr>
            <td>Asal Instansi</td>
            <td>:</td>
            <td>{{ $student->instansi }}</td>
        </tr>
        <tr>
          <td>Periode PKL / Magang</td>
          <td>:</td>
          <td>{{ $student->start_internship_month }} S.d {{ $student->end_internship_month }}</td>
      </tr>
    </table>

    <table class="table-presence">
      <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Presensi masuk</th>
        <th>Foto Presensi Masuk</th>
        <th>Presensi pulang</th>
        <th>Foto Presensi Pulang</th>
        <th>Status</th>
        <th>Keterangan</th>
      </tr>
      @foreach ($presence as $p)
      @if ($p->presence_status == 'H')
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ date('d-m-Y', strtotime($p->presence_at)) }}</td>
        <td>{{ $p->check_in }}</td>
        <td>
          <img src="{{ asset('storage/uploads/presence/' . $p->photo_in) }}" alt="" class="photo">
        </td>
        <td>{{ $p->check_out != null ? $p->check_out : 'Belum Presensi' }}</td>
        <td>
          @if ($p->photo_out != null)
          <img src="{{ asset('storage/uploads/presence/' . $p->photo_out) }}" alt="" class="photo">
          @else
          -
          @endif
        </td>
        <td style="text-align: center">{{ $p->presence_status }}</td>
        <td>
          @if ($p->check_in >= "07:00")
              Terlambat
          @else
              Tepat waktu
          @endif
        </td>
      </tr>
      @else
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ date('d-m-Y', strtotime($p->presence_at)) }}</td>
        <td>-</td>
        <td>
          -
        </td>
        <td>-</td>
        <td>
         -
        </td>
        <td style="text-align: center">{{ $p->presence_status }}</td>
        <td>
          {{ $p->keterangan_izin }}
        </td>
      </tr>
      @endif
      @endforeach
    </table>

    <table width="100%" style="margin-top: 100px">
      <tr>
        <td style="text-align: right">Gorontalo, {{ date('d-m-Y') }}</td>
      </tr>
      <tr>
        <td style="text-align: right; vertical-align:bottom" height="100px">
          <u>Sabar Siswanto</u><br>
          <i><b>GM Witel Gorontalo</b></i>
        </td>
      </tr>
    </table>

  </section>

</body>

</html>