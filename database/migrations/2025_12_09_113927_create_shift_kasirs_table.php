<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 // database/migrations/xxxx_create_shift_kasirs_table.php
public function up(): void
{
    Schema::create('shift_kasirs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users');
        $table->decimal('saldo_awal', 15, 2);
        $table->decimal('saldo_akhir', 15, 2)->nullable();
        $table->decimal('selisih', 15, 2)->nullable();
        $table->timestamp('dibuka_pada')->useCurrent();
        $table->timestamp('ditutup_pada')->nullable();
        $table->enum('status', ['buka', 'tutup'])->default('buka');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_kasirs');
    }
};
