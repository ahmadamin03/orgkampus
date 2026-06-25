<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable(['name', 'slug', 'description', 'logo'])]
class Organization extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($org) {
            if (empty($org->slug)) {
                $org->slug = Str::slug($org->name) . '-' . Str::random(6);
            }
        });
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function prokers()
    {
        return $this->hasMany(Proker::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function surats()
    {
        return $this->hasMany(Surat::class);
    }

    public function keuangans()
    {
        return $this->hasMany(Keuangan::class);
    }
}
