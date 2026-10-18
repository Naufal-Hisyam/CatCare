@extends('layouts.app')

@section('title', 'Sesi Berakhir | CatCare')

@section('content')
@include('errors.partial', [
    'code' => '419',
    'judul' => 'Sesi Berakhir',
    'pesan' => 'Sesi kamu sudah berakhir. Silakan muat ulang halaman lalu coba lagi.',
])
@endsection
