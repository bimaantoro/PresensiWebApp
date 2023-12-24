<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="light">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <h1 class="navbar-brand navbar-brand-autodark">
        ADMIN
      </h1>
      <div class="collapse navbar-collapse" id="sidebar-menu">
        <ul class="navbar-nav pt-lg-3">
          <li class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard-admin') }}" >
              <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l-2 0l9 -9l9 9l-2 0" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
              </span>
              <span class="nav-link-title">
                Home
              </span>
            </a>
          </li>
          <li class="nav-item dropdown {{ request()->is(['admin/employees', 'admin/pengajuan-izin-karyawan']) ? 'active' : '' }}">
            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="{{ request()->is(['admin/employees', 'admin/pengajuan-izin-karyawan']) ? 'active' : '' }}">
              <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-stack-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 4l-8 4l8 4l8 -4l-8 -4" /><path d="M4 12l8 4l8 -4" /><path d="M4 16l8 4l8 -4" /></svg>
              </span>
              <span class="nav-link-title">
                Master Data
              </span>
            </a>
            <div class="dropdown-menu {{ request()->is(['admin/employees', 'admin/pengajuan-izin-karyawan']) ? 'show' : '' }}">
              <div class="dropdown-menu-columns">
                <div class="dropdown-menu-column">
                  <a class="dropdown-item {{ request()->is('admin/employees') ? 'active' : '' }}" href="{{ route('employee-admin') }}">
                    Data Pegawai
                  </a>
                  <a class="dropdown-item {{ request()->is('pengajuan-izin-admin') ? 'active' : '' }}" href="{{ route('pengajuan-izin-admin') }}">
                    Data Izin / Sakit
                  </a>
                </div>
              </div>
            </div>
          </li>
          <li class="nav-item {{ request()->is('admin/presences') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('presence-admin') }}" >
              <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-heart-rate-monitor" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 4m0 1a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1z" /><path d="M7 20h10" /><path d="M9 16v4" /><path d="M15 16v4" /><path d="M7 10h2l2 3l2 -6l1 3h3" /></svg>
              </span>
              <span class="nav-link-title">
                Monitoring Presensi
              </span>
            </a>
          </li>
          {{-- <li class="nav-item dropdown {{ request()->is(['admin/presence/report', 'admin/presence/rekap']) ? 'active' : '' }}">
            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="{{ request()->is(['admin/presence/report', 'admin/presence/rekap']) ? 'true' : '' }}">
              <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-description" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M9 17h6" /><path d="M9 13h6" /></svg>
              </span>
              <span class="nav-link-title">
                Laporan
              </span>
            </a>
            <div class="dropdown-menu {{ request()->is(['admin/presence/report', 'admin/presence/rekap']) ? 'show' : '' }}">
              <div class="dropdown-menu-columns">
                <div class="dropdown-menu-column">
                  <a class="dropdown-item {{ request()->is('admin/presence/report') ? 'active' : '' }}" href="{{ route('report-presence-admin') }}">
                    Presensi
                  </a>
                  <a class="dropdown-item {{ request()->is('admin/presence/rekap') ? 'active' : '' }}" href="{{ route('rekap-presence-admin') }}">
                    Rekap Presensi
                  </a>
                </div>
              </div>
            </div>
          </li> --}}
        </ul>
      </div>
    </div>
  </aside>