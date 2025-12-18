<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuOption;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // LIST MENU
    public function index()
    {
        $menus = Menu::with('options', 'category')->orderBy('category_id')->latest('id')->get();
        return view('admin.menu.index', compact('menus'));
    }

    // SHOW CREATE FORM
    public function create()
    {
        $categories = Category::orderBy('nama')->get();
        return view('admin.menu.create', compact('categories'));
    }

    // STORE MENU
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga_base' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->except('foto', 'options');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('menu', 'public');
        }

        $menu = Menu::create($data);

        // Simpan options jika ada
        if ($request->has('options') && is_array($request->options)) {
            foreach ($request->options as $option) {
                if (!empty($option['tipe']) && !empty($option['nama_option'])) {
                    MenuOption::create([
                        'menu_id' => $menu->id,
                        'tipe' => $option['tipe'],
                        'nama_option' => $option['nama_option'],
                        'nilai' => $option['nilai'] ?? 0
                    ]);
                }
            }
        }

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    // SHOW MENU DETAIL
    public function show(Menu $menu)
    {
        return view('admin.menu.show', compact('menu'));
    }

    // SHOW EDIT FORM
    public function edit(Menu $menu)
    {
        $categories = Category::orderBy('nama')->get();
        return view('admin.menu.edit', compact('menu', 'categories'));
    }

    // UPDATE MENU
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga_base' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->except('foto', 'options');

        if ($request->hasFile('foto')) {
            if ($menu->foto) {
                \Storage::delete('public/' . $menu->foto);
            }
            $data['foto'] = $request->file('foto')->store('menu', 'public');
        }

        $menu->update($data);

        // Update options
        $menu->options()->delete();
        if ($request->has('options') && is_array($request->options)) {
            foreach ($request->options as $option) {
                if (!empty($option['tipe']) && !empty($option['nama_option'])) {
                    MenuOption::create([
                        'menu_id' => $menu->id,
                        'tipe' => $option['tipe'],
                        'nama_option' => $option['nama_option'],
                        'nilai' => $option['nilai'] ?? 0
                    ]);
                }
            }
        }

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diupdate!');
    }

    // DELETE MENU
    public function destroy(Menu $menu)
    {
        if ($menu->foto) {
            \Storage::delete('public/' . $menu->foto);
        }
        
        $menu->delete();
        return back()->with('success', 'Menu berhasil dihapus!');
    }

    // TOGGLE ACTIVE STATUS
    public function toggleStatus(Menu $menu)
    {
        $menu->update(['is_active' => !$menu->is_active]);
        $status = $menu->is_active ? 'Aktif' : 'Nonaktif';
        return back()->with('success', "Menu berhasil diubah menjadi {$status}!");
    }
}
