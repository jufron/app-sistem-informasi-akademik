<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Agama;
use App\Models\JenisKelamin;
use App\Models\MataPelajaran;
use App\Models\Guru;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuruControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    protected Agama $agama;
    protected JenisKelamin $jenisKelamin;
    protected MataPelajaran $subject;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles so Spatie Role works correctly in the test environment
        $this->seed(RoleSeeder::class);

        // Create an admin user and log them in by default
        $this->adminUser = User::factory()->create();
        $this->adminUser->assignRole('admin');

        // Setup lookup values required by Guru relation constraints
        $this->agama = Agama::create(['nama' => 'Katolik']);
        $this->jenisKelamin = JenisKelamin::create(['nama' => 'Laki-laki', 'kode' => 'L']);
        $this->subject = MataPelajaran::create([
            'nama' => 'Matematika',
            'deskripsi' => 'Belajar Berhitung'
        ]);
    }

    /**
     * Test index page rendering.
     */
    public function test_index_page_renders_successfully(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('dashboard.guru.index'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.admin.guru.index');
        $response->assertViewHas('dataTable');
    }

    /**
     * Test create page rendering.
     */
    public function test_create_page_renders_successfully(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('dashboard.guru.create'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.admin.guru.tambah');
        $response->assertViewHas(['jenisKelamin', 'agama', 'mataPelajaran', 'hasKepalaSekolah']);
    }

    /**
     * Test edit page rendering.
     */
    public function test_edit_page_renders_successfully(): void
    {
        $user = User::factory()->create();
        $user->assignRole('guru');

        $guru = Guru::create([
            'user_id'          => $user->id,
            'nip'              => '198503122010011002',
            'nama_lengkap'     => 'Antonius Budi, S.Pd',
            'nama_panggilan'   => 'Anton',
            'jenis_kelamin_id' => $this->jenisKelamin->id,
            'agama_id'         => $this->agama->id,
            'tempat_lahir'     => 'Weetabula',
            'tanggal_lahir'    => '1985-03-12',
            'telepon'          => '081234567890',
            'alamat'           => 'Jl. Melati No. 12, Weetabula',
            'tipe'             => 'Wali Kelas',
            'status'           => 'Aktif',
        ]);

        $response = $this->actingAs($this->adminUser)->get(route('dashboard.guru.edit', $guru));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.admin.guru.ubah');
        $response->assertViewHas('guru', $guru);
    }

    /**
     * Test index page AJAX request.
     */
    public function test_index_page_ajax_returns_json(): void
    {
        $user = User::factory()->create();
        $user->assignRole('guru');

        Guru::create([
            'user_id'          => $user->id,
            'nip'              => '198503122010011002',
            'nama_lengkap'     => 'Antonius Budi, S.Pd',
            'nama_panggilan'   => 'Anton',
            'jenis_kelamin_id' => $this->jenisKelamin->id,
            'agama_id'         => $this->agama->id,
            'tempat_lahir'     => 'Weetabula',
            'tanggal_lahir'    => '1985-03-12',
            'telepon'          => '081234567890',
            'alamat'           => 'Jl. Melati No. 12, Weetabula',
            'tipe'             => 'Wali Kelas',
            'status'           => 'Aktif',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->getJson(route('dashboard.guru.index'), [
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
        $this->assertEquals('198503122010011002', $data[0]['nip']);
        $this->assertEquals('Antonius Budi, S.Pd', $data[0]['nama_lengkap']);
    }

    /**
     * Test store method creates a new teacher and user account.
     */
    public function test_store_creates_guru_successfully(): void
    {
        $guruData = [
            'email'                 => 'testing_guru@mail.com',
            'password'              => '12345678',
            'password_confirmation' => '12345678',
            'nip'                   => '123456789012345',
            'nama_lengkap'       => 'Testing Teacher, S.Pd',
            'nama_panggilan'     => 'Test',
            'jenis_kelamin_id'   => $this->jenisKelamin->id,
            'agama_id'           => $this->agama->id,
            'tempat_lahir'       => 'Weetabula',
            'tanggal_lahir'      => '1990-01-01',
            'telepon'            => '08111222333',
            'alamat'             => 'Jl. Pendidikan No. 5',
            'tipe'               => 'Bukan Wali Kelas',
            'status'             => 'Aktif',
            'mata_pelajaran_ids' => [$this->subject->id]
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('dashboard.guru.store'), $guruData);

        $response->assertRedirect(route('dashboard.guru.index'));

        $this->assertDatabaseHas('users', [
            'email' => 'testing_guru@mail.com',
            'name'  => 'Testing Teacher, S.Pd'
        ]);

        $this->assertDatabaseHas('guru', [
            'nip'          => '123456789012345',
            'nama_lengkap' => 'Testing Teacher, S.Pd',
            'tempat_lahir' => 'Weetabula',
            'telepon'      => '08111222333',
        ]);
    }

    /**
     * Test update method updates a teacher profile and user account.
     */
    public function test_update_updates_guru_successfully(): void
    {
        $user = User::factory()->create(['email' => 'old_email@mail.com']);
        $user->assignRole('guru');

        $guru = Guru::create([
            'user_id'          => $user->id,
            'nip'              => '198503122010011002',
            'nama_lengkap'     => 'Antonius Budi, S.Pd',
            'nama_panggilan'   => 'Anton',
            'jenis_kelamin_id' => $this->jenisKelamin->id,
            'agama_id'         => $this->agama->id,
            'tempat_lahir'     => 'Weetabula',
            'tanggal_lahir'    => '1985-03-12',
            'telepon'          => '081234567890',
            'alamat'           => 'Jl. Melati No. 12, Weetabula',
            'tipe'             => 'Wali Kelas',
            'status'           => 'Aktif',
        ]);

        $updatedData = [
            'email'              => 'new_email@mail.com',
            'nip'                => '198503122010011002', // Keep NIP same
            'nama_lengkap'       => 'Antonius Budi Revised, S.Pd',
            'nama_panggilan'     => 'Anton R',
            'jenis_kelamin_id'   => $this->jenisKelamin->id,
            'agama_id'           => $this->agama->id,
            'tempat_lahir'       => 'Tambolaka',
            'tanggal_lahir'      => '1985-03-12',
            'telepon'            => '081234567899',
            'alamat'             => 'Jl. Kenanga No. 20',
            'tipe'               => 'Bukan Wali Kelas',
            'status'             => 'Cuti',
            'mata_pelajaran_ids' => [$this->subject->id]
        ];

        $response = $this->actingAs($this->adminUser)
            ->put(route('dashboard.guru.update', $guru), $updatedData);

        $response->assertRedirect(route('dashboard.guru.index'));

        $this->assertDatabaseHas('users', [
            'id'    => $user->id,
            'email' => 'new_email@mail.com',
            'name'  => 'Antonius Budi Revised, S.Pd'
        ]);

        $this->assertDatabaseHas('guru', [
            'id'           => $guru->id,
            'nama_lengkap' => 'Antonius Budi Revised, S.Pd',
            'tempat_lahir' => 'Tambolaka',
            'status'       => 'Cuti',
        ]);
    }

    /**
     * Test destroy method deletes a teacher and their user account.
     */
    public function test_destroy_deletes_guru_successfully(): void
    {
        $user = User::factory()->create();
        $user->assignRole('guru');

        $guru = Guru::create([
            'user_id'          => $user->id,
            'nip'              => '198503122010011002',
            'nama_lengkap'     => 'Antonius Budi, S.Pd',
            'nama_panggilan'   => 'Anton',
            'jenis_kelamin_id' => $this->jenisKelamin->id,
            'agama_id'         => $this->agama->id,
            'tempat_lahir'     => 'Weetabula',
            'tanggal_lahir'    => '1985-03-12',
            'telepon'          => '081234567890',
            'alamat'           => 'Jl. Melati No. 12, Weetabula',
            'tipe'             => 'Wali Kelas',
            'status'           => 'Aktif',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->delete(route('dashboard.guru.destroy', $guru));

        $response->assertRedirect(route('dashboard.guru.index'));
        $this->assertDatabaseMissing('guru', ['id' => $guru->id]);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /**
     * Test bulkDestroy method deletes multiple teachers and their user accounts.
     */
    public function test_bulk_destroy_deletes_selected_gurus_successfully(): void
    {
        $user1 = User::factory()->create();
        $user1->assignRole('guru');
        $guru1 = Guru::create([
            'user_id'          => $user1->id,
            'nip'              => 'NIP1',
            'nama_lengkap'     => 'Teacher 1',
            'jenis_kelamin_id' => $this->jenisKelamin->id,
            'agama_id'         => $this->agama->id,
            'tempat_lahir'     => 'Weetabula',
            'tanggal_lahir'    => '1990-01-01',
            'telepon'          => '08111',
            'alamat'           => 'Alamat 1',
            'tipe'             => 'Bukan Wali Kelas'
        ]);

        $user2 = User::factory()->create();
        $user2->assignRole('guru');
        $guru2 = Guru::create([
            'user_id'          => $user2->id,
            'nip'              => 'NIP2',
            'nama_lengkap'     => 'Teacher 2',
            'jenis_kelamin_id' => $this->jenisKelamin->id,
            'agama_id'         => $this->agama->id,
            'tempat_lahir'     => 'Weetabula',
            'tanggal_lahir'    => '1990-01-01',
            'telepon'          => '08112',
            'alamat'           => 'Alamat 2',
            'tipe'             => 'Bukan Wali Kelas'
        ]);

        $user3 = User::factory()->create();
        $user3->assignRole('guru');
        $guru3 = Guru::create([
            'user_id'          => $user3->id,
            'nip'              => 'NIP3',
            'nama_lengkap'     => 'Teacher 3',
            'jenis_kelamin_id' => $this->jenisKelamin->id,
            'agama_id'         => $this->agama->id,
            'tempat_lahir'     => 'Weetabula',
            'tanggal_lahir'    => '1990-01-01',
            'telepon'          => '08113',
            'alamat'           => 'Alamat 3',
            'tipe'             => 'Bukan Wali Kelas'
        ]);

        $response = $this->actingAs($this->adminUser)
            ->post(route('dashboard.guru.bulk-destroy'), [
                'ids' => [$guru1->id, $guru3->id]
            ]);

        $response->assertRedirect(route('dashboard.guru.index'));

        $this->assertDatabaseMissing('guru', ['id' => $guru1->id]);
        $this->assertDatabaseMissing('users', ['id' => $user1->id]);

        $this->assertDatabaseMissing('guru', ['id' => $guru3->id]);
        $this->assertDatabaseMissing('users', ['id' => $user3->id]);

        $this->assertDatabaseHas('guru', ['id' => $guru2->id]);
        $this->assertDatabaseHas('users', ['id' => $user2->id]);
    }

    /**
     * Test show method returns JSON successfully.
     */
    public function test_show_returns_json_successfully(): void
    {
        $user = User::factory()->create();
        $user->assignRole('guru');
        $guru = Guru::create([
            'user_id'          => $user->id,
            'nip'              => '198503122010011002',
            'nama_lengkap'     => 'Antonius Budi, S.Pd',
            'nama_panggilan'   => 'Anton',
            'jenis_kelamin_id' => $this->jenisKelamin->id,
            'agama_id'         => $this->agama->id,
            'tempat_lahir'     => 'Weetabula',
            'tanggal_lahir'    => '1985-03-12',
            'telepon'          => '081234567890',
            'alamat'           => 'Jl. Melati No. 12, Weetabula',
            'tipe'             => 'Wali Kelas',
            'status'           => 'Aktif',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->getJson(route('dashboard.guru.show', $guru));

        $response->assertStatus(200);
        $response->assertJson([
            'nip'          => '198503122010011002',
            'nama_lengkap' => 'Antonius Budi, S.Pd',
        ]);
    }

    /**
     * Test only one Kepala Sekolah is allowed in the system.
     */
    public function test_cannot_create_multiple_kepala_sekolah(): void
    {
        // 1. Setup existing Kepala Sekolah
        $existingUser = User::factory()->create();
        $existingUser->assignRole('kepala-sekolah');
        Guru::create([
            'user_id'          => $existingUser->id,
            'nip'              => '198503122010011002',
            'nama_lengkap'     => 'Existing Kepala Sekolah',
            'jenis_kelamin_id' => $this->jenisKelamin->id,
            'agama_id'         => $this->agama->id,
            'tempat_lahir'     => 'Weetabula',
            'tanggal_lahir'    => '1985-03-12',
            'telepon'          => '081234567890',
            'alamat'           => 'Jl. Melati No. 12, Weetabula',
            'tipe'             => 'Kepala Sekolah',
            'status'           => 'Aktif',
        ]);

        // 2. Try to store another Kepala Sekolah
        $newGuruData = [
            'email'                 => 'new_kepsek@mail.com',
            'password'              => '12345678',
            'password_confirmation' => '12345678',
            'nip'                   => '998877665544332',
            'nama_lengkap'       => 'Clashing Kepala Sekolah',
            'jenis_kelamin_id'   => $this->jenisKelamin->id,
            'agama_id'           => $this->agama->id,
            'tempat_lahir'       => 'Weetabula',
            'tanggal_lahir'      => '1990-01-01',
            'telepon'            => '08111222333',
            'alamat'             => 'Jl. Pendidikan No. 5',
            'tipe'               => 'Kepala Sekolah',
            'status'             => 'Aktif',
            'mata_pelajaran_ids' => [$this->subject->id]
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('dashboard.guru.store'), $newGuruData);

        $response->assertSessionHasErrors(['tipe']);
    }

    /**
     * Test storing a Kepala Sekolah assigns correct Spatie role.
     */
    public function test_storing_kepala_sekolah_assigns_correct_spatie_role(): void
    {
        $guruData = [
            'email'                 => 'kepsek_role@mail.com',
            'password'              => '12345678',
            'password_confirmation' => '12345678',
            'nip'                   => '123456789012345',
            'nama_lengkap'       => 'Testing Kepsek, S.Pd',
            'jenis_kelamin_id'   => $this->jenisKelamin->id,
            'agama_id'           => $this->agama->id,
            'tempat_lahir'       => 'Weetabula',
            'tanggal_lahir'      => '1990-01-01',
            'telepon'            => '08111222333',
            'alamat'             => 'Jl. Pendidikan No. 5',
            'tipe'               => 'Kepala Sekolah',
            'status'             => 'Aktif',
            'mata_pelajaran_ids' => [$this->subject->id]
        ];

        $this->actingAs($this->adminUser)
            ->post(route('dashboard.guru.store'), $guruData);

        $user = User::where('email', 'kepsek_role@mail.com')->firstOrFail();
        $this->assertTrue($user->hasRole('kepala-sekolah'));
        $this->assertFalse($user->hasRole('guru'));
    }

    /**
     * Test storing a Guru fails if password confirmation does not match.
     */
    public function test_storing_guru_fails_if_password_confirmation_does_not_match(): void
    {
        $guruData = [
            'email'                 => 'testing_pass@mail.com',
            'password'              => '12345678',
            'password_confirmation' => 'different_password',
            'nip'                   => '123456789012345',
            'nama_lengkap'          => 'Testing Teacher, S.Pd',
            'jenis_kelamin_id'      => $this->jenisKelamin->id,
            'agama_id'              => $this->agama->id,
            'tempat_lahir'          => 'Weetabula',
            'tanggal_lahir'         => '1990-01-01',
            'telepon'               => '08111222333',
            'alamat'                => 'Jl. Pendidikan No. 5',
            'tipe'                  => 'Bukan Wali Kelas',
            'status'                => 'Aktif',
            'mata_pelajaran_ids'    => [$this->subject->id]
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('dashboard.guru.store'), $guruData);

        $response->assertSessionHasErrors(['password']);
    }

    /**
     * Test storing a Guru succeeds if NIP is null/not provided.
     */
    public function test_storing_guru_with_nullable_nip_succeeds(): void
    {
        $guruData = [
            'email'                 => 'nullable_nip@mail.com',
            'password'              => '12345678',
            'password_confirmation' => '12345678',
            'nip'                   => null,
            'nama_lengkap'          => 'No NIP Teacher, S.Pd',
            'jenis_kelamin_id'      => $this->jenisKelamin->id,
            'agama_id'              => $this->agama->id,
            'tempat_lahir'          => 'Weetabula',
            'tanggal_lahir'         => '1990-01-01',
            'telepon'               => '08111222333',
            'alamat'                => 'Jl. Pendidikan No. 5',
            'tipe'                  => 'Bukan Wali Kelas',
            'status'             => 'Aktif',
            'mata_pelajaran_ids' => [$this->subject->id]
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('dashboard.guru.store'), $guruData);

        $response->assertRedirect(route('dashboard.guru.index'));

        $this->assertDatabaseHas('guru', [
            'nama_lengkap' => 'No NIP Teacher, S.Pd',
            'nip'          => null,
        ]);
    }

    /**
     * Test importing a valid CSV successfully.
     */
    public function test_import_csv_successfully(): void
    {
        $csvContent = "Email,NIP,Nama Lengkap,Nama Panggilan,Jenis Kelamin,Agama,Tempat Lahir,Tanggal Lahir,Telepon,Alamat,Tipe Jabatan,Status,Mata Pelajaran\n"
                    . "imported_teacher@mail.com,123456789012345,Imported Teacher,Imported,Laki-laki,Katolik,Weetabula,1990-01-01,08111222333,Jl. Sekolah No. 1,Bukan Wali Kelas,Aktif,Matematika";

        $file = \Illuminate\Http\UploadedFile::fake()->createWithContent('teachers.csv', $csvContent);

        $response = $this->actingAs($this->adminUser)
            ->post(route('dashboard.guru.import'), [
                'csv_file' => $file
            ]);

        $response->assertRedirect(route('dashboard.guru.index'));

        $this->assertDatabaseHas('users', [
            'email' => 'imported_teacher@mail.com',
            'name' => 'Imported Teacher'
        ]);

        $this->assertDatabaseHas('guru', [
            'nip' => '123456789012345',
            'nama_lengkap' => 'Imported Teacher',
            'tempat_lahir' => 'Weetabula',
            'telepon' => '08111222333',
            'tipe' => 'Bukan Wali Kelas',
            'status' => 'Aktif',
        ]);

        $guru = Guru::where('nip', '123456789012345')->first();
        $this->assertNotNull($guru);
        $this->assertTrue($guru->mataPelajaran->contains($this->subject->id));
        
        $user = User::where('email', 'imported_teacher@mail.com')->first();
        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('guru'));
    }

    /**
     * Test importing a CSV with invalid rows skips those rows but processes valid ones.
     */
    public function test_import_csv_skips_invalid_rows(): void
    {
        // Let's pre-seed one Kepala Sekolah to test that clashing ones are skipped
        $existingKepsekUser = User::factory()->create();
        $existingKepsekUser->assignRole('kepala-sekolah');
        Guru::create([
            'user_id'          => $existingKepsekUser->id,
            'nip'              => '999999999999999',
            'nama_lengkap'     => 'Existing Kepala Sekolah',
            'jenis_kelamin_id' => $this->jenisKelamin->id,
            'agama_id'         => $this->agama->id,
            'tempat_lahir'     => 'Weetabula',
            'tanggal_lahir'    => '1980-01-01',
            'telepon'          => '081234',
            'alamat'           => 'Jl. Utama No. 1',
            'tipe'             => 'Kepala Sekolah',
            'status'           => 'Aktif',
        ]);

        // Construct CSV:
        // Row 1: Valid row (Should be imported)
        // Row 2: Empty required field (skipped)
        // Row 3: Invalid gender lookup (skipped)
        // Row 4: Invalid subject lookup (skipped)
        // Row 5: Duplicate email (skipped)
        // Row 6: Clashing Kepala Sekolah (skipped)
        $csvContent = "Email,NIP,Nama Lengkap,Nama Panggilan,Jenis Kelamin,Agama,Tempat Lahir,Tanggal Lahir,Telepon,Alamat,Tipe Jabatan,Status,Mata Pelajaran\n"
                    . "valid_import@mail.com,111222333,Valid Import,Valid,Laki-laki,Katolik,Tambolaka,1992-05-05,081234567,Jl. Sukses No. 2,Wali Kelas,Aktif,Matematika\n"
                    . ",111222334,,Empty Field,Laki-laki,Katolik,Tambolaka,1992-05-05,081234567,Jl. Sukses No. 2,Wali Kelas,Aktif,Matematika\n"
                    . "invalid_gender@mail.com,111222335,Invalid Gender,Gender,Non-Binary,Katolik,Tambolaka,1992-05-05,081234567,Jl. Sukses No. 2,Wali Kelas,Aktif,Matematika\n"
                    . "invalid_subject@mail.com,111222336,Invalid Subject,Subject,Laki-laki,Katolik,Tambolaka,1992-05-05,081234567,Jl. Sukses No. 2,Wali Kelas,Aktif,Physics\n"
                    . "valid_import@mail.com,111222337,Duplicate Email,Email,Laki-laki,Katolik,Tambolaka,1992-05-05,081234567,Jl. Sukses No. 2,Wali Kelas,Aktif,Matematika\n"
                    . "clash_kepsek@mail.com,111222338,Clash Kepsek,Kepsek,Laki-laki,Katolik,Tambolaka,1992-05-05,081234567,Jl. Sukses No. 2,Kepala Sekolah,Aktif,Matematika";

        $file = \Illuminate\Http\UploadedFile::fake()->createWithContent('mixed_teachers.csv', $csvContent);

        $response = $this->actingAs($this->adminUser)
            ->post(route('dashboard.guru.import'), [
                'csv_file' => $file
            ]);

        $response->assertRedirect(route('dashboard.guru.index'));

        // Assert valid row was imported
        $this->assertDatabaseHas('users', [
            'email' => 'valid_import@mail.com',
            'name' => 'Valid Import'
        ]);

        $this->assertDatabaseHas('guru', [
            'nip' => '111222333',
            'nama_lengkap' => 'Valid Import'
        ]);

        // Assert invalid rows were skipped
        $this->assertDatabaseMissing('users', ['email' => 'invalid_gender@mail.com']);
        $this->assertDatabaseMissing('users', ['email' => 'invalid_subject@mail.com']);
        $this->assertDatabaseMissing('users', ['email' => 'clash_kepsek@mail.com']);
    }

    /**
     * Test download template csv succeeds and matches expected structure.
     */
    public function test_download_template_csv_succeeds(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('dashboard.guru.template'));

        $response->assertStatus(200);
        $this->assertStringContainsString('text/csv', $response->headers->get('Content-Type'));
        $this->assertEquals('attachment; filename="template-guru.csv"', $response->headers->get('Content-Disposition'));

        $content = $response->streamedContent();

        // Assert headers are in the CSV content
        $this->assertStringContainsString('Email', $content);
        $this->assertStringContainsString('NIP', $content);
        $this->assertStringContainsString('Nama Lengkap', $content);

        // Assert sample row is in the CSV content
        $this->assertStringContainsString('antonius@mail.com', $content);
        $this->assertStringContainsString('198503122010011002', $content);
        $this->assertStringContainsString('Antonius Budi, S.Pd', $content);
        $this->assertStringContainsString('Matematika, Ilmu Pengetahuan Alam dan Sosial (IPAS)', $content);
    }
}

