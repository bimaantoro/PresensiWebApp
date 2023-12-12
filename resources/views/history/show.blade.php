@if ($history->isEmpty())
    <div class="alert alert-warning">
        <p>Data tidak tersedia</p>
    </div>
@endif
@foreach ($history as $h)
<ul class="listview image-listview">
    <li>
        <div class="item">
            <img src="{{ asset('storage/uploads/presence/' . $h->photo_in) }}" alt="image" class="image">
            <div class="in">
                <div>
                    <b>{{ date('d-m-Y', strtotime($h->presence_at)) }}</b><br>
                </div>
                <span class="badge {{ $h->check_in < '07:00' ? 'bg-success' : 'bg-danger' }}">
                    Masuk: {{ $h->check_in }}
                </span>
                <span class="badge bg-danger">Keluar: {{ $h->check_out }}</span>
            </div>
        </div>
    </li>
</ul>
@endforeach