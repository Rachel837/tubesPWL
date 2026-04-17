<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Http\Requests\EventRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        // Hanya tampilkan event yang dikoordinasikan oleh organizer yang sedang login,
        // namun untuk sementara mengikuti permintaan: "kode buat crudnya aja yang sama"
        // kita tambahkan query ini:
        $events = Event::where('koordinator', auth()->id())->orderBy('date_start', 'desc')->paginate(10);
        return view('organizer.events.index', compact('events'));
    }

    public function create()
    {
        $coordinators = \App\Models\User::where('role_idrole', 2)->get();
        $categories = \App\Models\Category::all();
        return view('organizer.events.create', compact('coordinators', 'categories'));
    }

    public function store(EventRequest $request)
    {
        $data = $request->validated();
        $data['kategori_id'] = $request->input('kategori_id');
        // Override koordinator menjadi user saat ini (organizer)
        $data['koordinator'] = auth()->id();
        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('banners', 'public');
        }
        Event::create($data);
        return redirect()->route('organizer.events.index')
            ->with('success', 'Acara berhasil ditambahkan.');
    }

    public function show(Event $event)
    {
        return view('organizer.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $coordinators = \App\Models\User::where('role_idrole', 2)->get();
        $categories = \App\Models\Category::all();
        return view('organizer.events.edit', compact('event', 'coordinators', 'categories'));
    }

    public function update(EventRequest $request, Event $event)
    {
        $data = $request->validated();
        $data['kategori_id'] = $request->input('kategori_id');
        if ($request->hasFile('banner')) {
            if ($event->banner) {
                Storage::disk('public')->delete($event->banner);
            }
            $data['banner'] = $request->file('banner')->store('banners', 'public');
        }
        $event->update($data);
        return redirect()->route('organizer.events.index')
            ->with('success', 'Acara berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        if ($event->banner) {
            Storage::disk('public')->delete($event->banner);
        }
        $event->delete();
        return redirect()->route('organizer.events.index')
            ->with('success', 'Acara berhasil dihapus.');
    }
}
