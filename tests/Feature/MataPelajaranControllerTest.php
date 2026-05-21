<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\MataPelajaran;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MataPelajaranControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles so Spatie Role works correctly in the test environment
        $this->seed(RoleSeeder::class);

        // Create an admin user and log them in by default
        $this->adminUser = User::factory()->create();
        $this->adminUser->assignRole('admin');
    }

    /**
     * Test index page rendering.
     */
    public function test_index_page_renders_successfully(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('dashboard.mata-pelajaran.index'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.admin.mata-pelajaran.index');
        $response->assertViewHas('dataTable');
    }

    /**
     * Test create page rendering.
     */
    public function test_create_page_renders_successfully(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('dashboard.mata-pelajaran.create'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.admin.mata-pelajaran.tambah');
    }

    /**
     * Test edit page rendering.
     */
    public function test_edit_page_renders_successfully(): void
    {
        $subject = MataPelajaran::create([
            'nama' => 'IPA',
            'deskripsi' => 'Belajar Alam'
        ]);

        $response = $this->actingAs($this->adminUser)->get(route('dashboard.mata-pelajaran.edit', $subject));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.admin.mata-pelajaran.ubah');
        $response->assertViewHas('mataPelajaran', $subject);
    }

    /**
     * Test index page AJAX request.
     */
    public function test_index_page_ajax_returns_json(): void
    {
        // Seed some data
        MataPelajaran::create([
            'nama' => 'Matematika SD',
            'deskripsi' => 'Belajar berhitung dan logika matematika dasar.'
        ]);

        $response = $this->actingAs($this->adminUser)
            ->getJson(route('dashboard.mata-pelajaran.index'), [
                'HTTP_X-Requested-With' => 'XMLHttpRequest'
            ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data'
        ]);

        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertEquals('Matematika SD', $data[0]['nama']);
        $this->assertStringContainsString('Belajar berhitung', $data[0]['deskripsi']);
        $this->assertStringContainsString('checkbox', $data[0]['checkbox']);
        $this->assertStringContainsString('action', $data[0]['action']);
    }

    /**
     * Test store method creates a new subject.
     */
    public function test_store_creates_subject_successfully(): void
    {
        $subjectData = [
            'nama' => 'Bahasa Indonesia SD',
            'deskripsi' => 'Belajar membaca, menulis, dan tata bahasa Indonesia.'
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('dashboard.mata-pelajaran.store'), $subjectData);

        $response->assertRedirect(route('dashboard.mata-pelajaran.index'));
        $this->assertDatabaseHas('mata_pelajaran', $subjectData);
    }

    /**
     * Test update method updates a subject.
     */
    public function test_update_updates_subject_successfully(): void
    {
        $subject = MataPelajaran::create([
            'nama' => 'IPA Terpadu SD',
            'deskripsi' => 'Pengenalan ilmu pengetahuan alam secara mendasar.'
        ]);

        $updatedData = [
            'nama' => 'IPA Terpadu SD Revisi',
            'deskripsi' => 'Pengenalan alam dan sains dasar.'
        ];

        $response = $this->actingAs($this->adminUser)
            ->put(route('dashboard.mata-pelajaran.update', $subject), $updatedData);

        $response->assertRedirect(route('dashboard.mata-pelajaran.index'));
        $this->assertDatabaseHas('mata_pelajaran', $updatedData);
    }

    /**
     * Test destroy method deletes a subject.
     */
    public function test_destroy_deletes_subject_successfully(): void
    {
        $subject = MataPelajaran::create([
            'nama' => 'IPS SD',
            'deskripsi' => 'Belajar sejarah dan geografi dasar.'
        ]);

        $response = $this->actingAs($this->adminUser)
            ->delete(route('dashboard.mata-pelajaran.destroy', $subject));

        $response->assertRedirect(route('dashboard.mata-pelajaran.index'));
        $this->assertDatabaseMissing('mata_pelajaran', ['id' => $subject->id]);
    }

    /**
     * Test bulkDestroy method deletes multiple subjects.
     */
    public function test_bulk_destroy_deletes_selected_subjects_successfully(): void
    {
        $subject1 = MataPelajaran::create(['nama' => 'Mapel 1', 'deskripsi' => 'Deskripsi 1']);
        $subject2 = MataPelajaran::create(['nama' => 'Mapel 2', 'deskripsi' => 'Deskripsi 2']);
        $subject3 = MataPelajaran::create(['nama' => 'Mapel 3', 'deskripsi' => 'Deskripsi 3']);

        $response = $this->actingAs($this->adminUser)
            ->post(route('dashboard.mata-pelajaran.bulk-destroy'), [
                'ids' => [$subject1->id, $subject3->id]
            ]);

        $response->assertRedirect(route('dashboard.mata-pelajaran.index'));
        $this->assertDatabaseMissing('mata_pelajaran', ['id' => $subject1->id]);
        $this->assertDatabaseMissing('mata_pelajaran', ['id' => $subject3->id]);
        $this->assertDatabaseHas('mata_pelajaran', ['id' => $subject2->id]);
    }

    /**
     * Test bulkDestroy with no selection redirects.
     */
    public function test_bulk_destroy_with_no_selection_redirects(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->post(route('dashboard.mata-pelajaran.bulk-destroy'), [
                'ids' => []
            ]);

        $response->assertRedirect(route('dashboard.mata-pelajaran.index'));
    }

    /**
     * Test show method returns JSON successfully.
     */
    public function test_show_returns_json_successfully(): void
    {
        $subject = MataPelajaran::create([
            'nama' => 'Fisika',
            'deskripsi' => 'Belajar gerak dan gaya.'
        ]);

        $response = $this->actingAs($this->adminUser)
            ->getJson(route('dashboard.mata-pelajaran.show', $subject));

        $response->assertStatus(200);
        $response->assertJson([
            'nama' => 'Fisika',
            'deskripsi' => 'Belajar gerak dan gaya.',
        ]);
    }
}
