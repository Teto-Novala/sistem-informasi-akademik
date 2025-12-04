<?php

namespace Tests\Feature;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MahasiswaControllerTest extends TestCase
{
    // Membersihkan database setiap kali test selesai
    use RefreshDatabase;

    // Helper Login
    private function loginAsUser()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        return $this->actingAs($user);
    }

    public function test_halaman_index_mahasiswa_bisa_diakses()
    {
        $response = $this->loginAsUser()->get(route('mahasiswa.index'));

        $response->assertStatus(200);
    }

    public function test_bisa_menambah_data_mahasiswa_baru()
    {
        $formData = [
            'nama' => 'Maba Test',
            'nim' => '2300011122',
            'jurusan' => 'Teknik Informatika',
        ];

        // POST ke route store
        $response = $this->loginAsUser()->post(route('mahasiswa.store'), $formData);

        // Harapannya redirect ke index
        $response->assertRedirect(route('mahasiswa.index'));
        $response->assertSessionHasNoErrors();

        // Cek data masuk ke DB
        $this->assertDatabaseHas('mahasiswa', [
            'nama' => 'Maba Test',
            'nim' => '2300011122'
        ]);
    }

    public function test_validasi_gagal_jika_data_kosong()
    {
        // Kirim data kosong
        $response = $this->loginAsUser()->post(route('mahasiswa.store'), []);

        // Sesuaikan field wajib di validasi controller kamu (misal: nama, nim, jurusan)
        $response->assertSessionHasErrors(['nama', 'nim', 'jurusan']);
    }

    public function test_tidak_bisa_input_nim_kembar()
    {
        // 1. Buat mahasiswa A
        Mahasiswa::factory()->create(['nim' => '12345']);

        // 2. Coba input mahasiswa B dengan NIM sama
        $formData = [
            'nama' => 'Mahasiswa Baru',
            'nim' => '12345', // Duplikat
            'jurusan' => 'Sistem Informasi',
        ];

        $response = $this->loginAsUser()->post(route('mahasiswa.store'), $formData);

        // Harapannya error di field nim
        $response->assertSessionHasErrors(['nim']);
    }

    public function test_bisa_mengupdate_data_mahasiswa()
    {
        // Data Awal
        $mhs = Mahasiswa::factory()->create([
            'nama' => 'Nama Lama',
            'jurusan' => 'SI'
        ]);

        // Data Baru
        $updateData = [
            'nama' => 'Nama Baru Update',
            'nim' => $mhs->nim, // NIM tetap sama (seharusnya lolos validasi unique ignore ID)
            'jurusan' => 'TI',
        ];

        // PUT ke route update
        $response = $this->loginAsUser()->put(route('mahasiswa.update', $mhs->id), $updateData);

        $response->assertRedirect(route('mahasiswa.index'));

        // Cek DB
        $this->assertDatabaseHas('mahasiswa', [
            'id' => $mhs->id,
            'nama' => 'Nama Baru Update',
            'jurusan' => 'TI'
        ]);
    }

    public function test_bisa_menghapus_data_mahasiswa()
    {
        $mhs = Mahasiswa::factory()->create();

        // DELETE request (Asumsi controller return JSON seperti Dosen/Nilai)
        $response = $this->loginAsUser()->delete(route('mahasiswa.destroy', $mhs->id));

        $response->assertStatus(200);
        
        // Cek DB harus kosong
        $this->assertDatabaseMissing('mahasiswa', ['id' => $mhs->id]);
    }
}