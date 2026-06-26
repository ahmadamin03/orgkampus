<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\SuratResource;
use App\Models\Surat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratController extends BaseApiController
{
    public function index(): JsonResponse
    {
        $surats = Surat::latest()->paginate(20);

        return $this->success(SuratResource::collection($surats));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nomor_surat' => 'required|string|max:255|unique:surats,nomor_surat',
            'type' => 'required|in:Surat Masuk,Surat Keluar',
            'perihal' => 'required|string|max:255',
            'pengirim_penerima' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'description' => 'nullable|string|max:10000',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('surat', 'public');
        }

        $surat = Surat::create($data);

        return $this->success(new SuratResource($surat), 'Surat berhasil ditambahkan', 201);
    }

    public function show(Surat $surat): JsonResponse
    {
        return $this->success(new SuratResource($surat));
    }

    public function update(Request $request, Surat $surat): JsonResponse
    {
        $data = $request->validate([
            'nomor_surat' => 'required|string|max:255|unique:surats,nomor_surat,' . $surat->id,
            'type' => 'required|in:Surat Masuk,Surat Keluar',
            'perihal' => 'required|string|max:255',
            'pengirim_penerima' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'description' => 'nullable|string|max:10000',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('file')) {
            if ($surat->file_path) {
                Storage::disk('public')->delete($surat->file_path);
            }
            $data['file_path'] = $request->file('file')->store('surat', 'public');
        }

        $surat->update($data);

        return $this->success(new SuratResource($surat), 'Surat berhasil diperbarui');
    }

    public function destroy(Surat $surat): JsonResponse
    {
        if ($surat->file_path) {
            Storage::disk('public')->delete($surat->file_path);
        }

        $surat->delete();

        return $this->success(null, 'Surat berhasil dihapus');
    }
}
