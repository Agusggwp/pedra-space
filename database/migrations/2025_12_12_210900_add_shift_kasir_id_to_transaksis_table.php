<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->unsignedBigInteger('shift_kasir_id')->nullable()->after('user_id');

            // Jika ada tabel shift_kasirs gunakan FK
            if (Schema::hasTable('shift_kasirs')) {
                $table->foreign('shift_kasir_id')
                      ->references('id')->on('shift_kasirs')
                      ->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropForeign(['shift_kasir_id']);
            $table->dropColumn('shift_kasir_id');
        });
    }
};
