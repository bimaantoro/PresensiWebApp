<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Rekap Presensi</title>

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
    font-size: 18px;
    font-weight: bold;
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
    font-size: 9px;
  }

  .table-presence tr td {
    border: 1px solid black;
    padding: 5px;
    font-size: 12px;
  }

  body.A4.landscape .sheet {
    width: 297mm !important;
    height: auto !important;
  }
  
  </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4 landscape">

  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">
    
    <table style="width: 100%">
        <tr>
            <td style="width: 30px">
                <img src="{{ asset('assets/img/icon/192x192.png') }}" alt="" width="100" height="100">
            </td>
            <td>
                <span id="title">
                    REKAP PRESENSI KARYAWAN<br>
                    PERIODE {{ strtoupper($months[$month]) }} {{ $year }}<br>
                    PT. KOPERASI INTERNET NETWORK GORONTALO<br>
                </span>
                <span><i>H4H2+XHM, Permata, Tilongkabila, Bone Bolango Regency, Gorontalo 96127</i></span>
            </td>
        </tr>
    </table>

    <table class="table-presence">
      <tr>
        <th rowspan="2">ID Karyawan</th>
        <th rowspan="2">Nama</th>
        <th rowspan="2">Jabatan</th>
        <th colspan="{{ $totalDays }}">Bulan {{ $months[$month] }} {{ $year }}</th>
        <th rowspan="2">H</th>
        <th rowspan="2">I</th>
        <th rowspan="2">S</th>
        <th rowspan="2">A</th>
    </tr>
    <tr>
      @foreach ($rangeDate as $rd)
        @if ($rd != NULL)
          <th>{{ date('d', strtotime($rd)) }}</th>
        @endif
      @endforeach
    </tr>
    @foreach ($recapPresence as $rp)
    <tr>
      <td>{{ $rp->id_employee }}</td>
      <td>{{ $rp->fullname }}</td>
      <td>{{ $rp->position }}</td>
      <?php
        $totalPresence = 0;
        $totalAlpa = 0;
        $totalAbsen = 0;
        $totalSakit = 0;
        $color = "";
        for ($i=1; $i <= $totalDays; $i++) { 
          $date = "tgl_" . $i;
          $dataPresence = explode("|", $rp->$date);

          if($rp->$date != NULL) {
            $statusPresence = $dataPresence[2];
          } else {
            $statusPresence = "";
          }

          if($statusPresence == 'H') {
             $totalPresence += 1;
             $color = "white";
          }

          if($statusPresence == 'I') {
            $totalAbsen += 1;
            $color = "#ffbb00";
          }

          if($statusPresence == 'S') {
            $totalSakit += 1;
             $color = "#34a1eb";
          }

          if(empty($statusPresence)) {
            $totalAlpa += 1;
            $color = "red";
          } else {
            $color = "";
          }
      ?>
      <td style="background-color: {{ $color }}">            
        {{ $statusPresence }}
      </td>
      <?php
      }
      ?>
      <td>
        {{ !empty($totalPresence) ? $totalPresence : "" }}
      </td>
      <td>
        {{ !empty($totalAbsen) ? $totalAbsen : "" }}
      </td>
      <td>
        {{ !empty($totalSakit) ? $totalSakit : "" }}
      </td>
      <td>
        {{ !empty($totalAlpa) ? $totalAlpa : "" }}
      </td>
    </tr>
    @endforeach
    </table>

    <table width="100%" style="margin-top: 100px">
      <tr>
        <td style="text-align: right">Gorontalo, {{ date('d-m-Y') }}</td>
      </tr>
      <tr>
        <td style="text-align: right; vertical-align:bottom" height="100px">
          <u>Name</u><br>
          <i><b>Jabatan</b></i>
        </td>
      </tr>
    </table>

  </section>

</body>

</html>