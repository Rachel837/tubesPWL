<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScannerController extends Controller
{
    public function index()
    {
        return view('organizer.scanner.index');
    }

    public function verify(Request $request)
    {
        $qrData = json_decode($request->qr_data, true);

        if (!$qrData || !isset($qrData['registration_id'])) {
            return response()->json(['success' => false, 'message' => 'Format QR Code tidak valid.'], 400);
        }

        $registration = Registration::with(['tiket.eventDetail.event', 'user'])->find($qrData['registration_id']);

        if (!$registration) {
            return response()->json(['success' => false, 'message' => 'Tiket tidak ditemukan.'], 404);
        }

        // Verify that the event belongs to this organizer
        $event = $registration->tiket->eventDetail->event;
        if ($event->koordinator != Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Tiket ini bukan untuk event yang Anda kelola.'], 403);
        }

        // Verify status
        if ($registration->status !== 'selesai') {
            return response()->json(['success' => false, 'message' => 'Tiket belum tervalidasi (Status: ' . $registration->status . ').'], 400);
        }

        // Check if already attended
        if ($registration->is_attended) {
            return response()->json([
                'success' => false, 
                'message' => 'Tiket sudah digunakan pada ' . \Carbon\Carbon::parse($registration->attended_at)->translatedFormat('H:i d M Y')
            ], 400);
        }

        // Mark as attended
        $registration->update([
            'is_attended' => true,
            'attended_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Terdaftar! Selamat datang.',
            'data' => [
                'event' => $event->nama_event,
                'peserta' => $registration->user->name ?? 'Tamu',
                'tiket' => $registration->tiket->jenis_tiket
            ]
        ]);
    }
}
