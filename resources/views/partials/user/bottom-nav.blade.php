<!-- App Bottom Menu -->
<div class="appBottomMenu">
    <a href="{{ route('dashboard') }}" class="item {{ request()->is('dashboard') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="home-outline"></ion-icon>
            <strong>Beranda</strong>
        </div>
    </a>
    <a href="{{ route('pengajuan-izin') }}" class="item {{ request()->is('pengajuan-izin') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="calendar-outline"></ion-icon>
            <strong>Izin</strong>
        </div>
    </a>
    <a href="{{ route('presence.create') }}" class="item">
        <div class="col">
            <div class="action-button large">
                <ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
            </div>
        </div>
    </a>
    <a href="{{ route('history') }}" class="item {{ request()->is('history') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="document-text-outline"></ion-icon>
            <strong>Riwayat</strong>
        </div>
    </a>
    <a href="{{ route('profile') }}" class="item {{ request()->is('profile') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="person-outline"></ion-icon>
            <strong>Profil</strong>
        </div>
    </a>
</div>
<!-- * App Bottom Menu -->