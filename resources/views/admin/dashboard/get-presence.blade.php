@foreach ($presence as $p)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $p->employee_id }}</td>
    <td>{{ $p->fullname }}</td>
    <td>{{ $p->name }} ({{ $p->jam_in }} S.d {{ $p->jam_out }})</td>
    <td>
        <div class="d-flex py-1 align-items-center">
            <img src="{{ asset('storage/uploads/presence/' . $p->photo_in) }}" alt="" class="me-2" width="150">
            <div class="flex-fill">
                <div class="font-weight-medium">{{ $p->check_in }}</div>
            </div>
        </div>
    </td>
    <td>
        <div class="d-flex py-1 align-items-center">
            @if ($p->check_out != null)
            <img src="{{ asset('storage/uploads/presence/' . $p->photo_out) }}" alt="" class="me-2" width="150">
            @endif
            <div class="flex-fill">
                <div class="font-weight-medium">{!! $p->check_out != null ? $p->check_out : '<span class="badge bg-danger text-light">Belum Absen</span>' !!}</div>
            </div>
        </div>
    </td>
    <td>
        @if ($p->check_in > $p->jam_in)
            <span class="badge bg-danger text-light">Terlambat</span>
        @else
            <span class="badge bg-success text-light">Tepat waktu</span>
        @endif
    </td>
    <td>
        <a href="#" class="btn btn-primary show-map" id_map="{{ $p->id  }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-pin-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18.364 4.636a9 9 0 0 1 .203 12.519l-.203 .21l-4.243 4.242a3 3 0 0 1 -4.097 .135l-.144 -.135l-4.244 -4.243a9 9 0 0 1 12.728 -12.728zm-6.364 3.364a3 3 0 1 0 0 6a3 3 0 0 0 0 -6z" stroke-width="0" fill="currentColor" /></svg>
            Lokasi
        </a>
    </td>
</tr>
@endforeach

<script>
    $(function() {
        $(".show-map").click(function(e) {
            const id = $(this).attr("id_map");
            $.ajax({
                type: 'POST',
                url: '/admin/presence/map',
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