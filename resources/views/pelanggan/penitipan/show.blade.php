@extends('layouts.panel')

@section('title', 'Detail Penitipan | CatCare')
@section('page_title', 'Detail Penitipan')

@section('panel')
<div class="page-head">
    <div>
        <h2>{{ $penitipan->nama_kucing }} · {{ $penitipan->nama_layanan }}</h2>
        <p>Diajukan {{ $penitipan->created_at?->format('d-m-Y H:i') }}</p>
    </div>
    <div class="page-actions">
        <a class="button button-outline" href="{{ in_array($penitipan->status, ['selesai', 'ditolak']) ? route('penitipan.riwayat') : route('penitipan.saya') }}">&laquo; Kembali</a>
    </div>
</div>

@include('partials.steps')

<div class="card">
    <h3>Rincian</h3>
    @include('partials.ringkasan')
</div>

@if ($penitipan->status === 'menunggu')
    <div class="info-box">Pengajuanmu sedang diperiksa admin. Status akan diperbarui setelah disetujui atau ditolak.</div>
@elseif ($penitipan->status === 'disetujui')
    <div class="info-box">Pengajuan disetujui. Bawa kucingmu sesuai tanggal masuk; admin akan mencatat kedatangannya.</div>
@elseif ($penitipan->status === 'aktif' && ! $penitipan->sudah_dibayar)
    <div class="info-box">Pembayaran dilakukan <strong>tunai di tempat</strong> saat kucing dijemput.</div>
@endif
@endsection
