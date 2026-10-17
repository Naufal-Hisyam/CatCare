
@extends('layouts.app')

@section('title', 'Dashboard Admin | CatCare')

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
                <span>Data Pelanggan</span>
            </a>

            <a href="#" class="nav-link">
                <span>Data Layanan</span>
            </a>

            <a href="#" class="nav-link">
                <span>Pengajuan Penitipan</span>
            </a>

            <a href="#" class="nav-link">
                <span>Pembayaran</span>
            </a>

            <a href="#" class="nav-link">
                <span>Riwayat Penitipan</span>
            </a>

            <a href="{{ route('admin.profile.show') }}" class="nav-link">
                <span>Profil</span>
            </a>
        </nav>

        <div class="sidebar-bottom">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-button">
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="main-area">
        <header class="topbar">
            <div class="topbar-title">
                <h1>Dashboard Admin</h1>
            </div>

            <a href="{{ route('admin.profile.show') }}" class="topbar-profile">
                <div class="profile-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <div class="profile-info">
                    <strong>{{ auth()->user()->name }}</strong>
                    <small>Administrator</small>
                </div>
            </a>
        </header>

        <div class="page-content">
            <section class="welcome-banner">
                <div>
                    <span class="welcome-label">CATCARE ADMIN</span>

                    <h2>Selamat datang, {{ auth()->user()->name }}!</h2>

                    <p>
                        Pantau aktivitas dan pengelolaan penitipan kucing di sini.
                    </p>
                </div>
            </section>

            <section class="stats-grid">
                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Data Layanan</span>
                    </div>

                    <strong class="stat-number">
                        {{ $totalLayanan ?? 0 }}
                    </strong>

                    <small>Total layanan tersedia</small>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Pengajuan Penitipan</span>
                    </div>

                    <strong class="stat-number">
                        {{ $totalPengajuan ?? 0 }}
                    </strong>

                    <small>Total pengajuan penitipan</small>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Total Pelanggan</span>
                    </div>

                    <strong class="stat-number">
                        {{ $totalPengguna ?? 0 }}
                    </strong>

                    <small>Total pelanggan terdaftar</small>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Penitipan Aktif</span>
                    </div>

                    <strong class="stat-number">
                        {{ $totalPenitipanAktif ?? 0 }}
                    </strong>

                    <small>Penitipan sedang berjalan</small>
                </div>
            </section>

            <section class="activity-section">
                <div class="activity-header">
                    <div>
                        <h2>Aktivitas Terbaru</h2>

                        <p>
                            Daftar aktivitas terbaru dalam sistem CatCare.
                        </p>
                    </div>
                </div>

                <div class="activity-table-wrapper">
                    <table class="activity-table">
                        <thead>
                            <tr>
                                <th>Aktivitas</th>
                                <th>Pelanggan</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse (($aktivitasTerbaru ?? collect()) as $aktivitas)
                                <tr>
                                    <td>
                                        {{ $aktivitas->aktivitas ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $aktivitas->pengguna ?? $aktivitas->pelanggan ?? '-' }}
                                    </td>

                                    <td>
                                        @if (!empty($aktivitas->tanggal))
                                            {{ \Carbon\Carbon::parse($aktivitas->tanggal)->format('d-m-Y H:i') }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td>
                                        {{ $aktivitas->status ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="empty-activity">
                                        <strong>Belum ada aktivitas</strong>

                                        <p>
                                            Aktivitas terbaru akan ditampilkan di sini.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
</div>
@endsection
