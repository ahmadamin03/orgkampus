<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventController extends BaseApiController
{
    public function index(): JsonResponse
    {
        $events = Event::latest()->paginate(20);

        return $this->success(EventResource::collection($events));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:10000',
            'date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:Planning,Active,Completed,Cancelled',
        ]);

        $event = Event::create($data);

        return $this->success(new EventResource($event), 'Event berhasil ditambahkan', 201);
    }

    public function show(Event $event): JsonResponse
    {
        return $this->success(new EventResource($event));
    }

    public function update(Request $request, Event $event): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:10000',
            'date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:Planning,Active,Completed,Cancelled',
        ]);

        $event->update($data);

        return $this->success(new EventResource($event), 'Event berhasil diperbarui');
    }

    public function destroy(Event $event): JsonResponse
    {
        $event->delete();

        return $this->success(null, 'Event berhasil dihapus');
    }
}
