<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventDetail;
use App\Models\Tiket;
use Illuminate\Http\Request;

class TiketController extends Controller
{
    public function create(Event $event)
    {
        return view('organizer.events.tikets.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'jenis_tiket' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'kuota' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string'
        ]);

        $eventDetail = $event->eventDetails()->first();
        
        if (!$eventDetail) {
            $eventDetail = EventDetail::create([
                'event_idevent' => $event->idevent,
                'date' => date('Y-m-d', strtotime($event->date_start)),
                'sesi' => 'Sesi Utama',
                'time_start' => date('H:i', strtotime($event->date_start)),
                'time_end' => date('H:i', strtotime($event->date_end)),
                'deskripsi' => 'Sesi Default Terpusat'
            ]);
        }

        Tiket::create([
            'jenis_tiket' => $request->jenis_tiket,
            'harga' => $request->harga,
            'kuota' => $request->kuota,
            'deskripsi' => $request->deskripsi,
            'event_detail_idevent_detail' => $eventDetail->idevent_detail
        ]);

        return redirect()->route('organizer.events.show', $event->idevent)
                         ->with('success', 'Tiket berhasil ditambahkan.');
    }

    public function edit(Event $event, Tiket $tiket)
    {
        return view('organizer.events.tikets.edit', compact('event', 'tiket'));
    }

    public function update(Request $request, Event $event, Tiket $tiket)
    {
        $request->validate([
            'jenis_tiket' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'kuota' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string'
        ]);

        $newKuota = $request->kuota;
        
        if ($newKuota > $tiket->kuota) {
            $addedStock = $newKuota - $tiket->kuota;
            
            $waitingRegistrations = \App\Models\Registration::where('tiket_idtiket', $tiket->idtiket)
                ->where('status', 'menunggu')
                ->whereNotNull('waiting_list_idwaiting_list')
                ->orderBy('created_at', 'asc')
                ->limit($addedStock)
                ->get();
                
            foreach($waitingRegistrations as $reg) {
                $reg->update(['status' => 'ditawarkan']);
            }
        }

        $tiket->update([
            'jenis_tiket' => $request->jenis_tiket,
            'harga' => $request->harga,
            'kuota' => $newKuota,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('organizer.events.show', $event->idevent)
                         ->with('success', 'Tiket berhasil diperbarui.');
    }

    public function destroy(Event $event, Tiket $tiket)
    {
        $tiket->delete();
        return redirect()->route('organizer.events.show', $event->idevent)
                         ->with('success', 'Tiket berhasil dihapus.');
    }
}
