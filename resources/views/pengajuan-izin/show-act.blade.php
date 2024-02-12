<ul class="action-button-list">
    <li>
        @if ($dataIzin->status == 'I')
        <a href="pengajuan-izin/absen/{{ $dataIzin->id }}/edit" class="btn btn-list text-primary">
            <span>
                <ion-icon name="create-outline"></ion-icon>
                Edit Izin Absen
            </span>
        </a>
        @elseif($dataIzin->status == 'S')
        <a href="pengajuan-izin/sakit/{{ $dataIzin->id }}/edit" class="btn btn-list text-primary">
            <span>
                <ion-icon name="create-outline"></ion-icon>
                Edit Izin Sakit
            </span>
        </a>
        @endif
    </li>
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
            $("#hapus-pengajuan").attr("href", '/pengajuan-izin/' + '{{ $dataIzin->id }}/delete');
        });
    });
</script>