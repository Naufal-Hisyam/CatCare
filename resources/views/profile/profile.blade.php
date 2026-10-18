@extends('layouts.app')

@section('title', 'Profil Admin | CatCare')

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

            <a href="{{ route('cats.index') }}" class="nav-link">
                <span>Data Kucing</span>
            </a>

            <a href="{{ route('layanan.index') }}" class="nav-link">
                <span>Daftar Layanan</span>
            </a>

            <a href="#" class="nav-link">
                <span>Data Penitipan</span>
            </a>

            <a href="{{ route('admin.customers.index') }}" class="nav-link">
                <span>Data Pelanggan</span>
            </a>

            <a href="{{ route('admin.profile.show') }}" class="nav-link active">
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
                <h1>Profil</h1>
            </div>

            <a href="{{ route('admin.profile.show') }}" class="topbar-profile">
                <div class="profile-avatar">
                    {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                </div>

                <div class="profile-info">
                    <strong>{{ $user->name }}</strong>
                    <small>Admin</small>
                </div>
            </a>
        </header>

        <div class="page-content">
            <section class="profile-edit-card">
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 28px;">
                    <div class="profile-avatar" style="width: 64px; height: 64px; font-size: 26px;">
                        {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                    </div>

                    <div>
                        <h2 style="margin: 0 0 6px;">
                            {{ $user->name }}
                        </h2>

                        <p class="profile-description" style="margin: 0;">
                            Informasi akun administrator CatCare
                        </p>
                    </div>
                </div>

                <div class="profile-form-group">
                    <label>Nama Lengkap</label>
                    <input
                        type="text"
                        value="{{ $user->name }}"
                        readonly
                    >
                </div>

                <div class="profile-form-group">
                    <label>Email</label>
                    <input
                        type="email"
                        value="{{ $user->email }}"
                        readonly
                    >
                </div>

                <div class="profile-form-group">
                    <label>Role</label>
                    <input
                        type="text"
                        value="Admin"
                        readonly
                    >
                </div>
            </section>
        </div>
    </main>
</div>
@endsection
