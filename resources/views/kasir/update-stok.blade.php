<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Stok - Kasir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-gray-50">

@include('kasir.partials.sidebar')

<!-- MAIN CONTENT -->
<div class="lg:ml-72 p-6 md:p-8">
    <div class="max-w-5xl mx-auto">

        <!-- HEADER -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2 flex items-center gap-3">
                        <i class="ph ph-package text-gray-700"></i> 
                        Update Stok Produk
                    </h1>
                    <p class="text-gray-600">Tambah atau kurangi stok dengan cepat dan mudah</p>
                </div>
            </div>

            <a href="{{ route('kasir.dashboard') }}" 
               class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 font-semibold transition">
                <i class="ph ph-arrow-left"></i>
                <span>Kembali ke Dashboard</span>
            </a>
        </div>

        <!-- NOTIFIKASI -->
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-lg mb-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <i class="ph ph-check-circle text-2xl"></i>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-lg mb-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <i class="ph ph-warning-circle text-2xl"></i>
                    <span class="font-semibold">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- FORM CARD -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 md:p-8">
            <form action="{{ route('kasir.update-stok') }}" method="POST">
                @csrf

                <div class="grid md:grid-cols-3 gap-6">

                    <!-- PILIH PRODUK -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Pilih Produk <span class="text-red-500">*</span>
                        </label>
                        <select name="produk_id" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent transition" 
                                required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach($produks as $p)
                                <option value="{{ $p->id }}">
                                    {{ $p->nama }} (Stok: {{ $p->stok }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Pilih produk yang ingin diupdate</p>
                    </div>

                    <!-- JUMLAH -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Jumlah <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               name="jumlah" 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 text-center text-2xl font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent transition"
                               placeholder="50 atau -10" 
                               required>
                        <div class="mt-2 text-xs text-gray-600 space-y-1">
                            <p><span class="font-semibold text-green-600">Positif (+)</span> = Tambah stok</p>
                            <p><span class="font-semibold text-red-600">Negatif (-)</span> = Kurangi stok</p>
                        </div>
                    </div>

                    <!-- KETERANGAN -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Keterangan <span class="text-gray-400 font-normal">(opsional)</span>
                        </label>
                        <input type="text" 
                               name="keterangan" 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent transition"
                               placeholder="Contoh: Restock supplier">
                        <p class="text-xs text-gray-500 mt-1">Catatan untuk update stok ini</p>
                    </div>
                </div>

                <!-- TOMBOL SUBMIT -->
                <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
                    <button type="submit" 
                            class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-gray-800 text-white rounded-lg font-bold shadow-md hover:bg-gray-900 hover:shadow-lg transition transform hover:-translate-y-0.5">
                        <i class="ph ph-check-circle text-2xl"></i>
                        <span>Update Stok Sekarang</span>
                    </button>

                    <a href="{{ route('kasir.dashboard') }}" 
                       class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-white text-gray-700 rounded-lg font-bold shadow-md hover:bg-gray-50 hover:shadow-lg transition border border-gray-200">
                        <i class="ph ph-x-circle text-2xl"></i>
                        <span>Batal</span>
                    </a>
                </div>
            </form>
        </div>

        <!-- INFO CARD -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex gap-3">
                <i class="ph ph-info text-2xl text-blue-600 flex-shrink-0"></i>
                <div class="text-sm text-blue-800">
                    <p class="font-semibold mb-1">Informasi Penting:</p>
                    <ul class="list-disc list-inside space-y-1 text-blue-700">
                        <li>Pastikan jumlah yang dimasukkan sudah benar sebelum update</li>
                        <li>Sistem akan otomatis mencegah pengurangan stok melebihi jumlah tersedia</li>
                        <li>Semua perubahan stok akan tercatat dalam riwayat sistem</li>
                    </ul>
                </div>
            </div>
        </div>
        @include('kasir.partials.footer')
    </div>
</div>

</body>
</html>