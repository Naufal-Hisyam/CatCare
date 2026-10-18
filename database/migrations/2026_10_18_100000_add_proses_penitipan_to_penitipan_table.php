<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kolom untuk proses penitipan, pembayaran, dan riwayat (Anggota 4).
     *
     * Kolom yang sudah ada dan dipakai:
     *  - tanggal_mulai / tanggal_selesai = RENCANA tanggal masuk / keluar
     *  - status            = menunggu | disetujui | ditolak | aktif | selesai
     *  - jumlah_pembayaran, metode_pembayaran, status_pembayaran
     *    (status_pembayaran: menunggu | sudah_dibayar)
     */
    public function up(): void
    {
        Schema::table('penitipan', function (Blueprint $table) {
            $table->date('tanggal_masuk_aktual')->nullable();
            $table->date('tanggal_keluar_aktual')->nullable();
            $table->decimal('total_biaya', 12, 2)->nullable();
            $table->text('alasan_penolakan')->nullable();
            $table->timestamp('tanggal_pembayaran')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('penitipan', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal_masuk_aktual',
                'tanggal_keluar_aktual',
                'total_biaya',
                'alasan_penolakan',
                'tanggal_pembayaran',
            ]);
        });
    }
};
