<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Direktur - KOPINETGO</title>
    <!-- CSS files -->
    <link href="{{ asset('assets/css/inc/tabler/tabler.min.css?1692870487') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css/inc/tabler/tabler-flags.min.css?1692870487') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css/inc/tabler/tabler-payments.min.css?1692870487') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css/inc/tabler/tabler-vendors.min.css?1692870487') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="icon" type="image/png"  href="{{ asset('assets/img/favicon.ico') }}" sizes="32x32">
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body>
    <div class="page">
      <!-- Navbar -->
      @include('partials.manager.navbar')
      <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
              <div class="row g-2 align-items-center">
                  <div class="col">
                      <h2 class="page-title">
                          @yield('title')
                      </h2>
                  </div>
              </div>
          </div>
        </div>
        <!-- Page body -->
        @yield('content')
        
        @include('partials.manager.footer')
      </div>
    </div>

    @include('partials.script.master-manager')
  </body>
</html>