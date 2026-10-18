<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penitipan', function (Blueprint $table) {
            $table->foreignId('cat_id')
                ->nullable()
                ->constrained('cats')
                ->nullOnDelete();

            $table->foreignId('layanan_id')
                ->nullable()
                ->constrained('layanan')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('penitipan', function (Blueprint $table) {
            $table->dropConstrainedForeignId('cat_id');
            $table->dropConstrainedForeignId('layanan_id');
        });
    }
};