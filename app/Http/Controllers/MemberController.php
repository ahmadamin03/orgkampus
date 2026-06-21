<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index()
    {
        $members = User::latest()->get();
        return view('members.index', compact('members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nim' => 'nullable|string|unique:users',
            'phone' => 'nullable|string',
            'role_organisasi' => 'required|string',
            'departemen' => 'nullable|string',
            'status' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nim' => $request->nim,
            'phone' => $request->phone,
            'role_organisasi' => $request->role_organisasi,
            'departemen' => $request->departemen,
            'status' => $request->status,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('members.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function update(Request $request, User $member)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $member->id,
            'nim' => 'nullable|string|unique:users,nim,' . $member->id,
            'phone' => 'nullable|string',
            'role_organisasi' => 'required|string',
            'departemen' => 'nullable|string',
            'status' => 'required|string',
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'nim' => $request->nim,
            'phone' => $request->phone,
            'role_organisasi' => $request->role_organisasi,
            'departemen' => $request->departemen,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $member->update($data);

        return redirect()->route('members.index')->with('success', 'Anggota berhasil diperbarui.');
    }

    public function destroy(User $member)
    {
        if ($member->id === auth()->id()) {
            return redirect()->route('members.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $member->delete();

        return redirect()->route('members.index')->with('success', 'Anggota berhasil dihapus.');
    }
}
