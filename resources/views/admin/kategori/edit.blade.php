<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori - POS Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">

<div class="flex min-h-screen">

    <!-- SIDEBAR COMPONENT -->
    @include('components.sidebar')

    <!-- KONTEN UTAMA -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- TOPBAR COMPONENT -->
        @include('components.topbar')

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-6 md:p-8 lg:p-10 overflow-y-auto bg-gray-50">

            <!-- Judul -->
            <div class="mb-8 mt-20">
                <h3 class="text-3xl md:text-4xl font-bold text-blue-700 flex items-center gap-4 mb-2">
                    <i class="ph ph-pencil-circle text-5xl md:text-6xl"></i>
                    Edit Kategori
                </h3>
                <p class="text-gray-600 text-lg">Perbarui informasi kategori produk</p>
            </div>

            <!-- CARD FORM -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden max-w-2xl">
                <div class="p-8 md:p-10">
                    <form action="{{ route('admin.category.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- NAMA KATEGORI -->
                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-3">
                                Nama Kategori <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="nama" 
                                   value="{{ old('nama', $category->nama) }}"
                                   placeholder="Contoh: Kopi, Minuman, Snack, Dessert"
                                   class="w-full px-5 py-4 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition text-lg @error('nama') border-red-500 @enderror"
                                   required>
                            
                            @error('nama')
                            <p class="mt-3 text-red-600 flex gap-2 items-center text-sm font-semibold">
                                <i class="ph ph-warning-circle text-xl flex-shrink-0"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- INFO PRODUK -->
                        <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-5 mb-8">
                            <p class="text-blue-800 flex gap-3 items-center font-semibold">
                                <i class="ph ph-info text-2xl flex-shrink-0"></i>
                                Kategori ini memiliki <strong class="text-lg">{{ $category->produks()->count() }}</strong> produk terdaftar.
                            </p>
                        </div>

                        <!-- BUTTONS -->
                        <div class="flex gap-4">
                            <button type="submit" 
                                    class="flex-1 px-6 py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-lg transition shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                                <i class="ph ph-check text-2xl"></i>
                                Update Kategori
                            </button>
                            <a href="{{ route('admin.category.index') }}" 
                               class="flex-1 px-6 py-4 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-xl font-bold text-lg transition shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                                <i class="ph ph-x text-2xl"></i>
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </main>
    </div>
</div>

</body>
</html>
