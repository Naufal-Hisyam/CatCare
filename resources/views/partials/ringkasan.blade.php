<dl class="detail-list">
    @if (! empty($tampilPelanggan))
        <dt>Pelanggan</dt>
        <dd>{{ $penitipan->user->name ?? '-' }} <small class="muted">({{ $penitipan->user->email ?? '-' }})</small></dd>
    @endif

    <dt>Kucing</dt>
    <dd>{{ $penitipan->nama_kucing }}
        @if ($penitipan->cat?->breed) <small class="muted">· {{ $penitipan->cat->breed }}</small> @endif
    </dd>

    <dt>Layanan</dt>
    <dd>{{ $penitipan->nama_layanan }} <small class="muted">· {{ \App\Support\Format::rupiah($penitipan->harga_per_hari) }} / hari</small></dd>

    <dt>Rencana masuk</dt>
    <dd>{{ \App\Support\Format::tanggal($penitipan->tanggal_mulai) }}</dd>

    <dt>Rencana keluar</dt>
    <dd>{{ \App\Support\Format::tanggal($penitipan->tanggal_selesai) }} <small class="muted">({{ $penitipan->lama_rencana }} hari)</small></dd>

    <dt>Masuk aktual</dt>
    <dd>{{ \App\Support\Format::tanggal($penitipan->tanggal_masuk_aktual) }}</dd>

    <dt>Keluar aktual</dt>
    <dd>{{ \App\Support\Format::tanggal($penitipan->tanggal_keluar_aktual) }}
        @if ($penitipan->lama_aktual) <small class="muted">({{ $penitipan->lama_aktual }} hari)</small> @endif
    </dd>

    <dt>Catatan pelanggan</dt>
    <dd>{{ $penitipan->catatan ?: '-' }}</dd>

    <dt>Status</dt>
    <dd><span class="badge {{ $penitipan->status_badge }}">{{ $penitipan->status_label }}</span></dd>

    @if ($penitipan->status === 'ditolak')
        <dt>Alasan penolakan</dt>
        <dd>{{ $penitipan->alasan_penolakan ?: '-' }}</dd>
    @endif

    @if ($penitipan->status !== 'ditolak')
        <dt>{{ $penitipan->total_biaya !== null ? 'Total biaya' : 'Perkiraan biaya' }}</dt>
        <dd><strong>{{ \App\Support\Format::rupiah($penitipan->biaya_tampil) }}</strong>
            @if ($penitipan->total_biaya === null)
                <small class="muted">(dihitung dari rencana tanggal; biaya final menyesuaikan tanggal aktual)</small>
            @endif
        </dd>

        <dt>Pembayaran</dt>
        <dd>
            <span class="badge {{ $penitipan->pembayaran_badge }}">{{ $penitipan->pembayaran_label }}</span>
            <small class="muted">· Tunai di tempat</small>
            @if ($penitipan->sudah_dibayar)
                <br><small class="muted">
                    {{ \App\Support\Format::rupiah($penitipan->jumlah_pembayaran) }}
                    · {{ optional($penitipan->tanggal_pembayaran)->format('d-m-Y H:i') }}
                </small>
            @endif
        </dd>
    @endif
</dl>
