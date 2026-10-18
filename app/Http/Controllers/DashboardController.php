<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            $totalLayanan = DB::table('layanan')->count();

            $totalPengajuan = DB::table('penitipan')->count();

            $totalPelanggan = DB::table('users')
                ->where('role', 'pelanggan')
                ->count();

            $totalPengguna = $totalPelanggan;

            $totalPenitipanAktif = DB::table('penitipan')
                ->where('status', 'aktif')
                ->count();

            $aktivitasTerbaru = DB::table('penitipan')
                ->join('users', 'penitipan.user_id', '=', 'users.id')
                ->select(
                    'penitipan.id',
                    'penitipan.status',
                    'penitipan.created_at as tanggal',
                    'users.name as pelanggan'
                )
                ->orderBy('penitipan.created_at', 'desc')
                ->limit(5)
                ->get()
                ->map(function ($item) {
                    $item->aktivitas = 'Pengajuan penitipan';
                    $item->status = \App\Models\Penitipan::LABEL_STATUS[$item->status] ?? $item->status;

                    return $item;
                });

            return view('dashboard.admin', compact(
                'totalLayanan',
                'totalPengajuan',
                'totalPelanggan',
                'totalPengguna',
                'totalPenitipanAktif',
                'aktivitasTerbaru'
            ));
        }

        $userId = $user->id;

        $totalKucing = 0;

        if (Schema::hasTable('kucings')) {
            $totalKucing = DB::table('kucings')
                ->where('user_id', $userId)
                ->count();
        }

        $totalPenitipanAktif = DB::table('penitipan')
            ->where('user_id', $userId)
            ->where('status', 'aktif')
            ->count();

        $totalRiwayatPenitipan = DB::table('penitipan')
            ->where('user_id', $userId)
            ->where('status', 'selesai')
            ->count();

        $totalPembayaranMenunggu = DB::table('penitipan')
            ->where('user_id', $userId)
            ->whereIn('status', ['disetujui', 'aktif', 'selesai'])
            ->where('status_pembayaran', 'menunggu')
            ->count();

        return view('dashboard.pelanggan', compact(
            'totalKucing',
            'totalPenitipanAktif',
            'totalRiwayatPenitipan',
            'totalPembayaranMenunggu'
        ));
    }
}
