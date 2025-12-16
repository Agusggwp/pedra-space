<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kategori - POS Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

            <!-- Header dengan Breadcrumb -->
            <div class="mb-8 mt-20">

                <!-- Title -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <h3 class="text-3xl md:text-4xl font-bold text-blue-700 flex items-center gap-4">
                        <i class="ph ph-info text-5xl md:text-6xl"></i>
                        Detail Kategori
                    </h3>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.category.index') }}"
                           class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-xl flex items-center gap-2 shadow-lg transition text-base font-medium">
                            <i class="ph ph-arrow-left text-xl"></i>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            <div class="max-w-6xl mx-auto">
                
                <!-- INFO KATEGORI -->
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-6">
                        <h4 class="text-xl font-bold text-white flex items-center gap-3">
                            <i class="ph ph-circles-three text-3xl"></i>
                            Informasi Kategori
                        </h4>
                    </div>
                    <div class="p-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                            <!-- Nama Kategori -->
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                    Nama Kategori
                                </label>
                                <p class="text-2xl font-bold text-gray-900">{{ $category->nama }}</p>
                            </div>

                            <!-- Jumlah Produk -->
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                    Jumlah Produk
                                </label>
                                <div class="flex items-center gap-3">
                                    <span class="inline-block px-6 py-3 rounded-xl text-lg font-bold shadow-md bg-green-600 text-white">
                                        {{ $category->produks()->count() }}
                                    </span>
                                    <span class="text-gray-600">produk terdaftar</span>
                                </div>
                            </div>

                            <!-- Jumlah Menu -->
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                    Jumlah Menu
                                </label>
                                <div class="flex items-center gap-3">
                                    <span class="inline-block px-6 py-3 rounded-xl text-lg font-bold shadow-md bg-blue-600 text-white">
                                        {{ $category->menus()->count() }}
                                    </span>
                                    <span class="text-gray-600">menu terdaftar</span>
                                </div>
                            </div>

                            <!-- Tanggal Dibuat -->
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                    Tanggal Dibuat
                                </label>
                                <p class="text-base text-gray-700 flex items-center gap-2">
                                    <i class="ph ph-calendar text-xl text-blue-600"></i>
                                    {{ $category->created_at ? $category->created_at->format('d F Y, H:i') : '-' }}
                                </p>
                            </div>

                            <!-- Terakhir Diupdate -->
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                    Terakhir Diupdate
                                </label>
                                <p class="text-base text-gray-700 flex items-center gap-2">
                                    <i class="ph ph-clock text-xl text-blue-600"></i>
                                    {{ $category->updated_at ? $category->updated_at->format('d F Y, H:i') : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>
</body>
</html>