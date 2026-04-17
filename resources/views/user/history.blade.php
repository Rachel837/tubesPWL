@extends('user.layouts.app')

@section('title', 'Riwayat Event Saya')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h2 class="font-weight-bold">Riwayat Event & Tiket</h2>
        <p class="text-muted">Daftar semua event yang pernah Anda ikuti dan tiket Anda.</p>
    </div>
</div>

<div class="row">
    @forelse($registrations as $reg)
        @php
            $event = $reg->tiket->eventDetail->event;
        @endphp
        <div class="col-12 mb-4">
            <div class="card overflow-hidden shadow-sm">
                <div class="row no-gutters">
                    <div class="col-md-3">
                        @if($event->banner)
                            <img src="{{ Storage::url($event->banner) }}" class="card-img h-100" style="object-fit: cover;" alt="Banner">
                        @else
                            <img src="{{ asset('assets/img/blog/single_blog_1.png') }}" class="card-img h-100" style="object-fit: cover;" alt="Banner Default">
                        @endif
                    </div>
                    <div class="col-md-6 border-right">
                        <div class="card-body">
                            <h4 class="card-title font-weight-bold text-white">{{ $event->nama_event }}</h4>
                            <div class="mb-3">
                                @if($reg->status == 'selesai')
                                    <span class="badge badge-success px-3 py-2">Terverifikasi</span>
                                @elseif($reg->status == 'menunggu')
                                    <span class="badge badge-warning px-3 py-2 text-dark">Menunggu Verifikasi</span>
                                @else
                                    <span class="badge badge-danger px-3 py-2">Ditolak</span>
                                @endif
                            </div>
                            <p class="mb-1 text-muted small"><i class="ti-ticket mr-2"></i>Jenis Tiket: <strong>{{ $reg->tiket->jenis_tiket }}</strong></p>
                            <p class="mb-1 text-muted small"><i class="ti-calendar mr-2"></i>Tanggal: {{ \Carbon\Carbon::parse($event->date_start)->format('d M Y') }}</p>
                            <p class="mb-3 text-muted small"><i class="ti-location-pin mr-2"></i>Lokasi: {{ $event->location }}</p>
                            
                            @if($reg->payment && $reg->payment->payment_proof)
                                <div class="mt-3">
                                    <p class="small text-muted mb-1">Bukti Pembayaran:</p>
                                    <a href="{{ Storage::url($reg->payment->payment_proof) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                        <i class="ti-image mr-1"></i> Lihat Bukti
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3 d-flex flex-column justify-content-center align-items-center p-4 bg-white">
                        @if($reg->status == 'selesai' && $reg->qr_code)
                            <div class="p-2 border rounded bg-white">
                                {!! QrCode::size(140)->generate($reg->qr_code) !!}
                            </div>
                            <p class="mt-2 text-dark font-weight-bold small">QR Tiket Anda</p>
                            <small class="text-muted">Scan saat masuk venue</small>
                        @elseif($reg->status == 'menunggu')
                            <div class="text-center p-3">
                                <i class="ti-timer text-warning" style="font-size: 40px;"></i>
                                <p class="mt-2 small font-weight-bold" style="color: black !important;">Menunggu Verifikasi</p>
                                <small class="d-block" style="color: black !important;">Admin sedang mengecek bukti bayar Anda</small>
                            </div>
                        @else
                            <div class="text-center p-3">
                                <i class="ti-close text-danger" style="font-size: 40px;"></i>
                                <p class="mt-2 text-dark small font-weight-bold">Pendaftaran Ditolak</p>
                                <small class="text-muted">Maaf, bukti bayar tidak valid.</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <div class="card p-5">
                <i class="ti-face-sad mb-3" style="font-size: 60px; color: #94a3b8;"></i>
                <h4 class="text-muted">Belum ada riwayat event.</h4>
                <p class="mb-4">Ayo jelajahi event menarik dan amankan tiketmu!</p>
                <div>
                    <a href="{{ route('user.home') }}" class="btn btn-primary px-4 py-2">Lihat Event</a>
                </div>
            </div>
        </div>
    @endforelse
</div>
@endsection
