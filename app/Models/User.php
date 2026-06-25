<?php

namespace App\Models;

use App\Traits\TenantScoped;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['organization_id', 'name', 'email', 'password', 'nim', 'phone', 'role_organisasi', 'departemen', 'status'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TenantScoped;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'assigned_to');
    }

    public function kepanitiaans()
    {
        return $this->hasMany(Kepanitiaan::class);
    }

    public function keuangans()
    {
        return $this->hasMany(Keuangan::class);
    }
}
