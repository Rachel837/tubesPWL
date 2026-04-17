@extends('organizer.layouts.app')

@section('title', 'Grafik Transaksi')

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
                    <h4 class="fw-bold mb-0 text-center"><i class="bi bi-graph-up text-primary"></i> Grafik Transaksi (7 Hari Terakhir)</h4>
                </div>
                <div class="card-body p-4">
                    <div style="height: 400px;">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'Tiket Terjual',
                    data: {!! json_encode($data) !!},
                    backgroundColor: 'rgba(13, 110, 253, 0.2)',
                    borderColor: 'rgba(13, 110, 253, 1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: 'rgba(13, 110, 253, 1)',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, font: {size: 14} }
                    },
                    x: {
                        ticks: { font: {size: 14} }
                    }
                },
                plugins: {
                    legend: { display: true, position: 'top' },
                    tooltip: {
                        bodyFont: {size: 14},
                        titleFont: {size: 16}
                    }
                }
            }
        });
    });
</script>
@endpush
