@extends('layouts.master-auth')
@section('content')
<div class="authentication-wrapper authentication-basic container-p-y">
  <div class="authentication-inner">
    <!-- Register -->
    <div class="card">
      <div class="card-body">
        <!-- Logo -->
        <div class="app-brand justify-content-center">
          <a href="{{ route('login') }}" class="app-brand-link gap-2">
            <span class="app-brand-logo demo">
              <img src="{{ asset('assets/img/logo-telkom.png') }}" alt="" width="25">
            </span>
            <span class="app-brand-text demo text-body fw-bold">PT. Telkom Witel Gorontalo</span>
          </a>
        </div>
        <!-- /Logo -->
        <h4 class="mb-2">Selamat datang di E-Presensi! 👋</h4>
        <p class="mb-4">Masuk ke akun Anda</p>

        @if (session()->has('error'))
            <div class="alert alert-danger">
              {{ session('error') }}
            </div>
        @endif

        <form id="formAuthentication" class="mb-3" action="{{ route('authenticate') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input
              type="text"
              class="form-control"
              id="username"
              name="username"
              placeholder="Enter your username"
              autofocus />
          </div>
          <div class="mb-3 form-password-toggle">
            <div class="d-flex justify-content-between">
              <label class="form-label" for="password">Password</label>
            </div>
            <div class="input-group input-group-merge">
              <input
                type="password"
                id="password"
                class="form-control"
                name="password"
                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                aria-describedby="password" />
              <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>
          </div>
          <div class="mb-3">
            <button class="btn btn-danger d-grid w-100" type="submit">Masuk</button>
          </div>
        </form>
      </div>
    </div>
    <!-- /Register -->
  </div>
</div>
@endsection