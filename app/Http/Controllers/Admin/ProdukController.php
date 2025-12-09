<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            'kode' => 'required|unique:produks,kode',
            'nama' => 'required',
            'category_id' => 'required|exists:categories,id',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|integer',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();
        $data['kode'] = strtoupper($request->kode);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama_file = time() . '_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/produk'), $nama_file);
            $data['foto'] = 'uploads/produk/' . $nama_file;
        }

        Produk::create($data);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Produk $produk)
    {
        $categories = Category::orderBy('nama')->get();
        return view('admin.produk.edit', compact('produk', 'categories'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'kode' => 'required|unique:produks,kode,'.$produk->id,
            'nama' => 'required',
            'category_id' => 'required|exists:categories,id',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|integer',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();
        $data['kode'] = strtoupper($request->kode);

        if ($request->hasFile('foto')) {
            if ($produk->foto && file_exists(public_path($produk->foto))) {
                unlink(public_path($produk->foto));
            }
            $file = $request->file('foto');
            $nama_file = time() . '_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/produk'), $nama_file);
            $data['foto'] = 'uploads/produk/' . $nama_file;
        }

        $produk->update($data);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy(Produk $produk)
    {
        if ($produk->foto && file_exists(public_path($produk->foto))) {
            unlink(public_path($produk->foto));
        }
        $produk->delete();
        return back()->with('success', 'Produk dihapus!');
    }
}