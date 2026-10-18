@extends('layouts.app')

@section('title', 'Data Kucing | CatCare')

@php
    $profileRoute = auth()->user()?->role === 'admin' ? route('admin.profile.show') : route('profile.show');
@endphp

@section('content')
<div class="app-shell">
    <aside class="sidebar">
        <a href="{{ url('/dashboard') }}" class="sidebar-brand">
            <img src="{{ asset('logoCat.png') }}" alt="Logo CatCare"> CatCare
        </a>
        <nav class="nav-menu">
            <a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a>
            <a href="{{ route('cats.index') }}" class="nav-link active">Data Kucing</a>
            <a href="#" class="nav-link">Daftar Layanan</a>
            <a href="#" class="nav-link">Data Penitipan</a>
            <a href="#" class="nav-link">Data Pelanggan</a>
            <a href="{{ $profileRoute }}" class="nav-link">Profil</a>
        </nav>
        <div class="sidebar-bottom">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-button">Logout</button>
            </form>
        </div>
    </aside>

    <!-- MAIN AREA -->
    <div class="main-area">
        <!-- TOPBAR -->
        <header class="topbar">
            <div class="topbar-title">
                <h1>Data Kucing</h1>
            </div>
            <a href="{{ $profileRoute }}" class="topbar-profile">
                <div class="profile-avatar">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="profile-info">
                    <strong>{{ Auth::user()->name ?? 'Admin CatCare' }}</strong>
                    <small>Admin</small>
                </div>
            </a>
        </header>

        <!-- KONTEN UTAMA HALAMAN -->
        <main class="page-content">
            <div class="activity-section">
                <div class="activity-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h2>Daftar Data Kucing</h2>
                        <p>Kelola data kucing yang terdaftar di sistem CatCare</p>
                    </div>
                    <div>
                        <a href="{{ route('cats.create') }}" class="btn" style="width: auto; padding: 8px 16px; margin-top: 0;">+ Tambah Data</a>
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
                                <th>Nama Kucing</th>
                                <th>Ras</th>
                                <th>Umur</th>
                                <th>Gender</th>
                                <th>Pemilik</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cats as $index => $cat)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $cat->name }}</strong></td>
                                    <td>{{ $cat->breed ?? '-' }}</td>
                                    <td>{{ $cat->age ? $cat->age . ' bulan' : '-' }}</td>
                                    <td style="text-transform: capitalize;">{{ $cat->gender }}</td>
                                    <td>{{ $cat->user->name ?? 'Tidak diketahui' }}</td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('cats.show', $cat->id) }}" style="color: #368fb9; font-weight: 600; margin-right: 10px;">Detail</a>
                                        <a href="{{ route('cats.edit', $cat->id) }}" style="color: #d97706; font-weight: 600; margin-right: 10px;">Edit</a>
                                        <form action="{{ route('cats.destroy', $cat->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background: none; border: none; color: #b9404e; font-weight: 600; cursor: pointer; padding: 0;" onclick="return confirm('Yakin ingin menghapus data kucing ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="empty-activity">
                                        <strong>Belum ada data kucing</strong>
                                        <p>Silakan tambahkan data kucing baru melalui tombol di atas.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection