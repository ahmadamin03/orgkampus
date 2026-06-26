<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\KeuanganResource;
use App\Models\Keuangan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KeuanganController extends BaseApiController
{
    public function index(): JsonResponse
    {
        $keuangans = Keuangan::with('user')->latest()->paginate(20);

        $totals = Keuangan::selectRaw("SUM(CASE WHEN type = 'Pemasukan' THEN amount ELSE 0 END) as total_pemasukan")
            ->selectRaw("SUM(CASE WHEN type = 'Pengeluaran' THEN amount ELSE 0 END) as total_pengeluaran")
            ->first();

        return $this->success([
            'transactions' => KeuanganResource::collection($keuangans),
            'summary' => [
                'total_pemasukan' => (float) ($totals->total_pemasukan ?? 0),
                'total_pengeluaran' => (float) ($totals->total_pengeluaran ?? 0),
                'saldo' => (float) (($totals->total_pemasukan ?? 0) - ($totals->total_pengeluaran ?? 0)),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'type' => 'required|in:Pemasukan,Pengeluaran',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01|max:999999999.99',
            'date' => 'required|date',
            'description' => 'nullable|string|max:10000',
        ]);

        $data['user_id'] = $request->user()->id;

        $keuangan = Keuangan::create($data);

        return $this->success(new KeuanganResource($keuangan), 'Transaksi berhasil dicatat', 201);
    }

    public function show(Keuangan $keuangan): JsonResponse
    {
        $keuangan->load('user');

        return $this->success(new KeuanganResource($keuangan));
    }

    public function update(Request $request, Keuangan $keuangan): JsonResponse
    {
        $data = $request->validate([
            'type' => 'required|in:Pemasukan,Pengeluaran',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01|max:999999999.99',
            'date' => 'required|date',
            'description' => 'nullable|string|max:10000',
        ]);

        $keuangan->update($data);

        return $this->success(new KeuanganResource($keuangan), 'Transaksi berhasil diperbarui');
    }

    public function destroy(Keuangan $keuangan): JsonResponse
    {
        $keuangan->delete();

        return $this->success(null, 'Transaksi berhasil dihapus');
    }
}
