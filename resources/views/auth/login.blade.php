@extends('layouts.app')

@section('title', 'Login - CatCare')

@section('content')
<div class="auth-page">
    <div class="auth-card">

        <div class="auth-brand">
            <div class="brand-logo">
                <img src="{{ asset('logoCat.png') }}" alt="Logo CatCare">
                <span>CatCare</span>
            </div>

            <p>
                Tempat terbaik untuk penitipan kucing kesayanganmu.
            </p>

            <div class="cat-illustration">
                <img src="{{ asset('cattt.png') }}" alt="Kucing CatCare">
            </div>
        </div>

        <div class="auth-form">
            <h1>Masuk ke Akun Anda</h1>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

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

            <form action="{{ route('login.process') }}" method="POST">
                @csrf

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
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <button type="submit" class="btn">
                    Login
                </button>
            </form>

            <p class="auth-switch">
                Belum punya akun?
                <a href="{{ route('register') }}">Register</a>
            </p>
        </div>

    </div>
</div>
@endsection