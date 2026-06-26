<?php

namespace App\Services;

use App\Contracts\Services\SuratServiceInterface;
use App\Models\Surat;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SuratService implements SuratServiceInterface
{
    public function list(int $perPage = 20): LengthAwarePaginator
    {
        return Surat::latest()->paginate($perPage);
    }

    public function create(array $data, ?UploadedFile $file = null): Surat
    {
        if ($file) {
            $data['file_path'] = $file->store('surat', 'public');
        }

        return Surat::create($data);
    }

    public function getById(int $id): ?Surat
    {
        return Surat::find($id);
    }

    public function update(int $id, array $data, ?UploadedFile $file = null): ?Surat
    {
        $surat = Surat::find($id);

        if (!$surat) {
            return null;
        }

        if ($file) {
            if ($surat->file_path) {
                Storage::disk('public')->delete($surat->file_path);
            }

            $data['file_path'] = $file->store('surat', 'public');
        }

        $surat->update($data);

        return $surat;
    }

    public function delete(int $id): bool
    {
        $surat = Surat::find($id);

        if (!$surat) {
            return false;
        }

        if ($surat->file_path) {
            Storage::disk('public')->delete($surat->file_path);
        }

        return $surat->delete();
    }
}
