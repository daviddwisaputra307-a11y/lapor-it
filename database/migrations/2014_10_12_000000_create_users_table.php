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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // PK
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            
            // Tambahan sesuai catatan 6.1
            $table->enum('role', ['user', 'admin', 'teknisi'])->default('user');
            $table->string('unit_kerja')->nullable(); // Boleh kosong
            
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps(); // created_at, updated_at
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
