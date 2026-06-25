<?php

namespace App\Models;

use App\Traits\TenantScoped;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['organization_id', 'proker_id', 'title', 'description', 'assigned_to', 'due_date', 'status'])]
class Tugas extends Model
{
    use HasFactory, TenantScoped;

    protected $table = 'tugas';

    public function proker()
    {
        return $this->belongsTo(Proker::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
