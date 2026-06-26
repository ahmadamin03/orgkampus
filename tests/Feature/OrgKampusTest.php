<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\User;
use App\Models\Proker;
use App\Models\Event;
use App\Models\Keuangan;
use App\Models\Surat;
use App\Models\Tugas;
use App\Traits\TenantContext;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OrgKampusTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_landing_page(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_guest_can_view_login_page(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_guest_can_view_register_page(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_dashboard(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_access_authenticated_pages(): void
    {
        foreach (['/members', '/prokers', '/events', '/surats', '/keuangans'] as $route) {
            $response = $this->get($route);
            $response->assertRedirect('/login');
        }
    }

    public function test_user_can_register_new_organization(): void
    {
        $response = $this->post('/register', [
            'organization_name' => 'Himpunan Mahasiswa Teknik',
            'name' => 'Admin Teknik',
            'email' => 'admin@hmt.ac.id',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ]);

        $response->assertRedirect('/dashboard');

        $this->assertDatabaseHas('organizations', [
            'name' => 'Himpunan Mahasiswa Teknik',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'admin@hmt.ac.id',
            'role_organisasi' => 'Ketua Organisasi',
        ]);
    }

    public function test_user_can_login(): void
    {
        $org = Organization::factory()->create();
        User::factory()->create([
            'organization_id' => $org->id,
            'email' => 'admin@test.ac.id',
            'password' => bcrypt('admin123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@test.ac.id',
            'password' => 'admin123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    public function test_user_can_logout(): void
    {
        $org = Organization::factory()->create();
        $user = User::factory()->create(['organization_id' => $org->id]);

        $response = $this->actingAs($user)->post('/logout');
        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_authenticated_user_sees_dashboard(): void
    {
        $org = Organization::factory()->create(['name' => 'Test Org']);
        $user = User::factory()->create([
            'organization_id' => $org->id,
            'name' => 'Test User',
        ]);

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Test Org');
    }

    public function test_member_crud(): void
    {
        $org = Organization::factory()->create();
        $user = User::factory()->create([
            'organization_id' => $org->id,
        ]);

        $this->actingAs($user);

        // Create
        $response = $this->post('/members', [
            'name' => 'Budi Santoso',
            'email' => 'budi@test.ac.id',
            'phone' => '081234567890',
            'role_organisasi' => 'Anggota',
            'nim' => '1234567890',
            'status' => 'Aktif',
            'password' => 'MemberPass1',
        ]);
        $response->assertRedirect('/members');

        $this->assertDatabaseHas('users', [
            'name' => 'Budi Santoso',
            'email' => 'budi@test.ac.id',
            'organization_id' => $org->id,
        ]);

        // List
        $response = $this->get('/members');
        $response->assertStatus(200);
        $response->assertSee('Budi Santoso');

        // Show JSON
        $member = User::where('email', 'budi@test.ac.id')->first();
        $response = $this->get("/members/{$member->id}");
        $response->assertStatus(200);
        $response->assertJson(['name' => 'Budi Santoso']);

        // Update
        $response = $this->put("/members/{$member->id}", [
            'name' => 'Budi Updated',
            'email' => 'budi@test.ac.id',
            'phone' => '081234567890',
            'role_organisasi' => 'Bendahara',
            'nim' => '1234567890',
            'status' => 'Aktif',
        ]);
        $response->assertRedirect('/members');

        $this->assertDatabaseHas('users', ['name' => 'Budi Updated']);

        // Delete
        $response = $this->delete("/members/{$member->id}");
        $response->assertRedirect('/members');

        $this->assertDatabaseMissing('users', ['name' => 'Budi Updated']);
    }

    public function test_proker_and_task_crud(): void
    {
        $org = Organization::factory()->create();
        $user = User::factory()->create(['organization_id' => $org->id]);

        $this->actingAs($user);

        // Create proker
        $response = $this->post('/prokers', [
            'name' => 'Bakti Sosial',
            'description' => 'Bakti sosial ke panti asuhan',
            'status' => 'Rencana',
            'deadline' => '2026-12-31',
        ]);
        $response->assertRedirect('/prokers');

        $this->assertDatabaseHas('prokers', [
            'name' => 'Bakti Sosial',
            'organization_id' => $org->id,
        ]);

        // List
        $response = $this->get('/prokers');
        $response->assertStatus(200);

        // Show
        $proker = Proker::where('name', 'Bakti Sosial')->first();
        $response = $this->get("/prokers/{$proker->id}");
        $response->assertStatus(200);

        // Update
        $response = $this->put("/prokers/{$proker->id}", [
            'name' => 'Bakti Sosial Update',
            'description' => 'Bakti sosial ke panti asuhan',
            'status' => 'Berjalan',
            'deadline' => '2026-12-31',
        ]);
        $response->assertRedirect('/prokers');

        $this->assertDatabaseHas('prokers', ['name' => 'Bakti Sosial Update', 'status' => 'Berjalan']);
        $proker->refresh();

        // Add task
        $response = $this->post("/prokers/{$proker->id}/tasks", [
            'title' => 'Survei lokasi',
            'assigned_to' => $user->id,
            'due_date' => '2026-08-01',
            'status' => 'Pending',
        ]);
        $response->assertRedirect();

        $this->assertDatabaseHas('tugas', [
            'title' => 'Survei lokasi',
            'proker_id' => $proker->id,
        ]);

        // Delete proker (cascade deletes tasks)
        $response = $this->delete("/prokers/{$proker->id}");
        $response->assertRedirect('/prokers');

        $this->assertDatabaseMissing('prokers', ['name' => 'Bakti Sosial Update']);
        $this->assertDatabaseMissing('tugas', ['title' => 'Survei lokasi']);
    }

    public function test_event_crud(): void
    {
        $org = Organization::factory()->create();
        $user = User::factory()->create(['organization_id' => $org->id]);

        $this->actingAs($user);

        // Create
        $response = $this->post('/events', [
            'name' => 'Seminar Nasional',
            'description' => 'Seminar nasional tentang teknologi',
            'location' => 'Aula Utama',
            'date' => '2026-08-15',
            'status' => 'Rencana',
        ]);
        $response->assertRedirect('/events');

        $this->assertDatabaseHas('events', [
            'name' => 'Seminar Nasional',
            'organization_id' => $org->id,
        ]);

        // List
        $response = $this->get('/events');
        $response->assertStatus(200);
        $response->assertSee('Seminar Nasional');

        // Delete
        $event = Event::where('name', 'Seminar Nasional')->first();
        $response = $this->delete("/events/{$event->id}");
        $response->assertRedirect('/events');

        $this->assertDatabaseMissing('events', ['name' => 'Seminar Nasional']);
    }

    public function test_surat_crud_with_file_upload(): void
    {
        Storage::fake('public');

        $org = Organization::factory()->create();
        $user = User::factory()->create(['organization_id' => $org->id]);

        $this->actingAs($user);

        // Create
        $file = UploadedFile::fake()->create('surat-resmi.pdf', 100);
        $response = $this->post('/surats', [
            'nomor_surat' => '001/A/2026',
            'type' => 'Masuk',
            'perihal' => 'Permohonan Aula',
            'pengirim_penerima' => 'Rektorat',
            'tanggal' => '2026-06-01',
            'description' => 'Permohonan penggunaan aula',
            'file' => $file,
        ]);
        $response->assertRedirect('/surats');

        $this->assertDatabaseHas('surats', [
            'perihal' => 'Permohonan Aula',
            'organization_id' => $org->id,
        ]);

        // List
        $response = $this->get('/surats');
        $response->assertStatus(200);
        $response->assertSee('Permohonan Aula');

        // Delete
        $surat = Surat::where('perihal', 'Permohonan Aula')->first();
        $response = $this->delete("/surats/{$surat->id}");
        $response->assertRedirect('/surats');

        $this->assertDatabaseMissing('surats', ['perihal' => 'Permohonan Aula']);
    }

    public function test_keuangan_crud(): void
    {
        $org = Organization::factory()->create();
        $user = User::factory()->create(['organization_id' => $org->id]);

        $this->actingAs($user);

        // Create pemasukan
        $response = $this->post('/keuangans', [
            'type' => 'Pemasukan',
            'category' => 'Kas Anggota',
            'amount' => 10000000,
            'description' => 'Iuran kas bulanan',
            'date' => '2026-06-01',
        ]);
        $response->assertRedirect('/keuangans');

        $this->assertDatabaseHas('keuangans', [
            'type' => 'Pemasukan',
            'amount' => 10000000,
            'organization_id' => $org->id,
        ]);

        // Create pengeluaran
        $response = $this->post('/keuangans', [
            'type' => 'Pengeluaran',
            'category' => 'Konsumsi',
            'amount' => 500000,
            'description' => 'Cetak spanduk',
            'date' => '2026-06-15',
        ]);
        $response->assertRedirect('/keuangans');

        // List
        $response = $this->get('/keuangans');
        $response->assertStatus(200);
        $response->assertSee('Iuran kas bulanan');

        // Delete
        $keuangan = Keuangan::where('description', 'Iuran kas bulanan')->first();
        $response = $this->delete("/keuangans/{$keuangan->id}");
        $response->assertRedirect('/keuangans');

        $this->assertDatabaseMissing('keuangans', ['description' => 'Iuran kas bulanan']);
    }

    public function test_multi_tenant_isolation(): void
    {
        $orgA = Organization::factory()->create(['name' => 'Org A']);
        $userA = User::factory()->create([
            'organization_id' => $orgA->id,
            'name' => 'User A',
        ]);
        Proker::factory()->create([
            'organization_id' => $orgA->id,
            'name' => 'Proker Alpha',
        ]);

        $orgB = Organization::factory()->create(['name' => 'Org B']);
        $userB = User::factory()->create([
            'organization_id' => $orgB->id,
            'name' => 'User B',
        ]);
        Proker::factory()->create([
            'organization_id' => $orgB->id,
            'name' => 'Proker Beta',
        ]);

        $this->assertEquals(2, Proker::withoutGlobalScopes()->count());
        $this->assertEquals(1, Proker::where('organization_id', $orgA->id)->count());
        $this->assertEquals(1, Proker::where('organization_id', $orgB->id)->count());

        $this->actingAs($userA);
        $this->assertCount(1, Proker::all());
        $this->assertEquals('Proker Alpha', Proker::first()->name);

        $responseA = $this->get('/prokers');
        $responseA->assertSee('Proker Alpha');

        $this->post('/logout');

        $responseB = $this->actingAs($userB)->get('/prokers');
        $responseB->assertSee('Proker Beta');
    }
}
