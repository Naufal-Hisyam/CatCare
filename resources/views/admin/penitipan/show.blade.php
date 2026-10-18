@extends('layouts.panel')

@section('title', 'Detail Penitipan | CatCare')
@section('page_title', 'Detail Penitipan')

@section('panel')
<div class="page-head">
    <div>
        <h2>Penitipan #{{ $penitipan->id }} · {{ $penitipan->nama_kucing }}</h2>
        <p>Diajukan {{ $penitipan->created_at?->format('d-m-Y H:i') }}</p>
    </div>
    <div class="page-actions">
        <a class="button button-outline" href="{{ in_array($penitipan->status, ['selesai', 'ditolak']) ? route('admin.riwayat.index') : route('admin.penitipan.index') }}">&laquo; Kembali</a>
    </div>
</div>

@include('partials.steps')

<div class="grid-2">
    <div class="card">
        <h3>Data Penitipan</h3>
        @include('partials.ringkasan', ['tampilPelanggan' => true])
    </div>

    <div>
        {{-- 1. Periksa pengajuan --}}
        @if ($penitipan->bisaDiputuskan())
            <div class="card">
                <h3>Keputusan Pengajuan</h3>
                <p class="muted" style="font-size:12px;margin-top:0">Periksa data di samping, lalu setujui atau tolak pengajuan ini.</p>

                <form action="{{ route('admin.penitipan.setujui', $penitipan) }}" method="POST" class="inline-form"
                      onsubmit="return confirm('Setujui pengajuan ini?')">
                    @csrf
                    <button type="submit" class="button button-success">Setujui Pengajuan</button>
                </form>

                <hr style="border:none;border-top:1px solid var(--border);margin:18px 0">

                <form action="{{ route('admin.penitipan.tolak', $penitipan) }}" method="POST">
                    @csrf
                    <div class="field {{ $errors->has('alasan_penolakan') ? 'has-error' : '' }}">
                        <label for="alasan_penolakan">Alasan penolakan <span class="req">*</span></label>
                        <textarea id="alasan_penolakan" name="alasan_penolakan" maxlength="500" placeholder="Contoh: kandang penuh pada tanggal tersebut">{{ old('alasan_penolakan') }}</textarea>
                        @error('alasan_penolakan') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="button button-danger" onclick="return confirm('Tolak pengajuan ini?')">Tolak Pengajuan</button>
                    </div>
                </form>
            </div>
        @endif

        {{-- 2. Catat masuk --}}
        @if ($penitipan->bisaMasuk())
            <div class="card">
                <h3>Catat Kucing Masuk</h3>
                <form action="{{ route('admin.penitipan.masuk', $penitipan) }}" method="POST">
                    @csrf
                    <div class="field {{ $errors->has('tanggal_masuk_aktual') ? 'has-error' : '' }}">
                        <label for="tanggal_masuk_aktual">Tanggal masuk aktual <span class="req">*</span></label>
                        <input type="date" id="tanggal_masuk_aktual" name="tanggal_masuk_aktual"
                               value="{{ old('tanggal_masuk_aktual', now()->format('Y-m-d')) }}" max="{{ now()->format('Y-m-d') }}" required>
                        @error('tanggal_masuk_aktual') <span class="error">{{ $message }}</span> @enderror
                        <span class="hint">Rencana pelanggan: {{ \App\Support\Format::tanggal($penitipan->tanggal_mulai) }}</span>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="button">Catat Masuk &amp; Mulai Penitipan</button>
                    </div>
                </form>
            </div>
        @endif

        {{-- 3. Catat keluar --}}
        @if ($penitipan->bisaKeluar())
            <div class="card">
                <h3>Catat Kucing Keluar (Dijemput)</h3>
                <form action="{{ route('admin.penitipan.keluar', $penitipan) }}" method="POST">
                    @csrf
                    <div class="field {{ $errors->has('tanggal_keluar_aktual') ? 'has-error' : '' }}">
                        <label for="tanggal_keluar_aktual">Tanggal keluar aktual <span class="req">*</span></label>
                        <input type="date" id="tanggal_keluar_aktual" name="tanggal_keluar_aktual"
                               value="{{ old('tanggal_keluar_aktual', now()->format('Y-m-d')) }}"
                               min="{{ optional($penitipan->tanggal_masuk_aktual)->format('Y-m-d') }}" max="{{ now()->format('Y-m-d') }}" required>
                        @error('tanggal_keluar_aktual') <span class="error">{{ $message }}</span> @enderror
                        <span class="hint">Rencana pelanggan: {{ \App\Support\Format::tanggal($penitipan->tanggal_selesai) }}. Total biaya dihitung otomatis dari tanggal masuk & keluar aktual.</span>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="button">Catat Keluar &amp; Hitung Biaya</button>
                    </div>
                </form>
            </div>
        @endif

        {{-- 4. Pembayaran --}}
        @if ($penitipan->bisaBayar())
            <div class="card">
                <h3>Pembayaran Tunai</h3>
                <div class="info-box">
                    <small>Total biaya yang harus dibayar</small>
                    <span class="big">{{ \App\Support\Format::rupiah($penitipan->total_biaya) }}</span>
                </div>
                <div class="form-actions">
                    <a class="button" href="{{ route('admin.pembayaran.show', $penitipan) }}">Catat Pembayaran</a>
                </div>
            </div>
        @endif

        {{-- 5. Selesai --}}
        @if ($penitipan->bisaSelesai())
            <div class="card">
                <h3>Selesaikan Penitipan</h3>
                <p class="muted" style="font-size:12px;margin-top:0">Kucing sudah keluar dan pembayaran lunas. Ubah status menjadi Selesai.</p>
                <form action="{{ route('admin.penitipan.selesai', $penitipan) }}" method="POST"
                      onsubmit="return confirm('Tandai penitipan ini sebagai Selesai?')">
                    @csrf
                    <button type="submit" class="button button-success">Tandai Selesai</button>
                </form>
            </div>
        @endif

        @if (in_array($penitipan->status, ['selesai', 'ditolak']))
            <div class="card">
                <h3>Status Akhir</h3>
                <p class="muted" style="margin:0;font-size:13px">
                    {{ $penitipan->status === 'selesai' ? 'Penitipan ini sudah selesai dan tersimpan di riwayat.' : 'Pengajuan ini ditolak dan tersimpan di riwayat.' }}
                </p>
            </div>
        @endif
    </div>
</div>
@endsection
