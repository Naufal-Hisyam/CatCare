<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Menampilkan daftar semua pelanggan.
     */
    public function index()
    {
        $customers = User::where('role', 'pelanggan')
            ->latest()
            ->get();

        return view('customers.index', compact('customers'));
    }

    /**
     * Menampilkan halaman form untuk menambah pelanggan baru.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Menyimpan data pelanggan baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ], [
            'name.required' => 'Nama pelanggan wajib diisi.',
            'email.required' => 'Email pelanggan wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar, gunakan email lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        // 2. Simpan data ke database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password di-enkripsi
        ]);

        // 3. Kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.customers.index')
                         ->with('success', 'Data pelanggan berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail spesifik satu pelanggan.
     */
    public function show($id)
    {
        $customer = User::findOrFail($id); // Mencari data berdasarkan ID
        return view('customers.show', compact('customer'));
    }

    /**
     * Menampilkan form untuk mengedit data pelanggan.
     */
    public function edit($id)
    {
        $customer = User::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    /**
     * Menyimpan perubahan (update) data pelanggan ke database.
     */
    public function update(Request $request, $id)
    {
        $customer = User::findOrFail($id);

        // 1. Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            // Rule unique ignore digunakan agar email milik dia sendiri tidak dianggap duplikat
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($customer->id)],
            'password' => 'nullable|string|min:8', // Password opsional saat diedit
        ], [
            'name.required' => 'Nama pelanggan wajib diisi.',
            'email.required' => 'Email pelanggan wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        // 2. Update atribut nama dan email
        $customer->name = $request->name;
        $customer->email = $request->email;
        
        // 3. Jika input password diisi, maka update password-nya juga
        if ($request->filled('password')) {
            $customer->password = Hash::make($request->password);
        }
        
        $customer->save();

        // 4. Kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.customers.index')
                         ->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    /**
     * Menghapus data pelanggan dari database.
     */
    public function destroy($id)
    {
        $customer = User::findOrFail($id);
        $customer->delete();

        return redirect()->route('admin.customers.index')
                         ->with('success', 'Data pelanggan berhasil dihapus!');
    }
}