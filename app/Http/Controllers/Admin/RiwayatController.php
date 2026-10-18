<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penitipan;
use Illuminate\Http\Request;

/** Anggota 4: riwayat penitipan (admin). */
class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $cari = trim((string) $request->query('cari', ''));

        $query = Penitipan::with(['user', 'cat', 'layanan'])
            ->whereIn('status', Penitipan::STATUS_RIWAYAT);

        if (in_array($status, Penitipan::STATUS_RIWAYAT, true)) {
            $query->where('status', $status);
        }

        if ($cari !== '') {
            $query->where(function ($q) use ($cari) {
                $q->whereHas('user', fn ($u) => $u->where('name', 'like', "%{$cari}%"))
                    ->orWhereHas('cat', fn ($c) => $c->where('name', 'like', "%{$cari}%"));
            });
        }

        $penitipan = $query->latest('updated_at')->paginate(10)->withQueryString();

        return view('admin.riwayat.index', compact('penitipan', 'status', 'cari'));
    }
}
