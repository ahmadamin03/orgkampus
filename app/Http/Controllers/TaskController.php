<?php

namespace App\Http\Controllers;

use App\Models\Proker;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function store(Request $request, Proker $proker)
    {
        if ($proker->organization_id !== Auth::user()->organization_id) {
            abort(404);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:10000',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
            'status' => 'required|in:Pending,Ongoing,Completed',
        ]);

        $data['proker_id'] = $proker->id;
        Tugas::create($data);

        return redirect()->route('prokers.show', $proker)
            ->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function updateStatus(Request $request, Tugas $tugas)
    {
        if ($tugas->proker->organization_id !== Auth::user()->organization_id) {
            abort(404);
        }

        $request->validate([
            'status' => 'required|in:Pending,Ongoing,Completed',
        ]);

        $tugas->update(['status' => $request->status]);

        return redirect()->back()
            ->with('success', 'Status tugas berhasil diperbarui.');
    }

    public function destroy(Tugas $tugas)
    {
        if ($tugas->proker->organization_id !== Auth::user()->organization_id) {
            abort(404);
        }

        $prokerId = $tugas->proker_id;
        $tugas->delete();

        return redirect()->route('prokers.show', $prokerId)
            ->with('success', 'Tugas berhasil dihapus.');
    }
}
