<?php

namespace App\Http\Controllers;

use App\Models\Penitipan;
use App\Models\Layanan;
use App\Models\Cat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenitipanController extends Controller
{
    // Menampilkan form pengajuan penitipan
    public function create()
    {
        $kucings = Cat::where('user_id', Auth::id())->get();
        $layanans = Layanan::all();

        return view('penitipan.create', compact('kucings', 'layanans'));
    }

    // Menyimpan pengajuan penitipan
    public function store(Request $request)
    {
        $data = $request->validate([
            'cat_id' => 'required|exists:cats,id',
            'layanan_id' => 'required|exists:layanan,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'catatan' => 'nullable|string|max:1000',
        ]);

        // Memastikan kucing milik pengguna yang login
        $kucing = Cat::where('id', $data['cat_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        Penitipan::create([
            'user_id' => Auth::id(),
            'cat_id' => $kucing->id,
            'layanan_id' => $data['layanan_id'],
            'tanggal_mulai' => $data['tanggal_mulai'],
            'tanggal_selesai' => $data['tanggal_selesai'],
            'catatan' => $data['catatan'] ?? null,
            'status' => 'menunggu',
        ]);

        return redirect()->route('layanan.index')
            ->with('success', 'Pengajuan penitipan berhasil dikirim!');
    }
}