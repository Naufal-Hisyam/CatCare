@extends('layouts.app')

@section('title', 'Halaman Tidak Ditemukan | CatCare')

@section('content')
@include('errors.partial', [
    'code' => '404',
    'judul' => 'Halaman Tidak Ditemukan',
    'pesan' => 'Maaf, halaman atau data yang kamu cari tidak tersedia.',
])
@endsection
