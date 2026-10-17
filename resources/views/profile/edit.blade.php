
@extends('layouts.app')

@section('title', 'Profil | CatCare')

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

            <a href="{{ route('profile.show') }}" class="nav-link active">
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

            <a href="{{ route('profile.show') }}" class="topbar-profile">
                <div class="profile-avatar">
                    {{ strtoupper(substr($user->name ?? 'P', 0, 1)) }}
                </div>

                <div class="profile-info">
                    <strong>{{ $user->name }}</strong>
                    <small>Pelanggan</small>
                </div>
            </a>
        </header>

        <div class="page-content">

            @if (session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <section class="profile-edit-card">
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 22px;">
                    <div class="profile-avatar" style="width: 60px; height: 60px; font-size: 24px;">
                        {{ strtoupper(substr($user->name ?? 'P', 0, 1)) }}
                    </div>

                    <div>
                        <h2 style="margin: 0 0 6px;">Edit Profil</h2>
                        <p class="profile-description" style="margin: 0;">
                            Perbarui informasi akun CatCare kamu.
                        </p>
                    </div>
                </div>

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="profile-form-group">
                        <label for="name">Nama Lengkap</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            placeholder="Masukkan nama lengkap"
                            maxlength="255"
                            autocomplete="name"
                            required
                        >
                    </div>

                    <div class="profile-form-group">
                        <label for="email">Alamat Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            placeholder="Masukkan alamat email"
                            maxlength="255"
                            autocomplete="email"
                            required
                        >
                    </div>

                    <div class="profile-form-group">
                        <label for="role">Role Akun</label>
                        <input
                            type="text"
                            id="role"
                            value="Pelanggan"
                            readonly
                        >
                    </div>

                    <div class="profile-form-group">
                        <label for="current_password">Password Lama</label>
                        <input
                            type="password"
                            id="current_password"
                            name="current_password"
                            autocomplete="current-password"
                            placeholder="Masukkan password lama"
                        >
                    </div>

                    <div class="profile-form-group">
                        <label for="password">Password Baru</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            minlength="8"
                            autocomplete="new-password"
                            placeholder="Minimal 8 karakter"
                        >
                    </div>

                    <div class="profile-form-group">
                        <label for="password_confirmation">
                            Konfirmasi Password Baru
                        </label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            minlength="8"
                            autocomplete="new-password"
                            placeholder="Masukkan ulang password baru"
                        >
                    </div>

                    <div class="profile-form-actions">
                        <button type="submit" class="profile-save-button">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </main>
</div>
@endsection
