<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\Proker;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    private array $userData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userData = [
            'organization_name' => 'Himpunan Mahasiswa Teknik',
            'name' => 'John Doe',
            'email' => 'john@test.ac.id',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ];
    }

    public function test_api_register()
    {
        $response = $this->postJson('/api/register', $this->userData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success', 'message',
                'data' => ['token', 'user' => ['id', 'name', 'email', 'organization_id', 'role_organisasi']],
            ]);

        $this->assertDatabaseHas('users', ['email' => 'john@test.ac.id']);
    }

    public function test_api_register_validation_error()
    {
        $response = $this->postJson('/api/register', [
            'organization_name' => '',
            'name' => '',
            'email' => 'not-an-email',
            'password' => 'short',
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors']);
    }

    public function test_api_login()
    {
        $this->postJson('/api/register', $this->userData);

        $response = $this->postJson('/api/login', [
            'email' => 'john@test.ac.id',
            'password' => 'Password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success', 'message',
                'data' => ['token', 'user'],
            ]);
    }

    public function test_api_login_invalid_credentials()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'wrong@test.ac.id',
            'password' => 'WrongPass1',
        ]);

        $response->assertStatus(422);
    }

    public function test_api_authenticated_endpoints_require_token()
    {
        $response = $this->getJson('/api/members');
        $response->assertStatus(401);
    }

    public function test_api_crud_members()
    {
        $token = $this->registerAndGetToken();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->getJson('/api/members', $headers);
        $response->assertStatus(200);

        $response = $this->postJson('/api/members', [
            'name' => 'Budi Santoso',
            'email' => 'budi@test.ac.id',
            'role_organisasi' => 'Anggota',
            'status' => 'Aktif',
            'password' => 'MemberPass1',
        ], $headers);

        $response->assertStatus(201);

        $memberId = $response->json('data.id');

        $response = $this->getJson("/api/members/$memberId", $headers);
        $response->assertStatus(200)
            ->assertJsonPath('data.name', 'Budi Santoso');

        $response = $this->putJson("/api/members/$memberId", [
            'name' => 'Budi Update',
            'email' => 'budi@test.ac.id',
            'role_organisasi' => 'Bendahara',
            'status' => 'Aktif',
        ], $headers);

        $response->assertStatus(200)
            ->assertJsonPath('data.role_organisasi', 'Bendahara');

        $response = $this->deleteJson("/api/members/$memberId", [], $headers);
        $response->assertStatus(200);

        $this->assertDatabaseMissing('users', ['id' => $memberId]);
    }

    public function test_api_crud_prokers()
    {
        $token = $this->registerAndGetToken();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->postJson('/api/prokers', [
            'name' => 'Bakti Sosial',
            'description' => 'Bakti sosial ke panti asuhan',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'status' => 'Planning',
        ], $headers);

        $response->assertStatus(201);

        $prokerId = $response->json('data.id');

        $response = $this->getJson("/api/prokers/$prokerId", $headers);
        $response->assertStatus(200)
            ->assertJsonPath('data.name', 'Bakti Sosial');

        $response = $this->putJson("/api/prokers/$prokerId", [
            'name' => 'Bakti Sosial Update',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'status' => 'Active',
        ], $headers);

        $response->assertStatus(200)
            ->assertJsonPath('data.status', 'Active');

        $response = $this->deleteJson("/api/prokers/$prokerId", [], $headers);
        $response->assertStatus(200);

        $this->assertDatabaseMissing('prokers', ['id' => $prokerId]);
    }

    public function test_api_crud_events()
    {
        $token = $this->registerAndGetToken();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->postJson('/api/events', [
            'name' => 'Seminar Nasional',
            'description' => 'Seminar tentang teknologi AI',
            'date' => '2026-08-15',
            'location' => 'Aula Utama',
            'status' => 'Planning',
        ], $headers);

        $response->assertStatus(201);

        $eventId = $response->json('data.id');

        $response = $this->getJson("/api/events/$eventId", $headers);
        $response->assertStatus(200)
            ->assertJsonPath('data.name', 'Seminar Nasional');

        $response = $this->deleteJson("/api/events/$eventId", [], $headers);
        $response->assertStatus(200);
    }

    public function test_api_crud_keuangan()
    {
        $token = $this->registerAndGetToken();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->postJson('/api/keuangans', [
            'type' => 'Pemasukan',
            'category' => 'Iuran Kas',
            'amount' => 10000000,
            'date' => '2026-06-01',
            'description' => 'Iuran kas bulanan',
        ], $headers);

        $response->assertStatus(201);

        $keuanganId = $response->json('data.id');

        $response = $this->deleteJson("/api/keuangans/$keuanganId", [], $headers);
        $response->assertStatus(200);
    }

    public function test_api_crud_surat()
    {
        Storage::fake('public');

        $token = $this->registerAndGetToken();
        $headers = ['Authorization' => "Bearer $token"];

        $file = UploadedFile::fake()->create('surat.pdf', 100);

        $response = $this->post('/api/surats', [
            'nomor_surat' => '001/HMT/2026',
            'type' => 'Surat Masuk',
            'perihal' => 'Permohonan Aula',
            'pengirim_penerima' => 'Rektorat',
            'tanggal' => '2026-06-01',
            'description' => 'Permohonan penggunaan aula',
            'file' => $file,
        ], $headers);

        $response->assertStatus(201);
    }

    public function test_api_multi_tenant_isolation()
    {
        $tokenA = $this->registerAndGetToken();
        $headersA = ['Authorization' => "Bearer $tokenA"];

        $orgA = Organization::first();

        Proker::factory()->create([
            'organization_id' => $orgA->id,
            'name' => 'Proker Alpha',
        ]);

        $orgB = Organization::factory()->create(['name' => 'Org B']);
        $userB = User::factory()->create([
            'organization_id' => $orgB->id,
            'email' => 'userb@test.ac.id',
            'password' => bcrypt('Password1'),
        ]);
        $tokenB = $userB->createToken('api-token')->plainTextToken;
        $headersB = ['Authorization' => "Bearer $tokenB"];

        Proker::factory()->create([
            'organization_id' => $orgB->id,
            'name' => 'Proker Beta',
        ]);

        $this->assertEquals(2, Proker::withoutGlobalScopes()->count());

        $responseA = $this->getJson('/api/prokers', $headersA);
        $responseA->assertStatus(200);
        $dataA = $responseA->json('data');
        $itemsA = is_array($dataA) && isset($dataA['data']) ? $dataA['data'] : (is_array($dataA) ? $dataA : []);
        $this->assertCount(1, $itemsA);
        $this->assertEquals('Proker Alpha', $itemsA[0]['name']);

        $responseB = $this->getJson('/api/prokers', $headersB);
        $responseB->assertStatus(200);
        $dataB = $responseB->json('data');
        $itemsB = is_array($dataB) && isset($dataB['data']) ? $dataB['data'] : (is_array($dataB) ? $dataB : []);
        $this->assertCount(1, $itemsB);
        $this->assertEquals('Proker Beta', $itemsB[0]['name']);
    }

    public function test_api_logout()
    {
        $token = $this->registerAndGetToken();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->postJson('/api/logout', [], $headers);
        $response->assertStatus(200)
            ->assertJson(['success' => true, 'message' => 'Logout berhasil']);

        $this->assertCount(0, \Laravel\Sanctum\PersonalAccessToken::all());
    }

    public function test_api_user_endpoint()
    {
        $token = $this->registerAndGetToken();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->getJson('/api/user', $headers);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success', 'data' => ['id', 'name', 'email', 'organization_id', 'organization'],
            ]);
    }

    private function registerAndGetToken(): string
    {
        $response = $this->postJson('/api/register', $this->userData);

        return $response->json('data.token');
    }
}
