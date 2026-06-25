<?php

namespace App\Models;

use App\Traits\TenantScoped;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['organization_id', 'name', 'description', 'start_date', 'end_date', 'budget', 'status'])]
class Proker extends Model
{
    use HasFactory, TenantScoped;

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }
}
