<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Penitipan;
use Illuminate\Support\Facades\Auth;

/** Anggota 4: status & riwayat penitipan milik pelanggan. */
class PenitipanSayaController extends Controller
{
    public function index()
    {
        $penitipan = Penitipan::with(['cat', 'layanan'])
            ->where('user_id', Auth::id())
            ->whereIn('status', Penitipan::STATUS_BERJALAN)
            ->latest()
            ->paginate(10);

        return view('pelanggan.penitipan.index', compact('penitipan'));
    }

    public function riwayat()
    {
        $penitipan = Penitipan::with(['cat', 'layanan'])
            ->where('user_id', Auth::id())
            ->whereIn('status', Penitipan::STATUS_RIWAYAT)
            ->latest('updated_at')
            ->paginate(10);

        return view('pelanggan.penitipan.riwayat', compact('penitipan'));
    }

    public function show(Penitipan $penitipan)
    {
        // Pelanggan hanya boleh melihat penitipan miliknya sendiri.
        if ($penitipan->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak memiliki akses ke data penitipan ini.');
        }

        $penitipan->load(['cat', 'layanan']);

        return view('pelanggan.penitipan.show', compact('penitipan'));
    }
}
