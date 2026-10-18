<div class="error-page">
    <div class="code">{{ $code }}</div>
    <h1>{{ $judul }}</h1>
    <p>{{ $pesan }}</p>

    @auth
        <a href="{{ route('dashboard') }}" class="button">Kembali ke Dashboard</a>
    @else
        <a href="{{ route('login') }}" class="button">Kembali ke Login</a>
    @endauth
</div>
