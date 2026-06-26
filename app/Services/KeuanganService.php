<?php

namespace App\Services;

use App\Contracts\Services\KeuanganServiceInterface;
use App\Models\Keuangan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class KeuanganService implements KeuanganServiceInterface
{
    public function list(int $perPage = 20): array
    {
        $keuangans = Keuangan::with('user')
            ->latest()
           ->paginate($perPage);

        $totals = Keuangan::selectRaw("SUM(CASE WHEN type = 'Pemasukan' THEN amount ELSE 0 END) as total_pemasukan")
            ->selectRaw("SUM(CASE WHEN type = 'Pengeluaran' THEN amount ELSE 0 END) as total_pengeluaran")
            ->first();

        return [
            'transactions' => $keuangans,
            'summary' => [
                'total_pemasukan' => (float) ($totals->total_pemasukan ?? 0),
                'total_pengeluaran' => (float) ($totals->total_pengeluaran ?? 0),
                'saldo' => (float) (($totals->total_pemasukan ?? 0) - ($totals->total_pengeluaran ?? 0)),
            ],
        ];
    }

    public function create(array $data): Keuangan
    {
        return Keuangan::create($data);
    }

    public function getById(int $id): ?Keuangan
    {
        return Keuangan::with('user')->find($id);
    }

    public function update(int $id, array $data): ?Keuangan
    {
        $keuangan = Keuangan::find($id);

        if (!$keuangan) {
            return null;
        }

        $keuangan->update($data);

        return $keuangan;
    }

    public function delete(int $id): bool
    {
        $keuangan = Keuangan::find($id);

        if (!$keuangan) {
            return false;
        }

        return $keuangan->delete();
    }
}
