<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Menus
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga_base', 10, 2);
            $table->string('kategori')->default('beverage'); // beverage, food, dll
            $table->string('foto')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tabel Menu Options (customization seperti less sugar, pilihan susu, etc)
        Schema::create('menu_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
            $table->string('tipe'); // 'sugar_level', 'milk_type', 'temperature', etc
            $table->string('nama_option'); // 'Less Sugar', 'Almond Milk', 'Ice', etc
            $table->decimal('nilai', 10, 2)->default(0); // tambah harga jika ada
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_options');
        Schema::dropIfExists('menus');
    }
};
