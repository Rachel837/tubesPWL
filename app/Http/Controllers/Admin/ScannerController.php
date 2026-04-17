<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class ScannerController extends Controller
{
    public function index()
    {
        return view('admin.scanner.index');
    }

    public function process(Request $request)
    {
        $request->validate(['qr_code' => 'required|string']);
        
        $registration = Registration::where('qr_code', $request->qr_code)->first();

        if ($registration) {
            if ($registration->status == 'Digunakan') {
                return back()->with('warning', 'Peringatan: Tiket sudah digunakan sebelumnya!');
            }
            
            $registration->update(['status' => 'Digunakan']);
            $tiket = $registration->tiket;
            $eventDetail = $tiket ? $tiket->eventDetail : null;
            $event = $eventDetail ? $eventDetail->event : null;

            $eventName = $event ? $event->nama_event : 'Event Tidak Diketahui';
            $tiketName = $tiket ? $tiket->jenis_tiket : '-';

            return back()->with('success', "Validasi Berhasil! Tiket valid untuk event $eventName ($tiketName).");
        }

        return back()->with('error', 'QR Code tidak valid atau tiket tidak ditemukan.');
    }
}
