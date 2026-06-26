<?php

namespace App\Contracts\Services;

use App\Models\Surat;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;

interface SuratServiceInterface
{
    public function list(int $perPage = 20): LengthAwarePaginator;

    public function create(array $data, ?UploadedFile $file = null): Surat;

    public function getById(int $id): ?Surat;

    public function update(int $id, array $data, ?UploadedFile $file = null): ?Surat;

    public function delete(int $id): bool;
}
