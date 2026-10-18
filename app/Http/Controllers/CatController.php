<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            $cats = Cat::with('user')->latest()->get();
        } else {
            $cats = Cat::where('user_id', $user->id)->latest()->get();
        }

        return view('cats.index', compact('cats'));
    }

    public function create()
    {
        return view('cats.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'breed' => 'nullable|string',
            'age' => 'nullable|numeric',
            'gender' => 'required|in:jantan,betina',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('cats', 'public');
        }

        Cat::create($data);

        return redirect()->route('cats.index')->with('success', 'Data kucing berhasil ditambahkan!');
    }

    public function show(Cat $cat)
    {
        $this->authorizeAccess($cat);
        return view('cats.show', compact('cat'));
    }

    public function edit(Cat $cat)
    {
        $this->authorizeAccess($cat);
        return view('cats.edit', compact('cat'));
    }

    public function update(Request $request, Cat $cat)
    {
        $this->authorizeAccess($cat);

        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:jantan,betina',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('cats', 'public');
        }

        $cat->update($data);

        return redirect()->route('cats.index')->with('success', 'Data kucing berhasil diperbarui!');
    }

    public function destroy(Cat $cat)
    {
        $this->authorizeAccess($cat);
        $cat->delete();

        return redirect()->route('cats.index')->with('success', 'Data kucing berhasil dihapus!');
    }

    private function authorizeAccess(Cat $cat)
    {
        if (Auth::user()->role !== 'admin' && $cat->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke data kucing ini.');
        }
    }
}
