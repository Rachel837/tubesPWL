@extends('organizer.layouts.app')

@section('title', 'Total Pendapatan')

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
            <div class="card shadow border-0 bg-success text-white h-100 rounded-4">
                <div class="card-body py-5 text-center">
                    <i class="bi bi-wallet2 display-1 opacity-50 mb-3 d-block"></i>
                    <h4 class="card-title fw-light mb-3">Total Pendapatan Keseluruhan</h4>
                    <h1 class="fw-bold mb-0 display-4">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h1>
                    <p class="mt-4 mb-0 opacity-75">Berdasarkan tiket dengan status Berhasil dan Digunakan</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
