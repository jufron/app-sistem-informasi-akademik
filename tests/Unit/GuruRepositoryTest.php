<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Guru;
use App\Models\Agama;
use App\Models\JenisKelamin;
use App\Models\User;
use App\Repositories\Interfaces\GuruRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class GuruRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected GuruRepositoryInterface $guruRepo;
    protected Agama $agama;
    protected JenisKelamin $jenisKelamin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->guruRepo = $this->app->make(GuruRepositoryInterface::class);
        
        $this->agama = Agama::create(['nama' => 'Katolik']);
        $this->jenisKelamin = JenisKelamin::create(['nama' => 'Laki-laki', 'kode' => 'L']);
        
        Cache::flush();
    }

    /**
     * Test existsByNip checks if NIP already exists.
     */
    public function test_exists_by_nip(): void
    {
        $this->assertFalse($this->guruRepo->existsByNip('111222'));

        $user = User::factory()->create();
        Guru::create([
            'user_id' => $user->id,
            'nip' => '111222',
            'nama_lengkap' => 'Teacher',
            'jenis_kelamin_id' => $this->jenisKelamin->id,
            'agama_id' => $this->agama->id,
            'tempat_lahir' => 'Weetabula',
            'tanggal_lahir' => '1990-01-01',
            'telepon' => '123',
            'alamat' => 'Alamat',
            'tipe' => 'Bukan Wali Kelas',
            'status' => 'Aktif'
        ]);

        $this->assertTrue($this->guruRepo->existsByNip('111222'));
    }

    /**
     * Test hasPrincipal checks single principal existence correctly.
     */
    public function test_has_principal(): void
    {
        $this->assertFalse($this->guruRepo->hasPrincipal());

        $user = User::factory()->create();
        $principal = Guru::create([
            'user_id' => $user->id,
            'nip' => '999',
            'nama_lengkap' => 'Principal',
            'jenis_kelamin_id' => $this->jenisKelamin->id,
            'agama_id' => $this->agama->id,
            'tempat_lahir' => 'Weetabula',
            'tanggal_lahir' => '1990-01-01',
            'telepon' => '123',
            'alamat' => 'Alamat',
            'tipe' => 'Kepala Sekolah',
            'status' => 'Aktif'
        ]);

        $this->assertTrue($this->guruRepo->hasPrincipal());
        
        // Excluding principal's own ID should return false
        $this->assertFalse($this->guruRepo->hasPrincipal($principal->id));
    }

    /**
     * Test getByIds returns selected teachers.
     */
    public function test_get_by_ids(): void
    {
        $user1 = User::factory()->create();
        $g1 = Guru::create([
            'user_id' => $user1->id,
            'nip' => '1',
            'nama_lengkap' => 'Teacher One',
            'jenis_kelamin_id' => $this->jenisKelamin->id,
            'agama_id' => $this->agama->id,
            'tempat_lahir' => 'Weetabula',
            'tanggal_lahir' => '1990-01-01',
            'telepon' => '123',
            'alamat' => 'Alamat',
            'tipe' => 'Bukan Wali Kelas',
            'status' => 'Aktif'
        ]);

        $user2 = User::factory()->create();
        $g2 = Guru::create([
            'user_id' => $user2->id,
            'nip' => '2',
            'nama_lengkap' => 'Teacher Two',
            'jenis_kelamin_id' => $this->jenisKelamin->id,
            'agama_id' => $this->agama->id,
            'tempat_lahir' => 'Weetabula',
            'tanggal_lahir' => '1990-01-01',
            'telepon' => '123',
            'alamat' => 'Alamat',
            'tipe' => 'Bukan Wali Kelas',
            'status' => 'Aktif'
        ]);

        $result = $this->guruRepo->getByIds([$g1->id, $g2->id]);
        $this->assertCount(2, $result);
        $this->assertTrue($result->contains($g1));
        $this->assertTrue($result->contains($g2));
    }

    /**
     * Test getTeachersForHomeSlide builds carousel slides format and caches it.
     */
    public function test_get_teachers_for_home_slide_mapping_and_caching(): void
    {
        $user1 = User::factory()->create();
        Guru::create([
            'user_id' => $user1->id,
            'nip' => '123',
            'nama_lengkap' => 'Antonius Budi',
            'jenis_kelamin_id' => $this->jenisKelamin->id,
            'agama_id' => $this->agama->id,
            'tempat_lahir' => 'Weetabula',
            'tanggal_lahir' => '1985-03-12',
            'telepon' => '123',
            'alamat' => 'Alamat',
            'tipe' => 'Wali Kelas',
            'status' => 'Aktif'
        ]);

        $slides = $this->guruRepo->getTeachersForHomeSlide();
        $this->assertCount(1, $slides);
        $this->assertEquals('Antonius Budi', $slides[0]['name']);
        $this->assertEquals('Wali Kelas & Guru ', $slides[0]['role']);
        $this->assertEquals('Pendidikan bukan sekadar transfer ilmu, tapi pembentukan karakter dan logika bernalar.', $slides[0]['quote']);
        $this->assertTrue(Cache::has('guru_home_slides'));

        // Modifying teacher triggers cache invalidation
        $user2 = User::factory()->create();
        $this->guruRepo->create([
            'user_id' => $user2->id,
            'nip' => '456',
            'nama_lengkap' => 'Maria Yosefina',
            'jenis_kelamin_id' => $this->jenisKelamin->id,
            'agama_id' => $this->agama->id,
            'tempat_lahir' => 'Weetabula',
            'tanggal_lahir' => '1990-08-24',
            'telepon' => '123',
            'alamat' => 'Alamat',
            'tipe' => 'Bukan Wali Kelas',
            'status' => 'Aktif'
        ]);

        $this->assertFalse(Cache::has('guru_home_slides'));
    }
}
