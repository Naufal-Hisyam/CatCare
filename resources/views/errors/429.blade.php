@extends('layouts.app')

@section('title', 'Terlalu Banyak Permintaan | CatCare')

@section('content')
@include('errors.partial', [
    'code' => '429',
    'judul' => 'Terlalu Banyak Permintaan',
    'pesan' => 'Mohon tunggu sebentar sebelum mencoba lagi.',
])
@endsection
