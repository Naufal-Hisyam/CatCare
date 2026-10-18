@extends('layouts.panel')

@section('title', 'Pembayaran | CatCare')
@section('page_title', 'Pembayaran')

@section('panel')
<div class="page-head">
    <div>
        <h2>Pembayaran Tunai</h2>
        <p>Catat pembayaran tunai setelah kucing dijemput.</p>
    </div>
</div>

<div class="tabs">
    <a class="tab {{ ! $filter ? 'active' : '' }}" href="{{ route('admin.pembayaran.index') }}">Semua</a>
    <a class="tab {{ $filter === 'belum' ? 'active' : '' }}" href="{{ route('admin.pembayaran.index', ['status' => 'belum']) }}">Belum Dibayar</a>
    <a class="tab {{ $filter === 'sudah' ? 'active' : '' }}" href="{{ route('admin.pembayaran.index', ['status' => 'sudah']) }}">Sudah Dibayar</a>
</div>

<section class="activity-section card-flush" style="margin-top:0">
    <form method="GET" class="filter-bar">
        @if ($filter) <input type="hidden" name="status" value="{{ $filter }}" style="min-width:0"> @endif
        <input type="search" name="cari" value="{{ $cari }}" placeholder="Cari nama pelanggan atau kucing...">
        <button class="button button-sm" type="submit">Cari</button>
        @if ($cari) <a class="button button-sm button-outline" href="{{ route('admin.pembayaran.index', array_filter(['status' => $filter])) }}">Reset</a> @endif
    </form>

    <div class="activity-table-wrapper">
        <table class="activity-table">
            <thead>
                <tr>
                    <th>Pelanggan</th>
                    <th>Kucing</th>
                    <th>Layanan</th>
                    <th>Total Biaya</th>
                    <th>Pembayaran</th>
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
                            {{ \App\Support\Format::rupiah($p->biaya_tampil) }}
                            @if ($p->total_biaya === null) <br><small>perkiraan</small> @endif
                        </td>
                        <td>
                            <span class="badge {{ $p->pembayaran_badge }}">{{ $p->pembayaran_label }}</span>
                            @if (! $p->tanggal_keluar_aktual && ! $p->sudah_dibayar) <br><small>Kucing belum keluar</small> @endif
                        </td>
                        <td>
                            <a class="button button-sm {{ $p->bisaBayar() ? '' : 'button-outline' }}" href="{{ route('admin.pembayaran.show', $p) }}">
                                {{ $p->bisaBayar() ? 'Catat Bayar' : 'Lihat' }}
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-activity">
                            <strong>Tidak ada data pembayaran</strong>
                            <p>Pembayaran muncul setelah kucing tercatat masuk.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $penitipan->links() }}
</section>
@endsection
