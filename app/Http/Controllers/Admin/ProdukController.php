<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::with('category')->orderBy('nama')->get();
        return view('admin.produk.index', compact('produks'));
    }

    public function create()
    {
        $categories = Category::orderBy('nama')->get();
        return view('admin.produk.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode'        => 'required|unique:produks,kode',
            'nama'        => 'required',
            'category_id' => 'required|exists:categories,id',
            'harga_beli'  => 'required|numeric',
            'harga_jual'  => 'required|numeric',
            'stok'        => 'required|integer',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->all();
        $data['kode'] = strtoupper($request->kode);

        // Upload foto ke storage
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();

            // Simpan ke storage/app/public/produk
            $path = $file->storeAs('produk', $filename, 'public');

            // Simpan hanya path relatif (tanpa public/)
            $data['foto'] = 'produk/' . $filename;        // atau langsung $path
        }

        Produk::create($data);

        return redirect()
            ->route('admin.produk.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Produk $produk)
    {
        $categories = Category::orderBy('nama')->get();
        return view('admin.produk.edit', compact('produk', 'categories'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'kode'        => 'required|unique:produks,kode,' . $produk->id,
            'nama'        => 'required',
            'category_id' => 'required|exists:categories,id',
            'harga_beli'  => 'required|numeric',
            'harga_jual'  => 'required|numeric',
            'stok'        => 'required|integer',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->all();
        $data['kode'] = strtoupper($request->kode);

        // Hapus foto lama & upload yang baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
                Storage::disk('public')->delete($produk->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('produk', $filename, 'public');
            $data['foto'] = 'produk/' . $filename;
        }

        $produk->update($data);

        return redirect()
            ->route('admin.produk.index')
            ->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy(Produk $produk)
    {
        // Hapus foto dari storage
        if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
            Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();

        return back()->with('success', 'Produk berhasil dihapus!');
    }
}