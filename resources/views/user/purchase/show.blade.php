@extends('user.layouts.app')

@section('title', 'Beli Tiket: ' . $event->nama_event)

@section('content')
<div class="container py-5 mt-5">
    
    @if(session('success'))
        <div class="alert alert-success mt-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning mt-4">
            {{ session('warning') }}
        </div>
    @endif

    <form action="{{ route('purchase.process', $event->idevent) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row gx-5">
            <div class="col-lg-8">
                @if($event->banner)
                    <img src="{{ Storage::url($event->banner) }}" alt="{{ $event->nama_event }}" class="img-fluid rounded mb-4" style="width: 100%; max-height: 400px; object-fit: cover;">
                @endif
                <h1 class="font-weight-bold mb-3 text-white">{{ $event->nama_event }}</h1>
                <p class="text-muted"><i class="fa fa-map-marker-alt text-primary"></i> {{ $event->location }}</p>
                <p class="text-muted"><i class="fa fa-calendar-alt text-primary"></i> {{ \Carbon\Carbon::parse($event->date_start)->translatedFormat('d F Y H:i') }} - {{ \Carbon\Carbon::parse($event->date_end)->translatedFormat('d F Y H:i') }}</p>

                <hr>
                
                <h4 class="mb-3 text-white">Deskripsi Acara</h4>
                <div class="text-muted">
                    {!! nl2br(e($event->deskripsi ?: 'Tidak ada deskripsi.')) !!}
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4 text-white">Pilih Tiket</h5>
                        
                        <div class="mb-4">
                            @php
                                $hasAvailableTickets = false;
                            @endphp
                            @forelse($tikets as $tiket)
                                @if($tiket->kuota > 0)
                                    @php $hasAvailableTickets = true; @endphp
                                @endif
                                <div class="form-check border rounded p-3 mb-2 ticket-card {{ $tiket->kuota == 0 ? 'opacity-50 text-muted' : '' }}">
                                    <!-- Normal Payment Selection for available tickets -->
                                    <input class="form-check-input ms-1 mt-2" type="radio" name="tiket_id" id="tiket_{{ $tiket->idtiket }}" value="{{ $tiket->idtiket }}" {{ $tiket->kuota == 0 ? 'disabled' : '' }} required>
                                    <label class="form-check-label w-100 ps-4 text-white" for="tiket_{{ $tiket->idtiket }}">
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-bold">{{ $tiket->jenis_tiket }}</span>
                                            <span>Rp {{ number_format($tiket->harga, 0, ',', '.') }}</span>
                                        </div>
                                        @if($tiket->deskripsi)
                                        <div class="small text-muted mt-1">{{ $tiket->deskripsi }}</div>
                                        @endif
                                        <div class="mt-2 text-primary small d-flex justify-content-between align-items-center">
                                            @if($tiket->kuota > 0)
                                                <span>Tersisa {{ $tiket->kuota }} tiket</span>
                                            @else
                                                <span class="text-danger">Habis</span>
                                                <!-- Formaction Button for Waiting List -->
                                                <button type="submit" name="tiket_id" value="{{ $tiket->idtiket }}" formaction="{{ route('purchase.waitingList', $event->idevent) }}" formnovalidate class="btn btn-warning btn-sm py-1 px-3 text-dark fw-bold rounded-pill shadow-sm" style="z-index: 2; position: relative;">Join Waiting List</button>
                                            @endif
                                        </div>
                                    </label>
                                </div>
                            @empty
                                <p class="text-muted text-center py-3">Belum ada tiket untuk acara ini.</p>
                            @endforelse
                        </div>

                        @if($hasAvailableTickets)
                        <div class="mb-4">
                            <label for="email" class="form-label text-white">Email Tujuan Pengiriman E-Ticket</label>
                            <input type="email" class="form-control" name="email" id="email" required placeholder="Masukkan email aktif">
                        </div>

                        <button type="button" class="btn btn-primary w-100 py-3 rounded-pill text-white fw-bold shadow-sm" data-toggle="modal" data-target="#paymentModal">
                            Beli Tiket Sekarang
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal di luar card untuk menghindari stacking context issue -->
        <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="background: #1e293b; color: #f8fafc; border: 1px solid rgba(255,255,255,0.1); border-radius: 16px;">
                    <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                        <h5 class="modal-title font-weight-bold" id="paymentModalLabel">Konfirmasi Pembayaran</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <p class="mb-4">Silakan unggah foto atau tangkapan layar bukti transfer pembayaran Anda untuk memverifikasi pesanan ini.</p>
                        <div class="form-group">
                            <label for="payment_proof" class="form-label">Bukti Pembayaran (Gambar)</label>
                            <input type="file" class="form-control" name="payment_proof" id="payment_proof" required accept="image/*">
                            <small class="text-muted mt-2 d-block">Maksimal ukuran file: 2MB (JPG, JPEG, PNG)</small>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.1);">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">Beli & Konfirmasi</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
