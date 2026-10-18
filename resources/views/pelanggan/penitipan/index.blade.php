@extends('layouts.panel')

@section('title', 'Penitipan Saya | CatCare')
@section('page_title', 'Penitipan Saya')

@section('panel')
<div class="page-head">
    <div>
        <h2>Penitipan Saya</h2>
        <p>Pantau status pengajuan dan penitipan yang sedang berjalan.</p>
    </div>
    <div class="page-actions">
        <a class="button" href="{{ route('penitipan.create') }}">+ Ajukan Penitipan</a>
    </div>
</div>

<section class="activity-section card-flush" style="margin-top:0">
    <div class="activity-table-wrapper">
        <table class="activity-table">
            <thead>
                <tr>
                    <th>Kucing</th>
                    <th>Layanan</th>
                    <th>Tanggal</th>
                    <th>Biaya</th>
                    <th>Status</th>
                    <th>Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($penitipan as $p)
                    <tr>
                        <td>{{ $p->nama_kucing }}</td>
                        <td>{{ $p->nama_layanan }}</td>
                        <td class="nowrap">
                            @if ($p->tanggal_masuk_aktual)
                                {{ \App\Support\Format::tanggal($p->tanggal_masuk_aktual) }} – {{ \App\Support\Format::tanggal($p->tanggal_keluar_aktual) }}
                            @else
                                <small>Rencana</small><br>{{ \App\Support\Format::tanggal($p->tanggal_mulai) }} – {{ \App\Support\Format::tanggal($p->tanggal_selesai) }}
                            @endif
                        </td>
                        <td class="nowrap">
                            @if ($p->status === 'ditolak') - @else
                                {{ \App\Support\Format::rupiah($p->biaya_tampil) }}
                                @if ($p->total_biaya === null) <br><small>perkiraan</small> @endif
                            @endif
                        </td>
                        <td><span class="badge {{ $p->status_badge }}">{{ $p->status_label }}</span></td>
                        <td>
                            @if ($p->status === 'ditolak') - @else
                                <span class="badge {{ $p->pembayaran_badge }}">{{ $p->pembayaran_label }}</span>
                            @endif
                        </td>
                        <td><a class="button button-sm button-outline" href="{{ route('penitipan.saya.show', $p) }}">Detail</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-activity">
                            <strong>Belum ada penitipan berjalan</strong>
                            <p>Ajukan penitipan baru untuk kucingmu.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $penitipan->links() }}
</section>
@endsection
