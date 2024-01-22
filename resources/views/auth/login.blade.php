@extends('layouts.master-auth')

@section('content')
<div class="login-form mt-1">
    <div class="section">
        <img src="{{ asset('assets/img/login.jpg') }}" alt="image" class="form-image">
    </div>
    <div class="section mt-1">
        <h1>E-Presensi PT. KOPINETGO</h1>
        <h4>Masuk ke akun Anda</h4>
    </div>
    <div class="section mt-1 mb-5">

        @if(session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('authenticate') }}" method="POST">
            @csrf
            <div class="form-group boxed">
                <div class="input-wrapper">
                    <input type="text" name="username" class="form-control" id="username" placeholder="Username" required autofocus>
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
            </div>

            <div class="form-group boxed">
                <div class="input-wrapper">
                    <input type="password" name="password" class="form-control" id="password" placeholder="Kata Sandi" required>
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
            </div>

            <div class="form-group boxed">
                <button type="submit" class="btn btn-primary btn-block btn-lg">Masuk</button>
            </div>

        </form>
    </div>
</div>
@endsection