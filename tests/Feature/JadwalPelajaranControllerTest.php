<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Agama;
use App\Models\Guru;
use App\Models\JadwalPelajaran;
use App\Models\JenisKelamin;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Rombel;
use App\Models\Semester;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JadwalPelajaranControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected Agama $agama;

    protected JenisKelamin $jenisKelamin;

    protected MataPelajaran $subject;

    protected Guru $teacher;

    protected Kelas $kelasA;

    protected Kelas $kelasB;

    protected Rombel $rombelA;

    protected Rombel $rombelB;

    protected Semester $semester1;

    protected Semester $semester2;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles so Spatie Role works correctly in the test environment
        $this->seed(RoleSeeder::class);

        // Create an admin user and log them in by default
        $this->adminUser = User::factory()->create();
        $this->adminUser->assignRole('admin');

        // Setup lookup values required for relations
        $this->agama = Agama::create(['nama' => 'Islam']);
        $this->jenisKelamin = JenisKelamin::create(['nama' => 'Laki-laki', 'kode' => 'L']);
        $this->subject = MataPelajaran::create([
            'nama' => 'Matematika',
            'deskripsi' => 'Belajar Berhitung',
        ]);

        // Create a teacher
        $teacherUser = User::factory()->create();
        $teacherUser->assignRole('guru');
        $this->teacher = Guru::create([
            'user_id' => $teacherUser->id,
            'nip' => '199001012015011001',
            'nama_lengkap' => 'Budi Utomo, S.Pd',
            'jenis_kelamin_id' => $this->jenisKelamin->id,
            'agama_id' => $this->agama->id,
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-01-01',
            'telepon' => '08123456789',
            'alamat' => 'Jl. Raya No. 1',
            'tipe' => 'Bukan Wali Kelas',
            'status' => 'Aktif',
        ]);

        // Create Kelas, Rombel, and Semester
        $this->kelasA = Kelas::create(['nama' => 'Kelas X']);
        $this->kelasB = Kelas::create(['nama' => 'Kelas XI']);

        $this->rombelA = Rombel::create(['nama' => 'Rombel A']);
        $this->rombelB = Rombel::create(['nama' => 'Rombel B']);

        $this->semester1 = Semester::create(['nama' => 'Semester Ganjil']);
        $this->semester2 = Semester::create(['nama' => 'Semester Genap']);
    }

    /**
     * Test index page rendering.
     */
    public function test_index_page_renders_successfully(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('dashboard.jadwal-pelajaran.index'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.admin.jadwal-pelajaran.index');
        $response->assertViewHas(['dataTable', 'kelasList', 'rombelList', 'semesterList']);
    }

    /**
     * Test create page rendering.
     */
    public function test_create_page_renders_successfully(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('dashboard.jadwal-pelajaran.create'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.admin.jadwal-pelajaran.create');
        $response->assertViewHas(['gurus', 'mataPelajarans', 'kelasList', 'rombelList', 'semesterList']);
    }

    /**
     * Test index page AJAX request returns JSON structured for DataTable.
     */
    public function test_index_page_ajax_returns_json(): void
    {
        // Create a schedule
        JadwalPelajaran::create([
            'guru_id' => $this->teacher->id,
            'mata_pelajaran_id' => $this->subject->id,
            'kelas_id' => $this->kelasA->id,
            'rombel_id' => $this->rombelA->id,
            'semester_id' => $this->semester1->id,
            'ganjil_genap' => 'Ganjil',
            'hari' => 'Senin',
            'jam_mulai' => '07:30:00',
            'jam_selesai' => '09:00:00',
            'ruangan' => 'R. 101',
            'warna' => '#1572e8',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->getJson(route('dashboard.jadwal-pelajaran.index'), [
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
            ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data',
        ]);

        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertEquals('Matematika', $data[0]['mata_pelajaran']);
        $this->assertEquals('Budi Utomo, S.Pd', $data[0]['guru']);
        $this->assertEquals('Kelas X', $data[0]['kelas']);
        $this->assertEquals('Rombel A', $data[0]['rombel']);
    }

    /**
     * Test filtering DataTable by Kelas.
     */
    public function test_index_page_ajax_filters_by_kelas(): void
    {
        // Roster 1: Kelas X
        $roster1 = JadwalPelajaran::create([
            'guru_id' => $this->teacher->id,
            'mata_pelajaran_id' => $this->subject->id,
            'kelas_id' => $this->kelasA->id,
            'rombel_id' => $this->rombelA->id,
            'semester_id' => $this->semester1->id,
            'ganjil_genap' => 'Ganjil',
            'hari' => 'Senin',
            'jam_mulai' => '07:30:00',
            'jam_selesai' => '09:00:00',
            'ruangan' => 'R. 101',
            'warna' => '#1572e8',
        ]);

        // Roster 2: Kelas XI
        $roster2 = JadwalPelajaran::create([
            'guru_id' => $this->teacher->id,
            'mata_pelajaran_id' => $this->subject->id,
            'kelas_id' => $this->kelasB->id,
            'rombel_id' => $this->rombelA->id,
            'semester_id' => $this->semester1->id,
            'ganjil_genap' => 'Ganjil',
            'hari' => 'Selasa',
            'jam_mulai' => '09:00:00',
            'jam_selesai' => '10:30:00',
            'ruangan' => 'R. 102',
            'warna' => '#48abf7',
        ]);

        // Filter by Kelas X
        $response = $this->actingAs($this->adminUser)
            ->getJson(route('dashboard.jadwal-pelajaran.index', ['kelas_id' => $this->kelasA->id]), [
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
            ]);

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertEquals($roster1->id, $data[0]['id']);

        // Filter by Kelas XI
        $response2 = $this->actingAs($this->adminUser)
            ->getJson(route('dashboard.jadwal-pelajaran.index', ['kelas_id' => $this->kelasB->id]), [
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
            ]);

        $response2->assertStatus(200);
        $data2 = $response2->json('data');
        $this->assertCount(1, $data2);
        $this->assertEquals($roster2->id, $data2[0]['id']);
    }

    /**
     * Test filtering DataTable by Rombel.
     */
    public function test_index_page_ajax_filters_by_rombel(): void
    {
        $roster1 = JadwalPelajaran::create([
            'guru_id' => $this->teacher->id,
            'mata_pelajaran_id' => $this->subject->id,
            'kelas_id' => $this->kelasA->id,
            'rombel_id' => $this->rombelA->id,
            'semester_id' => $this->semester1->id,
            'ganjil_genap' => 'Ganjil',
            'hari' => 'Senin',
            'jam_mulai' => '07:30:00',
            'jam_selesai' => '09:00:00',
            'ruangan' => 'R. 101',
            'warna' => '#1572e8',
        ]);

        $roster2 = JadwalPelajaran::create([
            'guru_id' => $this->teacher->id,
            'mata_pelajaran_id' => $this->subject->id,
            'kelas_id' => $this->kelasA->id,
            'rombel_id' => $this->rombelB->id,
            'semester_id' => $this->semester1->id,
            'ganjil_genap' => 'Ganjil',
            'hari' => 'Senin',
            'jam_mulai' => '09:00:00',
            'jam_selesai' => '10:30:00',
            'ruangan' => 'R. 102',
            'warna' => '#48abf7',
        ]);

        // Filter by Rombel A
        $response = $this->actingAs($this->adminUser)
            ->getJson(route('dashboard.jadwal-pelajaran.index', ['rombel_id' => $this->rombelA->id]), [
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
            ]);

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertEquals($roster1->id, $data[0]['id']);
    }

    /**
     * Test filtering DataTable by Semester.
     */
    public function test_index_page_ajax_filters_by_semester(): void
    {
        $roster1 = JadwalPelajaran::create([
            'guru_id' => $this->teacher->id,
            'mata_pelajaran_id' => $this->subject->id,
            'kelas_id' => $this->kelasA->id,
            'rombel_id' => $this->rombelA->id,
            'semester_id' => $this->semester1->id,
            'ganjil_genap' => 'Ganjil',
            'hari' => 'Senin',
            'jam_mulai' => '07:30:00',
            'jam_selesai' => '09:00:00',
            'ruangan' => 'R. 101',
            'warna' => '#1572e8',
        ]);

        $roster2 = JadwalPelajaran::create([
            'guru_id' => $this->teacher->id,
            'mata_pelajaran_id' => $this->subject->id,
            'kelas_id' => $this->kelasA->id,
            'rombel_id' => $this->rombelA->id,
            'semester_id' => $this->semester2->id,
            'ganjil_genap' => 'Genap',
            'hari' => 'Senin',
            'jam_mulai' => '09:00:00',
            'jam_selesai' => '10:30:00',
            'ruangan' => 'R. 102',
            'warna' => '#48abf7',
        ]);

        // Filter by Semester 1
        $response = $this->actingAs($this->adminUser)
            ->getJson(route('dashboard.jadwal-pelajaran.index', ['semester_id' => $this->semester1->id]), [
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
            ]);

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertEquals($roster1->id, $data[0]['id']);
    }

    /**
     * Test filtering DataTable by Hari.
     */
    public function test_index_page_ajax_filters_by_hari(): void
    {
        $roster1 = JadwalPelajaran::create([
            'guru_id' => $this->teacher->id,
            'mata_pelajaran_id' => $this->subject->id,
            'kelas_id' => $this->kelasA->id,
            'rombel_id' => $this->rombelA->id,
            'semester_id' => $this->semester1->id,
            'ganjil_genap' => 'Ganjil',
            'hari' => 'Senin',
            'jam_mulai' => '07:30:00',
            'jam_selesai' => '09:00:00',
            'ruangan' => 'R. 101',
            'warna' => '#1572e8',
        ]);

        $roster2 = JadwalPelajaran::create([
            'guru_id' => $this->teacher->id,
            'mata_pelajaran_id' => $this->subject->id,
            'kelas_id' => $this->kelasA->id,
            'rombel_id' => $this->rombelA->id,
            'semester_id' => $this->semester1->id,
            'ganjil_genap' => 'Ganjil',
            'hari' => 'Selasa',
            'jam_mulai' => '09:00:00',
            'jam_selesai' => '10:30:00',
            'ruangan' => 'R. 102',
            'warna' => '#48abf7',
        ]);

        // Filter by Hari = Senin
        $response = $this->actingAs($this->adminUser)
            ->getJson(route('dashboard.jadwal-pelajaran.index', ['hari' => 'Senin']), [
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
            ]);

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertEquals($roster1->id, $data[0]['id']);
    }

    /**
     * Test filtering DataTable by Jam Mulai.
     */
    public function test_index_page_ajax_filters_by_jam_mulai(): void
    {
        $roster1 = JadwalPelajaran::create([
            'guru_id' => $this->teacher->id,
            'mata_pelajaran_id' => $this->subject->id,
            'kelas_id' => $this->kelasA->id,
            'rombel_id' => $this->rombelA->id,
            'semester_id' => $this->semester1->id,
            'ganjil_genap' => 'Ganjil',
            'hari' => 'Senin',
            'jam_mulai' => '07:30:00',
            'jam_selesai' => '09:00:00',
            'ruangan' => 'R. 101',
            'warna' => '#1572e8',
        ]);

        $roster2 = JadwalPelajaran::create([
            'guru_id' => $this->teacher->id,
            'mata_pelajaran_id' => $this->subject->id,
            'kelas_id' => $this->kelasA->id,
            'rombel_id' => $this->rombelA->id,
            'semester_id' => $this->semester1->id,
            'ganjil_genap' => 'Ganjil',
            'hari' => 'Senin',
            'jam_mulai' => '09:00:00',
            'jam_selesai' => '10:30:00',
            'ruangan' => 'R. 102',
            'warna' => '#48abf7',
        ]);

        // Filter by jam_mulai = '07:30'
        $response = $this->actingAs($this->adminUser)
            ->getJson(route('dashboard.jadwal-pelajaran.index', ['jam_mulai' => '07:30']), [
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
            ]);

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertEquals($roster1->id, $data[0]['id']);
    }

    /**
     * Test events endpoint for FullCalendar.
     */
    public function test_events_endpoint_returns_json_successfully(): void
    {
        $response = $this->actingAs($this->adminUser)->getJson(route('dashboard.jadwal-pelajaran.events'));

        $response->assertStatus(200);
    }

    /**
     * Test show endpoint returns json details successfully.
     */
    public function test_show_endpoint_returns_json_successfully(): void
    {
        $roster = JadwalPelajaran::create([
            'guru_id' => $this->teacher->id,
            'mata_pelajaran_id' => $this->subject->id,
            'kelas_id' => $this->kelasA->id,
            'rombel_id' => $this->rombelA->id,
            'semester_id' => $this->semester1->id,
            'ganjil_genap' => 'Ganjil',
            'hari' => 'Senin',
            'jam_mulai' => '07:30:00',
            'jam_selesai' => '09:00:00',
            'ruangan' => 'R. 101',
            'warna' => '#1572e8',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->getJson(route('dashboard.jadwal-pelajaran.show', $roster));

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $roster->id,
            'ganjil_genap' => 'Ganjil',
            'hari' => 'Senin',
            'ruangan' => 'R. 101',
        ]);
    }
}
