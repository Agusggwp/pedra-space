<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diskon Kategori - POS Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">

<div class="flex min-h-screen">
    @include('components.sidebar')

    <div class="flex-1 flex flex-col min-w-0">
        @include('components.topbar')

        <main class="flex-1 p-6 md:p-8 lg:p-10 overflow-y-auto bg-gray-50">
            <div class="mb-8 mt-20">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-purple-700 flex items-center gap-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/>
                                <path d="M7 12a5 5 0 1 0 10 0 5 5 0 0 0-10 0z"/>
                            </svg>
                            Diskon Kategori
                        </h2>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.diskon.index') }}" class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-semibold transition-colors">
                            ← Kembali
                        </a>
                        <a href="{{ route('admin.diskon.kategori.create') }}" class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold transition-colors">
                            + Tambah Diskon Kategori
                        </a>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-5 rounded-xl mb-8 flex items-center gap-4 shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-lg">
                <div class="p-6 border-b border-gray-200">
                    <form method="GET" class="flex gap-4 items-end">
                        <div class="flex-1">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Cari Kategori</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama kategori..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="">Semua</option>
                                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                        <button type="submit" class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold transition-colors">
                            Cari
                        </button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Kategori</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Persentase</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Nominal</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($diskons as $diskon)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                        {{ $diskon->category->nama }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $diskon->persentase ? $diskon->persentase . '%' : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $diskon->nominal ? 'Rp ' . number_format($diskon->nominal, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <form action="{{ route('admin.diskon.toggle', $diskon) }}" method="POST" class="inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="px-3 py-1 rounded-full text-xs font-semibold {{ $diskon->aktif ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $diskon->aktif ? 'Aktif' : 'Nonaktif' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.diskon.kategori.edit', $diskon) }}" class="px-3 py-1 bg-purple-600 hover:bg-purple-700 text-white rounded text-xs font-semibold transition-colors">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.diskon.destroy', $diskon) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs font-semibold transition-colors">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-auto mb-4 text-gray-400">
                                            <circle cx="12" cy="12" r="10"/>
                                            <line x1="12" x2="12" y1="16" y2="12"/>
                                            <line x1="12" x2="12.01" y1="8" y2="8"/>
                                        </svg>
                                        <p class="text-lg font-semibold">Tidak ada diskon kategori</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $diskons->links() }}
                </div>
            </div>
        </main>
    </div>
</div>

</body>
</html>
