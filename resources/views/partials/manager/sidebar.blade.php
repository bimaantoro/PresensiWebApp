<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <h1 class="navbar-brand navbar-brand-autodark">
        KOPINETGO
      </h1>
      <div class="collapse navbar-collapse" id="sidebar-menu">
        <ul class="navbar-nav pt-lg-3">
          <li class="nav-item dropdown {{ request()->is(['manager/presence-employee/report', 'manager/presence-employee/recap']) ? 'active' : '' }}">
            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="{{ request()->is(['manager/presence-employee/report', 'manager/presence-employee/recap']) ? 'true' : '' }}">
              <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-description" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M9 17h6" /><path d="M9 13h6" /></svg>
              </span>
              <span class="nav-link-title">
                Laporan
              </span>
            </a>
            <div class="dropdown-menu {{ request()->is(['manager/presence-employee/report', 'manager/presence-employee/recap']) ? 'show' : '' }}">
              <div class="dropdown-menu-columns">
                <div class="dropdown-menu-column">
                  <a class="dropdown-item {{ request()->is('manager/presence-employee/report') ? 'active' : '' }}" href="{{ route('report-presence') }}">
                    Presensi
                  </a>
                  <a class="dropdown-item {{ request()->is('manager/presence-employee/recap') ? 'active' : '' }}" href="{{ route('recap-presence') }}">
                    Rekap Presensi
                  </a>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </aside>