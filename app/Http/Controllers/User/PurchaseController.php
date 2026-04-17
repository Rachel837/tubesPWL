<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Tiket;
use App\Models\Registration;
use App\Models\Payment;
use App\Models\WaitingList;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\TicketMail;

class PurchaseController extends Controller
{
    public function show(Event $event)
    {
        $eventDetail = $event->eventDetails()->first();
        $tikets = $eventDetail ? $eventDetail->tikets : [];
        return view('user.purchase.show', compact('event', 'tikets'));
    }

    public function process(Request $request, Event $event)
    {
        $request->validate([
            'tiket_id' => 'required|exists:tiket,idtiket',
            'email' => 'required|email',
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $tiket = Tiket::findOrFail($request->tiket_id);

        if ($tiket->kuota > 0) {
            // Success Purchase
            $tiket->decrement('kuota');
            
            // Handle Payment Proof Upload
            $proofPath = null;
            if ($request->hasFile('payment_proof')) {
                $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
            }

            $qrLink = (string) \Illuminate\Support\Str::uuid();

            $registration = Registration::create([
                'status' => 'menunggu',
                'tiket_idtiket' => $tiket->idtiket,
                'user_id' => Auth::id(),
                'qr_code' => $qrLink,
            ]);

            // Generate Detailed QR Code Data (including the link if needed)
            $qrData = [
                'user_id' => Auth::id(),
                'event_id' => $event->idevent,
                'registration_id' => $registration->idregistrations,
                'link' => $qrLink,
            ];
            $qrContent = json_encode($qrData);
            
            // Re-update with full detail if we want the JSON in the DB too
            $registration->update(['qr_code' => $qrContent]);

            Payment::create([
                'registrations_idregistrations' => $registration->idregistrations,
                'payment_proof' => $proofPath
            ]);

            // Store QR content (using simple-qrcode for the DB/web part)
            $registration->update(['qr_code' => $qrContent]);

            // For Email: Use QuickChart API (reliable replacement for Google Charts)
            $qrImageUrl = "https://quickchart.io/chart?chs=300x300&cht=qr&chl=" . urlencode($qrContent);
            $qrImage = file_get_contents($qrImageUrl); 

            // Send Email
            Mail::to($request->email)->send(new TicketMail($event, $tiket, $registration, $qrImage));

            return redirect()->route('user.history')->with('success', 'Pembelian berhasil! Tiket telah dikirim ke email dan tersedia di riwayat.');

        } else {
            return redirect()->back()->with('warning', 'Maaf, tiket sudah habis.');
        }
    }

    public function joinWaitingList(Request $request, Event $event)
    {
        $request->validate([
            'tiket_id' => 'required|exists:tiket,idtiket'
        ]);

        $tiket = Tiket::findOrFail($request->tiket_id);

        if ($tiket->kuota > 0) {
            return redirect()->back()->with('success', 'Tiket ini sekarang tersedia! Silakan beli secara reguler.');
        }

        $waitingList = WaitingList::firstOrCreate([
            'event_idevent' => $event->idevent,
            'user_id_user' => Auth::id(),
            'users_id' => Auth::id(),
            'status' => 'Sedang Menunggu',
        ]);

        $qrLink = (string) \Illuminate\Support\Str::uuid();

        Registration::create([
            'status' => 'menunggu',
            'waiting_list_idwaiting_list' => $waitingList->idwaiting_list,
            'tiket_idtiket' => $tiket->idtiket,
            'user_id' => Auth::id(),
            'qr_code' => $qrLink,
        ]);

        return redirect()->route('user.waiting_list')->with('success', 'Anda telah berhasil masuk ke Waiting List. Kami akan memberitahu Anda jika tiket tersedia.');
    }

    public function payOffered(Request $request, Registration $registration)
    {
        $request->validate([
            'email' => 'required|email',
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($registration->status !== 'ditawarkan' || $registration->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');

        Payment::create([
            'registrations_idregistrations' => $registration->idregistrations,
            'payment_proof' => $proofPath
        ]);

        if ($registration->tiket && $registration->tiket->kuota > 0) {
            $registration->tiket->decrement('kuota');
        }

        // Change status to menunggu (waiting for payment verification)
        $registration->update([
            'status' => 'menunggu',
            'waiting_list_idwaiting_list' => null // Optional: remove from waiting list specific state since it acts as a normal transaction now
        ]);

        // Generate full QR Code data
        $qrData = [
            'user_id' => Auth::id(),
            'event_id' => $registration->tiket->eventDetail->event_idevent,
            'registration_id' => $registration->idregistrations,
            'link' => $registration->qr_code,
        ];
        $qrContent = json_encode($qrData);
        $registration->update(['qr_code' => $qrContent]);

        // Email Sending
        $qrImageUrl = "https://quickchart.io/chart?chs=300x300&cht=qr&chl=" . urlencode($qrContent);
        $qrImage = file_get_contents($qrImageUrl); 
        Mail::to($request->email)->send(new TicketMail($registration->tiket->eventDetail->event, $registration->tiket, $registration, $qrImage));

        return redirect()->route('user.history')->with('success', 'Pembayaran berhasil dikirim dan sedang diverifikasi. Tiket Anda pindah ke Riwayat.');
    }
}
