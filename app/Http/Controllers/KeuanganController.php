<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeuanganController extends Controller
{
    public function index()
    {
        $keuangans = Keuangan::with('user')->latest()->paginate(20);

        $totals = Keuangan::selectRaw("SUM(CASE WHEN type = 'Pemasukan' THEN amount ELSE 0 END) as total_pemasukan")
            ->selectRaw("SUM(CASE WHEN type = 'Pengeluaran' THEN amount ELSE 0 END) as total_pengeluaran")
            ->first();

        $totalPemasukan = $totals->total_pemasukan ?? 0;
        $totalPengeluaran = $totals->total_pengeluaran ?? 0;
        $saldo = $totalPemasukan - $totalPengeluaran;

        return view('keuangans.index', compact(
            'keuangans', 'totalPemasukan', 'totalPengeluaran', 'saldo'
        ));
    }

    public function show(Keuangan $keuangan)
    {
        if ($keuangan->organization_id !== Auth::user()->organization_id) {
            abort(404);
        }
        return response()->json($keuangan);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:Pemasukan,Pengeluaran',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01|max:999999999.99',
            'date' => 'required|date',
            'description' => 'nullable|string|max:10000',
        ]);

        $data['user_id'] = Auth::id();

        Keuangan::create($data);

        return redirect()->route('keuangans.index')
            ->with('success', 'Transaksi berhasil dicatat.');
    }

    public function update(Request $request, Keuangan $keuangan)
    {
        if ($keuangan->organization_id !== Auth::user()->organization_id) {
            abort(404);
        }

        $data = $request->validate([
            'type' => 'required|in:Pemasukan,Pengeluaran',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01|max:999999999.99',
            'date' => 'required|date',
            'description' => 'nullable|string|max:10000',
        ]);

        $keuangan->update($data);

        return redirect()->route('keuangans.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Keuangan $keuangan)
    {
        if ($keuangan->organization_id !== Auth::user()->organization_id) {
            abort(404);
        }

        $keuangan->delete();
        return redirect()->route('keuangans.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}
