@extends('layouts.app')

@section('title', 'Daftar Layanan | CatCare')

@section('content')
<div class="app-shell">
    <aside class="sidebar">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <img src="{{ asset('logoCat.png') }}" alt="Logo CatCare">
            <span>CatCare</span>
        </a>

        <nav class="nav-menu">
            @if(auth()->check() && auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.customers.index') }}" class="nav-link">
                    <span>Data Pelanggan</span>
                </a>
                <a href="{{ route('layanan.index') }}" class="nav-link active">
                    <span>Data Layanan</span>
                </a>
                <a href="{{ route('admin.penitipan.index') }}" class="nav-link">
                    <span>Pengajuan Penitipan</span>
                </a>
                <a href="{{ route('admin.pembayaran.index') }}" class="nav-link">
                    <span>Pembayaran</span>
                </a>
                <a href="{{ route('admin.riwayat.index') }}" class="nav-link">
                    <span>Riwayat Penitipan</span>
                </a>
                <a href="{{ route('admin.profile.show') }}" class="nav-link">
                    <span>Profil</span>
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('cats.index') }}" class="nav-link">
                    <span>Data Kucing</span>
                </a>
                <a href="{{ route('layanan.index') }}" class="nav-link active">
                    <span>Daftar Layanan</span>
                </a>
                <a href="{{ route('penitipan.saya') }}" class="nav-link">
                    <span>Penitipan Saya</span>
                </a>
                <a href="{{ route('penitipan.riwayat') }}" class="nav-link">
                    <span>Riwayat Penitipan</span>
                </a>
                <a href="{{ route('profile.show') }}" class="nav-link">
                    <span>Profil</span>
                </a>
            @endif
        </nav>

        @auth
            <div class="sidebar-bottom">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-button">Logout</button>
                </form>
            </div>
        @endauth
    </aside>

    <main class="main-area">
        <header class="topbar">
            <div class="topbar-title">
                <h1>Data Layanan</h1>
            </div>
        </header>

        <div class="page-content">
            <section class="welcome-banner">
                <div>
                    <span class="welcome-label">CATCARE</span>
                    <h2>Daftar Layanan Penitipan Kucing</h2>
                    <p>Lihat layanan penitipan yang tersedia di CatCare.</p>
                </div>
            </section>

            <section class="activity-section">
                <div class="activity-header">
                    <div>
                        <h2>Daftar Layanan</h2>
                        <p>Informasi layanan dan harga penitipan kucing.</p>
                    </div>

                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <a href="{{ route('layanan.create') }}"
                           style="display:inline-block; background:#70c5eb; color:white; padding:12px 20px; border-radius:8px; text-decoration:none; font-weight:bold;">
                            + Tambah Layanan
                        </a>
                    @endif
                </div>

                @if(session('success'))
                    <div style="background:#e7f6fd; color:#24465b; padding:14px 18px; border-radius:8px; margin:16px 0;">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="activity-table-wrapper">
                    <table class="activity-table">
                        <thead>
                            <tr>
                                <th>Nama Layanan</th>
                                <th>Deskripsi</th>
                                <th>Harga per Hari</th>
                                <th>Detail</th>

                                @if(auth()->check() && auth()->user()->role === 'admin')
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($layanans as $layanan)
                                <tr>
                                    <td>{{ $layanan->nama_layanan }}</td>
                                    <td>{{ $layanan->deskripsi ?? '-' }}</td>
                                    <td>
                                        Rp{{ number_format($layanan->harga, 0, ',', '.') }}
                                    </td>

                                    <td>
                                        <a href="{{ route('layanan.show', $layanan->id) }}"
                                           style="display:inline-block; background:#e7f6fd; color:#378fb8; padding:8px 16px; border-radius:6px; text-decoration:none; font-weight:bold;">
                                            Lihat Detail
                                        </a>
                                    </td>

                                    @if(auth()->check() && auth()->user()->role === 'admin')
                                        <td>
                                            <a href="{{ route('layanan.edit', $layanan->id) }}"
                                               style="display:inline-block; background:#70c5eb; color:white; padding:8px 16px; border-radius:6px; text-decoration:none;">
                                                Edit
                                            </a>

                                            <form id="hapus-layanan-{{ $layanan->id }}"
                                                  action="{{ route('layanan.destroy', $layanan->id) }}"
                                                  method="POST"
                                                  style="display:inline-block; margin-left:8px;">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button"
                                                        onclick="bukaModalHapus('hapus-layanan-{{ $layanan->id }}')"
                                                        style="background:#ef4444; color:white; padding:8px 16px; border:none; border-radius:6px; cursor:pointer;">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ auth()->check() && auth()->user()->role === 'admin' ? 5 : 4 }}"
                                        class="empty-activity">
                                        <strong>Belum ada layanan yang tersedia.</strong>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
</div>

<!-- Modal konfirmasi hapus -->
<div id="modalHapus"
     style="display:none; position:fixed; inset:0; background:rgba(20,40,60,0.45); z-index:9999; align-items:center; justify-content:center; padding:20px;">

    <div role="dialog"
         aria-modal="true"
         aria-labelledby="judulModalHapus"
         style="background:white; padding:32px; border-radius:20px; width:100%; max-width:400px; text-align:center; box-shadow:0 15px 40px rgba(0,0,0,0.15);">

        <div style="font-size:42px; margin-bottom:12px;">
            🐱
        </div>

        <h2 id="judulModalHapus"
            style="color:#24465b; margin-bottom:12px;">
            Hapus Layanan?
        </h2>

        <p style="color:#64748b; line-height:1.6; margin-bottom:24px;">
            Apakah kamu yakin ingin menghapus layanan ini?
            Data yang dihapus tidak dapat dikembalikan.
        </p>

        <div style="display:flex; gap:12px; justify-content:center;">
            <button type="button"
                    onclick="tutupModalHapus()"
                    style="flex:1; padding:12px; border:none; border-radius:10px; background:#e7f6fd; color:#378fb8; cursor:pointer; font-weight:bold;">
                Batal
            </button>

            <button type="button"
                    onclick="konfirmasiHapus()"
                    style="flex:1; padding:12px; border:none; border-radius:10px; background:#70c5eb; color:white; cursor:pointer; font-weight:bold;">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
    let formHapusAktif = null;

    function bukaModalHapus(formId) {
        formHapusAktif = document.getElementById(formId);

        const modal = document.getElementById('modalHapus');
        modal.style.display = 'flex';
    }

    function tutupModalHapus() {
        const modal = document.getElementById('modalHapus');
        modal.style.display = 'none';

        formHapusAktif = null;
    }

    function konfirmasiHapus() {
        if (formHapusAktif) {
            formHapusAktif.submit();
        }
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            tutupModalHapus();
        }
    });
</script>
@endsection