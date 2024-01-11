<ul class="action-button-list">
    @if ($dataIzin->status == 'i')
        <li>
            <a href="pengajuan-izin/absen/{{ $dataIzin->kode_izin }}/edit" class="btn btn-list text-primary">
                <span>
                    <ion-icon name="create-outline"></ion-icon>
                    Edit Izin Absen
                </span>
            </a>
        </li>
    @elseif($dataIzin->status == 's')
        <li>
            <a href="pengajuan-izin/sakit/{{ $dataIzin->kode_izin }}/edit" class="btn btn-list text-primary">
                <span>
                    <ion-icon name="create-outline"></ion-icon>
                    Edit Izin Sakit
                </span>
            </a>
        </li>
    @endif

    <li>
        <a href="#" id="delete-btn" class="btn btn-list text-danger" data-dismiss="modal" data-toggle="modal" data-target="#deleteConfirm">
            <span>
                <ion-icon name="trash-outline"></ion-icon>
                Hapus
            </span>
        </a>
    </li>
</ul>

<script>
    $(function() {
        $("#delete-btn").click(function(e) {
            $("#hapus-pengajuan").attr("href", '/pengajuan-izin/' + '{{ $dataIzin->kode_izin }}/delete');
        });
    });
</script>