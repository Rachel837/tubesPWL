@extends('organizer.layouts.app')

@section('title', 'Analisis Performa Acara')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-lg-10 mx-auto">
            <form action="{{ url()->current() }}" method="GET" class="d-flex align-items-center bg-white p-3 rounded shadow-sm">
                <label for="event_id" class="me-3 fw-bold mb-0">Filter Acara:</label>
                <select name="event_id" id="event_id" class="form-select w-auto" onchange="this.form.submit()">
                    <option value="all" {{ $selectedEventId === 'all' ? 'selected' : '' }}>Semua Acara</option>
                    @foreach($allEvents as $evt)
                        <option value="{{ $evt->idevent }}" {{ (string)$selectedEventId === (string)$evt->idevent ? 'selected' : '' }}>
                            {{ $evt->nama_event }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-lg-10 mx-auto mb-4">
            <div class="card shadow border-0 h-100 rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h4 class="fw-bold mb-0 text-center"><i class="bi bi-star-fill text-warning"></i> Detail Performa Acara</h4>
                </div>
                <div class="card-body p-4">
                    <div class="list-group list-group-flush mt-3">
                        @forelse($events as $event)
                            <div class="list-group-item px-3 py-4 border rounded shadow-sm mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0 fw-bold text-dark">{{ $event->nama_event }}</h5>
                                    <span class="badge bg-primary rounded-pill fs-6">{{ $event->performance }}% Terjual</span>
                                </div>
                                <div class="progress w-100 mb-3" style="height: 15px;">
                                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $event->performance }}%" aria-valuenow="{{ $event->performance }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center text-muted">
                                    <div class="fw-medium">
                                        <i class="bi bi-ticket-detailed me-1"></i> Terjual: {{ $event->terjual }} Tiket
                                    </div>
                                    <div class="fw-medium">
                                        <i class="bi bi-info-circle me-1"></i> Status: <span class="text-dark">{{ ucfirst($event->status) }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="bi bi-calendar-x display-1 text-muted opacity-50"></i>
                                <h5 class="mt-3 text-muted">Belum ada acara yang tersedia.</h5>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
