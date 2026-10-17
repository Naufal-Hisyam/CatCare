
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penitipan', function (Blueprint $table) {
            $table->decimal('jumlah_pembayaran', 12, 2)->default(0);
            $table->string('metode_pembayaran')->default('cash');
            $table->string('status_pembayaran')->default('menunggu');
        });
    }

    public function down(): void
    {
        Schema::table('penitipan', function (Blueprint $table) {
            $table->dropColumn([
                'jumlah_pembayaran',
                'metode_pembayaran',
                'status_pembayaran',
            ]);
        });
    }
};
