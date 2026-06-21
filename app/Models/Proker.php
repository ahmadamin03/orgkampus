<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'description', 'start_date', 'end_date', 'budget', 'status'])]
class Proker extends Model
{
    use HasFactory;

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }
}
