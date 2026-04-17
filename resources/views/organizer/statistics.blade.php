@extends('organizer.layouts.app')

@section('title', 'Statistika Penjualan')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6 mx-auto">
            <form action="{{ url()->current() }}" method="GET" class="d-flex align-items-center bg-white p-3 rounded shadow-sm">
                <label for="event_id" class="me-3 fw-bold mb-0">Filter Acara:</label>
                <select name="event_id" id="event_id" class="form-select" onchange="this.form.submit()">
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
        <div class="col-md-6 mb-4 mx-auto">
            <div class="card shadow border-0 bg-primary text-white h-100 rounded-4">
                <div class="card-body py-5 text-center">
                    <i class="bi bi-ticket-perforated display-1 opacity-50 mb-3 d-block"></i>
                    <h4 class="card-title fw-light mb-3">Total Penjualan Tiket Keseluruhan</h4>
                    <h1 class="fw-bold mb-0 display-4">{{ number_format($totalSales, 0, ',', '.') }} Tiket</h1>
                    <p class="mt-4 mb-0 opacity-75">Tiket dengan status Berhasil dan Digunakan</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
