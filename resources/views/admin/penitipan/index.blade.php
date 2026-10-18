@extends('layouts.panel')

@section('title', 'Pengajuan Penitipan | CatCare')
@section('page_title', 'Pengajuan Penitipan')

@section('panel')
<div class="page-head">
    <div>
        <h2>Pengajuan & Proses Penitipan</h2>
        <p>Periksa pengajuan pelanggan dan kelola penitipan yang sedang berjalan.</p>
    </div>
</div>

<div class="tabs">
    <a class="tab {{ ! $status ? 'active' : '' }}" href="{{ route('admin.penitipan.index') }}">Semua</a>
    <a class="tab {{ $status === 'menunggu' ? 'active' : '' }}" href="{{ route('admin.penitipan.index', ['status' => 'menunggu']) }}">Menunggu ({{ $jumlah['menunggu'] ?? 0 }})</a>
    <a class="tab {{ $status === 'disetujui' ? 'active' : '' }}" href="{{ route('admin.penitipan.index', ['status' => 'disetujui']) }}">Disetujui ({{ $jumlah['disetujui'] ?? 0 }})</a>
    <a class="tab {{ $status === 'aktif' ? 'active' : '' }}" href="{{ route('admin.penitipan.index', ['status' => 'aktif']) }}">Sedang Dititipkan ({{ $jumlah['aktif'] ?? 0 }})</a>
</div>

<section class="activity-section card-flush" style="margin-top:0">
    <form method="GET" class="filter-bar">
        @if ($status) <input type="hidden" name="status" value="{{ $status }}" style="min-width:0"> @endif
        <input type="search" name="cari" value="{{ $cari }}" placeholder="Cari nama pelanggan atau kucing...">
        <button class="button button-sm" type="submit">Cari</button>
        @if ($cari) <a class="button button-sm button-outline" href="{{ route('admin.penitipan.index', array_filter(['status' => $status])) }}">Reset</a> @endif
    </form>

    <div class="activity-table-wrapper">
        <table class="activity-table">
            <thead>
                <tr>
                    <th>Pelanggan</th>
                    <th>Kucing</th>
                    <th>Layanan</th>
                    <th>Rencana Masuk – Keluar</th>
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
                        <td class="nowrap">{{ \App\Support\Format::tanggal($p->tanggal_mulai) }} – {{ \App\Support\Format::tanggal($p->tanggal_selesai) }}</td>
                        <td><span class="badge {{ $p->status_badge }}">{{ $p->status_label }}</span></td>
                        <td><a class="button button-sm" href="{{ route('admin.penitipan.show', $p) }}">{{ $p->status === 'menunggu' ? 'Periksa' : 'Kelola' }}</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-activity">
                            <strong>Tidak ada data</strong>
                            <p>Belum ada pengajuan penitipan{{ $status || $cari ? ' yang sesuai filter' : '' }}.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $penitipan->links() }}
</section>
@endsection
