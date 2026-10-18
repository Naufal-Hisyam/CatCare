<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Penitipan extends Model
{
    protected $table = 'penitipan';

    /* Status penitipan */
    public const MENUNGGU = 'menunggu';
    public const DISETUJUI = 'disetujui';
    public const DITOLAK = 'ditolak';
    public const AKTIF = 'aktif';
    public const SELESAI = 'selesai';

    /* Status pembayaran */
    public const BELUM_DIBAYAR = 'menunggu';
    public const SUDAH_DIBAYAR = 'sudah_dibayar';

    public const STATUS_BERJALAN = [self::MENUNGGU, self::DISETUJUI, self::AKTIF];
    public const STATUS_RIWAYAT = [self::SELESAI, self::DITOLAK];

    public const LABEL_STATUS = [
        self::MENUNGGU => 'Menunggu Persetujuan',
        self::DISETUJUI => 'Disetujui',
        self::DITOLAK => 'Ditolak',
        self::AKTIF => 'Sedang Dititipkan',
        self::SELESAI => 'Selesai',
    ];

    public const BADGE_STATUS = [
        self::MENUNGGU => 'badge-warning',
        self::DISETUJUI => 'badge-info',
        self::DITOLAK => 'badge-danger',
        self::AKTIF => 'badge-primary',
        self::SELESAI => 'badge-success',
    ];

    protected $fillable = [
        'user_id',
        'cat_id',
        'layanan_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'tanggal_masuk_aktual' => 'date',
            'tanggal_keluar_aktual' => 'date',
            'tanggal_pembayaran' => 'datetime',
            'total_biaya' => 'float',
            'jumlah_pembayaran' => 'float',
        ];
    }

    /* ------------------------------ Relasi ------------------------------ */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cat()
    {
        return $this->belongsTo(Cat::class, 'cat_id');
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }

    /* ------------------------ Perhitungan biaya ------------------------- */

    /** Jumlah hari, minimal 1 (masuk & keluar di hari yang sama = 1 hari). */
    public static function hitungHari($masuk, $keluar): int
    {
        $selisih = Carbon::parse($masuk)->startOfDay()
            ->diffInDays(Carbon::parse($keluar)->startOfDay());

        return max(1, (int) $selisih);
    }

    public function getHargaPerHariAttribute(): float
    {
        return (float) ($this->layanan->harga ?? 0);
    }

    public function getLamaRencanaAttribute(): int
    {
        return self::hitungHari($this->tanggal_mulai, $this->tanggal_selesai);
    }

    public function getLamaAktualAttribute(): ?int
    {
        if (! $this->tanggal_masuk_aktual || ! $this->tanggal_keluar_aktual) {
            return null;
        }

        return self::hitungHari($this->tanggal_masuk_aktual, $this->tanggal_keluar_aktual);
    }

    /** Perkiraan biaya = harga layanan x lama penitipan yang direncanakan. */
    public function getEstimasiBiayaAttribute(): float
    {
        return $this->harga_per_hari * $this->lama_rencana;
    }

    /** Total final bila sudah dihitung, jika belum pakai perkiraan. */
    public function getBiayaTampilAttribute(): float
    {
        return $this->total_biaya ?? $this->estimasi_biaya;
    }

    /* ------------------------------ Label ------------------------------- */

    public function getStatusLabelAttribute(): string
    {
        return self::LABEL_STATUS[$this->status] ?? ucfirst((string) $this->status);
    }

    public function getStatusBadgeAttribute(): string
    {
        return self::BADGE_STATUS[$this->status] ?? 'badge-muted';
    }

    public function getSudahDibayarAttribute(): bool
    {
        return $this->status_pembayaran === self::SUDAH_DIBAYAR;
    }

    public function getPembayaranLabelAttribute(): string
    {
        return $this->sudah_dibayar ? 'Sudah Dibayar' : 'Belum Dibayar';
    }

    public function getPembayaranBadgeAttribute(): string
    {
        return $this->sudah_dibayar ? 'badge-success' : 'badge-warning';
    }

    /** Nama kucing; aman bila data kucing sudah dihapus. */
    public function getNamaKucingAttribute(): string
    {
        return $this->cat->name ?? '(kucing dihapus)';
    }

    public function getNamaLayananAttribute(): string
    {
        return $this->layanan->nama_layanan ?? '(layanan dihapus)';
    }

    /* ------------------- Aturan transisi status (admin) ------------------ */

    public function bisaDiputuskan(): bool
    {
        return $this->status === self::MENUNGGU;
    }

    public function bisaMasuk(): bool
    {
        return $this->status === self::DISETUJUI;
    }

    public function bisaKeluar(): bool
    {
        return $this->status === self::AKTIF && ! $this->tanggal_keluar_aktual;
    }

    public function bisaBayar(): bool
    {
        return $this->status === self::AKTIF
            && $this->tanggal_keluar_aktual
            && ! $this->sudah_dibayar;
    }

    public function bisaSelesai(): bool
    {
        return $this->status === self::AKTIF
            && $this->tanggal_keluar_aktual
            && $this->sudah_dibayar;
    }
}
