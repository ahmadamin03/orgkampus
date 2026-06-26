<?php

namespace App\Models;

use App\Traits\TenantScoped;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['type', 'category', 'amount', 'date', 'description', 'user_id'])]
class Keuangan extends Model
{
    use HasFactory, TenantScoped;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
