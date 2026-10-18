@extends('layouts.app')

{{--
    Layout panel untuk halaman Anggota 4 (admin & pelanggan).
    Halaman anak mengisi section: title, page_title, panel.
--}}

@php
    $user = auth()->user();
    $isAdmin = $user->role === 'admin';
    $profilUrl = $isAdmin ? route('admin.profile.show') : route('profile.show');

    $menu = $isAdmin
        ? [
            ['Dashboard', route('dashboard'), 'dashboard'],
            ['Data Pelanggan', route('admin.customers.index'), 'admin.customers.*'],
            ['Data Layanan', route('layanan.index'), 'layanan.*'],
            ['Pengajuan Penitipan', route('admin.penitipan.index'), 'admin.penitipan.*'],
            ['Pembayaran', route('admin.pembayaran.index'), 'admin.pembayaran.*'],
            ['Riwayat Penitipan', route('admin.riwayat.index'), 'admin.riwayat.*'],
            ['Profil', $profilUrl, '*profile.*'],
        ]
        : [
            ['Dashboard', route('dashboard'), 'dashboard'],
            ['Data Kucing', route('cats.index'), 'cats.*'],
            ['Daftar Layanan', route('layanan.index'), 'layanan.*'],
            ['Penitipan Saya', route('penitipan.saya'), ['penitipan.saya', 'penitipan.saya.show']],
            ['Riwayat Penitipan', route('penitipan.riwayat'), 'penitipan.riwayat'],
            ['Profil', $profilUrl, '*profile.*'],
        ];
@endphp

@section('content')
<link rel="stylesheet" href="{{ asset('css/panel.css') }}">

<div class="app-shell">
    <aside class="sidebar">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <img src="{{ asset('logoCat.png') }}" alt="Logo CatCare">
            <span>CatCare</span>
        </a>

        <nav class="nav-menu">
            @foreach ($menu as [$label, $url, $pattern])
                <a href="{{ $url }}"
                   class="nav-link {{ request()->routeIs($pattern) ? 'active' : '' }}">
                    <span>{{ $label }}</span>
                </a>
            @endforeach
        </nav>

        <div class="sidebar-bottom">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-button">Logout</button>
            </form>
        </div>
    </aside>

    <main class="main-area">
        <header class="topbar">
            <div class="topbar-title">
                <h1>@yield('page_title')</h1>
            </div>

            <a href="{{ $profilUrl }}" class="topbar-profile">
                <div class="profile-avatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>

                <div class="profile-info">
                    <strong>{{ $user->name }}</strong>
                    <small>{{ $isAdmin ? 'Administrator' : 'Pelanggan' }}</small>
                </div>
            </a>
        </header>

        <div class="page-content">
            @include('partials.flash')

            @yield('panel')
        </div>
    </main>
</div>
@endsection
