<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Proker;
use App\Models\Event;
use App\Models\Surat;
use App\Models\Keuangan;
use App\Models\Tugas;

class DashboardController extends Controller
{
    public function index()
    {
        $members_count = User::count();
        $prokers_count = Proker::count();
        $events_count = Event::count();
        $surats_count = Surat::count();

        $kas_pemasukan = Keuangan::where('type', 'Pemasukan')->sum('amount');
        $kas_pengeluaran = Keuangan::where('type', 'Pengeluaran')->sum('amount');
        $saldo = $kas_pemasukan - $kas_pengeluaran;

        $recent_surats = Surat::latest()->take(5)->get();
        $recent_transactions = Keuangan::with('user')->latest()->take(5)->get();
        $active_tugas = Tugas::where('status', '!=', 'Completed')
            ->with(['proker', 'assignee'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'members_count',
            'prokers_count',
            'events_count',
            'surats_count',
            'saldo',
            'recent_surats',
            'recent_transactions',
            'active_tugas'
        ));
    }
}
