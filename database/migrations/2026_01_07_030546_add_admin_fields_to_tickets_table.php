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
    Schema::table('tickets', function (Blueprint $table) {
        $table->string('teknisi')->nullable()->after('prioritas');
        $table->string('status')->default('Open')->change(); // kalau status udah ada
    });
}

public function down(): void
{
    Schema::table('tickets', function (Blueprint $table) {
        $table->dropColumn('teknisi');
    });
}

};
