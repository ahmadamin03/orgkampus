<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeuanganController extends Controller
{
    public function index()
    {
        $keuangans = Keuangan::with('user')->latest()->get();

        $totalPemasukan = Keuangan::where('type', 'Pemasukan')->sum('amount');
        $totalPengeluaran = Keuangan::where('type', 'Pengeluaran')->sum('amount');
        $saldo = $totalPemasukan - $totalPengeluaran;

        return view('keuangans.index', compact(
            'keuangans', 'totalPemasukan', 'totalPengeluaran', 'saldo'
        ));
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
