<?php

namespace App\Http\Controllers;

use App\Models\Proker;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProkerController extends Controller
{
    public function index()
    {
        $prokers = Proker::with('tugas')->latest()->get();
        return view('prokers.index', compact('prokers'));
    }

    public function show(Proker $proker)
    {
        if ($proker->organization_id !== Auth::user()->organization_id) {
            abort(404);
        }

        $proker->load('tugas.assignee');
        $members = User::where('organization_id', Auth::user()->organization_id)
            ->where('status', 'Aktif')
            ->get();
        return view('prokers.show', compact('proker', 'members'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:10000',
            'status' => 'required|string|max:50',
            'deadline' => 'nullable|date',
        ]);

        $data['end_date'] = $data['deadline'] ?? null;
        unset($data['deadline']);

        Proker::create($data);

        return redirect()->route('prokers.index')
            ->with('success', 'Program kerja berhasil ditambahkan.');
    }

    public function update(Request $request, Proker $proker)
    {
        if ($proker->organization_id !== Auth::user()->organization_id) {
            abort(404);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:10000',
            'status' => 'required|string|max:50',
            'deadline' => 'nullable|date',
        ]);

        $data['end_date'] = $data['deadline'] ?? null;
        unset($data['deadline']);

        $proker->update($data);

        return redirect()->route('prokers.index')
            ->with('success', 'Program kerja berhasil diperbarui.');
    }

    public function destroy(Proker $proker)
    {
        if ($proker->organization_id !== Auth::user()->organization_id) {
            abort(404);
        }

        $proker->delete();
        return redirect()->route('prokers.index')
            ->with('success', 'Program kerja berhasil dihapus.');
    }
}
