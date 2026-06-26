<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\MemberResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberController extends BaseApiController
{
    public function index(): JsonResponse
    {
        $members = User::where('organization_id', Auth::user()->organization_id)
            ->latest()
            ->paginate(20);

        return $this->success(MemberResource::collection($members));
    }

    public function store(Request $request): JsonResponse
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

        $member = User::create($data);

        return $this->success(new MemberResource($member), 'Anggota berhasil ditambahkan', 201);
    }

    public function show(User $member): JsonResponse
    {
        if ($member->organization_id !== Auth::user()->organization_id) {
            return $this->error('Anggota tidak ditemukan', 404);
        }

        return $this->success(new MemberResource($member));
    }

    public function update(Request $request, User $member): JsonResponse
    {
        if ($member->organization_id !== Auth::user()->organization_id) {
            return $this->error('Anggota tidak ditemukan', 404);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $member->id,
            'nim' => 'nullable|string|max:50|unique:users,nim,' . $member->id,
            'phone' => 'nullable|string|max:20',
            'role_organisasi' => 'required|string|max:100',
            'departemen' => 'nullable|string|max:100',
            'status' => 'required|in:Aktif,Nonaktif',
            'password' => ['nullable', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/[a-z]/', 'regex:/[0-9]/'],
        ]);

        if (($data['password'] ?? false)) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $member->update($data);

        return $this->success(new MemberResource($member), 'Anggota berhasil diperbarui');
    }

    public function destroy(User $member): JsonResponse
    {
        if ($member->organization_id !== Auth::user()->organization_id) {
            return $this->error('Anggota tidak ditemukan', 404);
        }

        $member->delete();

        return $this->success(null, 'Anggota berhasil dihapus');
    }
}
