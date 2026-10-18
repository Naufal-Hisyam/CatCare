@extends('layouts.app')

@section('title', 'Pengajuan Penitipan | CatCare')

@section('content')
<style>
    .pengajuan-container {
        max-width: 850px;
        margin: 35px auto;
        padding: 0 20px;
    }

    .pengajuan-card {
        background: white;
        padding: 35px;
        border-radius: 18px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.07);
    }

    .pengajuan-card h2 {
        color: #253c75;
        margin-bottom: 8px;
    }

    .pengajuan-card p {
        color: #64748b;
        margin-bottom: 25px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #334155;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        font-size: 14px;
        box-sizing: border-box;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #4169a8;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .estimasi-box {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 12px;
        padding: 20px;
        margin: 25px 0;
    }

    .estimasi-box h3 {
        color: #253c75;
        margin: 0 0 10px;
    }

    .estimasi-box strong {
        font-size: 25px;
        color: #1d4ed8;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 25px;
    }

    .btn-ajukan {
        background: #315da5;
        color: white;
        border: none;
        padding: 12px 22px;
        border-radius: 9px;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-kembali {
        background: #e2e8f0;
        color: #334155;
        padding: 12px 22px;
        border-radius: 9px;
        text-decoration: none;
    }

    .error-text {
        color: #dc2626;
        font-size: 13px;
        margin-top: 5px;
    }

    @media (max-width: 600px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .pengajuan-card {
            padding: 22px;
        }
    }
</style>

<div class="pengajuan-container">
    <div class="pengajuan-card">

        <h2>Form Pengajuan Penitipan</h2>
        <p>Lengkapi data berikut untuk mengajukan penitipan kucing.</p>

        @if ($errors->any())
            <div style="color: #dc2626; margin-bottom: 20px;">
                Mohon periksa kembali data yang diisi.
            </div>
        @endif

        <form action="{{ route('penitipan.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="cat_id">Pilih Kucing</label>

                <select name="cat_id" id="cat_id" required>
                    <option value="">-- Pilih Kucing --</option>

                    @foreach ($kucings as $kucing)
                        <option value="{{ $kucing->id }}"
                            {{ old('cat_id') == $kucing->id ? 'selected' : '' }}>
                            {{ $kucing->name }}
                        </option>
                    @endforeach
                </select>

                @error('cat_id')
                    <div class="error-text">{{ $message }}</div>
                @enderror

                @if ($kucings->isEmpty())
                    <small>
                        Kamu belum memiliki data kucing.
                        <a href="{{ route('cats.create') }}">Tambah kucing dahulu</a>.
                    </small>
                @endif
            </div>

            <div class="form-group">
                <label for="layanan_id">Pilih Layanan</label>

                <select name="layanan_id" id="layanan_id" required>
                    <option value="">-- Pilih Layanan --</option>

                    @foreach ($layanans as $layanan)
                        <option
                            value="{{ $layanan->id }}"
                            data-harga="{{ $layanan->harga }}"
                            {{ old('layanan_id') == $layanan->id ? 'selected' : '' }}
                        >
                            {{ $layanan->nama_layanan }}
                            - Rp{{ number_format($layanan->harga, 0, ',', '.') }}/hari
                        </option>
                    @endforeach
                </select>

                @error('layanan_id')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="tanggal_mulai">Tanggal Mulai</label>
                    <input
                        type="date"
                        name="tanggal_mulai"
                        id="tanggal_mulai"
                        min="{{ date('Y-m-d') }}"
                        value="{{ old('tanggal_mulai') }}"
                        required
                    >

                    @error('tanggal_mulai')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tanggal_selesai">Tanggal Selesai</label>
                    <input
                        type="date"
                        name="tanggal_selesai"
                        id="tanggal_selesai"
                        value="{{ old('tanggal_selesai') }}"
                        required
                    >

                    @error('tanggal_selesai')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="catatan">Catatan Tambahan (Opsional)</label>
                <textarea
                    name="catatan"
                    id="catatan"
                    rows="4"
                    placeholder="Contoh: Kucing perlu diberi makan dua kali sehari."
                >{{ old('catatan') }}</textarea>

                @error('catatan')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="estimasi-box">
                <h3>Estimasi Biaya Penitipan</h3>

                <p id="durasiPenitipan" style="margin-bottom: 8px;">
                    Lama penitipan: -
                </p>

                <strong id="totalBiaya">Rp0</strong>

                <div style="font-size: 12px; color: #64748b; margin-top: 8px;">
                    Estimasi berdasarkan jumlah hari penitipan.
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('layanan.index') }}" class="btn-kembali">
                    Kembali
                </a>

                <button
                    type="submit"
                    class="btn-ajukan"
                    {{ $kucings->isEmpty() || $layanans->isEmpty() ? 'disabled' : '' }}
                >
                    Kirim Pengajuan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const layananSelect = document.getElementById('layanan_id');
    const tanggalMulai = document.getElementById('tanggal_mulai');
    const tanggalSelesai = document.getElementById('tanggal_selesai');
    const durasiPenitipan = document.getElementById('durasiPenitipan');
    const totalBiaya = document.getElementById('totalBiaya');

    function hitungEstimasi() {
        const pilihanLayanan = layananSelect.selectedOptions[0];
        const harga = Number(pilihanLayanan?.dataset.harga || 0);

        const mulai = tanggalMulai.value;
        const selesai = tanggalSelesai.value;

        if (!harga || !mulai || !selesai) {
            durasiPenitipan.textContent = 'Lama penitipan: -';
            totalBiaya.textContent = 'Rp0';
            return;
        }

        const tanggalAwal = new Date(mulai + 'T00:00:00');
        const tanggalAkhir = new Date(selesai + 'T00:00:00');

        const selisihHari = Math.round(
            (tanggalAkhir - tanggalAwal) / (1000 * 60 * 60 * 24)
        );

        if (selisihHari <= 0) {
            durasiPenitipan.textContent = 'Tanggal selesai harus setelah tanggal mulai.';
            totalBiaya.textContent = 'Rp0';
            return;
        }

        const jumlahHari = selisihHari + 1;
        const total = jumlahHari * harga;

        durasiPenitipan.textContent = 'Lama penitipan: ' + jumlahHari + ' hari';

        totalBiaya.textContent = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }).format(total);
    }

    layananSelect.addEventListener('change', hitungEstimasi);
    tanggalMulai.addEventListener('change', hitungEstimasi);
    tanggalSelesai.addEventListener('change', hitungEstimasi);

    hitungEstimasi();
</script>
@endsection