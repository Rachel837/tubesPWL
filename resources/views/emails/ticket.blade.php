<!DOCTYPE html>
<html>
<head>
    <title>E-Ticket Acara Anda</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f4f4; padding: 20px; }
        .card { background: #fff; max-width: 600px; margin: auto; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .header { text-align: center; border-bottom: 2px solid #eee; padding-bottom: 20px; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 2px; }
        .details { margin-bottom: 20px; }
        .qr-code { text-align: center; margin: 30px 0; }
        .footer { text-align: center; font-size: 12px; color: #888; border-top: 1px solid #eee; padding-top: 20px; }
        h1 { color: #333; margin: 0; font-size: 24px; }
        h2 { color: #555; margin: 0 0 10px; font-size: 18px; }
        p { color: #555; line-height: 1.6; margin: 5px 0; }
        strong { color: #333; }
        .badge { background: #e0f7fa; color: #006064; padding: 5px 10px; border-radius: 20px; font-weight: bold; font-size: 14px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h1>{{ $event->nama_event }}</h1>
            <p><strong>E-Ticket Resmi</strong></p>
        </div>
        <p>Hai,</p>
        <p>Terima kasih telah melakukan registrasi. Berikut ini adalah detail tiket Anda:</p>
        
        <div class="details">
            <h2>Detail Tiket</h2>
            <p><strong>Jenis Tiket:</strong> <span class="badge">{{ $tiket->jenis_tiket }}</span></p>
            <p><strong>Harga:</strong> Rp {{ number_format($tiket->harga, 0, ',', '.') }}</p>
            <p><strong>Status Pembayaran:</strong> Lunas</p>
        </div>

        <div class="details">
            <h2>Detail Acara</h2>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($event->date_start)->translatedFormat('d F Y H:i') }} - {{ \Carbon\Carbon::parse($event->date_end)->translatedFormat('H:i') }}</p>
            <p><strong>Lokasi:</strong> {{ $event->location }}</p>
        </div>

        <div class="qr-code">
            <p style="margin-bottom: 10px;">Gunakan QR Code berikut sebagai akses masuk:</p>
            <img src="{{ $message->embedData($qrImage, 'qrcode.png', 'image/png') }}" alt="QR Code" width="200" height="200">
            <p style="font-size: 12px; margin-top: 10px;">ID Registrasi: {{ $registration->qr_code }}</p>
        </div>

        <div class="footer">
            <p>Tunjukkan E-Ticket ini (QR Code) ke petugas saat berada di lokasi.</p>
            <p>&copy; {{ date('Y') }} Sistem Ticketing</p>
        </div>
    </div>
</body>
</html>
