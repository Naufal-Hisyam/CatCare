@extends('layouts.panel')

@section('title', 'Catat Pembayaran | CatCare')
@section('page_title', 'Pembayaran Tunai')

@section('panel')
<div class="page-head">
    <div>
        <h2>Pembayaran · {{ $penitipan->nama_kucing }}</h2>
        <p>Pelanggan: {{ $penitipan->user->name ?? '-' }}</p>
    </div>
    <div class="page-actions">
        <a class="button button-outline" href="{{ route('admin.pembayaran.index') }}">&laquo; Kembali</a>
        <a class="button button-outline" href="{{ route('admin.penitipan.show', $penitipan) }}">Detail Penitipan</a>
    </div>
</div>

<div class="grid-2">
    <div class="card">
        <h3>Rincian Biaya</h3>
        <dl class="detail-list">
            <dt>Layanan</dt>
            <dd>{{ $penitipan->nama_layanan }} · {{ \App\Support\Format::rupiah($penitipan->harga_per_hari) }} / hari</dd>
            <dt>Masuk aktual</dt>
            <dd>{{ \App\Support\Format::tanggal($penitipan->tanggal_masuk_aktual) }}</dd>
            <dt>Keluar aktual</dt>
            <dd>{{ \App\Support\Format::tanggal($penitipan->tanggal_keluar_aktual) }}</dd>
            <dt>Lama penitipan</dt>
            <dd>{{ $penitipan->lama_aktual ? $penitipan->lama_aktual . ' hari' : '-' }}</dd>
            <dt>{{ $penitipan->total_biaya !== null ? 'Total biaya' : 'Perkiraan biaya' }}</dt>
            <dd><strong>{{ \App\Support\Format::rupiah($penitipan->biaya_tampil) }}</strong></dd>
            <dt>Status pembayaran</dt>
            <dd><span class="badge {{ $penitipan->pembayaran_badge }}">{{ $penitipan->pembayaran_label }}</span></dd>
            @if ($penitipan->sudah_dibayar)
                <dt>Dibayar</dt>
                <dd>{{ \App\Support\Format::rupiah($penitipan->jumlah_pembayaran) }} · {{ optional($penitipan->tanggal_pembayaran)->format('d-m-Y H:i') }}</dd>
            @endif
        </dl>
    </div>

    <div class="card">
        @if ($penitipan->bisaBayar())
            <h3>Catat Pembayaran Tunai</h3>
            <form action="{{ route('admin.pembayaran.store', $penitipan) }}" method="POST">
                @csrf
                <div class="field {{ $errors->has('jumlah_pembayaran') ? 'has-error' : '' }}">
                    <label for="jumlah_pembayaran">Jumlah diterima (Rp) <span class="req">*</span></label>
                    <input type="number" id="jumlah_pembayaran" name="jumlah_pembayaran" min="0" step="1"
                           value="{{ old('jumlah_pembayaran', (int) $penitipan->total_biaya) }}" required>
                    @error('jumlah_pembayaran') <span class="error">{{ $message }}</span> @enderror
                    <span class="hint">Total yang harus dibayar: {{ \App\Support\Format::rupiah($penitipan->total_biaya) }}</span>
                </div>
                <div class="form-actions">
                    <button type="submit" class="button button-success" onclick="return confirm('Catat pembayaran tunai ini?')">Simpan Pembayaran</button>
                </div>
            </form>
        @elseif ($penitipan->sudah_dibayar)
            <h3>Pembayaran Lunas</h3>
            <p class="muted" style="font-size:13px;margin-top:0">Pembayaran sudah tercatat.</p>
            @if ($penitipan->bisaSelesai())
                <form action="{{ route('admin.penitipan.selesai', $penitipan) }}" method="POST"
                      onsubmit="return confirm('Tandai penitipan ini sebagai Selesai?')">
                    @csrf
                    <button type="submit" class="button button-success">Tandai Penitipan Selesai</button>
                </form>
            @endif
        @else
            <h3>Pembayaran Belum Bisa Dicatat</h3>
            <p class="muted" style="font-size:13px;margin-top:0">
                Catat tanggal kucing keluar terlebih dahulu agar total biaya dapat dihitung.
            </p>
            <a class="button" href="{{ route('admin.penitipan.show', $penitipan) }}">Ke Detail Penitipan</a>
        @endif
    </div>
</div>
@endsection
