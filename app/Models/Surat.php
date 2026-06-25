<?php

namespace App\Models;

use App\Traits\TenantScoped;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['organization_id', 'nomor_surat', 'type', 'perihal', 'pengirim_penerima', 'tanggal', 'file_path', 'description'])]
class Surat extends Model
{
    use HasFactory, TenantScoped;
}
