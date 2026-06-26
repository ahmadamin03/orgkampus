<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Keuangan;
use App\Models\Proker;
use App\Models\Surat;
use App\Models\Tugas;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $orgId = Auth::user()->organization_id;

        $totalMembers = User::where('organization_id', $orgId)->count();
        $totalProkers = Proker::where('organization_id', $orgId)->count();
        $totalEvents = Event::where('organization_id', $orgId)->count();
        $totalSurats = Surat::where('organization_id', $orgId)->count();

        $pemasukan = Keuangan::where('organization_id', $orgId)
            ->where('type', 'Pemasukan')->sum('amount');
        $pengeluaran = Keuangan::where('organization_id', $orgId)
            ->where('type', 'Pengeluaran')->sum('amount');
        $saldo = $pemasukan - $pengeluaran;

        $recentTransactions = Keuangan::with('user')
            ->where('organization_id', $orgId)
            ->latest()
            ->take(5)
            ->get();

        $recentLetters = Surat::where('organization_id', $orgId)
            ->latest()->take(5)->get();

        $activeTasks = Tugas::with(['proker', 'assignee'])
            ->where('organization_id', $orgId)
            ->where('status', 'Ongoing')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalMembers', 'totalProkers', 'totalEvents', 'totalSurats',
            'saldo', 'recentTransactions', 'recentLetters', 'activeTasks'
        ));
    }
}
