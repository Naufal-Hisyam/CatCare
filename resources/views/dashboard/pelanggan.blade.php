
@extends('layouts.app')

@section('title', 'Dashboard Pelanggan | CatCare')

@section('content')
<div class="app-shell">
    <aside class="sidebar">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <img src="{{ asset('logoCat.png') }}" alt="Logo CatCare">
            <span>CatCare</span>
        </a>

        <nav class="nav-menu">
            <a href="{{ route('dashboard') }}" class="nav-link active">
                <span>Dashboard</span>
            </a>

            <a href="#" class="nav-link">
                <span>Data Kucing</span>
            </a>

            <a href="#" class="nav-link">
                <span>Daftar Layanan</span>
            </a>

            <a href="#" class="nav-link">
                <span>Ajukan Penitipan</span>
            </a>

            <a href="#" class="nav-link">
                <span>Penitipan Saya</span>
            </a>

            <a href="#" class="nav-link">
                <span>Riwayat Penitipan</span>
            </a>

            <a href="{{ route('profile.show') }}" class="nav-link">
                <span>Profil</span>
            </a>
        </nav>

        <div class="sidebar-bottom">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-button">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="main-area">
        <header class="topbar">
            <div class="topbar-title">
                <h1>Dashboard Pelanggan</h1>
            </div>

            <a href="{{ route('profile.show') }}" class="topbar-profile">
                <div class="profile-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <div class="profile-info">
                    <strong>{{ auth()->user()->name }}</strong>
                    <small>Pelanggan</small>
                </div>
            </a>
        </header>

        <div class="page-content">
            <section class="welcome-banner">
                <div>
                    <span class="welcome-label">CATCARE PELANGGAN</span>

                    <h2>Selamat datang, {{ auth()->user()->name }}!</h2>

                    <p>
                        Pantau data kucing, pengajuan penitipan, dan status
                        pembayaran kucing kesayanganmu di CatCare.
                    </p>
                </div>
            </section>

            <section class="stats-grid">
                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Data Kucing</span>
                    </div>

                    <strong class="stat-number">
                        {{ $totalKucing ?? 0 }}
                    </strong>

                    <small>Total kucing terdaftar</small>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Penitipan Aktif</span>
                    </div>

                    <strong class="stat-number">
                        {{ $totalPenitipanAktif ?? 0 }}
                    </strong>

                    <small>Penitipan yang sedang berjalan</small>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Riwayat Penitipan</span>
                    </div>

                    <strong class="stat-number">
                        {{ $totalRiwayatPenitipan ?? 0 }}
                    </strong>

                    <small>Total penitipan yang selesai</small>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Pembayaran Menunggu</span>
                    </div>

                    <strong class="stat-number">
                        {{ $totalPembayaranMenunggu ?? 0 }}
                    </strong>

                    <small>Menunggu konfirmasi admin</small>
                </div>
            </section>

            <section class="catcare-banner">
                <div class="catcare-banner-image">
                    <img src="{{ asset('cattt.png') }}" alt="Kucing CatCare">
                </div>

                <div class="catcare-banner-text">
                    <h2>
                        Kucing Sehat,<br>
                        Anda Tenang
                    </h2>

                    <p>
                        Kami selalu memberikan perawatan terbaik untuk
                        kucing kesayangan Anda.
                    </p>
                </div>
            </section>
        </div>
    </main>
</div>
@endsection
