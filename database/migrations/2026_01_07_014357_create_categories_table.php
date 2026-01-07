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
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // PK
            $table->string('nama_kategori');
            $table->text('deskripsi')->nullable(); // Deskripsi boleh kosong
            $table->timestamps(); // created_at
            // updated_at otomatis ada kalau pakai timestamps()
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
