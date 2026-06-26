<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index()
    {
        $org = Auth::user()->organization;
        $members = $org->users()->latest()->get();
        return view('members.index', compact('members'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nim' => 'nullable|string|max:50|unique:users,nim',
            'phone' => 'nullable|string|max:20',
            'role_organisasi' => 'required|string|max:100',
            'departemen' => 'nullable|string|max:100',
            'status' => 'required|in:Aktif,Nonaktif',
            'password' => ['required', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/[a-z]/', 'regex:/[0-9]/'],
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['organization_id'] = Auth::user()->organization_id;

        User::create($data);

        return redirect()->route('members.index')
            ->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        if ($user->organization_id !== Auth::user()->organization_id) {
            abort(404);
        }
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        if ($user->organization_id !== Auth::user()->organization_id) {
            abort(404);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nim' => 'nullable|string|max:50|unique:users,nim,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'role_organisasi' => 'required|string|max:100',
            'departemen' => 'nullable|string|max:100',
            'status' => 'required|in:Aktif,Nonaktif',
            'password' => ['nullable', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/[a-z]/', 'regex:/[0-9]/'],
        ]);

        if ($data['password'] ?? false) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('members.index')
            ->with('success', 'Anggota berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->organization_id !== Auth::user()->organization_id) {
            abort(404);
        }
        $user->delete();
        return redirect()->route('members.index')
            ->with('success', 'Anggota berhasil dihapus.');
    }
}
