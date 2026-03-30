@extends('layouts.master')
@section('content')
    <div class="text-center mb-4 text-light">
        <h2 class="h4 fw-bold">Selamat Datang Kembali</h2>
        <p class="text-white-50">Silakan login untuk melanjutkan ke dashboard.</p>
    </div>

    <!-- Session Status -->


    <form method="POST" action="{{ route('login') }}" class="px-3 pb-3">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label text-light">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="form-control bg-dark text-white border-secondary @error('email') is-invalid @enderror" placeholder="masukan email anda">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label text-light">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" class="form-control bg-dark text-white border-secondary @error('password') is-invalid @enderror" placeholder="masukan password anda">
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="remember" id="remember_me" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label text-white" for="remember_me">{{ __('Remember me') }}</label>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            @if (Route::has('password.request'))
                <a class="text-decoration-none text-info" href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
            @endif

            <button type="submit" class="btn btn-primary px-4">{{ __('Log in') }}</button>
        </div>

        <div class="text-center text-muted small">
            Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
        </div>
    </form>
    @endsection