@extends('admin.layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary me-3">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <div>
                <h5 class="mb-0">Tambah Kategori Baru</h5>
                <p class="text-muted mb-0">Buat klasifikasi baru untuk acara-acara Anda.</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="nama_kategori" class="form-label fw-bold">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori') }}" placeholder="Misal: Konser Musik, Seminar, dll." required>
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="form-label fw-bold">Deskripsi Kategori</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4" placeholder="Jelaskan secara singkat jenis acara dalam kategori ini...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="reset" class="btn btn-light"><i class="bi bi-arrow-counterclockwise"></i> Reset</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mt-4 mt-lg-0">
        <div class="card bg-light border-0">
            <div class="card-body">
                <h6 class="fw-bold"><i class="bi bi-info-circle text-primary me-2"></i> Informasi Kategori</h6>
                <p class="text-muted small">
                    Kategori membantu peserta dan pengelola menemukan acara dengan lebih mudah. Nama kategori akan muncul dan dapat dipilih saat Anda membuat acara baru.
                </p>
                <hr>
                <ul class="text-muted small mb-0 ps-3">
                    <li>Gunakan nama yang jelas dan singkat.</li>
                    <li>Deskripsi adalah opsional namun bermanfaat untuk pelaporan.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
