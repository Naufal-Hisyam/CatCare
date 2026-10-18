@extends('layouts.panel')

@section('title', 'Riwayat Penitipan | CatCare')
@section('page_title', 'Riwayat Penitipan')

@section('panel')
<div class="page-head">
    <div>
        <h2>Riwayat Penitipan</h2>
        <p>Penitipan yang sudah selesai dan pengajuan yang ditolak.</p>
    </div>
</div>

<div class="tabs">
    <a class="tab {{ ! $status ? 'active' : '' }}" href="{{ route('admin.riwayat.index') }}">Semua</a>
    <a class="tab {{ $status === 'selesai' ? 'active' : '' }}" href="{{ route('admin.riwayat.index', ['status' => 'selesai']) }}">Selesai</a>
    <a class="tab {{ $status === 'ditolak' ? 'active' : '' }}" href="{{ route('admin.riwayat.index', ['status' => 'ditolak']) }}">Ditolak</a>
</div>

<section class="activity-section card-flush" style="margin-top:0">
    <form method="GET" class="filter-bar">
        @if ($status) <input type="hidden" name="status" value="{{ $status }}" style="min-width:0"> @endif
        <input type="search" name="cari" value="{{ $cari }}" placeholder="Cari nama pelanggan atau kucing...">
        <button class="button button-sm" type="submit">Cari</button>
        @if ($cari) <a class="button button-sm button-outline" href="{{ route('admin.riwayat.index', array_filter(['status' => $status])) }}">Reset</a> @endif
    </form>

    <div class="activity-table-wrapper">
        <table class="activity-table">
            <thead>
                <tr>
                    <th>Pelanggan</th>
                    <th>Kucing</th>
                    <th>Layanan</th>
                    <th>Masuk – Keluar</th>
                    <th>Total Biaya</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($penitipan as $p)
                    <tr>
                        <td>{{ $p->user->name ?? '-' }}</td>
                        <td>{{ $p->nama_kucing }}</td>
                        <td>{{ $p->nama_layanan }}</td>
                        <td class="nowrap">
                            @if ($p->status === 'selesai')
                                {{ \App\Support\Format::tanggal($p->tanggal_masuk_aktual) }} – {{ \App\Support\Format::tanggal($p->tanggal_keluar_aktual) }}
                            @else
                                <small>Rencana {{ \App\Support\Format::tanggal($p->tanggal_mulai) }} – {{ \App\Support\Format::tanggal($p->tanggal_selesai) }}</small>
                            @endif
                        </td>
                        <td class="nowrap">{{ $p->status === 'selesai' ? \App\Support\Format::rupiah($p->total_biaya) : '-' }}</td>
                        <td>
                            <span class="badge {{ $p->status_badge }}">{{ $p->status_label }}</span>
                            @if ($p->status === 'selesai') <br><span class="badge {{ $p->pembayaran_badge }}" style="margin-top:4px">{{ $p->pembayaran_label }}</span> @endif
                        </td>
                        <td><a class="button button-sm button-outline" href="{{ route('admin.penitipan.show', $p) }}">Detail</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-activity">
                            <strong>Belum ada riwayat</strong>
                            <p>Penitipan selesai atau ditolak akan tampil di sini.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $penitipan->links() }}
</section>
@endsection
