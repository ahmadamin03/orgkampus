<?php

namespace App\Models;

use App\Traits\TenantScoped;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'description', 'date', 'location', 'status'])]
class Event extends Model
{
    use HasFactory, TenantScoped;

    public function kepanitiaans()
    {
        return $this->hasMany(Kepanitiaan::class);
    }
}
