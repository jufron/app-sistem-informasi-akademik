<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Agama;
use App\Models\JenisKelamin;
use App\Models\MataPelajaran;
use App\Models\Guru;
use App\Models\User;
use App\Services\Interfaces\GuruServiceInterface;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GuruServiceTest extends TestCase
{
    use RefreshDatabase;

    protected GuruServiceInterface $guruService;
    protected Agama $agama;
    protected JenisKelamin $jenisKelamin;
    protected MataPelajaran $subject1;
    protected MataPelajaran $subject2;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles for Spatie Role setup
        $this->seed(RoleSeeder::class);

        // Retrieve our injected service interface from Laravel container
        $this->guruService = $this->app->make(GuruServiceInterface::class);

        // Pre-create lookups
        $this->agama = Agama::create(['nama' => 'Katolik']);
        $this->jenisKelamin = JenisKelamin::create(['nama' => 'Laki-laki', 'kode' => 'L']);
        $this->subject1 = MataPelajaran::create(['nama' => 'Fisika', 'deskripsi' => 'Fisika Dasar']);
        $this->subject2 = MataPelajaran::create(['nama' => 'Kimia', 'deskripsi' => 'Kimia Organik']);

        // Setup storage fake for file uploads
        Storage::fake('public');
    }

    /**
     * Test service store creates user, profile, roles and maps relations.
     */
    public function test_service_stores_guru_and_user_successfully(): void
    {
        $foto = UploadedFile::fake()->image('guru_avatar.jpg');

        $data = [
            'email'              => 'john_service@mail.com',
            'password'           => 'secret123',
            'nip'                => '1234567890123456',
            'nama_lengkap'       => 'John Doe, M.Pd',
            'nama_panggilan'     => 'John',
            'jenis_kelamin_id'   => $this->jenisKelamin->id,
            'agama_id'           => $this->agama->id,
            'tempat_lahir'       => 'Ruteng',
            'tanggal_lahir'      => '1988-12-05',
            'telepon'            => '081234567890',
            'alamat'             => 'Jl. Mangga No. 4',
            'tipe'               => 'Wali Kelas',
            'status'             => 'Aktif',
            'mata_pelajaran_ids' => [$this->subject1->id, $this->subject2->id]
        ];

        $guru = $this->guruService->store($data, $foto);

        $this->assertInstanceOf(Guru::class, $guru);
        $this->assertEquals('1234567890123456', $guru->nip);

        // Verify User Account
        $user = $guru->user;
        $this->assertNotNull($user);
        $this->assertEquals('john_service@mail.com', $user->email);
        $this->assertTrue($user->hasRole('guru'));

        // Verify Photo Uploaded
        $this->assertNotNull($guru->foto);
        Storage::disk('public')->assertExists($guru->foto);

        // Verify many-to-many relationship
        $this->assertCount(2, $guru->mataPelajaran);
        $this->assertTrue($guru->mataPelajaran->contains($this->subject1));
        $this->assertTrue($guru->mataPelajaran->contains($this->subject2));
    }

    /**
     * Test service update updates user details, hashes new password, replaces photo and updates many-to-many.
     */
    public function test_service_updates_guru_and_user_successfully(): void
    {
        // 1. First store a teacher
        $oldFoto = UploadedFile::fake()->image('old_avatar.png');

        $storeData = [
            'email'              => 'old_email@mail.com',
            'password'           => 'old_pass123',
            'nip'                => '12345',
            'nama_lengkap'       => 'Old Name',
            'jenis_kelamin_id'   => $this->jenisKelamin->id,
            'agama_id'           => $this->agama->id,
            'tempat_lahir'       => 'Ruteng',
            'tanggal_lahir'      => '1990-01-01',
            'telepon'            => '081',
            'alamat'             => 'Alamat',
            'tipe'               => 'Bukan Wali Kelas',
            'status'             => 'Aktif',
            'mata_pelajaran_ids' => [$this->subject1->id]
        ];

        $guru = $this->guruService->store($storeData, $oldFoto);
        $oldFotoPath = $guru->foto;
        Storage::disk('public')->assertExists($oldFotoPath);

        // 2. Perform update
        $newFoto = UploadedFile::fake()->image('new_avatar.png');

        $updateData = [
            'email'              => 'new_email@mail.com',
            'password'           => 'new_secure_pass',
            'nip'                => '12345_updated',
            'nama_lengkap'       => 'New Name, S.Si',
            'nama_panggilan'     => 'New',
            'jenis_kelamin_id'   => $this->jenisKelamin->id,
            'agama_id'           => $this->agama->id,
            'tempat_lahir'       => 'Kupang',
            'tanggal_lahir'      => '1990-01-01',
            'telepon'            => '082',
            'alamat'             => 'Alamat Baru',
            'tipe'               => 'Wali Kelas',
            'status'             => 'Cuti',
            'mata_pelajaran_ids' => [$this->subject2->id] // update subjects
        ];

        $updatedGuru = $this->guruService->update($guru, $updateData, $newFoto);

        // Verify teacher and user changes
        $this->assertEquals('12345_updated', $updatedGuru->nip);
        $this->assertEquals('New Name, S.Si', $updatedGuru->nama_lengkap);
        $this->assertEquals('new_email@mail.com', $updatedGuru->user->email);
        $this->assertEquals('Cuti', $updatedGuru->status);

        // Verify password updated successfully
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('new_secure_pass', $updatedGuru->user->password));

        // Verify new photo exists and old photo is deleted
        Storage::disk('public')->assertExists($updatedGuru->foto);
        Storage::disk('public')->assertMissing($oldFotoPath);

        // Verify relationship update
        $updatedGuru->load('mataPelajaran');
        $this->assertCount(1, $updatedGuru->mataPelajaran);
        $this->assertTrue($updatedGuru->mataPelajaran->contains($this->subject2));
        $this->assertFalse($updatedGuru->mataPelajaran->contains($this->subject1));
    }

    /**
     * Test service destroy deletes guru profile, user account, detaches relationships and deletes files.
     */
    public function test_service_deletes_guru_and_user_successfully(): void
    {
        $foto = UploadedFile::fake()->image('avatar.jpg');

        $data = [
            'email'              => 'delete_me@mail.com',
            'password'           => 'pass',
            'nip'                => '54321',
            'nama_lengkap'       => 'Delete Me',
            'jenis_kelamin_id'   => $this->jenisKelamin->id,
            'agama_id'           => $this->agama->id,
            'tempat_lahir'       => 'Lahir',
            'tanggal_lahir'      => '1990-01-01',
            'telepon'            => '123',
            'alamat'             => 'Alamat',
            'tipe'               => 'Bukan Wali Kelas',
            'status'             => 'Aktif',
            'mata_pelajaran_ids' => [$this->subject1->id]
        ];

        $guru = $this->guruService->store($data, $foto);
        $fotoPath = $guru->foto;
        $userId = $guru->user_id;

        $result = $this->guruService->destroy($guru);

        $this->assertTrue($result);

        // Assert database clean up
        $this->assertDatabaseMissing('guru', ['id' => $guru->id]);
        $this->assertDatabaseMissing('users', ['id' => $userId]);
        $this->assertDatabaseMissing('guru_mata_pelajaran', [
            'guru_id'           => $guru->id,
            'mata_pelajaran_id' => $this->subject1->id
        ]);

        // Assert photo file is deleted
        Storage::disk('public')->assertMissing($fotoPath);
    }

    /**
     * Test bulkDestroy deletes multiple teachers, users, relationships and files.
     */
    public function test_service_bulk_destroys_gurus_and_users_successfully(): void
    {
        $foto1 = UploadedFile::fake()->image('avatar1.jpg');
        $foto2 = UploadedFile::fake()->image('avatar2.jpg');

        $teacher1 = $this->guruService->store([
            'email'              => 't1@mail.com',
            'password'           => 'pass',
            'nip'                => '111',
            'nama_lengkap'       => 'Teacher One',
            'jenis_kelamin_id'   => $this->jenisKelamin->id,
            'agama_id'           => $this->agama->id,
            'tempat_lahir'       => 'L',
            'tanggal_lahir'      => '1990-01-01',
            'telepon'            => '1',
            'alamat'             => 'A',
            'tipe'               => 'Bukan Wali Kelas',
            'status'             => 'Aktif',
            'mata_pelajaran_ids' => [$this->subject1->id]
        ], $foto1);

        $teacher2 = $this->guruService->store([
            'email'              => 't2@mail.com',
            'password'           => 'pass',
            'nip'                => '222',
            'nama_lengkap'       => 'Teacher Two',
            'jenis_kelamin_id'   => $this->jenisKelamin->id,
            'agama_id'           => $this->agama->id,
            'tempat_lahir'       => 'L',
            'tanggal_lahir'      => '1990-01-01',
            'telepon'            => '2',
            'alamat'             => 'A',
            'tipe'               => 'Bukan Wali Kelas',
            'status'             => 'Aktif',
            'mata_pelajaran_ids' => [$this->subject2->id]
        ], $foto2);

        $path1 = $teacher1->foto;
        $path2 = $teacher2->foto;

        $result = $this->guruService->bulkDestroy([$teacher1->id, $teacher2->id]);

        $this->assertTrue($result);

        // Check DB clean
        $this->assertDatabaseMissing('guru', ['id' => $teacher1->id]);
        $this->assertDatabaseMissing('users', ['id' => $teacher1->user_id]);
        $this->assertDatabaseMissing('guru', ['id' => $teacher2->id]);
        $this->assertDatabaseMissing('users', ['id' => $teacher2->user_id]);

        // Check files are deleted
        Storage::disk('public')->assertMissing($path1);
        Storage::disk('public')->assertMissing($path2);
    }
}
