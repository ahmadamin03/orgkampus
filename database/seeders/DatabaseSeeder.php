<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $org = Organization::create([
            'name' => 'OrgKampus Demo',
            'slug' => 'orgkampus-demo',
            'description' => 'Organisasi demo untuk keperluan pengembangan.',
        ]);

        User::create([
            'organization_id' => $org->id,
            'name' => 'Admin Demo',
            'email' => 'admin@orgkampus.ac.id',
            'password' => Hash::make('admin123'),
            'role_organisasi' => 'Ketua Organisasi',
            'status' => 'Aktif',
        ]);
    }
}
