<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stok_histories', function (Blueprint $table) {
            $table->foreignId('produk_id')->after('id')->constrained('produks')->cascadeOnDelete();
            $table->enum('tipe', ['masuk', 'keluar'])->after('produk_id');
            $table->integer('jumlah')->after('tipe');
            $table->text('keterangan')->nullable()->after('jumlah');
            $table->foreignId('user_id')->after('keterangan')->constrained('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('stok_histories', function (Blueprint $table) {
            $table->dropForeign(['produk_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['produk_id', 'tipe', 'jumlah', 'keterangan', 'user_id']);
        });
    }
};