@extends('layouts.app')

@section('title', 'Terjadi Kesalahan | CatCare')

@section('content')
@include('errors.partial', [
    'code' => '500',
    'judul' => 'Terjadi Kesalahan',
    'pesan' => 'Maaf, terjadi kesalahan pada sistem. Silakan coba lagi beberapa saat lagi.',
])
@endsection
