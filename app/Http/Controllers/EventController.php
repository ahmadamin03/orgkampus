<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Kepanitiaan;
use App\Models\User;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with(['kepanitiaans.user'])->latest()->get();
        $members = User::where('status', 'Aktif')->orderBy('name')->get();
        return view('events.index', compact('events', 'members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'location' => 'nullable|string',
            'status' => 'required|string',
        ]);

        Event::create($request->all());

        return redirect()->route('events.index')->with('success', 'Event berhasil dibuat.');
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'location' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $event->update($request->all());

        return redirect()->route('events.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event berhasil dihapus.');
    }

    // Committee Management
    public function storeCommittee(Request $request, Event $event)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string|max:255',
        ]);

        $exists = $event->kepanitiaans()->where('user_id', $request->user_id)->exists();
        if ($exists) {
            return back()->with('error', 'Anggota tersebut sudah tergabung dalam kepanitiaan event ini.');
        }

        $event->kepanitiaans()->create($request->all());

        return redirect()->route('events.index')->with('success', 'Panitia berhasil ditambahkan.');
    }

    public function destroyCommittee(Kepanitiaan $committee)
    {
        $committee->delete();
        return back()->with('success', 'Panitia berhasil dikeluarkan dari event.');
    }
}
