@extends('layouts.app')

@section('title', 'Detail Kucing | CatCare')

@section('content')
<div class="page-content">
    <div class="activity-section" style="max-width: 800px; margin: 0 auto;">
        <div class="activity-header" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2>Detail Data Kucing</h2>
                <p>Informasi lengkap mengenai kucing</p>
            </div>
            <div>
                <a href="{{ route('cats.index') }}" class="btn" style="background-color: #8195a2; width: auto; padding: 8px 16px; margin-top: 0; text-decoration: none;">Kembali</a>
            </div>
        </div>

        <div style="padding: 24px;">
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 15px; margin-bottom: 15px; border-bottom: 1px solid var(--border); padding-bottom: 15px;">
                <strong style="color: var(--muted);">Nama Kucing</strong>
                <span style="font-weight: 700; color: var(--text);">{{ $cat->name }}</span>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 15px; margin-bottom: 15px; border-bottom: 1px solid var(--border); padding-bottom: 15px;">
                <strong style="color: var(--muted);">Ras Kucing</strong>
                <span>{{ $cat->breed ?? '-' }}</span>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 15px; margin-bottom: 15px; border-bottom: 1px solid var(--border); padding-bottom: 15px;">
                <strong style="color: var(--muted);">Umur</strong>
                <span>{{ $cat->age ? $cat->age . ' bulan' : '-' }}</span>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 15px; margin-bottom: 15px; border-bottom: 1px solid var(--border); padding-bottom: 15px;">
                <strong style="color: var(--muted);">Gender</strong>
                <span style="text-transform: capitalize;">{{ $cat->gender }}</span>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 15px; margin-bottom: 15px; border-bottom: 1px solid var(--border); padding-bottom: 15px;">
                <strong style="color: var(--muted);">Pemilik / Terdaftar Oleh</strong>
                <span>{{ $cat->user->name ?? 'Tidak diketahui' }}</span>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 25px;">
                <a href="{{ route('cats.edit', $cat->id) }}" class="btn" style="background-color: #d97706; width: auto; padding: 8px 20px; text-decoration: none; margin-top: 0;">Edit Data</a>
                <form action="{{ route('cats.destroy', $cat->id) }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn" style="background-color: #b9404e; width: auto; padding: 8px 20px; margin-top: 0; cursor: pointer;" onclick="return confirm('Yakin ingin menghapus data kucing ini?')">Hapus Data</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection