@foreach ($presence as $p)

@if ($p->presence_status == 'H')
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $p->user_id }}</td>
    <td>{{ $p->nama_lengkap }}</td>
    <td>{{ $p->instansi }}</td>
    <td>
        <div class="d-flex py-1 align-items-center">
            <img src="{{ asset('storage/uploads/presence/' . $p->photo_in) }}" alt="" class="avatar me-2">
            <div class="flex-fill">
                <div class="font-weight-medium">{{ $p->check_in }}</div>
            </div>
        </div>
    </td>
    <td>
        <div class="d-flex py-1 align-items-center">
            @if ($p->check_out != null)
            <img src="{{ asset('storage/uploads/presence/' . $p->photo_out) }}" alt="" class="avatar me-2">
            @endif
            <div class="flex-fill">
                <div class="font-weight-medium">{!! $p->check_out != null ? $p->check_out : '<span class="badge bg-danger text-light">Belum Presensi</span>' !!}</div>
            </div>
        </div>
    </td>
    <td>
        @if ($p->check_in > '07.00')
            <span class="badge bg-danger text-light">Terlambat</span>
        @else
            <span class="badge bg-success text-light">Tepat waktu</span>
        @endif
    </td>
    <td>
        <a href="#" class="btn btn-primary show-location" id="{{ $p->id  }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-pin-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18.364 4.636a9 9 0 0 1 .203 12.519l-.203 .21l-4.243 4.242a3 3 0 0 1 -4.097 .135l-.144 -.135l-4.244 -4.243a9 9 0 0 1 12.728 -12.728zm-6.364 3.364a3 3 0 1 0 0 6a3 3 0 0 0 0 -6z" stroke-width="0" fill="currentColor" /></svg>
            Lokasi
        </a>
    </td>
</tr>
@else
<tr>
    
    <td>{{ $loop->iteration }}</td>
    <td>{{ $p->user_id }}</td>
    <td>{{ $p->nama_lengkap }}</td>
    <td>{{ $p->instansi }}</td>
    <td>-</td>
    <td>-</td>
    <td>
        @if ($p->status_presence == 'I')
            <span class="badge bg-warning">Izin</span>
        @elseif($p->status_presence == 'S')
        <span class="badge bg-info">Sakit</span>      
        @endif
    </td>
</tr>

@endif
@endforeach

<script>
    $(function() {
        $(".show-location").click(function(e) {
            const id = $(this).attr("id");
            $.ajax({
                type: 'POST',
                url: '/admin/presence/show-map',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                success: (response) => {
                    $("#load-map").html(response);
                }
            });
            $("#modal-show-location").modal("show");
        });
    });
</script>