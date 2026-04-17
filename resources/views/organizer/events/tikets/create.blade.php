@extends('organizer.layouts.app')

@section('title', 'Tambah Tiket Acara')

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <a href="{{ route('organizer.events.show', $event->idevent) }}" class="btn btn-outline-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Kembali ke Detail Acara
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

        <h5 class="fw-bold mb-4">Tambah Tiket Baru untuk: {{ $event->nama_event }}</h5>

        <form action="{{ route('organizer.events.tikets.store', $event->idevent) }}" method="POST">
            @csrf
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="jenis_tiket" class="form-label">Jenis Tiket</label>
                    <input type="text" class="form-control" id="jenis_tiket" name="jenis_tiket" value="{{ old('jenis_tiket') }}" placeholder="Contoh: VIP, Reguler" required>
                </div>
                <div class="col-md-6">
                    <label for="harga" class="form-label">Harga (Rp)</label>
                    <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga', '0') }}" min="0" required>
                    <div class="form-text">Isi 0 untuk tiket gratis.</div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="kuota" class="form-label">Kuota / Stok</label>
                    <input type="number" class="form-control" id="kuota" name="kuota" value="{{ old('kuota', '100') }}" min="1" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Tiket (Opsional)</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Simpan Tiket</button>
            </div>
        </form>
    </div>
</div>
@endsection
