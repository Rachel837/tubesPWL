@extends('user.layouts.app')

@section('title', 'Waiting List Saya')

@section('content')
<div class="row">
    <div class="col-12 mb-4 mt-5">
        <h2 class="font-weight-bold text-white">Daftar Tunggu (Waiting List)</h2>
        <p class="text-muted">Tiket yang sedang Anda tunggu stoknya. Segera bayar jika tiket ditawarkan kepada Anda.</p>
    </div>
</div>

<div class="row">
    @if(session('success'))
        <div class="col-12 mb-3">
            <div class="alert alert-success mt-4">
                {{ session('success') }}
            </div>
        </div>
    @endif
    @if(session('warning'))
        <div class="col-12 mb-3">
            <div class="alert alert-warning mt-4">
                {{ session('warning') }}
            </div>
        </div>
    @endif

    @forelse($registrations as $reg)
        @php
            $event = $reg->tiket->eventDetail->event;
        @endphp
        <div class="col-12 mb-4">
            <div class="card overflow-hidden shadow-sm" style="background: transparent; border: 1px solid rgba(255,255,255,0.1);">
                <div class="row no-gutters">
                    <div class="col-md-3">
                        @if($event->banner)
                            <img src="{{ Storage::url($event->banner) }}" class="card-img h-100" style="object-fit: cover;" alt="Banner">
                        @else
                            <img src="{{ asset('assets/img/blog/single_blog_1.png') }}" class="card-img h-100" style="object-fit: cover;" alt="Banner Default">
                        @endif
                    </div>
                    <div class="col-md-6 border-right" style="border-color: rgba(255,255,255,0.1) !important;">
                        <div class="card-body">
                            <h4 class="card-title font-weight-bold text-white">{{ $event->nama_event }}</h4>
                            <div class="mb-3">
                                @if($reg->status == 'ditawarkan')
                                    <span class="badge badge-success px-3 py-2 text-dark" style="background:#4ade80;">Tiket Tersedia (Ditawarkan)</span>
                                @elseif($reg->status == 'menunggu')
                                    <span class="badge badge-warning px-3 py-2 text-dark">Dalam Antrean</span>
                                @endif
                            </div>
                            <p class="mb-1 text-muted small"><i class="ti-ticket mr-2"></i>Jenis Tiket: <strong>{{ $reg->tiket->jenis_tiket }}</strong></p>
                            <p class="mb-1 text-muted small"><i class="ti-money mr-2"></i>Harga: <strong>Rp {{ number_format($reg->tiket->harga, 0, ',', '.') }}</strong></p>
                            <p class="mb-1 text-muted small"><i class="ti-calendar mr-2"></i>Tanggal: {{ \Carbon\Carbon::parse($event->date_start)->format('d M Y') }}</p>
                            <p class="mb-3 text-muted small"><i class="ti-location-pin mr-2"></i>Lokasi: {{ $event->location }}</p>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex flex-column justify-content-center align-items-center p-4">
                        @if($reg->status == 'ditawarkan')
                            <div class="text-center p-3 text-white">
                                <i class="ti-check-box text-success mb-2" style="font-size: 40px;"></i>
                                <p class="mt-2 small font-weight-bold">Waktunya Membayar!</p>
                                <small class="text-muted d-block mb-3">Pastikan Anda segera membayar sebelum kedaluwarsa.</small>
                                <button type="button" class="btn btn-primary btn-sm btn-block rounded-pill text-white fw-bold shadow-sm" data-toggle="modal" data-target="#paymentModal{{ $reg->idregistrations }}">
                                    Bayar Sekarang
                                </button>
                            </div>
                        @elseif($reg->status == 'menunggu')
                            <div class="text-center p-3 text-white">
                                <i class="ti-timer text-warning" style="font-size: 40px;"></i>
                                <p class="mt-2 small font-weight-bold">Sedang Menunggu Stok</p>
                                <small class="text-muted d-block">Jika panitia menambah kuota, tiket akan muncul di sini.</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <div class="card p-5" style="background: transparent; border: 1px solid rgba(255,255,255,0.1);">
                <i class="ti-face-sad mb-3" style="font-size: 60px; color: #94a3b8;"></i>
                <h4 class="text-white">Anda tidak berada di waiting list mana pun.</h4>
                <p class="mb-4 text-muted">Ayo jelajahi event menarik dan amankan tiketmu!</p>
                <div>
                    <a href="{{ route('user.home') }}" class="btn btn-primary px-4 py-2">Lihat Event</a>
                </div>
            </div>
        </div>
    @endforelse
</div>

<!-- Modals for waiting list payment -->
@foreach($registrations as $reg)
    @if($reg->status == 'ditawarkan')
        <form action="{{ route('purchase.payOffered', $reg->idregistrations) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal fade" id="paymentModal{{ $reg->idregistrations }}" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 9999;">
                <div class="modal-dialog modal-dialog-centered" role="document" style="z-index: 10000;">
                    <div class="modal-content" style="background: #1e293b; color: #f8fafc; border: 1px solid rgba(255,255,255,0.1); border-radius: 16px;">
                        <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                            <h5 class="modal-title font-weight-bold">Konfirmasi Pembayaran</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body p-4 text-left">
                            <p class="mb-4">Silakan unggah foto atau tangkapan layar bukti transfer pembayaran Anda sebesar <strong>Rp {{ number_format($reg->tiket->harga, 0, ',', '.') }}</strong>.</p>
                            
                            <div class="form-group mb-3">
                                <label for="email_{{ $reg->idregistrations }}" class="form-label">Email E-Ticket</label>
                                <input type="email" class="form-control" name="email" id="email_{{ $reg->idregistrations }}" required placeholder="Masukkan email untuk menerima tiket">
                            </div>

                            <div class="form-group">
                                <label for="payment_proof_{{ $reg->idregistrations }}" class="form-label">Bukti Pembayaran</label>
                                <input type="file" class="form-control" name="payment_proof" id="payment_proof_{{ $reg->idregistrations }}" required accept="image/*">
                                <small class="text-muted mt-2 d-block">Maks 2MB (JPG, PNG)</small>
                            </div>
                        </div>
                        <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.1);">
                            <button type="button" class="btn btn-dark" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary px-4">Konfirmasi Bayar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif
@endforeach

@endsection
