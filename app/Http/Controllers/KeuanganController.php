<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index()
    {
        $transactions = Keuangan::with('user')->latest()->get();
        $total_pemasukan = Keuangan::where('type', 'Pemasukan')->sum('amount');
        $total_pengeluaran = Keuangan::where('type', 'Pengeluaran')->sum('amount');
        $saldo = $total_pemasukan - $total_pengeluaran;

        return view('keuangans.index', compact('transactions', 'total_pemasukan', 'total_pengeluaran', 'saldo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:Pemasukan,Pengeluaran',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        Keuangan::create([
            'type' => $request->type,
            'category' => $request->category,
            'amount' => $request->amount,
            'date' => $request->date,
            'description' => $request->description,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('keuangans.index')->with('success', 'Transaksi keuangan berhasil dicatat.');
    }

    public function destroy(Keuangan $keuangan)
    {
        $keuangan->delete();
        return redirect()->route('keuangans.index')->with('success', 'Transaksi keuangan berhasil dihapus.');
    }
}
