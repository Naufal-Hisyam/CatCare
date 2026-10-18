<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('cats', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke tabel users
        $table->string('name');                                           // Nama kucing
        $table->string('breed')->nullable();                             // Ras/Jenis kucing
        $table->integer('age')->nullable();                              // Umur kucing (tahun/bulan)
        $table->enum('gender', ['jantan', 'betina']);                    // Jenis kelamin
        $table->text('description')->nullable();                         // Deskripsi/catatan tambahan
        $table->string('image')->nullable();                             // Foto kucing
        $table->timestamps();                                            // created_at & updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cats');
    }
};
