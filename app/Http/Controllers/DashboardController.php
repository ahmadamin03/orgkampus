<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Keuangan;
use App\Models\Proker;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMembers = User::count();
        $totalProkers = Proker::count();
        $totalEvents = Event::count();
        $totalSurats = Surat::count();

        $pemasukan = Keuangan::where('type', 'Pemasukan')->sum('amount');
        $pengeluaran = Keuangan::where('type', 'Pengeluaran')->sum('amount');
        $saldo = $pemasukan - $pengeluaran;

        $recentTransactions = Keuangan::with('user')
            ->latest()
            ->take(5)
            ->get();

        $recentLetters = Surat::latest()->take(5)->get();

        return view('dashboard.index', compact(
            'totalMembers', 'totalProkers', 'totalEvents', 'totalSurats',
            'saldo', 'recentTransactions', 'recentLetters'
        ));
    }
}
