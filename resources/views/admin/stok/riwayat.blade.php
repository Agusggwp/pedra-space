<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Stok - POS Admin</title>
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
                        <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                        <path d="M3 3v5h5"/>
                        <path d="M12 7v5l4 2"/>
                    </svg>
                    Riwayat Stok
                </h3>
            </div>

            <!-- Tabel Riwayat -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-800 to-gray-900 text-white">
                            <tr>
                                <th class="py-5 px-5 text-left text-sm font-bold uppercase tracking-wider">Tanggal</th>
                                <th class="py-5 px-5 text-left text-sm font-bold uppercase tracking-wider">Produk</th>
                                <th class="py-5 px-5 text-left text-sm font-bold uppercase tracking-wider">Tipe</th>
                                <th class="py-5 px-5 text-center text-sm font-bold uppercase tracking-wider">Jumlah</th>
                                <th class="py-5 px-5 text-left text-sm font-bold uppercase tracking-wider">Keterangan</th>
                                <th class="py-5 px-5 text-left text-sm font-bold uppercase tracking-wider">User</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($histories as $h)
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="py-5 px-5 text-gray-700">
                                    {{ $h->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="py-5 px-5">
                                    <div class="font-semibold text-gray-900">{{ $h->produk->nama }}</div>
                                    <div class="text-sm text-gray-500">{{ $h->produk->kode }}</div>
                                </td>
                                <td class="py-5 px-5">
                                    @if($h->tipe == 'masuk')
                                        <span class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-green-600 text-white font-bold shadow">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M12 5v14"/>
                                                <path d="m19 12-7 7-7-7"/>
                                            </svg>
                                            Masuk
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-orange-600 text-white font-bold shadow">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M12 19V5"/>
                                                <path d="m5 12 7-7 7 7"/>
                                            </svg>
                                            Keluar
                                        </span>
                                    @endif
                                </td>
                                <td class="py-5 px-5 text-center">
                                    <span class="text-xl font-bold text-gray-800">{{ $h->jumlah }}</span>
                                </td>
                                <td class="py-5 px-5 text-gray-600">
                                    {{ $h->keterangan ?: '-' }}
                                </td>
                                <td class="py-5 px-5">
                                    <div class="font-medium text-gray-900">{{ $h->user->name }}</div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-20">
                                    <div class="text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="mx-auto mb-6 opacity-20">
                                            <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                                            <path d="M3 3v5h5"/>
                                            <path d="M12 7v5l4 2"/>
                                        </svg>
                                        <p class="text-2xl font-medium">Belum ada riwayat stok</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginasi -->
                <div class="p-6 bg-gray-50 border-t border-gray-200">
                    <div class="flex justify-center">
                        {{ $histories->links() }}
                    </div>
                </div>
            </div>

            </main>
        </div>
    </div>

</body>
</html>