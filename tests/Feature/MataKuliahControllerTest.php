<?php

namespace Tests\Feature;

use App\Models\MataKuliah;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MataKuliahControllerTest extends TestCase
{
    use RefreshDatabase;

    private function loginAsUser()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        return $this->actingAs($user);
    }

    public function test_halaman_index_matakuliah_bisa_diakses()
    {
        $response = $this->loginAsUser()->get(route('matakuliah.index'));

        $response->assertStatus(200);
    }

    public function test_bisa_menambah_data_matakuliah_baru()
    {
        $formData = [
            'nama' => 'Pemrograman Web Lanjut',
            'kode_mk' => 'TI2024',
            'sks' => 4
        ];

        // POST ke route store
        $response = $this->loginAsUser()->post(route('matakuliah.store'), $formData);

        // Redirect ke index
        $response->assertRedirect(route('matakuliah.index'));
        $response->assertSessionHasNoErrors();

        // Cek database
        $this->assertDatabaseHas('matakuliah', [
            'nama' => 'Pemrograman Web Lanjut',
            'kode_mk' => 'TI2024',
            'sks' => 4
        ]);
    }

    public function test_validasi_gagal_jika_data_kosong()
    {
        // Kirim data kosong
        $response = $this->loginAsUser()->post(route('matakuliah.store'), []);

        // Harapannya session error (sesuaikan field wajib di controller)
        $response->assertSessionHasErrors(['nama', 'kode_mk', 'sks']);
    }

    public function test_tidak_bisa_input_kode_mk_kembar()
    {
        // 1. Buat MK A
        MataKuliah::factory()->create(['kode_mk' => 'MK001']);

        // 2. Coba input MK B dengan kode sama
        $formData = [
            'nama' => 'Matkul Baru',
            'kode_mk' => 'MK001', // Duplikat
            'sks' => 2
        ];

        $response = $this->loginAsUser()->post(route('matakuliah.store'), $formData);

        // Harapannya error di field kode_mk
        $response->assertSessionHasErrors(['kode_mk']);
    }

    public function test_bisa_mengupdate_data_matakuliah()
    {
        // Data Awal
        $mk = MataKuliah::factory()->create([
            'nama' => 'Algoritma Dasar',
            'sks' => 3
        ]);

        // Data Baru
        $updateData = [
            'nama' => 'Algoritma & Pemrograman', // Ganti nama
            'kode_mk' => $mk->kode_mk, // Kode tetap sama (harus lolos validasi unique ignore ID)
            'sks' => 4 // Ganti SKS
        ];

        // PUT request
        $response = $this->loginAsUser()->put(route('matakuliah.update', $mk->id), $updateData);

        $response->assertRedirect(route('matakuliah.index'));

        // Cek DB
        $this->assertDatabaseHas('matakuliah', [
            'id' => $mk->id,
            'nama' => 'Algoritma & Pemrograman',
            'sks' => 4
        ]);
    }

    public function test_bisa_menghapus_data_matakuliah()
    {
        $mk = MataKuliah::factory()->create();

        // DELETE request (Asumsi controller return JSON)
        $response = $this->loginAsUser()->delete(route('matakuliah.destroy', $mk->id));

        $response->assertStatus(200);
        
        // Cek DB kosong
        $this->assertDatabaseMissing('matakuliah', ['id' => $mk->id]);
    }
}