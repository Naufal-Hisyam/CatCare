@extends('layouts.app')

@section('title', 'Halaman Tidak Ditemukan | CatCare')

@section('content')
<div class="card" style="text-align:center; padding:55px 20px;">
    <h1 style="font-size:60px; margin:0;">404</h1>
    <h2>Halaman Tidak Ditemukan</h2>
    <p class="muted">Maaf, halaman yang kamu cari tidak tersedia.</p>
    <a href="{{ route('login') }}" class="btn">Kembali ke Login</a>
</div>
@endsection