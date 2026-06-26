<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\TugasResource;
use App\Models\Tugas;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TugasController extends BaseApiController
{
    public function index(): JsonResponse
    {
        $tugas = Tugas::with('assignee', 'proker')->latest()->paginate(20);

        return $this->success(TugasResource::collection($tugas));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'proker_id' => 'required|exists:prokers,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:10000',
            'assigned_to' => 'required|exists:users,id,organization_id,' . $request->user()->organization_id,
            'due_date' => 'required|date',
            'status' => 'required|in:Pending,In Progress,Completed,Cancelled',
        ]);

        $tugas = Tugas::create($data);

        return $this->success(new TugasResource($tugas), 'Tugas berhasil ditambahkan', 201);
    }

    public function show(Tugas $tugas): JsonResponse
    {
        $tugas->load('assignee', 'proker');

        return $this->success(new TugasResource($tugas));
    }

    public function update(Request $request, Tugas $tugas): JsonResponse
    {
        $data = $request->validate([
            'proker_id' => 'required|exists:prokers,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:10000',
            'assigned_to' => 'required|exists:users,id,organization_id,' . $request->user()->organization_id,
            'due_date' => 'required|date',
            'status' => 'required|in:Pending,In Progress,Completed,Cancelled',
        ]);

        $tugas->update($data);

        return $this->success(new TugasResource($tugas), 'Tugas berhasil diperbarui');
    }

    public function destroy(Tugas $tugas): JsonResponse
    {
        $tugas->delete();

        return $this->success(null, 'Tugas berhasil dihapus');
    }
}
