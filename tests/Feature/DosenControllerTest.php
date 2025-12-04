<?php

namespace Tests\Feature;

use App\Models\Dosen;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DosenControllerTest extends TestCase
{
    use RefreshDatabase;

    private function loginAsUser(){
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        return $this->actingAs($user);
    }

    // PERBAIKAN: Tambahkan awalan 'test_' di semua nama function
    public function test_halaman_index_dosen_bisa_diakses()
    {
        $response = $this->loginAsUser()->get(route('dosen.index'));

        $response->assertStatus(200);
    }

    public function test_bisa_menambah_data_dosen_baru()
    {
        // Data input form
        $formData = [
            'nama' => 'Budi Santoso',
            'nidn' => '1234567890',
            'no_hp' => '08123456789'
        ];

        // POST ke route store
        $response = $this->loginAsUser()->post(route('dosen.store'), $formData);

        // Cek redirect & session sukses
        $response->assertRedirect(route('dosen.index'));
        $response->assertSessionHasNoErrors();

        // Cek database
        $this->assertDatabaseHas('dosen', [
            'nama' => 'Budi Santoso',
            'nidn' => '1234567890'
        ]);
    }

    public function test_validasi_gagal_jika_data_dosen_kosong()
    {
        // Kirim array kosong
        $response = $this->loginAsUser()->post(route('dosen.store'), []);

        // Harapannya session error di field wajib
        $response->assertSessionHasErrors(['nama', 'nidn', 'no_hp']);
    }

    public function test_tidak_bisa_input_nidn_kembar()
    {
        // 1. Buat dosen A
        Dosen::factory()->create(['nidn' => '99999']);

        // 2. Coba input dosen B dengan NIDN sama ('99999')
        $formData = [
            'nama' => 'Dosen Baru',
            'nidn' => '99999', // Duplikat
            'no_hp' => '0811111'
        ];

        $response = $this->loginAsUser()->post(route('dosen.store'), $formData);

        // Harapannya error di field nidn
        $response->assertSessionHasErrors(['nidn']);
    }

    public function test_bisa_mengupdate_data_dosen()
    {
        // Data awal
        $dosen = Dosen::factory()->create([
            'nama' => 'Nama Lama',
            'no_hp' => '080000'
        ]);

        // Data baru
        $updateData = [
            'nama' => 'Nama Baru Update',
            'nidn' => $dosen->nidn, // NIDN tetap sama
            'no_hp' => '089999'
        ];

        // PUT ke route update
        $response = $this->loginAsUser()->put(route('dosen.update', $dosen->id), $updateData);

        $response->assertRedirect(route('dosen.index'));

        // Cek DB apakah berubah
        $this->assertDatabaseHas('dosen', [
            'id' => $dosen->id,
            'nama' => 'Nama Baru Update',
            'no_hp' => '089999'
        ]);
    }

    public function test_bisa_menghapus_data_dosen()
    {
        $dosen = Dosen::factory()->create();

        // DELETE request (Controller kamu return JSON untuk delete)
        $response = $this->loginAsUser()->delete(route('dosen.destroy', $dosen->id));

        // Cek status OK
        $response->assertStatus(200);
        
        // Cek struktur JSON return-nya
        $response->assertJson([
            'status' => 'success',
            'message' => 'berhasil menghapus dosen'
        ]);

        // Cek DB harus kosong
        $this->assertDatabaseMissing('dosen', ['id' => $dosen->id]);
    }
}