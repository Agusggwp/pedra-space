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
        Schema::table('transaksis', function (Blueprint $table) {
            $table->string('nama_pelanggan')->nullable()->after('kembalian');
            $table->string('nomor_meja')->nullable()->after('nama_pelanggan');
    });
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['nama_pelanggan', 'nomor_meja']);
        });
    }
};
