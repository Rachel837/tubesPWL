@extends('organizer.layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title">Selamat datang di Panel Penata Acara!</h5>
                <p class="card-text text-muted">
                    Dari sini, Anda dapat mengelola semua acara, melacak pendaftaran, dan mengatur detail acara yang akan datang.
                </p>
                <div class="row mt-4">
                    <div class="col-md-4 mb-3">
                        <div class="card bg-primary text-white h-100 border-0">
                            <div class="card-body">
                                <h6 class="card-title"><i class="bi bi-calendar-check"></i> Kelola Acara</h6>
                                <p class="card-text">Pusat kontrol untuk buat, ubah, dan hapus data acara.</p>
                                <a href="{{ route('organizer.events.index') }}" class="btn btn-light btn-sm mt-2">Masuk ke Acara</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
