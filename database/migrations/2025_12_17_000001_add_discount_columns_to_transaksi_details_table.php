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
        Schema::table('transaksi_details', function (Blueprint $table) {
            $table->decimal('harga_awal', 12, 2)->nullable()->after('harga_satuan')->comment('Harga sebelum diskon');
            $table->decimal('diskon_nominal', 12, 2)->default(0)->after('harga_awal')->comment('Nominal diskon per item');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi_details', function (Blueprint $table) {
            $table->dropColumn(['harga_awal', 'diskon_nominal']);
        });
    }
};
