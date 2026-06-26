<?php

namespace App\Services;

use App\Contracts\Services\EventServiceInterface;
use App\Models\Event;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EventService implements EventServiceInterface
{
    public function list(int $perPage = 20): LengthAwarePaginator
    {
        return Event::latest()->paginate($perPage);
    }

    public function create(array $data): Event
    {
        return Event::create($data);
    }

    public function getById(int $id): ?Event
    {
        return Event::find($id);
    }

    public function update(int $id, array $data): ?Event
    {
        $event = Event::find($id);

        if (!$event) {
            return null;
        }

        $event->update($data);

        return $event;
    }

    public function delete(int $id): bool
    {
        $event = Event::find($id);

        if (!$event) {
            return false;
        }

        return $event->delete();
    }
}
