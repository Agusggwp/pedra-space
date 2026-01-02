<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Get all produks with relations
     */
    public function index(Request $request)
    {
        $query = Produk::with(['category']);

        // Filter by category if requested
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by stock availability
        if ($request->has('in_stock')) {
            if ($request->in_stock == 1) {
                $query->where('stok', '>', 0);
            }
        }

        $produks = $query->get()->map(function($produk) {
            return [
                'id' => $produk->id,
                'nama' => $produk->nama,
                'kode' => $produk->kode,
                'harga_jual' => $produk->harga_jual,
                'stok' => $produk->stok,
                'deskripsi' => $produk->deskripsi ?? null,
                'foto' => $produk->foto,
                'category' => [
                    'nama' => $produk->category->nama ?? null
                ]
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Data produk berhasil diambil',
            'data' => $produks
        ], 200);
    }

    /**
     * Get single produk by ID
     */
    public function show($id)
    {
        $produk = Produk::with(['category'])->find($id);

        if (!$produk) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        $data = [
            'id' => $produk->id,
            'nama' => $produk->nama,
            'kode' => $produk->kode,
            'harga_jual' => $produk->harga_jual,
            'stok' => $produk->stok,
            'deskripsi' => $produk->deskripsi ?? null,
            'foto' => $produk->foto,
            'category' => [
                'nama' => $produk->category->nama ?? null
            ]
        ];

        return response()->json([
            'success' => true,
            'message' => 'Data produk berhasil diambil',
            'data' => $data
        ], 200);
    }
}
