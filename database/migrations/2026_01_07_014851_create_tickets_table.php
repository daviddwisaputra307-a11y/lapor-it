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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id(); // PK
            $table->string('nomor_tiket')->unique(); // Agar tidak ada nomor kembar
            
            // FK ke User (Pelapor)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // FK ke Category
            $table->foreignId('category_id')->constrained('categories');
            
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('lokasi');
            
            // Prioritas (Kita pakai enum biar pilihan terbatas)
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi']);
            
            // Status (Sesuai catatan 6.3)
            $table->enum('status', ['open', 'in_progress', 'resolved', 'closed', 'reopen'])->default('open');
            
            // FK ke Teknisi (Bisa NULL karena awal lapor belum ada teknisi)
            // Kita arahkan ke tabel 'users' juga
            $table->foreignId('teknisi_id')->nullable()->constrained('users');
            
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
