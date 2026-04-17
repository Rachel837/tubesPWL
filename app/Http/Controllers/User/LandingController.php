<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Ambil event yang statusnya aktif
        $events = Event::where('status', 'aktif')->orderBy('date_start', 'asc')->get();
        return view('users.landing', compact('events'));
    }
}
