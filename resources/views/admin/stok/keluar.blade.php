<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok Keluar - POS Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen">
        @include('components.sidebar')
        
        <div class="flex-1 flex flex-col min-w-0">
            @include('components.topbar')

            <!-- MAIN CONTENT -->
            <main class="flex-1 overflow-y-auto p-6 md:p-8 lg:p-10">

            <!-- Judul Halaman -->
            <div class="mb-8">
                <h3 class="text-3xl md:text-4xl font-bold text-orange-700 flex items-center gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 19V5"/>
                        <path d="m5 12 7-7 7 7"/>
                    </svg>
                    Kurangi Stok Keluar
                </h3>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-10">
                <form action="{{ route('admin.stok.keluar') }}" method="POST">
                    @csrf

                    <!-- Success / Error Message -->
                    @if(session('success'))
                        <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-5 rounded-xl mb-8 flex items-center gap-4 shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="m9 12 2 2 4-4"/>
                            </svg>
                            <span class="text-lg">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-5 rounded-xl mb-8 flex items-center gap-4 shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="m15 9-6 6"/>
                                <path d="m9 9 6 6"/>
                            </svg>
                            <div>
                                <p class="font-bold mb-2">Ada kesalahan:</p>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Pilih Produk -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">
                                Pilih Produk
                            </label>
                            <select name="produk_id"
                                    class="w-full px-5 py-4 rounded-xl border {{ $errors->has('produk_id') ? 'border-red-500' : 'border-gray-300' }} focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition text-base"
                                    required>
                                <option value="">-- Pilih Produk --</option>
                                @foreach($produks as $p)
                                    <option value="{{ $p->id }}">
                                        {{ $p->kode }} - {{ $p->nama }} (Stok: {{ $p->stok }})
                                    </option>
                                @endforeach
                            </select>
                            @error('produk_id')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jumlah Keluar -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">
                                Jumlah Keluar
                            </label>
                            <input type="number" name="jumlah" min="1" value="{{ old('jumlah') }}"
                                   class="w-full px-5 py-4 rounded-xl border {{ $errors->has('jumlah') ? 'border-red-500' : 'border-gray-300' }} focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition"
                                   placeholder="Masukkan jumlah" required>
                            @error('jumlah')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Keterangan (full width) -->
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 font-medium mb-2">
                                Keterangan <span class="text-gray-500 text-sm">(opsional)</span>
                            </label>
                            <textarea name="keterangan" rows="4"
                                      class="w-full px-5 py-4 rounded-xl border border-gray-300 focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition resize-none"
                                      placeholder="Contoh: Barang rusak / kadaluarsa / hilang">{{ old('keterangan') }}</textarea>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="mt-10 flex flex-col sm:flex-row gap-4">
                        <button type="submit"
                                class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-4 px-10 rounded-xl shadow-lg transition transform hover:scale-105 flex items-center justify-center gap-3 text-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="m9 12 2 2 4-4"/>
                            </svg>
                            Kurangi Stok
                        </button>
                        <a href="{{ route('admin.stok.index') }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-4 px-10 rounded-xl shadow-lg transition text-center flex items-center justify-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m12 19-7-7 7-7"/>
                                <path d="M19 12H5"/>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </form>
            </div>

        </main>
    </div>
</div>

<!-- SCRIPT HAMBURGER MENU -->
<script>
    const menuBtn = document.getElementById('menuBtn');
    const sidebar = document.getElementById('sidebar');
    overlay = document.getElementById('overlay');

    menuBtn?.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    });

    overlay?.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });

    document.querySelectorAll('#sidebar a').forEach(link => {
        link.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    });
</script>

</body>
</html>