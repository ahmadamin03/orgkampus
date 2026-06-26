<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('kepanitiaans.user')->latest()->get();
        return view('events.index', compact('events'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:10000',
            'date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'status' => 'required|string|max:50',
        ]);

        Event::create($data);

        return redirect()->route('events.index')
            ->with('success', 'Event berhasil ditambahkan.');
    }

    public function update(Request $request, Event $event)
    {
        if ($event->organization_id !== Auth::user()->organization_id) {
            abort(404);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:10000',
            'date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'status' => 'required|string|max:50',
        ]);

        $event->update($data);

        return redirect()->route('events.index')
            ->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        if ($event->organization_id !== Auth::user()->organization_id) {
            abort(404);
        }

        $event->delete();
        return redirect()->route('events.index')
            ->with('success', 'Event berhasil dihapus.');
    }
}
