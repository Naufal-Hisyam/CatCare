@extends('layouts.app')

@section('title', 'Sedang Perawatan | CatCare')

@section('content')
@include('errors.partial', [
    'code' => '503',
    'judul' => 'Sedang Perawatan',
    'pesan' => 'CatCare sedang dalam perawatan. Silakan kembali beberapa saat lagi.',
])
@endsection
