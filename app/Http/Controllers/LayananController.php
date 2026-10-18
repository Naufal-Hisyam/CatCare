<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    // Menampilkan daftar layanan
    public function index()
    {
        $layanans = Layanan::all();

        return view('layanan.index', compact('layanans'));
    }

    // Menampilkan detail layanan
    public function show(Layanan $layanan)
    {
        return view('layanan.show', compact('layanan'));
    }

    // Menampilkan formulir tambah layanan
    public function create()
    {
        abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);

        return view('layanan.create');
    }

    // Menyimpan layanan baru
    public function store(Request $request)
    {
        abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);

        $data = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
        ]);

        Layanan::create($data);

        return redirect()->route('layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan!');
    }

    // Menampilkan formulir edit layanan
    public function edit(Layanan $layanan)
    {
        abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);

        return view('layanan.edit', compact('layanan'));
    }

    public function destroy(Layanan $layanan)
    {
        abort_unless(
            auth()->check() && auth()->user()->role === 'admin',
            403
        );

        $layanan->delete();

        return redirect()->route('layanan.index')
            ->with('success', 'Layanan berhasil dihapus!');
    }

    // Menyimpan perubahan layanan
    public function update(Request $request, Layanan $layanan)
    {
        abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);

        $data = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
        ]);

        $layanan->update($data);

        return redirect()->route('layanan.index')
            ->with('success', 'Layanan berhasil diperbarui!');
    }
}