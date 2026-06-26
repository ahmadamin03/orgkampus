<?php

namespace App\Services;

use App\Contracts\Services\MemberServiceInterface;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MemberService implements MemberServiceInterface
{
    public function list(int $organizationId, int $perPage = 20): LengthAwarePaginator
    {
        return User::where('organization_id', $organizationId)
            ->latest()
            ->paginate($perPage);
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function getById(int $id, int $organizationId): ?User
    {
        $member = User::find($id);

        if (!$member || $member->organization_id !== $organizationId) {
            return null;
        }

        return $member;
    }

    public function update(int $id, array $data, int $organizationId): ?User
    {
        $member = $this->getById($id, $organizationId);

        if (!$member) {
            return null;
        }

        $member->update($data);

        return $member;
    }

    public function delete(int $id, int $organizationId): bool
    {
        $member = $this->getById($id, $organizationId);

        if (!$member) {
            return false;
        }

        return $member->delete();
    }
}
