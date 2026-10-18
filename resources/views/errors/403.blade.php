@extends('layouts.app')

@section('title', 'Akses Ditolak | CatCare')

@section('content')
@include('errors.partial', [
    'code' => '403',
    'judul' => 'Akses Ditolak',
    'pesan' => ($exception ?? null) && $exception->getMessage() && ! str_contains($exception->getMessage(), 'unauthorized') ? $exception->getMessage() : 'Kamu tidak memiliki izin untuk membuka halaman atau data ini.',
])
@endsection
