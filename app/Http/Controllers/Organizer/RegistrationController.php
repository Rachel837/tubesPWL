<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function index()
    {
        // Get all events managed by the current organizer
        $eventIds = Event::where('koordinator', Auth::id())->pluck('idevent');
        
        // Get registrations for those events
        $registrations = Registration::whereHas('tiket.eventDetail', function($query) use ($eventIds) {
            $query->whereIn('event_idevent', $eventIds);
        })->with(['tiket.eventDetail.event', 'user', 'payment'])
          ->orderBy('created_at', 'desc')
          ->get();
          
        return view('organizer.registrations.index', compact('registrations'));
    }

    public function approve(Registration $registration)
    {
        $registration->update(['status' => 'selesai']);
        return redirect()->back()->with('success', 'Pendaftaran berhasil disetujui.');
    }

    public function reject(Registration $registration)
    {
        $registration->update(['status' => 'gagal']);
        
        // Restore ticket quota
        if ($registration->tiket) {
            $registration->tiket->increment('kuota');
        }
        
        return redirect()->back()->with('success', 'Pendaftaran telah ditolak dan kuota dikembalikan.');
    }
}
