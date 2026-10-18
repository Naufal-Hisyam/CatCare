@extends('layouts.app')

@section('title', 'Detail Layanan | CatCare')

@section('content')
<div class="app-shell">
    <aside class="sidebar">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <img src="{{ asset('logoCat.png') }}" alt="Logo CatCare">
            <span>CatCare</span>
        </a>

        <nav class="nav-menu">
            @if(auth()->check() && auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.customers.index') }}" class="nav-link">
                    <span>Data Pelanggan</span>
                </a>
                <a href="{{ route('layanan.index') }}" class="nav-link active">
                    <span>Data Layanan</span>
                </a>
                <a href="{{ route('admin.penitipan.index') }}" class="nav-link">
                    <span>Pengajuan Penitipan</span>
                </a>
                <a href="{{ route('admin.pembayaran.index') }}" class="nav-link">
                    <span>Pembayaran</span>
                </a>
                <a href="{{ route('admin.riwayat.index') }}" class="nav-link">
                    <span>Riwayat Penitipan</span>
                </a>
                <a href="{{ route('admin.profile.show') }}" class="nav-link">
                    <span>Profil</span>
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('cats.index') }}" class="nav-link">
                    <span>Data Kucing</span>
                </a>
                <a href="{{ route('layanan.index') }}" class="nav-link active">
                    <span>Daftar Layanan</span>
                </a>
                <a href="{{ route('penitipan.saya') }}" class="nav-link">
                    <span>Penitipan Saya</span>
                </a>
                <a href="{{ route('penitipan.riwayat') }}" class="nav-link">
                    <span>Riwayat Penitipan</span>
                </a>
                <a href="{{ route('profile.show') }}" class="nav-link">
                    <span>Profil</span>
                </a>
            @endif
        </nav>

        @auth
            <div class="sidebar-bottom">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-button">Logout</button>
                </form>
            </div>
        @endauth
    </aside>

    <main class="main-area">
        <header class="topbar">
            <div class="topbar-title">
                <h1>Detail Layanan</h1>
            </div>
        </header>

        <div class="page-content">
            <section class="welcome-banner">
                <div>
                    <span class="welcome-label">CATCARE</span>
                    <h2>{{ $layanan->nama_layanan }}</h2>
                    <p>Informasi lengkap layanan penitipan kucing.</p>
                </div>
            </section>

            <section class="activity-section">
                <div class="activity-header">
                    <div>
                        <h2>Informasi Layanan</h2>
                        <p>Detail layanan yang tersedia di CatCare.</p>
                    </div>
                </div>

                <div style="padding:28px;">
                    <div style="margin-bottom:24px;">
                        <h3 style="color:#24465b; margin-bottom:8px;">
                            Nama Layanan
                        </h3>
                        <p>{{ $layanan->nama_layanan }}</p>
                    </div>

                    <div style="margin-bottom:24px;">
                        <h3 style="color:#24465b; margin-bottom:8px;">
                            Deskripsi
                        </h3>
                        <p style="line-height:1.7;">
                            {{ $layanan->deskripsi ?? 'Belum ada deskripsi.' }}
                        </p>
                    </div>

                    <div style="background:#e7f6fd; padding:20px; border-radius:12px; margin-bottom:24px;">
                        <h3 style="color:#24465b; margin-bottom:8px;">
                            Harga Penitipan per Hari
                        </h3>

                        <p style="font-size:26px; font-weight:bold; color:#378fb8;">
                            Rp{{ number_format($layanan->harga, 0, ',', '.') }}
                        </p>
                    </div>

                    <a href="{{ route('layanan.index') }}"
                       style="display:inline-block; background:#70c5eb; color:white; padding:12px 20px; border-radius:8px; text-decoration:none; font-weight:bold;">
                        ← Kembali ke Daftar Layanan
                    </a>
                </div>
            </section>
        </div>
    </main>
</div>
@endsection