<?php

namespace Tests\Feature;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Nilai;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NilaiControllerTest extends TestCase
{
    // Menggunakan trait RefreshDatabase agar setiap test berjalan di database yang bersih
    use RefreshDatabase;

    /**
     * Helper untuk login sebagai user sebelum menjalankan request.
     */
    private function loginAsUser()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        return $this->actingAs($user);
    }

    /**
     * Test 1: Pastikan halaman index bisa dibuka
     */
    public function test_halaman_index_nilai_bisa_diakses()
    {
        $response = $this->loginAsUser()->get(route('nilai.index'));

        $response->assertStatus(200);
    }

    /**
     * Test 2: Pastikan bisa menambah data nilai baru dengan relasi yang benar
     */
    public function test_bisa_menambah_data_nilai_baru()
    {
        // 1. Persiapkan data pendukung (Foreign Keys)
        $mahasiswa = Mahasiswa::factory()->create();
        $dosen = Dosen::factory()->create();
        $matakuliah = MataKuliah::factory()->create();

        // 2. Data form yang akan dikirim
        $formData = [
            'mahasiswa_id' => $mahasiswa->id,
            'dosen_id' => $dosen->id,
            'matakuliah_id' => $matakuliah->id,
            'nilai_angka' => 85,
            'nilai_huruf' => 'A'
        ];

        // 3. Lakukan request POST
        $response = $this->loginAsUser()->post(route('nilai.store'), $formData);

        // 4. Assertions (Pengecekan)
        // Pastikan redirect ke index
        $response->assertRedirect(route('nilai.index'));
        // Pastikan tidak ada error session
        $response->assertSessionHasNoErrors();

        // Cek apakah data benar-benar masuk ke database
        $this->assertDatabaseHas('nilai', [
            'mahasiswa_id' => $mahasiswa->id,
            'nilai_angka' => 85,
            'nilai_huruf' => 'A'
        ]);
    }

    /**
     * Test 3: Pastikan validasi berjalan jika form dikosongkan
     */
    public function test_validasi_gagal_jika_data_kosong()
    {
        // Kirim array kosong
        $response = $this->loginAsUser()->post(route('nilai.store'), []);

        // Pastikan muncul error validasi pada field wajib
        $response->assertSessionHasErrors([
            'mahasiswa_id', 
            'dosen_id', 
            'matakuliah_id', 
            'nilai_angka', 
            'nilai_huruf'
        ]);
    }

    /**
     * Test 4: Pastikan bisa mengupdate data nilai
     */
    public function test_bisa_mengupdate_data_nilai()
    {
        // 1. Buat data dummy awal
        $nilai = Nilai::factory()->create([
            'nilai_angka' => 60,
            'nilai_huruf' => 'C'
        ]);

        // 2. Data baru untuk update
        $updateData = [
            'mahasiswa_id' => $nilai->mahasiswa_id,
            'dosen_id' => $nilai->dosen_id,
            'matakuliah_id' => $nilai->matakuliah_id,
            'nilai_angka' => 90, // Nilai diperbaiki jadi 90
            'nilai_huruf' => 'A'
        ];

        // 3. Lakukan request PUT
        $response = $this->loginAsUser()->put(route('nilai.update', $nilai->id), $updateData);

        // 4. Cek redirect
        $response->assertRedirect(route('nilai.index'));

        // 5. Cek Database apakah sudah berubah
        $this->assertDatabaseHas('nilai', [
            'id' => $nilai->id,
            'nilai_angka' => 90,
            'nilai_huruf' => 'A'
        ]);
    }

    /**
     * Test 5: Pastikan bisa menghapus data nilai
     */
    public function test_bisa_menghapus_data_nilai()
    {
        // 1. Buat data dummy
        $nilai = Nilai::factory()->create();

        // 2. Lakukan request DELETE
        // Karena di controller kamu return JSON untuk delete, kita pakai delete() biasa juga bisa, 
        // tapi asumsikan dia sukses dan return status 200.
        $response = $this->loginAsUser()->delete(route('nilai.destroy', $nilai->id));

        $response->assertStatus(200);
        
        // 3. Cek Database: Data harusnya SUDAH HILANG
        $this->assertDatabaseMissing('nilai', ['id' => $nilai->id]);
    }
}