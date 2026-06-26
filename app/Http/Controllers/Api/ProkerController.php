<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProkerResource;
use App\Models\Proker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProkerController extends BaseApiController
{
    public function index(): JsonResponse
    {
        $prokers = Proker::with('tugas')->latest()->paginate(20);

        return $this->success(ProkerResource::collection($prokers));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:10000',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'budget' => 'nullable|numeric|min:0|max:999999999.99',
            'status' => 'required|in:Planning,Active,Completed,Cancelled',
        ]);

        $proker = Proker::create($data);

        return $this->success(new ProkerResource($proker), 'Program kerja berhasil ditambahkan', 201);
    }

    public function show(Proker $proker): JsonResponse
    {
        $proker->load('tugas');

        return $this->success(new ProkerResource($proker));
    }

    public function update(Request $request, Proker $proker): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:10000',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'budget' => 'nullable|numeric|min:0|max:999999999.99',
            'status' => 'required|in:Planning,Active,Completed,Cancelled',
        ]);

        $proker->update($data);

        return $this->success(new ProkerResource($proker), 'Program kerja berhasil diperbarui');
    }

    public function destroy(Proker $proker): JsonResponse
    {
        $proker->delete();

        return $this->success(null, 'Program kerja berhasil dihapus');
    }
}
