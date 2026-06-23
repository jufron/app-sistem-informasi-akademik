<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Guru;
use App\Repositories\Interfaces\GuruRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Class GuruRepository
 * 
 * Repository implementation for managing teacher (Guru) database operations with caching.
 */
class GuruRepository implements GuruRepositoryInterface
{
    /**
     * Retrieve all teacher records. Cached for 7 days.
     *
     * @return Collection<int, Guru>
     */
    public function getAll(): Collection
    {
        return Cache::remember('guru_all', now()->addDays(7), function () {
            return Guru::all();
        });
    }

    /**
     * Find a specific teacher record by ID.
     *
     * @param int|string $id
     * @return Guru|null
     */
    public function findById(int|string $id): ?Guru
    {
        return Guru::find($id);
    }

    /**
     * Create a new teacher record. Clears related cache keys.
     *
     * @param array $data
     * @return Guru
     */
    public function create(array $data): Guru
    {
        $guru = Guru::create($data);
        $this->clearCache();
        return $guru;
    }

    /**
     * Update an existing teacher record. Clears related cache keys.
     *
     * @param int|string $id
     * @param array $data
     * @return Guru
     */
    public function update(int|string $id, array $data): Guru
    {
        $model = Guru::findOrFail($id);
        $model->update($data);
        $this->clearCache();
        return $model;
    }

    /**
     * Delete a specific teacher record. Clears related cache keys.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $model = Guru::findOrFail($id);
        $deleted = (bool) $model->delete();
        if ($deleted) {
            $this->clearCache();
        }
        return $deleted;
    }

    /**
     * Check if a principal already exists.
     *
     * @param int|string|null $excludeId
     * @return bool
     */
    public function hasPrincipal(int|string|null $excludeId = null): bool
    {
        $query = Guru::where('tipe', 'Kepala Sekolah');
        if ($excludeId !== null) {
            $query->where('id', '!=', $excludeId);
        }
        return $query->exists();
    }

    /**
     * Check if a teacher exists with the given NIP.
     *
     * @param string $nip
     * @return bool
     */
    public function existsByNip(string $nip): bool
    {
        return Guru::where('nip', $nip)->exists();
    }

    /**
     * Retrieve multiple teacher records by their IDs.
     *
     * @param array $ids
     * @return Collection
     */
    public function getByIds(array $ids): Collection
    {
        return Guru::whereIn('id', $ids)->get();
    }

    /**
     * Count the total number of teachers.
     *
     * @return int
     */
    public function count(): int
    {
        return Guru::count();
    }

    /**
     * Get a formatted list of teachers structured for the homepage carousel slides. Cached for 7 days.
     *
     * @return array
     */
    public function getTeachersForHomeSlide(): array
    {
        return Cache::remember('guru_home_slides', now()->addDays(7), function () {
            // Eager load mataPelajaran to prevent N+1 queries
            $teachers = Guru::with(['mataPelajaran', 'jenisKelamin'])->where('status', 'Aktif')->get();

            $quotesMap = [
                'Antonius Budi' => 'Pendidikan bukan sekadar transfer ilmu, tapi pembentukan karakter dan logika bernalar.',
                'Maria Yosefina' => 'Membuka jendela dunia untuk anak-anak melalui bahasa dan keberanian berekspresi.',
                'Yohanes Don Bosco' => 'Iman yang kuat adalah kompas terbaik bagi anak-anak untuk mengarungi masa depan.',
            ];

            $imagesMap = [
                'Antonius Budi' => 'https://images.unsplash.com/photo-1568602471122-7832951cc4c5?q=80&w=2070&auto=format&fit=crop',
                'Maria Yosefina' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=1976&auto=format&fit=crop',
                'Yohanes Don Bosco' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=1974&auto=format&fit=crop',
            ];

            $slides = [];

            foreach ($teachers as $guru) {
                // Determine photo URL
                $img = null;
                if (!empty($guru->foto)) {
                    if (str_starts_with($guru->foto, 'assets/') || str_starts_with($guru->foto, 'img/')) {
                        $img = asset($guru->foto);
                    } else {
                        $img = asset('storage/' . $guru->foto);
                    }
                }

                // Fallback to Unsplash images based on matching seeded names
                if (empty($img)) {
                    foreach ($imagesMap as $nameKey => $imgUrl) {
                        if (stripos($guru->nama_lengkap, $nameKey) !== false) {
                            $img = $imgUrl;
                            break;
                        }
                    }
                }

                // Final safety image fallback
                if (empty($img)) {
                    if ($guru->jenisKelamin && $guru->jenisKelamin->kode === 'P') {
                        $img = 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=1976&auto=format&fit=crop';
                    } else {
                        $img = 'https://images.unsplash.com/photo-1568602471122-7832951cc4c5?q=80&w=2070&auto=format&fit=crop';
                    }
                }

                // Determine Quote
                $quote = 'Mendidik dengan hati untuk menggali potensi emas setiap siswa.';
                foreach ($quotesMap as $nameKey => $qText) {
                    if (stripos($guru->nama_lengkap, $nameKey) !== false) {
                        $quote = $qText;
                        break;
                    }
                }

                // Determine Role
                $subjects = $guru->mataPelajaran->pluck('nama')->implode(' & ');
                if ($guru->tipe === 'Kepala Sekolah') {
                    $role = 'Kepala Sekolah';
                } else if ($guru->tipe === 'Wali Kelas') {
                    $role = 'Wali Kelas & Guru ' . $subjects;
                } else {
                    $role = 'Guru ' . $subjects;
                }

                $slides[] = [
                    'name'  => $guru->nama_lengkap,
                    'role'  => $role,
                    'quote' => $quote,
                    'img'   => $img
                ];
            }

            return $slides;
        });
    }

    /**
     * Clear all cached keys related to teacher operations.
     *
     * @return void
     */
    private function clearCache(): void
    {
        Cache::forget('guru_all');
        Cache::forget('guru_home_slides');
    }
}

