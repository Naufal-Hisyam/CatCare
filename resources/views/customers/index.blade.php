@extends('layouts.app')

@section('title', 'Data Pelanggan | CatCare')

@section('content')
<div class="app-shell">
    <aside class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <img src="{{ asset('logoCat.png') }}" alt="Logo CatCare">
            <span>CatCare</span>
        </a>

        <nav class="nav-menu">
            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.customers.index') }}" class="nav-link active">
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
                <h1>Data Pelanggan</h1>
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
            <section class="activity-section">
                <div class="activity-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h2>Daftar Data Pelanggan</h2>
                        <p>Kelola data pelanggan atau pemilik yang terdaftar di sistem CatCare</p>
                    </div>
                </div>

                @if(session('success'))
                    <div style="padding: 15px 20px;">
                        <div class="alert alert-success" style="margin-bottom: 0;">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                <div class="activity-table-wrapper">
                    <table class="activity-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Email</th>
                                <th>Terdaftar Sejak</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $index => $customer)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $customer->name }}</strong></td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->created_at->format('d M Y') }}</td>
                                    <td style="text-align: center;">
                                        <a href="#" style="color: #368fb9; font-weight: 600;">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="empty-activity">
                                        <strong>Belum ada data pelanggan</strong>
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