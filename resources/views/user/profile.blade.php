@extends('user.layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="container py-5 mt-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="font-weight-bold text-white">Pengaturan Akun</h2>
            <p class="text-muted">Kelola data profil dan keamanan akun Anda di sini.</p>
        </div>
    </div>

    @if(session('status') === 'profile-updated')
        <div class="alert alert-success">Profil berhasil diperbarui.</div>
    @endif

    @if(session('status') === 'password-updated')
        <div class="alert alert-success">Password berhasil diperbarui.</div>
    @endif

    <div class="row">
        <!-- Update Profile Information -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0" style="background: transparent; border: 1px solid rgba(255,255,255,0.1) !important;">
                <div class="card-body p-4 text-white">
                    <h4 class="font-weight-bold border-bottom pb-2 mb-4" style="border-color: rgba(255,255,255,0.1) !important;">Informasi Profil</h4>
                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')
                        
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill fw-bold">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Update Password -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0" style="background: transparent; border: 1px solid rgba(255,255,255,0.1) !important;">
                <div class="card-body p-4 text-white">
                    <h4 class="font-weight-bold border-bottom pb-2 mb-4" style="border-color: rgba(255,255,255,0.1) !important;">Ubah Password</h4>
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')
                        
                        <div class="form-group mb-3">
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <input id="current_password" name="current_password" type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" required>
                            @error('current_password', 'updatePassword') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input id="password" name="password" type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" required>
                            @error('password', 'updatePassword') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill fw-bold">Perbarui Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
