<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratController extends Controller
{
    public function index()
    {
        $surats = Surat::latest()->get();
        return view('surats.index', compact('surats'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nomor_surat' => 'required|string|max:100',
            'type' => 'required|in:Masuk,Keluar',
            'perihal' => 'required|string|max:255',
            'pengirim_penerima' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('surat', 'public');
        }

        Surat::create($data);

        return redirect()->route('surats.index')
            ->with('success', 'Surat berhasil diarsipkan.');
    }

    public function update(Request $request, Surat $surat)
    {
        $data = $request->validate([
            'nomor_surat' => 'required|string|max:100',
            'type' => 'required|in:Masuk,Keluar',
            'perihal' => 'required|string|max:255',
            'pengirim_penerima' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('file')) {
            if ($surat->file_path) {
                Storage::disk('public')->delete($surat->file_path);
            }
            $data['file_path'] = $request->file('file')->store('surat', 'public');
        }

        $surat->update($data);

        return redirect()->route('surats.index')
            ->with('success', 'Surat berhasil diperbarui.');
    }

    public function destroy(Surat $surat)
    {
        if ($surat->file_path) {
            Storage::disk('public')->delete($surat->file_path);
        }
        $surat->delete();

        return redirect()->route('surats.index')
            ->with('success', 'Surat berhasil dihapus.');
    }
}
