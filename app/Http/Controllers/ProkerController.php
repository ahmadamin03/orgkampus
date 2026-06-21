<?php

namespace App\Http\Controllers;

use App\Models\Proker;
use App\Models\Tugas;
use App\Models\User;
use Illuminate\Http\Request;

class ProkerController extends Controller
{
    public function index()
    {
        $prokers = Proker::withCount(['tugas', 'tugas as completed_tugas_count' => function ($query) {
            $query->where('status', 'Completed');
        }])->latest()->get();

        return view('prokers.index', compact('prokers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'budget' => 'required|numeric|min:0',
            'status' => 'required|string',
        ]);

        Proker::create($request->all());

        return redirect()->route('prokers.index')->with('success', 'Program Kerja berhasil dibuat.');
    }

    public function show(Proker $proker)
    {
        $proker->load(['tugas.assignee']);
        $members = User::where('status', 'Aktif')->orderBy('name')->get();
        return view('prokers.show', compact('proker', 'members'));
    }

    public function update(Request $request, Proker $proker)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'budget' => 'required|numeric|min:0',
            'status' => 'required|string',
        ]);

        $proker->update($request->all());

        return redirect()->route('prokers.index')->with('success', 'Program Kerja berhasil diperbarui.');
    }

    public function destroy(Proker $proker)
    {
        $proker->delete();
        return redirect()->route('prokers.index')->with('success', 'Program Kerja berhasil dihapus.');
    }

    // Task Management
    public function storeTask(Request $request, Proker $proker)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
            'status' => 'required|string',
        ]);

        $proker->tugas()->create($request->all());

        return redirect()->route('prokers.show', $proker)->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function updateTaskStatus(Request $request, Tugas $task)
    {
        $request->validate([
            'status' => 'required|string|in:Pending,Ongoing,Completed',
        ]);

        $task->update(['status' => $request->status]);

        return back()->with('success', 'Status tugas berhasil diperbarui.');
    }

    public function destroyTask(Tugas $task)
    {
        $prokerId = $task->proker_id;
        $task->delete();
        return redirect()->route('prokers.show', $prokerId)->with('success', 'Tugas berhasil dihapus.');
    }
}
