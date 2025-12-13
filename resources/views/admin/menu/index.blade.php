<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Menu - POS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">

<div class="flex min-h-screen">
    @include('components.sidebar')

    <div class="flex-1 flex flex-col min-w-0 min-h-screen overflow-hidden">
        @include('components.topbar')

        <main class="flex-1 p-6 md:p-8 lg:p-10 overflow-y-auto bg-gray-50 mt-20">
            <div class="max-w-7xl mx-auto">
                <!-- HEADER -->
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-4">
                        <div class="bg-gradient-to-r from-orange-500 to-red-500 p-4 rounded-xl">
                            <i class="ph ph-list text-4xl text-white"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Manajemen Menu</h1>
                            <p class="text-gray-600">Kelola menu dengan customization options</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.menu.create') }}" class="btn btn-primary flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                        <i class="ph ph-plus"></i> Tambah Menu
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
                        <i class="ph ph-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <!-- MENU GRID -->
                @if($menus->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($menus as $menu)
                            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 border {{ $menu->is_active ? 'border-green-200' : 'border-gray-200' }}">
                                <!-- FOTO -->
                                @if($menu->foto)
                                    <img src="{{ Storage::url($menu->foto) }}" alt="{{ $menu->nama }}" class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                        <i class="ph ph-image text-4xl text-gray-400"></i>
                                    </div>
                                @endif

                                <!-- CONTENT -->
                                <div class="p-6">
                                    <div class="flex items-start justify-between mb-2">
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-900">{{ $menu->nama }}</h3>
                                            <p class="text-sm text-gray-500">{{ ucfirst($menu->kategori) }}</p>
                                        </div>
                                        <span class="badge {{ $menu->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }} px-3 py-1 rounded-full text-sm font-semibold">
                                            {{ $menu->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>

                                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($menu->deskripsi, 80) }}</p>

                                    <div class="mb-4 pb-4 border-b border-gray-200">
                                        <p class="text-2xl font-bold text-green-600">Rp {{ number_format($menu->harga_base, 0, ',', '.') }}</p>
                                        @if($menu->harga_beli)
                                            <p class="text-sm text-gray-600">Modal: Rp {{ number_format($menu->harga_beli, 0, ',', '.') }}</p>
                                            <p class="text-sm font-semibold {{ ($menu->harga_base - $menu->harga_beli) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                                Keuntungan: Rp {{ number_format($menu->harga_base - $menu->harga_beli, 0, ',', '.') }}
                                            </p>
                                        @endif
                                    </div>

                                    <!-- OPTIONS -->
                                    @if($menu->options->count() > 0)
                                        <div class="mb-4">
                                            <p class="text-sm font-semibold text-gray-700 mb-2">Customization:</p>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($menu->options->groupBy('tipe') as $tipe => $opts)
                                                    <span class="badge bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                                        {{ ucfirst(str_replace('_', ' ', $tipe)) }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- ACTIONS -->
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.menu.edit', $menu) }}" class="btn btn-sm btn-primary flex-1 bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                                            <i class="ph ph-pencil"></i> Edit
                                        </a>

                                        <form action="{{ route('admin.menu.destroy', $menu) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin hapus menu ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger w-full bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                                                <i class="ph ph-trash"></i> Hapus
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.menu.toggle-status', $menu) }}" method="POST" class="flex-1">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn btn-sm {{ $menu->is_active ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} text-white px-3 py-2 rounded-lg font-semibold transition w-full flex items-center justify-center gap-2">
                                                <i class="ph {{ $menu->is_active ? 'ph-eye-slash' : 'ph-eye' }}"></i> {{ $menu->is_active ? 'Nonaktif' : 'Aktif' }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16 bg-white rounded-2xl shadow-lg">
                        <i class="ph ph-list text-6xl text-gray-300 mb-4 block"></i>
                        <p class="text-gray-500 text-lg">Belum ada menu</p>
                        <a href="{{ route('admin.menu.create') }}" class="btn btn-primary mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition inline-flex items-center gap-2">
                            <i class="ph ph-plus"></i> Tambah Menu Sekarang
                        </a>
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>

</body>
</html>
