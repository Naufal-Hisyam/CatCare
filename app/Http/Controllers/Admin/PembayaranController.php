<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penitipan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

/** Anggota 4: pembayaran tunai di tempat. */
class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('status');
        $cari = trim((string) $request->query('cari', ''));

        // Hanya penitipan yang kucingnya sudah masuk (aktif atau selesai).
        $query = Penitipan::with(['user', 'cat', 'layanan'])
            ->whereIn('status', [Penitipan::AKTIF, Penitipan::SELESAI]);

        if ($filter === 'belum') {
            $query->where('status_pembayaran', '!=', Penitipan::SUDAH_DIBAYAR);
        } elseif ($filter === 'sudah') {
            $query->where('status_pembayaran', Penitipan::SUDAH_DIBAYAR);
        }

        if ($cari !== '') {
            $query->where(function ($q) use ($cari) {
                $q->whereHas('user', fn ($u) => $u->where('name', 'like', "%{$cari}%"))
                    ->orWhereHas('cat', fn ($c) => $c->where('name', 'like', "%{$cari}%"));
            });
        }

        $penitipan = $query->latest()->paginate(10)->withQueryString();

        return view('admin.pembayaran.index', compact('penitipan', 'filter', 'cari'));
    }

    public function show(Penitipan $penitipan)
    {
        $penitipan->load(['user', 'cat', 'layanan']);

        return view('admin.pembayaran.show', compact('penitipan'));
    }

    public function store(Request $request, Penitipan $penitipan)
    {
        $penitipan->load('layanan');

        if (! $penitipan->bisaBayar()) {
            return redirect()->route('admin.pembayaran.show', $penitipan)
                ->with('error', 'Pembayaran belum dapat dicatat. Pastikan kucing sudah dicatat keluar dan belum dibayar.');
        }

        $total = (float) $penitipan->total_biaya;

        $data = $request->validate([
            'jumlah_pembayaran' => ['required', 'numeric', 'min:0', 'gte:' . $total],
        ], [
            'jumlah_pembayaran.required' => 'Jumlah pembayaran wajib diisi.',
            'jumlah_pembayaran.numeric' => 'Jumlah pembayaran harus berupa angka.',
            'jumlah_pembayaran.min' => 'Jumlah pembayaran tidak boleh negatif.',
            'jumlah_pembayaran.gte' => 'Jumlah pembayaran kurang dari total biaya.',
        ]);

        try {
            $ok = DB::transaction(function () use ($penitipan, $data) {
                $p = Penitipan::lockForUpdate()->find($penitipan->id);

                if (! $p || ! $p->bisaBayar()) {
                    return false;
                }

                $p->jumlah_pembayaran = $data['jumlah_pembayaran'];
                $p->metode_pembayaran = 'cash';
                $p->status_pembayaran = Penitipan::SUDAH_DIBAYAR;
                $p->tanggal_pembayaran = now();
                $p->save();

                return true;
            });
        } catch (Throwable $e) {
            report($e);

            return back()->withInput()->with('error', 'Pembayaran gagal disimpan. Silakan coba lagi.');
        }

        if (! $ok) {
            return redirect()->route('admin.pembayaran.show', $penitipan)
                ->with('error', 'Pembayaran sudah tercatat atau status penitipan berubah.');
        }

        return redirect()->route('admin.pembayaran.show', $penitipan)
            ->with('success', 'Pembayaran tunai tercatat. Status pembayaran: Sudah Dibayar.');
    }
}
