<?php

namespace App\Services;

use App\Contracts\Services\ProkerServiceInterface;
use App\Models\Proker;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProkerService implements ProkerServiceInterface
{
    public function list(int $perPage = 20): LengthAwarePaginator
    {
        return Proker::with('tugas')
            ->latest()
            ->paginate($perPage);
    }

    public function create(array $data): Proker
    {
        return Proker::create($data);
    }

    public function getById(int $id): ?Proker
    {
        return Proker::with('tugas')->find($id);
    }

    public function update(int $id, array $data): ?Proker
    {
        $proker = Proker::find($id);

        if (!$proker) {
            return null;
        }

        $proker->update($data);

        return $proker;
    }

    public function delete(int $id): bool
    {
        $proker = Proker::find($id);

        if (!$proker) {
            return false;
        }

        return $proker->delete();
    }
}
