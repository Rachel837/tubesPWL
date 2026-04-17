@extends('admin.layouts.app')

@section('title', 'Ubah Acara')

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.events.update', $event->idevent) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nama_event" class="form-label">Nama Acara</label>
                    <input type="text" class="form-control @error('nama_event') is-invalid @enderror" id="nama_event" name="nama_event" value="{{ old('nama_event', $event->nama_event) }}" required>
                </div>
                <div class="col-md-6">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select class="form-select @error('kategori_id') is-invalid @enderror" id="kategori_id" name="kategori_id" required>
                        <option value="" disabled>Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('kategori_id', $event->kategori_id) == $category->id ? 'selected' : '' }}>{{ $category->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="date_start" class="form-label">Tanggal Mulai</label>
                    <input type="datetime-local" class="form-control @error('date_start') is-invalid @enderror" id="date_start" name="date_start" value="{{ old('date_start', date('Y-m-d\TH:i', strtotime($event->date_start))) }}" required>
                </div>
                <div class="col-md-6">
                    <label for="date_end" class="form-label">Tanggal Selesai</label>
                    <input type="datetime-local" class="form-control @error('date_end') is-invalid @enderror" id="date_end" name="date_end" value="{{ old('date_end', date('Y-m-d\TH:i', strtotime($event->date_end))) }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="location" class="form-label">Lokasi</label>
                    <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $event->location) }}" required>
                </div>
                <div class="col-md-3">
                    <label for="max_participant" class="form-label">Maksimal Peserta</label>
                    <input type="number" class="form-control @error('max_participant') is-invalid @enderror" id="max_participant" name="max_participant" value="{{ old('max_participant', $event->max_participant) }}" min="1" required>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="aktif" {{ old('status', $event->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak aktif" {{ old('status', $event->status) == 'tidak aktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="koordinator" class="form-label">Koordinator</label>
                <select class="form-select @error('koordinator') is-invalid @enderror" id="koordinator" name="koordinator" required>
                    @foreach ($coordinators as $coordinator)
                        <option value="{{ $coordinator->id }}"
                            {{ old('koordinator', $event->koordinator) == $coordinator->id ? 'selected' : '' }}>
                            {{ $coordinator->name }}
                        </option>
                    @endforeach
                </select>
                @error('koordinator')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $event->deskripsi) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label" for="banner">Ganti Banner Acara (Opsional)</label>
                <input type="file" class="form-control @error('banner') is-invalid @enderror" id="banner" name="banner">
                @if($event->banner)
                    <div class="mt-2">
                        <small class="text-muted">Banner saat ini:</small><br>
                        <img src="{{asset("storage/".$event->banner) }}" alt="Banner" style="height: 100px; object-fit: cover;" class="rounded">
                    </div>
                @endif
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Perbarui Acara</button>
            </div>
        </form>
    </div>
</div>
@endsection
