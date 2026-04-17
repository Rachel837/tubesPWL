@extends('user.layouts.app')
@section('title', 'Jelajahi Event')
@section('content')
<div class="row">
    <div class="col-12 text-center mb-5">
        <h2 class="font-weight-bold text-white">Event Mendatang</h2>
        <p class="text-muted">Temukan berbagai acara menarik dan amankan tiket Anda sekarang.</p>
    </div>
</div>

<div class="row">
    @forelse($events as $event)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card event-card h-100">
                @if($event->banner)
                    <img src="{{ Storage::url($event->banner) }}" alt="Banner Event">
                @else
                    <img src="{{ asset('assets/img/blog/single_blog_1.png') }}" alt="Banner Default">
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title font-weight-normal">{{ $event->nama_event }}</h5>
                    <p class="text-muted small mb-2">
                        <i class="ti-calendar mr-1"></i> {{ \Carbon\Carbon::parse($event->date_start)->format('d M Y') }} - {{ \Carbon\Carbon::parse($event->date_end)->format('d M Y') }}
                    </p>
                    <p class="text-muted small mb-3">
                        <i class="ti-location-pin mr-1"></i> {{ $event->location }}
                    </p>
                    <p class="card-text flex-grow-1">
                        {{ Str::limit($event->deskripsi, 80) }}
                    </p>
                    <div class="mt-auto">
                        <a href="{{ route('purchase.show', $event->idevent) }}" class="btn btn-primary btn-block text-white" style="background-color: #ff3c00; border: none; padding: 10px 0;">Beli Tiket</a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center">
            <div class="alert alert-info">
                Saat ini belum ada event yang tersedia. Silakan kembali lagi nanti!
            </div>
        </div>
    @endforelse
</div>
@endsection
