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
        $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'type' => 'required|string|in:Masuk,Keluar',
            'perihal' => 'required|string|max:255',
            'pengirim_penerima' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5000',
            'description' => 'nullable|string',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('surat', 'public');
        }

        Surat::create([
            'nomor_surat' => $request->nomor_surat,
            'type' => $request->type,
            'perihal' => $request->perihal,
            'pengirim_penerima' => $request->pengirim_penerima,
            'tanggal' => $request->tanggal,
            'file_path' => $filePath,
            'description' => $request->description,
        ]);

        return redirect()->route('surats.index')->with('success', 'Surat berhasil diarsipkan.');
    }

    public function update(Request $request, Surat $surat)
    {
        $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'type' => 'required|string|in:Masuk,Keluar',
            'perihal' => 'required|string|max:255',
            'pengirim_penerima' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5000',
            'description' => 'nullable|string',
        ]);

        $data = [
            'nomor_surat' => $request->nomor_surat,
            'type' => $request->type,
            'perihal' => $request->perihal,
            'pengirim_penerima' => $request->pengirim_penerima,
            'tanggal' => $request->tanggal,
            'description' => $request->description,
        ];

        if ($request->hasFile('file')) {
            if ($surat->file_path) {
                Storage::disk('public')->delete($surat->file_path);
            }
            $data['file_path'] = $request->file('file')->store('surat', 'public');
        }

        $surat->update($data);

        return redirect()->route('surats.index')->with('success', 'Surat berhasil diperbarui.');
    }

    public function destroy(Surat $surat)
    {
        if ($surat->file_path) {
            Storage::disk('public')->delete($surat->file_path);
        }
        $surat->delete();

        return redirect()->route('surats.index')->with('success', 'Surat berhasil dihapus.');
    }
}
