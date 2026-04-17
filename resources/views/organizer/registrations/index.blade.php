@extends('organizer.layouts.app')

@section('title', 'Manajemen Registrasi Peserta')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">Daftar Pendaftaran</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Peserta</th>
                        <th>Event & Tiket</th>
                        <th>Bukti Bayar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations as $reg)
                        <tr>
                            <td>#{{ $reg->idregistrations }}</td>
                            <td>
                                <div class="fw-bold">{{ $reg->user->name ?? 'Guest' }}</div>
                                <small class="text-muted">{{ $reg->user->email ?? '-' }}</small>
                            </td>
                            <td>
                                <div class="text-primary fw-bold">{{ $reg->tiket->eventDetail->event->nama_event ?? '-' }}</div>
                                <small class="badge bg-secondary">{{ $reg->tiket->jenis_tiket }}</small>
                            </td>
                            <td>
                                @if($reg->payment && $reg->payment->payment_proof)
                                    <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#proofModal{{ $reg->idregistrations }}">
                                        <i class="bi bi-image"></i> Lihat Bukti
                                    </button>
                                    
                                    <!-- Modal Proof -->
                                    <div class="modal fade" id="proofModal{{ $reg->idregistrations }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Bukti Pembayaran #{{ $reg->idregistrations }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="{{ Storage::url($reg->payment->payment_proof) }}" class="img-fluid rounded" alt="Proof">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted small">Tidak ada bukti</span>
                                @endif
                            </td>
                            <td>
                                @if($reg->status == 'menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($reg->status == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-danger">Gagal</span>
                                @endif
                            </td>
                            <td>
                                @if($reg->status == 'menunggu')
                                    <div class="btn-group">
                                        <form action="{{ route('organizer.registrations.approve', $reg->idregistrations) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm me-1" onclick="return confirm('Setujui pendaftaran ini?')">
                                                <i class="bi bi-check-circle"></i> ACC
                                            </button>
                                        </form>
                                        <form action="{{ route('organizer.registrations.reject', $reg->idregistrations) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tolak pendaftaran ini?')">
                                                <i class="bi bi-x-circle"></i> Tolak
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted small">Tuntas</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">Belum ada data pendaftaran untuk event Anda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
