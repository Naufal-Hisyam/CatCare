<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penitipan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * Anggota 4: pengajuan & proses penitipan (sisi admin).
 * Alur: menunggu -> disetujui/ditolak -> aktif (masuk) -> keluar aktual
 *       -> pembayaran tunai -> selesai.
 */
class PenitipanController extends Controller
{
    private const FILTER = [Penitipan::MENUNGGU, Penitipan::DISETUJUI, Penitipan::AKTIF];

    public function index(Request $request)
    {
        $status = $request->query('status');
        $cari = trim((string) $request->query('cari', ''));

        $query = Penitipan::with(['user', 'cat', 'layanan'])
            ->whereIn('status', Penitipan::STATUS_BERJALAN);

        if (in_array($status, self::FILTER, true)) {
            $query->where('status', $status);
        }

        if ($cari !== '') {
            $query->where(function ($q) use ($cari) {
                $q->whereHas('user', fn ($u) => $u->where('name', 'like', "%{$cari}%"))
                    ->orWhereHas('cat', fn ($c) => $c->where('name', 'like', "%{$cari}%"));
            });
        }

        $penitipan = $query
            ->orderByRaw("CASE status WHEN 'menunggu' THEN 0 WHEN 'disetujui' THEN 1 ELSE 2 END")
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $jumlah = Penitipan::whereIn('status', Penitipan::STATUS_BERJALAN)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.penitipan.index', compact('penitipan', 'status', 'cari', 'jumlah'));
    }

    public function show(Penitipan $penitipan)
    {
        $penitipan->load(['user', 'cat', 'layanan']);

        return view('admin.penitipan.show', compact('penitipan'));
    }

    public function setujui(Penitipan $penitipan)
    {
        return $this->ubah($penitipan, 'bisaDiputuskan', function (Penitipan $p) {
            $p->status = Penitipan::DISETUJUI;
            $p->alasan_penolakan = null;
            $p->save();
        }, 'Pengajuan disetujui. Catat kucing masuk saat kucing tiba.');
    }

    public function tolak(Request $request, Penitipan $penitipan)
    {
        $data = $request->validate([
            'alasan_penolakan' => ['required', 'string', 'max:500'],
        ], [
            'alasan_penolakan.required' => 'Alasan penolakan wajib diisi.',
            'alasan_penolakan.max' => 'Alasan penolakan maksimal 500 karakter.',
        ]);

        return $this->ubah($penitipan, 'bisaDiputuskan', function (Penitipan $p) use ($data) {
            $p->status = Penitipan::DITOLAK;
            $p->alasan_penolakan = $data['alasan_penolakan'];
            $p->save();
        }, 'Pengajuan ditolak.');
    }

    /** Catat tanggal masuk aktual -> status Aktif. */
    public function masuk(Request $request, Penitipan $penitipan)
    {
        $data = $request->validate([
            'tanggal_masuk_aktual' => ['required', 'date', 'before_or_equal:today'],
        ], [
            'tanggal_masuk_aktual.required' => 'Tanggal masuk aktual wajib diisi.',
            'tanggal_masuk_aktual.date' => 'Format tanggal masuk tidak valid.',
            'tanggal_masuk_aktual.before_or_equal' => 'Tanggal masuk aktual tidak boleh melebihi hari ini.',
        ]);

        return $this->ubah($penitipan, 'bisaMasuk', function (Penitipan $p) use ($data) {
            $p->tanggal_masuk_aktual = $data['tanggal_masuk_aktual'];
            $p->status = Penitipan::AKTIF;
            $p->save();
        }, 'Kucing tercatat masuk. Status penitipan: Sedang Dititipkan.');
    }

    /** Catat tanggal keluar aktual dan hitung total biaya final. */
    public function keluar(Request $request, Penitipan $penitipan)
    {
        $masuk = optional($penitipan->tanggal_masuk_aktual)->format('Y-m-d');

        $data = $request->validate([
            'tanggal_keluar_aktual' => array_filter([
                'required', 'date', 'before_or_equal:today',
                $masuk ? 'after_or_equal:' . $masuk : null,
            ]),
        ], [
            'tanggal_keluar_aktual.required' => 'Tanggal keluar aktual wajib diisi.',
            'tanggal_keluar_aktual.date' => 'Format tanggal keluar tidak valid.',
            'tanggal_keluar_aktual.before_or_equal' => 'Tanggal keluar aktual tidak boleh melebihi hari ini.',
            'tanggal_keluar_aktual.after_or_equal' => 'Tanggal keluar tidak boleh lebih awal dari tanggal masuk aktual.',
        ]);

        return $this->ubah($penitipan, 'bisaKeluar', function (Penitipan $p) use ($data) {
            $p->tanggal_keluar_aktual = $data['tanggal_keluar_aktual'];
            $p->total_biaya = $p->harga_per_hari
                * Penitipan::hitungHari($p->tanggal_masuk_aktual, $data['tanggal_keluar_aktual']);
            $p->save();
        }, 'Tanggal keluar tercatat dan total biaya sudah dihitung. Lanjutkan ke pembayaran tunai.');
    }

    /** Setelah dibayar & kucing keluar -> status Selesai. */
    public function selesai(Penitipan $penitipan)
    {
        return $this->ubah($penitipan, 'bisaSelesai', function (Penitipan $p) {
            $p->status = Penitipan::SELESAI;
            $p->save();
        }, 'Penitipan selesai dan masuk ke riwayat.');
    }

    /**
     * Jalankan perubahan di dalam transaksi, setelah mengecek ulang bahwa
     * status saat ini memang mengizinkan aksi tersebut.
     */
    private function ubah(Penitipan $penitipan, string $syarat, \Closure $aksi, string $pesanBerhasil)
    {
        try {
            $ok = DB::transaction(function () use ($penitipan, $syarat, $aksi) {
                $terbaru = Penitipan::with('layanan')->lockForUpdate()->find($penitipan->id);

                if (! $terbaru || ! $terbaru->{$syarat}()) {
                    return false;
                }

                $aksi($terbaru);

                return true;
            });
        } catch (Throwable $e) {
            report($e);

            return back()->withInput()->with('error', 'Data gagal disimpan. Silakan coba lagi.');
        }

        if (! $ok) {
            return redirect()->route('admin.penitipan.show', $penitipan)
                ->with('error', 'Aksi tidak dapat dilakukan karena status penitipan saat ini tidak sesuai.');
        }

        return redirect()->route('admin.penitipan.show', $penitipan)
            ->with('success', $pesanBerhasil);
    }
}
