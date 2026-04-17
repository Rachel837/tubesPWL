@extends('admin.layouts.app')

@section('title', 'Dashboard Utama')

@section('content')
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0 bg-primary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title fw-bold">Total Pengguna</h5>
                    <i class="bi bi-people fs-2 opacity-50"></i>
                </div>
                <h2 class="display-5 fw-bold">{{ $totalUsers ?? 0 }}</h2>
                <p class="card-text mb-0 mt-3 small opacity-75">
                    Jumlah total pengguna terdaftar
                </p>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="{{ route('admin.users.index') }}" class="text-white text-decoration-none d-flex align-items-center small">
                    Kelola Pengguna <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-8 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h5 class="card-title fw-bold text-dark mb-3">Selamat Datang di Panel Admin</h5>
                <p class="card-text text-muted">
                    Gunakan menu di sebelah kiri untuk mengelola berbagai data sistem Anda. Saat ini Anda dapat mengelola data pengguna untuk membuat, mengubah, atau menghapus pengguna dari sistem.
                </p>
                <div class="alert alert-info border-0 mt-4 d-flex align-items-center">
                    <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                    <div>
                        <strong>Tip:</strong> Pastikan Anda selalu menjaga kerahasiaan kata sandi pengguna saat melakukan pengelolaan.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
