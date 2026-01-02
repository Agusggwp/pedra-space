<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Get all menus with relations
     */
    public function index(Request $request)
    {
        $query = Menu::with(['category', 'options']);

        // Filter by active status if requested
        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        // Filter by category if requested
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $menus = $query->get()->map(function($menu) {
            return [
                'id' => $menu->id,
                'nama' => $menu->nama,
                'harga_base' => $menu->harga_base,
                'deskripsi' => $menu->deskripsi,
                'foto' => $menu->foto,
                'is_active' => $menu->is_active,
                'category' => [
                    'nama' => $menu->category->nama ?? null
                ],
                'options' => $menu->options
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Data menu berhasil diambil',
            'data' => $menus
        ], 200);
    }

    /**
     * Get single menu by ID
     */
    public function show($id)
    {
        $menu = Menu::with(['category', 'options'])->find($id);

        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => 'Menu tidak ditemukan'
            ], 404);
        }

        $data = [
            'id' => $menu->id,
            'nama' => $menu->nama,
            'harga_base' => $menu->harga_base,
            'deskripsi' => $menu->deskripsi,
            'foto' => $menu->foto,
            'is_active' => $menu->is_active,
            'category' => [
                'nama' => $menu->category->nama ?? null
            ],
            'options' => $menu->options
        ];

        return response()->json([
            'success' => true,
            'message' => 'Data menu berhasil diambil',
            'data' => $data
        ], 200);
    }
}
