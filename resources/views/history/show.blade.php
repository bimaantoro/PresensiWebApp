@if ($history->isEmpty())
    <div class="alert alert-warning">
        <p>Data tidak tersedia</p>
    </div>
@endif
@foreach ($history as $h)
@if ($h->presence_status == 'H')
<div class="card mb-1">
    <div class="card-body">
        <div class="history-content">
            <div class="icon-presence">
                <ion-icon name="finger-print-outline" style="font-size: 48px;" class="text-success"></ion-icon>
            </div>
            <div class="data-presence">
                <h3 style="margin: 0px !important; line-height: 3px">{{ date('d-m-Y', strtotime($h->presence_at)) }}</h3>
                <span>
                    {!! $h->check_in != null ? date('H:i', strtotime($h->check_in)) : '<span class="text-danger"> Belum Presensi</span>' !!}
                </span>
                <span>
                    {!! $h->check_out != null ? "- " . date('H:i', strtotime($h->check_out)) : '<span class="text-danger">- Belum Presensi</span>' !!}
                </span>
            </div>
        </div>
    </div>
</div>
@elseif($h->presence_status == 'I')
<div class="card mb-1">
    <div class="card-body">
        <div class="history-content">
            <div class="icon-presence">
                <ion-icon name="calendar-outline" style="font-size: 48px;" class="text-primary"></ion-icon>
            </div>
            <div class="data-presence">
                <h3 style="line-height: 3px">Izin - {{ $h->kode_izin }}</h3>
                <h4 style="margin: 0px !important">{{ date('d-m-Y', strtotime($h->presence_at)) }}</h4>
                <span>
                   {{ $h->keterangan_izin }}
                </span>
            </div>
        </div>
    </div>
</div>
@elseif($h->presence_status == 'S')
<div class="card mb-1">
    <div class="card-body">
        <div class="history-content">
            <div class="icon-presence">
                <ion-icon name="medkit-outline" style="font-size: 48px;" class="text-danger"></ion-icon>
            </div>
            <div class="data-presence">
                <h3 style="line-height: 3px">Sakit - {{ $h->kode_izin }}</h3>
                <h4 style="margin: 0px !important">{{ date('d-m-Y', strtotime($h->presence_at)) }}</h4>
                <span>
                   {{ $h->keterangan_izin }}
                </span>
                <br>
                @if (!empty($d->file_surat_dokter))
                    <span style="color: blue">
                        <ion-icon name="document-attach-outline"></ion-icon>
                        Lihat Surat Izin Dokter
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
@endforeach