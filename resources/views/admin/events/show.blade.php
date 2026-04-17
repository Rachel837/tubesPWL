@extends('admin.layouts.app')

@section('title', 'Detail Acara')

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar
            </a>
            <div>
                <a href="{{ route('admin.events.edit', $event->idevent) }}" class="btn btn-primary">
                    <i class="bi bi-pencil"></i> Ubah Data
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <h3 class="fw-bold mb-3">{{ $event->nama_event }}</h3>
                <div class="mb-4">
                    <span class="badge bg-info text-dark me-2">{{ $event->kategori ?? 'Tidak ada kategori' }}</span>
                    @if($event->status == 'active')
                        <span class="badge bg-success">Aktif</span>
                    @elseif($event->status == 'inactive')
                        <span class="badge bg-danger">Nonaktif</span>
                    @else
                        <span class="badge bg-secondary">{{ $event->status }}</span>
                    @endif
                </div>

                <h5 class="fw-bold mt-4">Deskripsi</h5>
                <p class="text-muted">{{ $event->deskripsi ?: 'Belum ada deskripsi untuk acara ini.' }}</p>
            </div>
            
            <div class="col-md-4">
                <div class="card bg-light border-0">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="bi bi-info-circle"></i> Informasi Kegiatan</h6>
                        
                        <div class="mb-3">
                            <small class="text-muted d-block">Tanggal Pelaksanaan</small>
                            <span class="fw-medium">{{ \Carbon\Carbon::parse($event->date_start)->translatedFormat('d F Y H:i') }} - {{ \Carbon\Carbon::parse($event->date_end)->translatedFormat('d F Y H:i') }}</span>
                        </div>
                        
                        <div class="mb-3">
                            <small class="text-muted d-block">Lokasi</small>
                            <span class="fw-medium">{{ $event->location }}</span>
                        </div>
                        
                        <div class="mb-3">
                            <small class="text-muted d-block">Maksimal Peserta</small>
                            <span class="fw-medium">{{ $event->max_participant }} Orang</span>
                        </div>
                        
                        <div class="mb-0">
                            <small class="text-muted d-block">Koordinator</small>
                            <span class="fw-medium">{{ $event->koordinator }}</span>
                        </div>
                    </div>
                </div>
            <div class="col-md-12 mt-5">
                <hr>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold m-0"><i class="bi bi-ticket-perforated"></i> Manajemen Tiket</h5>
                    <a href="{{ route('admin.events.tikets.create', $event->idevent) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Tiket
                    </a>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Jenis Tiket</th>
                                <th>Harga</th>
                                <th>Stok/Kuota</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $eventDetail = $event->eventDetails()->first();
                                $tikets = $eventDetail ? $eventDetail->tikets : [];
                            @endphp
                            
                            @forelse($tikets as $tiket)
                                <tr>
                                    <td class="fw-bold">{{ $tiket->jenis_tiket }}</td>
                                    <td>Rp {{ number_format($tiket->harga, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge {{ $tiket->kuota > 0 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $tiket->kuota }} Tersedia
                                        </span>
                                    </td>
                                    <td>{{ $tiket->deskripsi ?: '-' }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.events.tikets.edit', [$event->idevent, $tiket->idtiket]) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i> Edit</a>
                                            <form action="{{ route('admin.events.tikets.destroy', [$event->idevent, $tiket->idtiket]) }}" method="POST" onsubmit="return confirm('Hapus tiket ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada tiket untuk acara ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
