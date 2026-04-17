@extends('organizer.layouts.app')

@section('title', 'Manajemen Acara')

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Acara</h5>
        <a href="{{ route('organizer.events.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Acara
        </a>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3">Nama Acara</th>
                        <th class="py-3">Tanggal Mulai</th>
                        <th class="py-3">Tanggal Selesai</th>
                        <th class="py-3">Lokasi</th>
                        <th class="py-3">Status</th>
                        <th class="px-4 py-3 text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                    <tr>
                        <td class="px-4 py-3 fw-medium">{{ $event->nama_event }}</td>
                        <td class="py-3">{{ \Carbon\Carbon::parse($event->date_start)->translatedFormat('d F Y') }}</td>
                        <td class="py-3">{{ \Carbon\Carbon::parse($event->date_end)->translatedFormat('d F Y') }}</td>
                        <td class="py-3">{{ $event->location }}</td>
                        <td class="py-3">
                            @if($event->status == 'active')
                                <span class="badge bg-success">Aktif</span>
                            @elseif($event->status == 'inactive')
                                <span class="badge bg-danger">Nonaktif</span>
                            @else
                                <span class="badge bg-secondary">{{ $event->status }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-end">
                            <div class="btn-group" role="group">
                                <a href="{{ route('organizer.events.show', $event->idevent) }}" class="btn btn-sm btn-outline-info" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('organizer.events.edit', $event->idevent) }}" class="btn btn-sm btn-outline-primary" title="Ubah">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('organizer.events.destroy', $event->idevent) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus acara ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted"> Belum ada data acara yang dibuat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($events->hasPages())
    <div class="card-footer bg-white py-3">
        {{ $events->links() }}
    </div>
    @endif
</div>
@endsection
