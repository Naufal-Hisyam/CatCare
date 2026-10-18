<?php

namespace Tests\Feature;

use App\Models\Cat;
use App\Models\Layanan;
use App\Models\Penitipan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProsesPenitipanTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $pelanggan;
    private Penitipan $p;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->pelanggan = User::factory()->create(['role' => 'pelanggan']);
        $this->p = $this->buatPenitipan($this->pelanggan);
    }

    private function buatPenitipan(User $user, string $status = 'menunggu'): Penitipan
    {
        $cat = Cat::create(['user_id' => $user->id, 'name' => 'Mochi', 'gender' => 'jantan']);
        $layanan = Layanan::create(['nama_layanan' => 'Reguler', 'harga' => 50000]);

        return Penitipan::create([
            'user_id' => $user->id,
            'cat_id' => $cat->id,
            'layanan_id' => $layanan->id,
            'tanggal_mulai' => now()->addDay()->toDateString(),
            'tanggal_selesai' => now()->addDays(4)->toDateString(),
            'status' => $status,
        ]);
    }

    public function test_alur_lengkap_dari_pengajuan_sampai_selesai(): void
    {
        $this->actingAs($this->admin);

        $this->post(route('admin.penitipan.setujui', $this->p))->assertRedirect();
        $this->assertSame('disetujui', $this->p->fresh()->status);

        $masuk = now()->subDays(3)->toDateString();
        $this->post(route('admin.penitipan.masuk', $this->p), ['tanggal_masuk_aktual' => $masuk]);
        $this->assertSame('aktif', $this->p->fresh()->status);

        $this->post(route('admin.penitipan.keluar', $this->p), ['tanggal_keluar_aktual' => now()->toDateString()]);
        $this->assertEquals(150000, $this->p->fresh()->total_biaya); // 3 hari x 50.000

        // belum dibayar -> tidak boleh selesai
        $this->post(route('admin.penitipan.selesai', $this->p))->assertSessionHas('error');
        $this->assertSame('aktif', $this->p->fresh()->status);

        $this->post(route('admin.pembayaran.store', $this->p), ['jumlah_pembayaran' => 150000])
            ->assertSessionHas('success');
        $this->assertSame('sudah_dibayar', $this->p->fresh()->status_pembayaran);

        $this->post(route('admin.penitipan.selesai', $this->p));
        $this->assertSame('selesai', $this->p->fresh()->status);

        $this->get(route('admin.riwayat.index'))->assertOk()->assertSee('Mochi');
    }

    public function test_tolak_wajib_alasan(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.penitipan.tolak', $this->p), ['alasan_penolakan' => ''])
            ->assertSessionHasErrors('alasan_penolakan');
        $this->assertSame('menunggu', $this->p->fresh()->status);

        $this->post(route('admin.penitipan.tolak', $this->p), ['alasan_penolakan' => 'Kandang penuh']);
        $this->assertSame('ditolak', $this->p->fresh()->status);
    }

    public function test_tanggal_keluar_tidak_boleh_sebelum_masuk(): void
    {
        $this->actingAs($this->admin);
        $this->post(route('admin.penitipan.setujui', $this->p));
        $this->post(route('admin.penitipan.masuk', $this->p), ['tanggal_masuk_aktual' => now()->toDateString()]);

        $this->post(route('admin.penitipan.keluar', $this->p), ['tanggal_keluar_aktual' => now()->subDay()->toDateString()])
            ->assertSessionHasErrors('tanggal_keluar_aktual');
        $this->assertNull($this->p->fresh()->tanggal_keluar_aktual);
    }

    public function test_pembayaran_kurang_ditolak_dan_loncat_status_dicegah(): void
    {
        $this->actingAs($this->admin);

        // belum masuk -> tidak bisa catat masuk/keluar/bayar
        $this->post(route('admin.penitipan.masuk', $this->p), ['tanggal_masuk_aktual' => now()->toDateString()])
            ->assertSessionHas('error');
        $this->post(route('admin.pembayaran.store', $this->p), ['jumlah_pembayaran' => 1000])
            ->assertSessionHas('error');
        $this->assertSame('menunggu', $this->p->fresh()->status);

        $this->post(route('admin.penitipan.setujui', $this->p));
        $this->post(route('admin.penitipan.masuk', $this->p), ['tanggal_masuk_aktual' => now()->subDays(2)->toDateString()]);
        $this->post(route('admin.penitipan.keluar', $this->p), ['tanggal_keluar_aktual' => now()->toDateString()]);

        $this->post(route('admin.pembayaran.store', $this->p), ['jumlah_pembayaran' => 1000])
            ->assertSessionHasErrors('jumlah_pembayaran');
        $this->assertSame('menunggu', $this->p->fresh()->status_pembayaran);
    }

    public function test_pelanggan_hanya_melihat_penitipan_miliknya(): void
    {
        $lain = User::factory()->create(['role' => 'pelanggan']);
        $punyaLain = $this->buatPenitipan($lain);

        $this->actingAs($this->pelanggan);

        $this->get(route('penitipan.saya'))->assertOk()->assertSee('Mochi');
        $this->get(route('penitipan.saya.show', $this->p))->assertOk();
        $this->get(route('penitipan.saya.show', $punyaLain))->assertForbidden();
    }

    public function test_pelanggan_tidak_bisa_mengubah_status_atau_masuk_halaman_admin(): void
    {
        $this->actingAs($this->pelanggan);

        $this->post(route('admin.penitipan.setujui', $this->p))->assertForbidden();
        $this->post(route('admin.pembayaran.store', $this->p), ['jumlah_pembayaran' => 1])->assertForbidden();
        $this->get(route('admin.penitipan.index'))->assertForbidden();
        $this->get(route('admin.riwayat.index'))->assertForbidden();
        $this->assertSame('menunggu', $this->p->fresh()->status);
    }

    public function test_admin_tidak_bisa_membuka_halaman_pelanggan_dan_tamu_dialihkan(): void
    {
        $this->actingAs($this->admin)->get(route('penitipan.saya'))->assertForbidden();

        auth()->logout();
        $this->get(route('admin.penitipan.index'))->assertRedirect(route('login'));
    }

    public function test_halaman_403_dan_404_ramah(): void
    {
        $this->actingAs($this->pelanggan)
            ->get(route('admin.penitipan.index'))
            ->assertForbidden()
            ->assertSee('Akses Ditolak');

        $this->get('/penitipan-saya/9999')->assertNotFound()->assertSee('Halaman Tidak Ditemukan');
    }

    public function test_semua_halaman_admin_dan_pelanggan_tampil(): void
    {
        $this->actingAs($this->admin);
        foreach (['admin.penitipan.index', 'admin.pembayaran.index', 'admin.riwayat.index'] as $r) {
            $this->get(route($r))->assertOk();
        }
        $this->get(route('admin.penitipan.show', $this->p))->assertOk()->assertSee('Setujui Pengajuan');
        $this->get(route('admin.pembayaran.show', $this->p))->assertOk();

        $this->actingAs($this->pelanggan);
        foreach (['penitipan.saya', 'penitipan.riwayat', 'dashboard'] as $r) {
            $this->get(route($r))->assertOk();
        }
    }
}
