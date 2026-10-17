@extends('layouts.app')

@section('title', 'Register - CatCare')

@section('content')
<div class="auth-page">
    <div class="auth-card">

        <div class="auth-brand">
            <div class="brand-logo">
                <img src="{{ asset('logoCat.png') }}" alt="Logo CatCare">
                <span>CatCare</span>
            </div>

            <p>
                Buat akun dan temukan cara yang nyaman untuk menitipkan kucing kesayanganmu.
            </p>

            <div class="cat-illustration">
                <img src="{{ asset('cattt.png') }}" alt="Kucing CatCare">
            </div>
        </div>

        <div class="auth-form register-form">
            <h1>Buat Akun Baru</h1>

            <p class="auth-subtitle">
                Daftar untuk melanjutkan.
            </p>

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.process') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        placeholder="Masukkan nama lengkap"
                        value="{{ old('name') }}"
                        autocomplete="name"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        placeholder="Masukkan email"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="Minimal 8 karakter"
                        autocomplete="new-password"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="Ulangi password"
                        autocomplete="new-password"
                        required
                    >
                </div>

                <button type="submit" class="btn register-btn">
                    Register
                </button>
            </form>

            <p class="auth-switch register-switch">
                Sudah punya akun?
                <a href="{{ route('login') }}">Login</a>
            </p>
        </div>

    </div>
</div>
@endsection
