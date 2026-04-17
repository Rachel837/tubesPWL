@extends('admin.layouts.app')

@section('title', 'Simulasi Scan Tiket')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm border-0 mt-4">
            <div class="card-body text-center p-5">
                <i class="bi bi-qr-code-scan display-1 text-primary mb-3"></i>
                <h4 class="fw-bold mb-4">Simulasi Scanner Validasi Tiket</h4>
                
                @if(session('success'))
                    <div class="alert alert-success fs-5">
                        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                    </div>
                @endif

                @if(session('warning'))
                    <div class="alert alert-warning fs-5">
                        <i class="bi bi-exclamation-triangle-fill"></i> {{ session('warning') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger fs-5">
                        <i class="bi bi-x-circle-fill"></i> {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('admin.scanner.process') }}" method="POST" class="text-start mt-4">
                    @csrf
                    <div class="mb-3">
                        <label for="qr_code" class="form-label fw-bold">ID QR Code / Hash string</label>
                        <input type="text" class="form-control form-control-lg text-center" id="qr_code" name="qr_code" placeholder="Masukkan serial QR Code" required autofocus autocomplete="off">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="bi bi-upc-scan"></i> Validasi Tiket Sekarang
                    </button>
                    <p class="text-muted mt-3 small text-center">Gunakan alat scanner atau ketik UUID dari tiket pelanggan untuk mengecek validitas.</p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
