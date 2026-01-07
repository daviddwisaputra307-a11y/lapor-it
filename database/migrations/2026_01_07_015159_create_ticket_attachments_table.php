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
        Schema::create('ticket_attachments', function (Blueprint $table) {
            $table->id(); // PK
            
            // FK ke Ticket
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
            
            $table->string('file_path'); // Lokasi simpan file
            $table->string('file_type'); // Tipe file (jpg/pdf/dll)
            
            $table->timestamps(); // created_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_attachments');
    }
};
