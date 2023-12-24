<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="/admin/dashboard" class="app-brand-link">
      <span class="app-brand-text demo menu-text fw-bold ms-2">Admin</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Dashboards -->
    <li class="menu-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
      <a href="{{ route('dashboard-admin') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Dashboards">Dashboards</div>
      </a>
    </li>

    <li class="menu-item {{ request()->is(['admin/employees', 'admin/pengajuan-izin-karyawan']) ? 'open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-layout"></i>
        <div data-i18n="Layouts">Master Data</div>
      </a>

      <ul class="menu-sub">
        <li class="menu-item">
          <a href="layouts-without-menu.html" class="menu-link">
            <div data-i18n="Without menu">Data Pegawai</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="layouts-without-navbar.html" class="menu-link">
            <div data-i18n="Without navbar">Data Izin / Sakit</div>
          </a>
        </li>
      </ul>
    </li>

    <!-- Front Pages -->
    <li class="menu-item">
      <a href="{{ request()->is('admin/presences') ? 'active' : '' }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-store"></i>
        <div data-i18n="Front Pages">Monitoring Presensi</div>
      </a>
    </li>

    <li class="menu-item {{ request()->is(['admin/employees', 'admin/pengajuan-izin-karyawan']) ? 'open' : '' }}">
      <a href="" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-layout"></i>
        <div data-i18n="Layouts">Laporan</div>
      </a>

      <ul class="menu-sub">
        <li class="menu-item">
          <a href="{{ route('report-presence-admin') }}" class="menu-link">
            <div data-i18n="Without menu">Presensi</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{ route('rekap-presence-admin') }}" class="menu-link">
            <div data-i18n="Without navbar">Rekap Presensi</div>
          </a>
        </li>
      </ul>
    </li>
  </ul>
</aside>