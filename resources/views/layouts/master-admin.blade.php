<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Dashboard - Tabler - Premium and Open Source dashboard template with responsive and high quality UI.</title>
    <!-- CSS files -->
    <link href="{{ asset('assets/css/inc/tabler/tabler.min.css?1692870487') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css/inc/tabler/tabler-flags.min.css?1692870487') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css/inc/tabler/tabler-payments.min.css?1692870487') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css/inc/tabler/tabler-vendors.min.css?1692870487') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css/inc/tabler/demo.min.css?1692870487') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    @stack('monitor-presence-style')
    @stack('presence-map-style')
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
    <script src="{{ asset('assets/js/lib/demo-theme.min.js?1692870487') }}"></script>
    <div class="page">
      <!-- Sidebar -->
      @include('partials.admin-2.sidebar')
      <!-- Navbar -->
      @include('partials.admin-2.header')
      <div class="page-wrapper">
        <!-- Page header -->
        <!-- Page body -->
        @yield('content')
        
        @include('partials.admin-2.footer')
      </div>
    </div>

    @include('partials.script.master-admin')
  </body>
</html>