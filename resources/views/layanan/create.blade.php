@extends('layouts.app')

@section('title', 'Tambah Layanan | CatCare')

@section('content')
<div class="app-shell">
    <aside class="sidebar">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <img src="{{ asset('logoCat.png') }}" alt="Logo CatCare">
            <span>CatCare</span>
        </a>

        <nav class="nav-menu">
            <a href="{{ route('dashboard') }}" class="nav-link">
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.customers.index') }}" class="nav-link">
                <span>Data Pelanggan</span>
            </a>

            <a href="{{ route('layanan.index') }}" class="nav-link active">
                <span>Data Layanan</span>
            </a>
        </nav>
    </aside>

    <main class="main-area">
        <header class="topbar">
            <div class="topbar-title">
                <h1>Tambah Layanan</h1>
            </div>
        </header>

        <div class="page-content">
            <section class="welcome-banner">
                <div>
                    <span class="welcome-label">CATCARE ADMIN</span>
                    <h2>Tambah Layanan Penitipan</h2>
                    <p>Masukkan informasi layanan baru untuk pelanggan CatCare.</p>
                </div>
            </section>

            <section class="activity-section">
                <div class="activity-header">
                    <div>
                        <h2>Form Tambah Layanan</h2>
                        <p>Lengkapi data layanan berikut.</p>
                    </div>
                </div>

                <div style="padding: 28px;">
                    <form action="{{ route('layanan.store') }}" method="POST">
                        @csrf

                        <div style="margin-bottom: 20px;">
                            <label for="nama_layanan">
                                <strong>Nama Layanan</strong>
                            </label>

                            <input
                                type="text"
                                id="nama_layanan"
                                name="nama_layanan"
                                value="{{ old('nama_layanan') }}"
                                placeholder="Contoh: Penitipan Reguler"
                                required
                                style="display:block; width:100%; padding:12px; margin-top:8px; border:1px solid #cfe5f2; border-radius:8px;"
                            >
                            @error('nama_layanan')
                                <p style="color:red;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label for="deskripsi">
                                <strong>Deskripsi</strong>
                            </label>

                            <textarea
                                id="deskripsi"
                                name="deskripsi"
                                rows="4"
                                placeholder="Jelaskan fasilitas layanan penitipan"
                                style="display:block; width:100%; padding:12px; margin-top:8px; border:1px solid #cfe5f2; border-radius:8px;"
                            >{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p style="color:red;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div style="margin-bottom: 24px;">
                            <label for="harga">
                                <strong>Harga per Hari (Rp)</strong>
                            </label>

                            <input
                                type="number"
                                id="harga"
                                name="harga"
                                value="{{ old('harga') }}"
                                min="0"
                                step="0.01"
                                placeholder="Contoh: 30000"
                                required
                                style="display:block; width:100%; padding:12px; margin-top:8px; border:1px solid #cfe5f2; border-radius:8px;"
                            >
                            @error('harga')
                                <p style="color:red;">{{ $message }}</p>
                            @enderror
                        </div>

                        <button
                            type="submit"
                            style="background:#70c5eb; color:white; padding:12px 24px; border:none; border-radius:8px; cursor:pointer; font-weight:bold;"
                        >
                            Simpan Layanan
                        </button>

                        <a
                            href="{{ route('layanan.index') }}"
                            style="margin-left:12px; color:#378fb8;"
                        >
                            Batal
                        </a>
                    </form>
                </div>
            </section>
        </div>
    </main>
</div>
@endsection