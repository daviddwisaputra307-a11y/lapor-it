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
        Schema::create('ticket_logs', function (Blueprint $table) {
            $table->id(); // PK
            
            // FK ke Ticket (Kalau tiket dihapus, log ikut hapus)
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
            
            // FK ke User (Siapa yang melakukan update/aktivitas)
            $table->foreignId('user_id')->constrained('users');
            
            $table->text('keterangan'); // Apa yang dilakukan
            $table->string('status')->nullable(); // Status saat log ini dibuat
            
            $table->timestamps(); // created_at (updated_at juga ikut, tapi gak masalah)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_logs');
    }
};
