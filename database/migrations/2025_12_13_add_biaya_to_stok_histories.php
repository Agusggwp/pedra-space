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
        Schema::table('stok_histories', function (Blueprint $table) {
            $table->decimal('biaya', 15, 2)->nullable()->after('jumlah')->comment('Nilai uang yang dikeluarkan untuk restok');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stok_histories', function (Blueprint $table) {
            $table->dropColumn('biaya');
        });
    }
};
