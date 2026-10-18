@extends('layouts.app')

@section('title', 'Edit Layanan | CatCare')

@section('content')
<div class="app-shell">

    <!-- SIDEBAR -->
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

    <!-- KONTEN UTAMA -->
    <main class="main-area">

        <!-- HEADER -->
        <header class="topbar">
            <div class="topbar-title">
                <h1>Edit Layanan</h1>
            </div>
        </header>

        <div class="page-content">

            <!-- BANNER -->
            <section class="welcome-banner">
                <div>
                    <span class="welcome-label">CATCARE ADMIN</span>
                    <h2>Edit Layanan Penitipan</h2>
                    <p>Ubah informasi layanan penitipan kucing.</p>
                </div>
            </section>

            <!-- FORM EDIT -->
            <section class="activity-section">

                <div class="activity-header">
                    <div>
                        <h2>Form Edit Layanan</h2>
                        <p>Perbarui data layanan berikut.</p>
                    </div>
                </div>

                <div style="padding: 28px;">

                    <form action="{{ route('layanan.update', $layanan->id) }}"
                          method="POST">

                        @csrf
                        @method('PUT')

                        <!-- NAMA LAYANAN -->
                        <div style="margin-bottom: 20px;">
                            <label for="nama_layanan">
                                <strong>Nama Layanan</strong>
                            </label>

                            <input
                                type="text"
                                id="nama_layanan"
                                name="nama_layanan"
                                value="{{ old('nama_layanan', $layanan->nama_layanan) }}"
                                required
                                style="display:block; width:100%; padding:12px; margin-top:8px; border:1px solid #cfe5f2; border-radius:8px;"
                            >

                            @error('nama_layanan')
                                <p style="color:red;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- DESKRIPSI -->
                        <div style="margin-bottom: 20px;">
                            <label for="deskripsi">
                                <strong>Deskripsi</strong>
                            </label>

                            <textarea
                                id="deskripsi"
                                name="deskripsi"
                                rows="4"
                                style="display:block; width:100%; padding:12px; margin-top:8px; border:1px solid #cfe5f2; border-radius:8px;"
                            >{{ old('deskripsi', $layanan->deskripsi) }}</textarea>

                            @error('deskripsi')
                                <p style="color:red;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- HARGA -->
                        <div style="margin-bottom: 24px;">
                            <label for="harga">
                                <strong>Harga per Hari (Rp)</strong>
                            </label>

                            <input
                                type="number"
                                id="harga"
                                name="harga"
                                value="{{ old('harga', $layanan->harga) }}"
                                min="0"
                                step="0.01"
                                required
                                style="display:block; width:100%; padding:12px; margin-top:8px; border:1px solid #cfe5f2; border-radius:8px;"
                            >

                            @error('harga')
                                <p style="color:red;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- TOMBOL -->
                        <button
                            type="submit"
                            style="background:#70c5eb; color:white; padding:12px 24px; border:none; border-radius:8px; cursor:pointer; font-weight:bold;"
                        >
                            Simpan Perubahan
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