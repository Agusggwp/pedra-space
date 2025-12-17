<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Diskon;
use App\Models\Produk;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiskonController extends Controller
{
    /**
     * Display a listing of all diskons
     */
    public function index()
    {
        $diskonProduk = Diskon::query()->produk()->count();
        $diskonMenu = Diskon::query()->menu()->count();
        $diskonKategori = Diskon::query()->kategori()->count();
        $diskonUmum = Diskon::query()->umum()->count();

        return view('admin.diskon.index', compact('diskonProduk', 'diskonMenu', 'diskonKategori', 'diskonUmum'));
    }

    /**
     * Display diskon produk
     */
    public function produk(Request $request)
    {
        $query = Diskon::query()->produk()->with('produk');

        if ($request->search) {
            $query->whereHas('produk', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('kode', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status !== null && $request->status !== '') {
            $query->where('aktif', $request->status);
        }

        $diskons = $query->paginate(15);

        return view('admin.diskon.produk', compact('diskons'));
    }

    /**
     * Display diskon menu
     */
    public function menu(Request $request)
    {
        $query = Diskon::query()->menu()->with('menu');

        if ($request->search) {
            $query->whereHas('menu', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status !== null && $request->status !== '') {
            $query->where('aktif', $request->status);
        }

        $diskons = $query->paginate(15);

        return view('admin.diskon.menu', compact('diskons'));
    }

    /**
     * Display diskon kategori
     */
    public function kategori(Request $request)
    {
        $query = Diskon::query()->kategori()->with('category');

        if ($request->search) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status !== null && $request->status !== '') {
            $query->where('aktif', $request->status);
        }

        $diskons = $query->paginate(15);

        return view('admin.diskon.kategori', compact('diskons'));
    }

    /**
     * Display diskon umum
     */
    public function umum(Request $request)
    {
        $query = Diskon::query()->umum();

        if ($request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        if ($request->status !== null && $request->status !== '') {
            $query->where('aktif', $request->status);
        }

        $diskons = $query->paginate(15);

        return view('admin.diskon.umum', compact('diskons'));
    }

    /**
     * Show form for creating diskon produk
     */
    public function createProduk()
    {
        $produks = Produk::orderBy('nama')->get();
        return view('admin.diskon.create-produk', compact('produks'));
    }

    /**
     * Show form for creating diskon menu
     */
    public function createMenu()
    {
        $menus = Menu::orderBy('nama')->get();
        return view('admin.diskon.create-menu', compact('menus'));
    }

    /**
     * Show form for creating diskon kategori
     */
    public function createKategori()
    {
        $categories = Category::orderBy('nama')->get();
        return view('admin.diskon.create-kategori', compact('categories'));
    }

    /**
     * Show form for creating diskon umum
     */
    public function createUmum()
    {
        return view('admin.diskon.create-umum');
    }

    /**
     * Store diskon produk
     */
    public function storeProduk(Request $request)
    {
        $validated = $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'persentase' => 'nullable|numeric|min:0|max:100',
            'nominal' => 'nullable|integer|min:0',
            'deskripsi' => 'nullable|string|max:500',
            'aktif' => 'boolean',
            'berlaku_dari' => 'nullable|date',
            'berlaku_sampai' => 'nullable|date|after:berlaku_dari',
        ]);

        // Validasi: minimal salah satu dari persentase atau nominal harus diisi
        if (empty($validated['persentase']) && empty($validated['nominal'])) {
            return back()->withErrors(['error' => 'Minimal isi Persentase atau Nominal Diskon'])->withInput();
        }

        $validated['tipe'] = 'produk';
        $validated['aktif'] = $request->has('aktif');

        Diskon::create($validated);

        return redirect()->route('admin.diskon.produk')->with('success', 'Diskon produk berhasil dibuat');
    }

    /**
     * Store diskon menu
     */
    public function storeMenu(Request $request)
    {
        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'persentase' => 'nullable|numeric|min:0|max:100',
            'nominal' => 'nullable|integer|min:0',
            'deskripsi' => 'nullable|string|max:500',
            'aktif' => 'boolean',
            'berlaku_dari' => 'nullable|date',
            'berlaku_sampai' => 'nullable|date|after:berlaku_dari',
        ]);

        if (empty($validated['persentase']) && empty($validated['nominal'])) {
            return back()->withErrors(['error' => 'Minimal isi Persentase atau Nominal Diskon'])->withInput();
        }

        $validated['tipe'] = 'menu';
        $validated['aktif'] = $request->has('aktif');

        Diskon::create($validated);

        return redirect()->route('admin.diskon.menu')->with('success', 'Diskon menu berhasil dibuat');
    }

    /**
     * Store diskon kategori
     */
    public function storeKategori(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'persentase' => 'nullable|numeric|min:0|max:100',
            'nominal' => 'nullable|integer|min:0',
            'deskripsi' => 'nullable|string|max:500',
            'aktif' => 'boolean',
            'berlaku_dari' => 'nullable|date',
            'berlaku_sampai' => 'nullable|date|after:berlaku_dari',
        ]);

        if (empty($validated['persentase']) && empty($validated['nominal'])) {
            return back()->withErrors(['error' => 'Minimal isi Persentase atau Nominal Diskon'])->withInput();
        }

        $validated['tipe'] = 'kategori';
        $validated['aktif'] = $request->has('aktif');

        Diskon::create($validated);

        return redirect()->route('admin.diskon.kategori')->with('success', 'Diskon kategori berhasil dibuat');
    }

    /**
     * Store diskon umum
     */
    public function storeUmum(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'persentase' => 'nullable|numeric|min:0|max:100',
            'nominal' => 'nullable|integer|min:0',
            'deskripsi' => 'nullable|string|max:500',
            'aktif' => 'boolean',
            'berlaku_dari' => 'nullable|date',
            'berlaku_sampai' => 'nullable|date|after:berlaku_dari',
        ]);

        if (empty($validated['persentase']) && empty($validated['nominal'])) {
            return back()->withErrors(['error' => 'Minimal isi Persentase atau Nominal Diskon'])->withInput();
        }

        $validated['tipe'] = 'umum';
        $validated['aktif'] = $request->has('aktif');

        Diskon::create($validated);

        return redirect()->route('admin.diskon.umum')->with('success', 'Diskon umum berhasil dibuat');
    }

    /**
     * Show form for editing diskon produk
     */
    public function editProduk(Diskon $diskon)
    {
        if ($diskon->tipe !== 'produk') {
            abort(404);
        }

        $produks = Produk::orderBy('nama')->get();
        return view('admin.diskon.edit-produk', compact('diskon', 'produks'));
    }

    /**
     * Show form for editing diskon menu
     */
    public function editMenu(Diskon $diskon)
    {
        if ($diskon->tipe !== 'menu') {
            abort(404);
        }

        $menus = Menu::orderBy('nama')->get();
        return view('admin.diskon.edit-menu', compact('diskon', 'menus'));
    }

    /**
     * Show form for editing diskon kategori
     */
    public function editKategori(Diskon $diskon)
    {
        if ($diskon->tipe !== 'kategori') {
            abort(404);
        }

        $categories = Category::orderBy('nama')->get();
        return view('admin.diskon.edit-kategori', compact('diskon', 'categories'));
    }

    /**
     * Show form for editing diskon umum
     */
    public function editUmum(Diskon $diskon)
    {
        if ($diskon->tipe !== 'umum') {
            abort(404);
        }

        return view('admin.diskon.edit-umum', compact('diskon'));
    }

    /**
     * Update diskon produk
     */
    public function updateProduk(Request $request, Diskon $diskon)
    {
        if ($diskon->tipe !== 'produk') {
            abort(404);
        }

        $validated = $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'persentase' => 'nullable|numeric|min:0|max:100',
            'nominal' => 'nullable|integer|min:0',
            'deskripsi' => 'nullable|string|max:500',
            'aktif' => 'boolean',
            'berlaku_dari' => 'nullable|date',
            'berlaku_sampai' => 'nullable|date|after:berlaku_dari',
        ]);

        if (empty($validated['persentase']) && empty($validated['nominal'])) {
            return back()->withErrors(['error' => 'Minimal isi Persentase atau Nominal Diskon'])->withInput();
        }

        $validated['aktif'] = $request->has('aktif');

        $diskon->update($validated);

        return redirect()->route('admin.diskon.produk')->with('success', 'Diskon produk berhasil diperbarui');
    }

    /**
     * Update diskon menu
     */
    public function updateMenu(Request $request, Diskon $diskon)
    {
        if ($diskon->tipe !== 'menu') {
            abort(404);
        }

        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'persentase' => 'nullable|numeric|min:0|max:100',
            'nominal' => 'nullable|integer|min:0',
            'deskripsi' => 'nullable|string|max:500',
            'aktif' => 'boolean',
            'berlaku_dari' => 'nullable|date',
            'berlaku_sampai' => 'nullable|date|after:berlaku_dari',
        ]);

        if (empty($validated['persentase']) && empty($validated['nominal'])) {
            return back()->withErrors(['error' => 'Minimal isi Persentase atau Nominal Diskon'])->withInput();
        }

        $validated['aktif'] = $request->has('aktif');

        $diskon->update($validated);

        return redirect()->route('admin.diskon.menu')->with('success', 'Diskon menu berhasil diperbarui');
    }

    /**
     * Update diskon kategori
     */
    public function updateKategori(Request $request, Diskon $diskon)
    {
        if ($diskon->tipe !== 'kategori') {
            abort(404);
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'persentase' => 'nullable|numeric|min:0|max:100',
            'nominal' => 'nullable|integer|min:0',
            'deskripsi' => 'nullable|string|max:500',
            'aktif' => 'boolean',
            'berlaku_dari' => 'nullable|date',
            'berlaku_sampai' => 'nullable|date|after:berlaku_dari',
        ]);

        if (empty($validated['persentase']) && empty($validated['nominal'])) {
            return back()->withErrors(['error' => 'Minimal isi Persentase atau Nominal Diskon'])->withInput();
        }

        $validated['aktif'] = $request->has('aktif');

        $diskon->update($validated);

        return redirect()->route('admin.diskon.kategori')->with('success', 'Diskon kategori berhasil diperbarui');
    }

    /**
     * Update diskon umum
     */
    public function updateUmum(Request $request, Diskon $diskon)
    {
        if ($diskon->tipe !== 'umum') {
            abort(404);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'persentase' => 'nullable|numeric|min:0|max:100',
            'nominal' => 'nullable|integer|min:0',
            'deskripsi' => 'nullable|string|max:500',
            'aktif' => 'boolean',
            'berlaku_dari' => 'nullable|date',
            'berlaku_sampai' => 'nullable|date|after:berlaku_dari',
        ]);

        if (empty($validated['persentase']) && empty($validated['nominal'])) {
            return back()->withErrors(['error' => 'Minimal isi Persentase atau Nominal Diskon'])->withInput();
        }

        $validated['aktif'] = $request->has('aktif');

        $diskon->update($validated);

        return redirect()->route('admin.diskon.umum')->with('success', 'Diskon umum berhasil diperbarui');
    }

    /**
     * Delete diskon
     */
    public function destroy(Diskon $diskon)
    {
        $tipe = $diskon->tipe;
        $diskon->delete();

        return back()->with('success', 'Diskon berhasil dihapus');
    }

    /**
     * Toggle aktif/nonaktif diskon
     */
    public function toggle(Diskon $diskon)
    {
        $diskon->update(['aktif' => !$diskon->aktif]);

        $status = $diskon->aktif ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', 'Diskon berhasil ' . $status);
    }
}
