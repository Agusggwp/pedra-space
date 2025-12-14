<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            // Cek apakah kolom category_id sudah ada
            if (!Schema::hasColumn('menus', 'category_id')) {
                // Tambah kolom category_id nullable dulu
                $table->foreignId('category_id')->nullable()->after('harga_base')->constrained('categories')->onDelete('cascade');
            }
        });
        
        // Update existing menus yang tidak punya category_id
        // Ambil category_id pertama dari tabel categories sebagai default
        $defaultCategoryId = DB::table('categories')->first()?->id ?? 1;
        DB::table('menus')->whereNull('category_id')->update(['category_id' => $defaultCategoryId]);
        
        // Hapus kolom kategori lama jika ada
        Schema::table('menus', function (Blueprint $table) {
            if (Schema::hasColumn('menus', 'kategori')) {
                $table->dropColumn('kategori');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            // Tambah kolom kategori kembali
            $table->string('kategori')->default('beverage');
            
            // Hapus foreign key dan kolom category_id
            $table->dropForeignIdFor(\App\Models\Category::class);
            if (Schema::hasColumn('menus', 'category_id')) {
                $table->dropColumn('category_id');
            }
        });
    }
};
