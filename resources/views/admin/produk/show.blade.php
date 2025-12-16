<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - {{ $produk->nama }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">

<div class="flex min-h-screen">
    @include('components.sidebar')
    
    <div class="flex-1 flex flex-col min-w-0">
        @include('components.topbar')
        
        <main class="flex-1 p-6 md:p-8 lg:p-10 overflow-y-auto bg-gray-50">
            
            <!-- Header Section -->
            <div class="mb-8 mt-20">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h3 class="text-3xl md:text-4xl font-bold text-blue-700 flex items-center gap-4">
                            <i class="ph ph-package text-5xl md:text-6xl"></i>
                            Detail Produk
                        </h3>
                    </div>
                    <a href="{{ route('admin.produk.index') }}"
                       class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-xl flex items-center gap-2 shadow-lg transition text-base font-medium">
                        <i class="ph ph-arrow-left text-xl"></i>
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                    
                    <!-- Left Column - Image & Stock -->
                    <div class="lg:col-span-4 space-y-6">
                        
                        <!-- Product Image Card -->
                        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                            <div class="bg-gray-100 p-5">
                                <h4 class="text-lg font-bold text-black flex items-center gap-2">
                                    <i class="ph ph-image text-2xl"></i>
                                    Foto Produk
                                </h4>
                            </div>
                            <div class="p-6">
                                <div class="aspect-square bg-gray-100 rounded-xl overflow-hidden border-4 border-gray-200 shadow-inner cursor-pointer hover:border-blue-400 transition-all duration-300"
                                     onclick="showImageModal('{{ $produk->foto ? asset('storage/' . $produk->foto) : 'https://via.placeholder.com/500/E5E7EB/9CA3AF?text=No+Image' }}')">
                                    <img src="{{ $produk->foto ? asset('storage/' . $produk->foto) : 'https://via.placeholder.com/500/E5E7EB/9CA3AF?text=No+Image' }}"
                                         alt="{{ $produk->nama }}"
                                         class="w-full h-full object-cover hover:scale-110 transition-transform duration-300">
                                </div>
                                <p class="text-xs text-gray-500 text-center mt-3">
                                    <i class="ph ph-magnifying-glass-plus"></i>
                                    Klik untuk memperbesar
                                </p>
                            </div>
                        </div>

                        <!-- Stock Card -->
                        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                            <div class="bg-gray p-5">
                                <h4 class="text-lg font-bold text-black flex items-center gap-2">
                                    <i class="ph ph-stack text-2xl"></i>
                                    Status Stok
                                </h4>
                            </div>
                            <div class="p-6">
                                <div class="text-center p-6 bg-gradient-to-br from-blue-50 to-purple-50 rounded-xl mb-4">
                                    <div class="text-6xl font-bold text-gray-700 mb-2">
                                        {{ $produk->stok }}
                                    </div>
                                    <div class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Unit Tersedia</div>
                                </div>
                                
                                <div class="flex justify-center">
                                    @if($produk->stok <= 0)
                                        <span class="px-6 py-3 rounded-full text-sm font-bold bg-gray-300 text-gray-700 shadow flex items-center gap-2">
                                            <i class="ph ph-x-circle text-xl"></i>
                                            Stok Habis
                                        </span>
                                    @elseif($produk->stok <= 10)
                                        <span class="px-6 py-3 rounded-full text-sm font-bold bg-yellow-300 text-white shadow flex items-center gap-2">
                                            <i class="ph ph-warning text-xl"></i>
                                            Stok Menipis
                                        </span>
                                    @else
                                        <span class="px-6 py-3 rounded-full text-sm font-bold bg-gray-100 text-gray-700 shadow flex items-center gap-2">
                                            <i class="ph ph-check-circle text-xl"></i>
                                            Stok Aman
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column - Details -->
                    <div class="lg:col-span-8 space-y-6">
                        
                        <!-- Basic Info Card -->
                        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                            <div class="bg-gray-100 p-5">
                                <h4 class="text-lg font-bold text-gray-700 flex items-center gap-2">
                                    <i class="ph ph-info text-2xl"></i>
                                    Informasi Dasar
                                </h4>
                            </div>
                            <div class="p-6 space-y-5">
                                
                                <!-- Kode Produk -->
                                <div class="flex items-center pb-4 border-b border-gray-200">
                                    <div class="w-40 flex-shrink-0">
                                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Kode Produk</label>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-lg font-mono font-bold text-blue-600 bg-blue-50 inline-block px-4 py-2 rounded-lg">
                                            {{ $produk->kode }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Nama Produk -->
                                <div class="flex items-center pb-4 border-b border-gray-200">
                                    <div class="w-40 flex-shrink-0">
                                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Produk</label>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xl font-bold text-gray-900">{{ $produk->nama }}</p>
                                    </div>
                                </div>

                                <!-- Kategori -->
                                <div class="flex items-center pb-4 border-b border-gray-200">
                                    <div class="w-40 flex-shrink-0">
                                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori</label>
                                    </div>
                                    <div class="flex-1">
                                        @if($produk->category)
                                            <span class="inline-flex items-center gap-2 bg-purple-100 text-purple-700 px-4 py-2 rounded-lg font-semibold">
                                                <i class="ph ph-tag"></i>
                                                {{ $produk->category->nama }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 italic">Tidak ada kategori</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Deskripsi -->
                                @if($produk->deskripsi)
                                <div class="flex pb-4">
                                    <div class="w-40 flex-shrink-0">
                                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Deskripsi</label>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-base text-gray-700 leading-relaxed">{{ $produk->deskripsi }}</p>
                                    </div>
                                </div>
                                @endif

                            </div>
                        </div>

                        <!-- Pricing Card -->
                        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                            <div class="bg-gray-100 p-5">
                                <h4 class="text-lg font-bold text-gray-700 flex items-center gap-2">
                                    <i class="ph ph-currency-circle-dollar text-2xl"></i>
                                    Informasi Harga
                                </h4>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                    <!-- Harga Beli -->
                                    <div class="bg-white p-5 rounded-xl border border-gray-200">
                                        <div class="flex items-center gap-2 mb-2">
                                            <div class="bg-gray-200 p-2 rounded-lg">
                                                <i class="ph ph-arrow-down text-xl text-gray-600"></i>
                                            </div>
                                            <p class="text-xs font-bold text-gray-600 uppercase">Harga Beli</p>
                                        </div>
                                        <p class="text-2xl font-bold text-gray-700">
                                            Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <!-- Harga Jual -->
                                    <div class="bg-white p-5 rounded-xl border border-gray-200">
                                        <div class="flex items-center gap-2 mb-2">
                                            <div class="bg-gray-200 p-2 rounded-lg">
                                                <i class="ph ph-arrow-up text-xl text-gray-600"></i>
                                            </div>
                                            <p class="text-xs font-bold text-gray-600 uppercase">Harga Jual</p>
                                        </div>
                                        <p class="text-2xl font-bold text-gray-700">
                                            Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <!-- Margin -->
                                    @php
                                        $profit = $produk->harga_jual - $produk->harga_beli;
                                    @endphp
                                    <div class="bg-white p-5 rounded-xl border border-gray-200">
                                        <div class="flex items-center gap-2 mb-2">
                                            <div class="bg-gray-200 p-2 rounded-lg">
                                                <i class="ph ph-trend-up text-xl text-gray-600"></i>
                                            </div>
                                            <p class="text-xs font-bold text-gray-600 uppercase">Margin</p>
                                        </div>
                                        <p class="text-2xl font-bold text-gray-700">
                                            Rp {{ number_format($profit, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Timestamp Card -->
                        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                            <div class="bg-gray-200 p-5">
                                <h4 class="text-lg font-bold text-gray-700 flex items-center gap-2">
                                    <i class="ph ph-clock-clockwise text-2xl"></i>
                                    Informasi Waktu
                                </h4>
                            </div>
                            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                                
                                <!-- Created At -->
                                <div class="flex items-start gap-3">
                                    <div class="bg-blue-100 p-3 rounded-lg flex-shrink-0">
                                        <i class="ph ph-calendar-plus text-2xl text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Dibuat Pada</p>
                                        <p class="text-base font-bold text-gray-900">
                                            {{ $produk->created_at ? $produk->created_at->format('d F Y') : '-' }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            {{ $produk->created_at ? $produk->created_at->format('H:i') : '' }} WIB
                                        </p>
                                    </div>
                                </div>

                                <!-- Updated At -->
                                <div class="flex items-start gap-3">
                                    <div class="bg-purple-100 p-3 rounded-lg flex-shrink-0">
                                        <i class="ph ph-calendar-check text-2xl text-purple-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Terakhir Diupdate</p>
                                        <p class="text-base font-bold text-gray-900">
                                            {{ $produk->updated_at ? $produk->updated_at->format('d F Y') : '-' }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            {{ $produk->updated_at ? $produk->updated_at->format('H:i') : '' }} WIB
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </main>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4" onclick="closeImageModal()">
    <div class="relative max-w-4xl w-full">
        <button onclick="closeImageModal()" class="absolute -top-12 right-0 text-white hover:text-gray-300 transition">
            <i class="ph ph-x text-4xl"></i>
        </button>
        <img id="modalImage" src="" alt="Product Image" class="w-full h-auto rounded-xl shadow-2xl">
    </div>
</div>

<script>
// Show Image Modal
function showImageModal(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

// Close Image Modal
function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>

</body>
</html>