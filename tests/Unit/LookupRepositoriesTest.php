<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Agama;
use App\Models\JenisKelamin;
use App\Models\MataPelajaran;
use App\Models\User;
use App\Repositories\Interfaces\AgamaRepositoryInterface;
use App\Repositories\Interfaces\JenisKelaminRepositoryInterface;
use App\Repositories\Interfaces\MataPelajaranRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LookupRepositoriesTest extends TestCase
{
    use RefreshDatabase;

    protected AgamaRepositoryInterface $agamaRepo;
    protected JenisKelaminRepositoryInterface $jkRepo;
    protected MataPelajaranRepositoryInterface $mapelRepo;
    protected UserRepositoryInterface $userRepo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->agamaRepo = $this->app->make(AgamaRepositoryInterface::class);
        $this->jkRepo = $this->app->make(JenisKelaminRepositoryInterface::class);
        $this->mapelRepo = $this->app->make(MataPelajaranRepositoryInterface::class);
        $this->userRepo = $this->app->make(UserRepositoryInterface::class);
    }

    /**
     * Test AgamaRepository operations.
     */
    public function test_agama_repository_crud_and_lookup(): void
    {
        // 1. Create
        $agama = $this->agamaRepo->create(['nama' => 'Islam']);
        $this->assertInstanceOf(Agama::class, $agama);
        $this->assertDatabaseHas('agama', ['nama' => 'Islam']);

        // 2. Find by Name
        $found = $this->agamaRepo->findByName('Islam');
        $this->assertNotNull($found);
        $this->assertEquals($agama->id, $found->id);

        // 3. Get All
        $all = $this->agamaRepo->getAll();
        $this->assertCount(1, $all);

        // 4. Update
        $updated = $this->agamaRepo->update($agama->id, ['nama' => 'Kristen']);
        $this->assertEquals('Kristen', $updated->nama);

        // 5. Delete
        $this->assertTrue($this->agamaRepo->delete($agama->id));
        $this->assertDatabaseMissing('agama', ['id' => $agama->id]);
    }

    /**
     * Test JenisKelaminRepository operations.
     */
    public function test_jenis_kelamin_repository_crud_and_lookup(): void
    {
        // 1. Create
        $jk = $this->jkRepo->create(['nama' => 'Laki-laki', 'kode' => 'L']);
        $this->assertInstanceOf(JenisKelamin::class, $jk);
        $this->assertDatabaseHas('jenis_kelamin', ['nama' => 'Laki-laki']);

        // 2. Find by Name
        $found = $this->jkRepo->findByName('Laki-laki');
        $this->assertNotNull($found);
        $this->assertEquals($jk->id, $found->id);

        // 3. Get All
        $all = $this->jkRepo->getAll();
        $this->assertCount(1, $all);

        // 4. Update
        $updated = $this->jkRepo->update($jk->id, ['nama' => 'Perempuan', 'kode' => 'P']);
        $this->assertEquals('Perempuan', $updated->nama);

        // 5. Delete
        $this->assertTrue($this->jkRepo->delete($jk->id));
        $this->assertDatabaseMissing('jenis_kelamin', ['id' => $jk->id]);
    }

    /**
     * Test MataPelajaranRepository operations.
     */
    public function test_mata_pelajaran_repository_crud_and_lookup(): void
    {
        // 1. Create
        $mapel = $this->mapelRepo->create(['nama' => 'Matematika', 'deskripsi' => 'Berhitung']);
        $this->assertInstanceOf(MataPelajaran::class, $mapel);
        $this->assertDatabaseHas('mata_pelajaran', ['nama' => 'Matematika']);

        // 2. Find by Name
        $found = $this->mapelRepo->findByName('Matematika');
        $this->assertNotNull($found);
        $this->assertEquals($mapel->id, $found->id);

        // 3. Get All & Count
        $this->assertCount(1, $this->mapelRepo->getAll());
        $this->assertEquals(1, $this->mapelRepo->count());

        // 4. Update
        $updated = $this->mapelRepo->update($mapel->id, ['nama' => 'Fisika']);
        $this->assertEquals('Fisika', $updated->nama);

        // 5. Delete
        $this->assertTrue($this->mapelRepo->delete($mapel->id));
        $this->assertDatabaseMissing('mata_pelajaran', ['id' => $mapel->id]);
    }

    /**
     * Test UserRepository operations.
     */
    public function test_user_repository_crud_and_lookup(): void
    {
        // 1. Create
        $user = $this->userRepo->create([
            'name' => 'John Doe',
            'email' => 'john@mail.com',
            'password' => bcrypt('password')
        ]);
        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas('users', ['email' => 'john@mail.com']);

        // 2. Exists by Email
        $this->assertTrue($this->userRepo->existsByEmail('john@mail.com'));
        $this->assertFalse($this->userRepo->existsByEmail('other@mail.com'));

        // 3. Get All
        $all = $this->userRepo->getAll();
        $this->assertCount(1, $all);

        // 4. Find by ID
        $found = $this->userRepo->findById($user->id);
        $this->assertNotNull($found);
        $this->assertEquals($user->email, $found->email);

        // 5. Update
        $updated = $this->userRepo->update($user->id, ['name' => 'John U. Doe']);
        $this->assertEquals('John U. Doe', $updated->name);

        // 6. Delete
        $this->assertTrue($this->userRepo->delete($user->id));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
