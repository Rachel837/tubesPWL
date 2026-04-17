<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('organizer.dashboard');
    }

    public function graph(Request $request)
    {
        $koordinatorId = auth()->id();
        $allEvents = \App\Models\Event::where('koordinator', $koordinatorId)->get();
        $selectedEventId = $request->input('event_id', 'all');

        if ($selectedEventId !== 'all') {
            $events = collect([$selectedEventId]);
        } else {
            $events = $allEvents->pluck('idevent');
        }
        
        $labels = [];
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subDays($i)->format('Y-m-d');
            $labels[] = $date;
            $count = \App\Models\Registration::whereHas('tiket.eventDetail', function ($q) use ($events) {
                            $q->whereIn('event_idevent', $events);
                        })
                        ->whereDate('created_at', $date)
                        ->count();
            $data[] = $count;
        }

        return view('organizer.graph', compact('labels', 'data', 'allEvents', 'selectedEventId'));
    }

    public function performance(Request $request)
    {
        $allEvents = \App\Models\Event::where('koordinator', auth()->id())->get();
        $selectedEventId = $request->input('event_id', 'all');

        $eventsQuery = \App\Models\Event::where('koordinator', auth()->id());
        if ($selectedEventId !== 'all') {
            $eventsQuery->where('idevent', $selectedEventId);
        }
        $events = $eventsQuery->get();

        foreach ($events as $event) {
            $terjual = \App\Models\Registration::whereHas('tiket.eventDetail', function ($q) use ($event) {
                $q->where('event_idevent', $event->idevent);
            })->where('status', 'selesai')->count();
            
            $sisaKuota = \App\Models\Tiket::whereHas('eventDetail', function($q) use ($event) {
                $q->where('event_idevent', $event->idevent);
            })->sum('kuota');
            
            $totalAsli = $terjual + $sisaKuota;
            
            $event->terjual = $terjual;
            $event->performance = $totalAsli > 0 ? round(($terjual / $totalAsli) * 100) : 0;
        }
        return view('organizer.performance', compact('events', 'allEvents', 'selectedEventId'));
    }

    public function revenue(Request $request)
    {
        $allEvents = \App\Models\Event::where('koordinator', auth()->id())->get();
        $selectedEventId = $request->input('event_id', 'all');

        if ($selectedEventId !== 'all') {
            $events = collect([$selectedEventId]);
        } else {
            $events = $allEvents->pluck('idevent');
        }

        $totalRevenue = \App\Models\Registration::where('status', 'selesai')
            ->whereHas('tiket.eventDetail', function ($q) use ($events) {
                $q->whereIn('event_idevent', $events);
            })
            ->with('tiket')
            ->get()
            ->sum(function ($reg) {
                return $reg->tiket->harga;
            });

        return view('organizer.revenue', compact('totalRevenue', 'allEvents', 'selectedEventId'));
    }

    public function statistics(Request $request)
    {
        $allEvents = \App\Models\Event::where('koordinator', auth()->id())->get();
        $selectedEventId = $request->input('event_id', 'all');

        if ($selectedEventId !== 'all') {
            $events = collect([$selectedEventId]);
        } else {
            $events = $allEvents->pluck('idevent');
        }

        $totalSales = \App\Models\Registration::where('status', 'selesai')
            ->whereHas('tiket.eventDetail', function ($q) use ($events) {
                $q->whereIn('event_idevent', $events);
            })
            ->count();

        return view('organizer.statistics', compact('totalSales', 'allEvents', 'selectedEventId'));
    }
}
