<?php

namespace App\Services;

use App\Contracts\Services\TugasServiceInterface;
use App\Models\Tugas;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TugasService implements TugasServiceInterface
{
    public function list(int $perPage = 20): LengthAwarePaginator
    {
        return Tugas::with('assignee', 'proker')
            ->latest()
            ->paginate($perPage);
    }

    public function create(array $data): Tugas
    {
        return Tugas::create($data);
    }

    public function getById(int $id): ?Tugas
    {
        return Tugas::with('assignee', 'proker')->find($id);
    }

    public function update(int $id, array $data): ?Tugas
    {
        $tugas = Tugas::find($id);

        if (!$tugas) {
            return null;
        }

        $tugas->update($data);

        return $tugas;
    }

    public function delete(int $id): bool
    {
        $tugas = Tugas::find($id);

        if (!$tugas) {
            return false;
        }

        return $tugas->delete();
    }
}
