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
        Schema::create('diskons', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe', ['produk', 'menu', 'kategori', 'umum']); // Tipe diskon
            $table->foreignId('produk_id')->nullable()->constrained('produks')->onDelete('cascade');
            $table->foreignId('menu_id')->nullable()->constrained('menus')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('cascade');
            $table->decimal('persentase', 8, 2)->nullable(); // Diskon dalam persen
            $table->integer('nominal')->nullable(); // Diskon dalam nominal (Rp)
            $table->string('nama')->nullable(); // Nama diskon (khusus untuk diskon umum)
            $table->text('deskripsi')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamp('berlaku_dari')->nullable();
            $table->timestamp('berlaku_sampai')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Index untuk performa query
            $table->index('tipe');
            $table->index('produk_id');
            $table->index('menu_id');
            $table->index('category_id');
            $table->index('aktif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diskons');
    }
};
