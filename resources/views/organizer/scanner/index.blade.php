@extends('organizer.layouts.app')

@section('title', 'Scan Tiket Peserta')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0 overflow-hidden" style="border-radius: 20px;">
                <div class="card-header bg-primary text-white py-3 border-0">
                    <h5 class="mb-0 fw-bold text-center"><i class="bi bi-camera-fill me-2"></i> Scanner Kamera</h5>
                </div>
                <div class="card-body p-0">
                    <!-- Scanner Container -->
                    <div id="reader" style="width: 100%; border: none; background: #000;"></div>
                    
                    <div id="scanner-result" class="p-4" style="display: none;">
                        <div id="result-alert" class="alert mb-4 border-0 shadow-sm" style="border-radius: 12px;"></div>
                        <div id="participant-info" class="card border-0 shadow-sm" style="display: none; background: #f8fafc; border-radius: 12px;">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3 text-dark border-bottom pb-2">Detail Peserta</h6>
                                <p class="mb-1"><strong>Nama:</strong> <span id="res-name" class="text-primary"></span></p>
                                <p class="mb-1"><strong>Event:</strong> <span id="res-event"></span></p>
                                <p class="mb-0"><strong>Tiket:</strong> <span id="res-ticket" class="badge bg-secondary"></span></p>
                            </div>
                        </div>
                        <button onclick="restartScanner()" class="btn btn-primary w-100 mt-4 py-3 fw-bold rounded-pill shadow-sm transition-all hover-lift">
                            <i class="bi bi-arrow-repeat me-2"></i> Scan Tiket Lain
                        </button>
                    </div>

                    <div id="scanner-placeholder" class="p-5 text-center">
                        <div class="pulse-animation mb-4">
                            <i class="bi bi-qr-code-scan text-primary" style="font-size: 80px;"></i>
                        </div>
                        <h4 class="fw-bold">Siap Memindai?</h4>
                        <p class="text-muted px-4">Pastikan Anda telah mengizinkan akses kamera pada browser Anda.</p>
                        <button onclick="startScanner()" class="btn btn-primary px-5 py-3 rounded-pill fw-bold mt-2 shadow-sm">
                            Buka Kamera Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    #reader__scan_region {
        background: #000 !important;
    }
    #reader__dashboard_section_csr button {
        background-color: #0d6efd !important;
        border: none !important;
        padding: 10px 20px !important;
        border-radius: 30px !important;
        color: white !important;
        font-weight: bold !important;
        margin: 10px !important;
        text-transform: uppercase !important;
        font-size: 12px !important;
    }
    #reader video {
        border-radius: 0 !important;
        object-fit: cover !important;
    }
    #reader img[alt="Info icon"] { display: none; }
    #reader img[alt="Camera icon"] { display: none; }
    
    .pulse-animation {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.7; }
        100% { transform: scale(1); opacity: 1; }
    }
    
    .hover-lift:hover {
        transform: translateY(-3px);
    }
    .transition-all {
        transition: all 0.3s ease;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    let html5QrcodeScanner = null;
    let isScanning = false;

    function startScanner() {
        document.getElementById('scanner-placeholder').style.display = 'none';
        
        html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", 
            { 
                fps: 15, 
                qrbox: {width: 250, height: 250},
                aspectRatio: 1.0
            },
            /* verbose= */ false
        );
        
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        isScanning = true;
    }

    function onScanSuccess(decodedText, decodedResult) {
        if (!isScanning) return;
        
        // Vibration feedback
        if ("vibrate" in navigator) {
            navigator.vibrate(200);
        }

        isScanning = false;
        html5QrcodeScanner.clear().then(() => {
            // Send to server
            verifyTicket(decodedText);
        }).catch(error => {
            console.error(error);
            verifyTicket(decodedText);
        });
    }

    function verifyTicket(text) {
        // Loading state
        const resultDiv = document.getElementById('scanner-result');
        const alertDiv = document.getElementById('result-alert');
        resultDiv.style.display = 'block';
        alertDiv.className = 'alert alert-info text-center';
        alertDiv.innerHTML = '<div class="spinner-border spinner-border-sm me-2"></div> Memvalidasi...';
        document.getElementById('reader').style.display = 'none';

        fetch("{{ route('organizer.scanner.verify') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ qr_data: text })
        })
        .then(response => response.json())
        .then(data => {
            showResult(data);
        })
        .catch(error => {
            showResult({ success: false, message: "Kesalahan jaringan. Harap cek koneksi Anda." });
        });
    }

    function onScanFailure(error) {
        // Silent
    }

    function showResult(data) {
        const alertDiv = document.getElementById('result-alert');
        const infoDiv = document.getElementById('participant-info');
        
        if (data.success) {
            alertDiv.className = 'alert alert-success fs-5 fw-bold text-center py-4';
            alertDiv.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i> ' + data.message;
            
            infoDiv.style.display = 'block';
            document.getElementById('res-name').innerText = data.data.peserta;
            document.getElementById('res-event').innerText = data.data.event;
            document.getElementById('res-ticket').innerText = data.data.tiket;
        } else {
            alertDiv.className = 'alert alert-danger fs-5 fw-bold text-center py-4';
            alertDiv.innerHTML = '<i class="bi bi-x-circle-fill me-2"></i> ' + data.message;
            infoDiv.style.display = 'none';
        }
    }

    function restartScanner() {
        document.getElementById('scanner-result').style.display = 'none';
        document.getElementById('reader').style.display = 'block';
        startScanner();
    }
</script>
@endpush
