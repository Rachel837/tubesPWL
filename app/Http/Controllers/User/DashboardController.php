<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function home()
    {
        // Get active events
        $events = Event::where('status', 'aktif')->orderBy('date_start', 'asc')->get();
        return view('user.home', compact('events'));
    }

    public function waitingList()
    {
        // Show waiting list registrations for the logged in user
        $registrations = Registration::where('user_id', Auth::id())
            ->whereNotNull('waiting_list_idwaiting_list')
            ->with(['tiket.eventDetail.event'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('user.waiting_list', compact('registrations'));
    }

    public function history()
    {
        // History contains normal non-waiting transactions
        $registrations = Registration::where('user_id', Auth::id())
            ->whereNull('waiting_list_idwaiting_list')
            ->with(['tiket.eventDetail.event', 'payment'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('user.history', compact('registrations'));
    }
}
