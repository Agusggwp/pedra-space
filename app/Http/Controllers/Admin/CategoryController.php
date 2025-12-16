<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // TAMPILKAN DAFTAR KATEGORI
    public function index()
    {
        $categories = Category::orderBy('nama')->paginate(10);
        return view('admin.kategori.index', compact('categories'));
    }

    // TAMPILKAN FORM TAMBAH
    public function create()
    {
        return view('admin.kategori.create');
    }

    // SIMPAN KATEGORI BARU
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:categories,nama'
        ]);

        Category::create([
            'nama' => $request->nama
        ]);

        return redirect()->route('admin.category.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    // TAMPILKAN FORM EDIT
    public function edit(Category $category)
    {
        return view('admin.kategori.edit', compact('category'));
    }

    // UPDATE KATEGORI
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:categories,nama,' . $category->id
        ]);

        $category->update([
            'nama' => $request->nama
        ]);

        return redirect()->route('admin.category.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    // HAPUS KATEGORI
    public function destroy(Category $category)
    {
        // Cek jika kategori masih memiliki produk
        if ($category->produks()->count() > 0) {
            return redirect()->route('admin.category.index')
                ->with('error', 'Tidak bisa menghapus kategori yang masih memiliki produk!');
        }

        $category->delete();

        return redirect()->route('admin.category.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }

    public function show(Category $category)
    {
        // Eager load produks untuk efisiensi
        $category->load('produks');
        
        return view('admin.kategori.show', compact('category'));
    }
}
