<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi_details', function (Blueprint $table) {
            // Ubah produk_id menjadi nullable
            $table->foreignId('produk_id')
                ->nullable()
                ->change();
            
            // Tambah menu_id
            $table->foreignId('menu_id')
                ->nullable()
                ->constrained('menus')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('transaksi_details', function (Blueprint $table) {
            $table->dropForeignKeyIfExists(['menu_id']);
            $table->dropColumn('menu_id');
            
            // Kembalikan produk_id menjadi required
            $table->foreignId('produk_id')
                ->nullable(false)
                ->change();
        });
    }
};
