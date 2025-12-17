<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kasir POS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-gray-50">

<div class="flex min-h-screen">

    @include('components.topbar')
    <!-- KONTEN UTAMA -->
        <div class="flex-1 flex flex-col min-w-0 min-h-screen overflow-hidden pt-16">
            @include('kasir.partials.sidebar')

                <div class="lg:ml-72 p-6 md:p-8">
                    <div class="max-w-[1600px] mx-auto">

                        <!-- HEADER -->
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-800 mb-1">Point of Sale</h1>
                                <p class="text-gray-600">Kasir: <span class="font-semibold">{{ auth()->user()->name }}</span></p>
                            </div>

                            <div class="flex gap-2">
                                <button onclick="toggleFullscreen(event)" 
                                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-white text-gray-700 rounded-lg shadow-sm hover:shadow-md hover:bg-gray-50 transition font-semibold border border-gray-200">
                                    <i class="ph ph-arrows-out text-lg" id="fullscreenIcon"></i>
                                    <span class="hidden sm:inline">Fullscreen</span>
                                </button>
                                <a href="{{ route('kasir.daftar') }}" 
                                class="inline-flex items-center gap-2 px-4 py-2.5 bg-white text-gray-700 rounded-lg shadow-sm hover:shadow-md hover:bg-gray-50 transition font-semibold border border-gray-200">
                                    <i class="ph ph-receipt text-lg"></i>
                                    <span class="hidden sm:inline">Daftar Penjualan</span>
                                </a>
                                <a href="{{ route('kasir.tutup.form') }}" 
                                class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-600 text-white rounded-lg shadow-sm hover:shadow-md hover:bg-red-700 transition font-semibold">
                                    <i class="ph ph-lock text-lg"></i>
                                    <span class="hidden sm:inline">Tutup Kasir</span>
                                </a>
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-3 gap-6">

                            <!-- DAFTAR PRODUK & MENU -->
                            <div class="lg:col-span-2">
                                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                                    
                                    <!-- TABS -->
                                    <div class="border-b border-gray-200">
                                        <nav class="flex" id="tabs">
                                            <button onclick="switchTab('produk')" 
                                                    id="tab-produk"
                                                    class="tab-button active px-6 py-4 font-semibold border-b-2 transition">
                                                <i class="ph ph-package mr-2"></i>Produk
                                            </button>
                                            <button onclick="switchTab('menu')" 
                                                    id="tab-menu"
                                                    class="tab-button px-6 py-4 font-semibold border-b-2 transition">
                                                <i class="ph ph-coffee mr-2"></i>Menu
                                            </button>
                                        </nav>
                                    </div>

                                    <!-- TAB CONTENT -->
                                    <div class="p-6" style="max-height: 75vh; overflow-y: auto;">
                                        
                                        <!-- TAB PRODUK -->
                                        <div id="content-produk" class="tab-content">
                                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                                                @forelse($produks as $p)
                                                <form action="{{ route('kasir.tambah') }}" method="POST" class="form-tambah-produk">
                                                    @csrf
                                                    <input type="hidden" name="produk_id" value="{{ $p->id }}">
                                                    <input type="hidden" class="stok-produk" value="{{ $p->stok }}">
                                                    <input type="hidden" class="nama-produk" value="{{ $p->nama }}">

                                                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-md hover:border-gray-300 transition group cursor-pointer">
                                                        
                                                        <!-- FOTO PRODUK -->
                                                        <div class="relative">
                                                            @if($p->foto)
                                                                <img src="{{ Storage::url($p->foto) }}"
                                                                    alt="{{ $p->nama }}"
                                                                    class="w-full h-32 object-cover"
                                                                    onerror="this.src='https://via.placeholder.com/300x200/E5E7EB/9CA3AF?text=No+Image'">
                                                            @else
                                                                <div class="w-full h-32 bg-gray-100 flex items-center justify-center">
                                                                    <i class="ph ph-image text-4xl text-gray-300"></i>
                                                                </div>
                                                            @endif
                                                            
                                                            <!-- BADGE STOK -->
                                                            <span class="absolute top-2 right-2 px-2 py-1 bg-green-600 text-white text-xs font-semibold rounded-full">
                                                                Stok: {{ $p->stok }}
                                                            </span>
                                                        </div>

                                                        <!-- INFO PRODUK -->
                                                        <div class="p-3">
                                                            <h3 class="font-semibold text-sm text-gray-800 mb-1 truncate">{{ $p->nama }}</h3>
                                                            
                                                            @php
                                                                $hargaAwal = $p->harga_jual;
                                                                $hargaFinal = $hargaAwal;
                                                                $hasDiskon = false;
                                                                
                                                                $diskonProduk = $p->diskon->first();
                                                                if ($diskonProduk) {
                                                                    $hargaFinal = $diskonProduk->hargaSetelahDiskon($hargaAwal);
                                                                    $hasDiskon = true;
                                                                }
                                                            @endphp
                                                            
                                                            <div class="mb-2">
                                                                @if($hasDiskon)
                                                                    <p class="text-xs text-gray-500 line-through">Rp {{ number_format($hargaAwal) }}</p>
                                                                    <p class="text-lg font-bold text-red-600">Rp {{ number_format($hargaFinal) }}</p>
                                                                @else
                                                                    <p class="text-lg font-bold text-gray-800">Rp {{ number_format($hargaAwal) }}</p>
                                                                @endif
                                                            </div>
                                                            
                                                            <button type="submit" class="w-full px-3 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition text-sm font-semibold">
                                                                <i class="ph ph-shopping-cart-simple mr-1"></i>Tambah
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                                @empty
                                                <div class="col-span-full text-center py-12">
                                                    <i class="ph ph-package text-6xl text-gray-300 mb-3"></i>
                                                    <p class="text-gray-500">Tidak ada produk tersedia</p>
                                                </div>
                                                @endforelse
                                            </div>
                                        </div>

                                        <!-- TAB MENU -->
                                        <div id="content-menu" class="tab-content hidden">
                                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                                                @forelse($menus as $menu)
                                                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-md hover:border-gray-300 transition cursor-pointer"
                                                    onclick="openMenuModal('{{ $menu->id }}')">
                                                    
                                                    <!-- FOTO MENU -->
                                                    <div class="relative">
                                                        @if($menu->foto)
                                                            <img src="{{ Storage::url($menu->foto) }}"
                                                                alt="{{ $menu->nama }}"
                                                                class="w-full h-32 object-cover"
                                                                onerror="this.src='https://via.placeholder.com/300x200/E5E7EB/9CA3AF?text=No+Image'">
                                                        @else
                                                            <div class="w-full h-32 bg-gray-100 flex items-center justify-center">
                                                                <i class="ph ph-image text-4xl text-gray-300"></i>
                                                            </div>
                                                        @endif
                                                        
                                                        <!-- BADGE KATEGORI -->
                                                        <span class="absolute top-2 right-2 px-2 py-1 bg-blue-600 text-white text-xs font-semibold rounded-full">
                                                            {{ $menu->kategori }}
                                                        </span>
                                                    </div>

                                                    <!-- INFO MENU -->
                                                    <div class="p-3">
                                                        <h3 class="font-semibold text-sm text-gray-800 mb-1 truncate">{{ $menu->nama }}</h3>
                                                        
                                                        @php
                                                            $hargaMenuAwal = $menu->harga_base;
                                                            $hargaMenuFinal = $hargaMenuAwal;
                                                            $hasMenuDiskon = false;
                                                            
                                                            $diskonMenu = $menu->diskon->first();
                                                            if ($diskonMenu) {
                                                                $hargaMenuFinal = $diskonMenu->hargaSetelahDiskon($hargaMenuAwal);
                                                                $hasMenuDiskon = true;
                                                            }
                                                        @endphp
                                                        
                                                        <div class="mb-1">
                                                            @if($hasMenuDiskon)
                                                                <p class="text-xs text-gray-500 line-through">Rp {{ number_format($hargaMenuAwal) }}</p>
                                                                <p class="text-lg font-bold text-red-600">Rp {{ number_format($hargaMenuFinal) }}</p>
                                                            @else
                                                                <p class="text-lg font-bold text-gray-800">Rp {{ number_format($hargaMenuAwal) }}</p>
                                                            @endif
                                                        </div>

                                                        @if($menu->options->count() > 0)
                                                            <p class="text-xs text-gray-500 mb-2">
                                                                <i class="ph ph-gear-six"></i> {{ $menu->options->count() }} Pilihan
                                                            </p>
                                                        @endif
                                                        
                                                        <button type="button" class="w-full px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-semibold">
                                                            <i class="ph ph-shopping-cart-simple mr-1"></i>Pilih
                                                        </button>
                                                    </div>
                                                </div>

                                                <!-- MODAL MENU -->
                                                <div id="menuModal{{ $menu->id }}" class="modal-menu hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                                                    <div class="bg-white rounded-lg max-w-md w-full max-h-[90vh] overflow-y-auto">
                                                        <div class="sticky top-0 bg-white border-b border-gray-200 p-4 flex justify-between items-center">
                                                            <h3 class="text-xl font-bold text-gray-800">{{ $menu->nama }}</h3>
                                                            <button onclick="closeMenuModal('{{ $menu->id }}')" class="text-gray-400 hover:text-gray-600">
                                                                <i class="ph ph-x text-2xl"></i>
                                                            </button>
                                                        </div>

                                                        <form action="{{ route('kasir.tambah.menu') }}" method="POST" class="p-4">
                                                            @csrf
                                                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">

                                                            @if($menu->deskripsi)
                                                                <p class="text-gray-600 mb-4">{{ $menu->deskripsi }}</p>
                                                            @endif

                                                            <div class="mb-4">
                                                                <strong class="text-gray-800">Harga Dasar: Rp {{ number_format($menu->harga_base) }}</strong>
                                                            </div>

                                                            <!-- OPTIONS -->
                                                            @if($menu->options->count() > 0)
                                                                <h4 class="font-semibold text-gray-800 mb-3">Pilihan Khusus:</h4>
                                                                @php
                                                                    $groupedOptions = $menu->options->groupBy('tipe');
                                                                    $tipeLabel = [
                                                                        'sugar_level' => 'Tingkat Gula',
                                                                        'milk_type' => 'Jenis Susu',
                                                                        'temperature' => 'Suhu Minuman',
                                                                        'size' => 'Ukuran',
                                                                        'extra' => 'Tambahan'
                                                                    ];
                                                                @endphp
                                                                @foreach($groupedOptions as $tipe => $opts)
                                                                    <div class="mb-3">
                                                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                                            {{ $tipeLabel[$tipe] ?? $tipe }}
                                                                        </label>
                                                                        <select name="options[{{ $tipe }}]" class="menu-option-select w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400">
                                                                            <option value="">-- Tidak Pilih --</option>
                                                                            @foreach($opts as $opt)
                                                                                <option value="{{ $opt->id }}" data-harga="{{ $opt->nilai }}">
                                                                                    {{ $opt->nama_option }}
                                                                                    @if($opt->nilai > 0)
                                                                                        (+Rp {{ number_format($opt->nilai) }})
                                                                                    @elseif($opt->nilai < 0)
                                                                                        (-Rp {{ number_format(abs($opt->nilai)) }})
                                                                                    @endif
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                @endforeach
                                                            @endif

                                                            <!-- JUMLAH -->
                                                            <div class="mb-4">
                                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah</label>
                                                                <input type="number" name="jumlah" class="menu-jumlah w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400" value="1" min="1" required>
                                                            </div>

                                                            <!-- TOTAL -->
                                                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                                                                <strong class="text-gray-800">Total: <span class="totalHargaMenu" data-base="{{ $menu->harga_base }}">Rp {{ number_format($menu->harga_base) }}</span></strong>
                                                            </div>

                                                            <div class="flex gap-2">
                                                                <button type="button" onclick="closeMenuModal('{{ $menu->id }}')" class="flex-1 px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition font-semibold">
                                                                    Batal
                                                                </button>
                                                                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                                                                    <i class="ph ph-shopping-cart-simple mr-1"></i>Tambah
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                                @empty
                                                <div class="col-span-full text-center py-12">
                                                    <i class="ph ph-coffee text-6xl text-gray-300 mb-3"></i>
                                                    <p class="text-gray-500">Tidak ada menu tersedia</p>
                                                </div>
                                                @endforelse
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- KERANJANG -->
                            <div class="lg:col-span-1">
                                <div class="bg-white rounded-lg shadow-sm border border-gray-200 sticky top-6">
                                    
                                    <!-- HEADER KERANJANG -->
                                    <div class="border-b border-gray-200 p-4">
                                        <div class="flex justify-between items-center">
                                            <h2 class="text-xl font-bold text-gray-800">Keranjang</h2>
                                            <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full font-semibold text-sm">
                                                {{ count($keranjang) }} item
                                            </span>
                                        </div>
                                        @if(!empty($keranjang))
                                            <p class="text-sm text-gray-600 mt-1">
                                                Total: <span class="font-bold text-gray-800">Rp {{ number_format(collect($keranjang)->sum(fn($i) => $i['harga'] * $i['jumlah'])) }}</span>
                                            </p>
                                        @endif
                                    </div>

                                    <!-- ISI KERANJANG -->
                                    <div class="p-4" style="max-height: 40vh; overflow-y: auto;">
                                        @if(empty($keranjang))
                                            <div class="text-center py-8">
                                                <i class="ph ph-shopping-cart text-6xl text-gray-300 mb-3"></i>
                                                <p class="text-gray-500">Keranjang kosong</p>
                                            </div>
                                        @else
                                            <div class="space-y-3">
                                                @foreach($keranjang as $id => $item)
                                                <div class="flex gap-3 p-3 bg-gray-50 rounded-lg">
                                                    <div class="flex-1">
                                                        <h3 class="font-semibold text-sm text-gray-800">{{ $item['nama'] }}</h3>
                                                        
                                                        <!-- TAMPILKAN OPTIONS MENU JIKA ADA -->
                                                        @if(isset($item['options']) && !empty($item['options']))
                                                            <div class="flex flex-wrap gap-1.5 mt-2">
                                                                @foreach($item['options'] as $tipeOption => $namaOption)
                                                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-full text-xs font-semibold text-blue-700">
                                                                        <i class="ph ph-check-circle text-blue-500"></i>
                                                                        {{ $namaOption }}
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                        
                                                        <p class="text-xs text-gray-600 mt-2">Rp {{ number_format($item['harga']) }}</p>
                                                        <p class="text-sm font-bold text-gray-800 mt-1">Rp {{ number_format($item['harga'] * $item['jumlah']) }}</p>
                                                    </div>
                                                    <div class="flex items-center gap-1">
                                                        <button type="button" onclick="updateJumlah('{{ $id }}', -1)" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition text-sm font-bold">
                                                            −
                                                        </button>
                                                        <span class="px-2 py-1 bg-white border border-gray-300 rounded text-center text-sm font-semibold w-10 jumlah-item-{{ $id }}">{{ $item['jumlah'] }}</span>
                                                        <button type="button" onclick="updateJumlah('{{ $id }}', 1)" class="px-2 py-1 bg-green-500 text-white rounded hover:bg-green-600 transition text-sm font-bold">
                                                            +
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('kasir.hapus', $id) }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                                            <i class="ph ph-trash text-lg"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>

                                    <!-- FORM PEMBAYARAN -->
                                    @if(!empty($keranjang))
                                    <div class="border-t border-gray-200 p-4">
                                        <form action="{{ route('kasir.bayar') }}" method="POST" class="space-y-3">
                                            @csrf

                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Pelanggan <span class="text-red-500">*</span></label>
                                                <input type="text" name="nama_pelanggan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Meja <span class="text-red-500">*</span></label>
                                                <input type="number" name="nomor_meja" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-1">Metode Pembayaran <span class="text-red-500">*</span></label>
                                                <select name="metode" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                                                    <option value="Tunai">Tunai</option>
                                                    <option value="EDC">EDC / Kartu</option>
                                                    <option value="QRIS">QRIS</option>
                                                    <option value="Transfer">Transfer</option>
                                                </select>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-1">Jumlah Bayar <span class="text-red-500">*</span></label>
                                                <input type="number" 
                                                    name="bayar" 
                                                    id="inputBayar"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400 text-right font-bold" 
                                                    min="{{ collect($keranjang)->sum(fn($i) => $i['harga'] * $i['jumlah']) }}" 
                                                    placeholder="0" 
                                                    required>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-1">Kembalian</label>
                                                <input type="text" 
                                                    id="displayKembalian"
                                                    class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg text-right font-bold text-green-600" 
                                                    value="Rp 0"
                                                    readonly>
                                            </div>

                                            <button type="submit" class="w-full px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-bold shadow-md hover:shadow-lg">
                                                <i class="ph ph-printer mr-2"></i>BAYAR & CETAK STRUK
                                            </button>
                                        </form>
                                    </div>
                                    @endif

                                </div>
                            </div>

                        </div>
                    </div>
                    @include('kasir.partials.footer')
                </div>
        </div>
</div>
<style>
.tab-button {
    color: #6b7280;
    border-bottom-color: transparent;
}
.tab-button.active {
    color: #1f2937;
    border-bottom-color: #1f2937;
}
</style>

<script>
// TAB SWITCHING
function switchTab(tab) {
    document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(content => content.classList.add('hidden'));
    
    document.getElementById('tab-' + tab).classList.add('active');
    document.getElementById('content-' + tab).classList.remove('hidden');
}

// MENU MODAL
function openMenuModal(menuId) {
    document.getElementById('menuModal' + menuId).classList.remove('hidden');
}

function closeMenuModal(menuId) {
    document.getElementById('menuModal' + menuId).classList.add('hidden');
}

// VALIDASI STOK
document.querySelectorAll('.form-tambah-produk').forEach(form => {
    form.addEventListener('submit', function(e) {
        const stok = parseInt(this.querySelector('.stok-produk').value);
        const namaProduk = this.querySelector('.nama-produk').value;
        
        if (stok <= 0) {
            e.preventDefault();
            alert(`❌ Stok "${namaProduk}" sudah habis!`);
            return false;
        }
    });
});

// HITUNG TOTAL MENU
document.querySelectorAll('[id^="menuModal"]').forEach(modal => {
    const totalSpan = modal.querySelector('.totalHargaMenu');
    const hargaBase = parseFloat(totalSpan.dataset.base);
    
    const updateTotal = () => {
        const jumlah = parseInt(modal.querySelector('.menu-jumlah').value) || 1;
        let totalTambahan = 0;
        
        modal.querySelectorAll('.menu-option-select').forEach(select => {
            const option = select.options[select.selectedIndex];
            totalTambahan += parseFloat(option.dataset.harga || 0);
        });
        
        const total = (hargaBase + totalTambahan) * jumlah;
        totalSpan.textContent = 'Rp ' + total.toLocaleString('id-ID');
    };
    
    modal.querySelectorAll('.menu-option-select, .menu-jumlah').forEach(el => {
        el.addEventListener('change', updateTotal);
        el.addEventListener('input', updateTotal);
    });
});

// HITUNG KEMBALIAN
const inputBayar = document.getElementById('inputBayar');
const displayKembalian = document.getElementById('displayKembalian');
const totalBelanja = {{ collect($keranjang)->sum(fn($i) => $i['harga'] * $i['jumlah']) }};

if (inputBayar) {
    inputBayar.addEventListener('input', function() {
        const bayar = parseFloat(this.value) || 0;
        const kembalian = bayar - totalBelanja;
        
        if (kembalian < 0) {
            displayKembalian.value = 'Rp 0';
            displayKembalian.classList.remove('text-green-600');
            displayKembalian.classList.add('text-red-600');
        } else {
            displayKembalian.value = 'Rp ' + kembalian.toLocaleString('id-ID');
            displayKembalian.classList.remove('text-red-600');
            displayKembalian.classList.add('text-green-600');
        }
    });
}

// FULLSCREEN
function toggleFullscreen(event) {
    event.preventDefault();
    event.stopPropagation();
    
    const elem = document.documentElement;
    const icon = document.getElementById('fullscreenIcon');
    
    if (!document.fullscreenElement) {
        elem.requestFullscreen().then(() => {
            icon.classList.remove('ph-arrows-out');
            icon.classList.add('ph-arrows-in');
        }).catch(err => {
            alert(`Fullscreen error: ${err.message}`);
        });
    } else {
        document.exitFullscreen().then(() => {
            icon.classList.remove('ph-arrows-in');
            icon.classList.add('ph-arrows-out');
        });
    }
}

// UPDATE JUMLAH KERANJANG
function updateJumlah(itemId, change) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("kasir.update.jumlah") }}';
    
    form.innerHTML = `
        @csrf
        <input type="hidden" name="item_id" value="${itemId}">
        <input type="hidden" name="change" value="${change}">
    `;
    
    document.body.appendChild(form);
    form.submit();
}
</script>
<!-- MODAL STOK TIDAK CUKUP -->
<div id="stokModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl max-w-sm w-full p-6 text-center animate-scale">
        <div class="flex justify-center mb-3">
            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-red-100">
                <i class="ph ph-warning text-red-600 text-2xl"></i>
            </div>
        </div>
        <h3 class="text-lg font-bold text-gray-800 mb-2">Stok Tidak Cukup</h3>
        <p id="stokModalText" class="text-gray-600 mb-5 text-sm">
            Stok produk tidak mencukupi
        </p>
        <button onclick="closeStokModal()"
            class="w-full px-4 py-2 bg-gray-800 text-white rounded-lg font-semibold hover:bg-gray-900 transition">
            OK
        </button>
    </div>
</div>

<style>
@keyframes scale {
    from { transform: scale(.9); opacity: 0 }
    to { transform: scale(1); opacity: 1 }
}
.animate-scale {
    animation: scale .2s ease-out;
}
</style>
<script>
function showStokModal(message) {
    document.getElementById('stokModalText').innerText = message;
    document.getElementById('stokModal').classList.remove('hidden');
}

function closeStokModal() {
    document.getElementById('stokModal').classList.add('hidden');
}
</script>
<script>
document.querySelectorAll('.form-tambah-produk').forEach(form => {
    form.addEventListener('submit', function(e) {
        const stok = parseInt(this.querySelector('.stok-produk').value);
        const nama = this.querySelector('.nama-produk').value;

        if (stok <= 0) {
            e.preventDefault();
            showStokModal(`Stok "${nama}" sudah habis`);
            return false;
        }
    });
});
</script>
<script>
function updateJumlah(itemId, change) {
    const jumlahEl = document.querySelector('.jumlah-item-' + itemId);
    if (!jumlahEl) return;

    const jumlahSekarang = parseInt(jumlahEl.innerText);

    // Ambil stok dari badge produk (fallback aman)
    const produkCard = document.querySelector(`input[name="produk_id"][value="${itemId}"]`)
        ?.closest('form')
        ?.querySelector('.stok-produk');

    if (produkCard) {
        const stok = parseInt(produkCard.value);

        if (change > 0 && jumlahSekarang + 1 > stok) {
            showStokModal(`Jumlah melebihi stok tersedia (${stok})`);
            return;
        }
    }

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("kasir.update.jumlah") }}';

    form.innerHTML = `
        @csrf
        <input type="hidden" name="item_id" value="${itemId}">
        <input type="hidden" name="change" value="${change}">
    `;

    document.body.appendChild(form);
    form.submit();
}
</script>
@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        showStokModal("{{ session('error') }}");
    });
</script>
@endif

</body>
</html>