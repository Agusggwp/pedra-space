<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - POS Admin</title>
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
                <h3 class="text-3xl md:text-4xl font-bold text-blue-700 flex items-center gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                        <path d="m15 5 4 4"/>
                    </svg>
                    Edit Produk: <span class="text-gray-800">{{ $produk->nama }}</span>
                </h3>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-10">
                <form action="{{ route('admin.produk.update', $produk) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Error Summary -->
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

                        <!-- Kode Produk -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">
                                Kode Produk
                            </label>
                            <input type="text" name="kode" value="{{ old('kode', $produk->kode) }}"
                                   class="w-full px-5 py-4 rounded-xl border {{ $errors->has('kode') ? 'border-red-500' : 'border-gray-300' }} focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition"
                                   required>
                            @error('kode')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nama Produk -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">
                                Nama Produk
                            </label>
                            <input type="text" name="nama" value="{{ old('nama', $produk->nama) }}"
                                   class="w-full px-5 py-4 rounded-xl border {{ $errors->has('nama') ? 'border-red-500' : 'border-gray-300' }} focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition"
                                   required>
                            @error('nama')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">
                                Kategori
                            </label>
                            <select name="category_id"
                                    class="w-full px-5 py-4 rounded-xl border {{ $errors->has('category_id') ? 'border-red-500' : 'border-gray-300' }} focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition"
                                    required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $produk->category_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Harga Beli -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">
                                Harga Beli
                            </label>
                            <input type="number" name="harga_beli" value="{{ old('harga_beli', $produk->harga_beli) }}"
                                   class="w-full px-5 py-4 rounded-xl border {{ $errors->has('harga_beli') ? 'border-red-500' : 'border-gray-300' }} focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition"
                                   required>
                        </div>

                        <!-- Harga Jual -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">
                                Harga Jual
                            </label>
                            <input type="number" name="harga_jual" value="{{ old('harga_jual', $produk->harga_jual) }}"
                                   class="w-full px-5 py-4 rounded-xl border {{ $errors->has('harga_jual') ? 'border-red-500' : 'border-gray-300' }} focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition"
                                   required>
                        </div>

                        <!-- Stok -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">
                                Stok Saat Ini
                            </label>
                            <input type="number" name="stok" value="{{ old('stok', $produk->stok) }}"
                                   class="w-full px-5 py-4 rounded-xl border {{ $errors->has('stok') ? 'border-red-500' : 'border-gray-300' }} focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition"
                                   required>
                        </div>

                        <!-- Foto Saat Ini -->
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 font-medium mb-3">
                                Foto Saat Ini
                            </label>
                            <div class="flex items-center gap-4">
                                @if($produk->foto)
                                    <img src="{{ asset('storage/' . $produk->foto) }}" 
                                         alt="{{ $produk->nama }}" 
                                         class="w-32 h-32 object-cover rounded-xl shadow-lg border-4 border-gray-200">
                                @else
                                    <div class="w-32 h-32 bg-gray-200 rounded-xl flex items-center justify-center border-4 border-dashed border-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                                            <rect width="18" height="18" x="3" y="3" rx="2" ry="2"/>
                                            <circle cx="9" cy="9" r="2"/>
                                            <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                                        </svg>
                                    </div>
                                @endif
                                <span class="text-gray-600">Kosongkan jika tidak ingin mengganti foto</span>
                            </div>
                        </div>

                        <!-- Ganti Foto -->
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 font-medium mb-2">
                                Ganti Foto Produk <span class="text-gray-500 text-sm">(opsional)</span>
                            </label>
                            <input type="file" name="foto" accept="image/*"
                                   class="w-full px-5 py-4 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition file:mr-4 file:py-3 file:px-6 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @error('foto')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="mt-10 flex flex-col sm:flex-row gap-4">
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-10 rounded-xl shadow-lg transition transform hover:scale-105 flex items-center justify-center gap-3 text-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="m9 12 2 2 4-4"/>
                            </svg>
                            Update Produk
                        </button>
                        <a href="{{ route('admin.produk.index') }}"
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

</body>
</html>