<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Per Shift User - POS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">

<div class="flex min-h-screen">
    <!-- SIDEBAR COMPONENT -->
    @include('components.sidebar')

    <!-- KONTEN UTAMA -->
    <div class="flex-1 flex flex-col min-w-0 min-h-screen overflow-hidden">
        <!-- TOPBAR COMPONENT -->
        @include('components.topbar')

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-6 md:p-8 lg:p-10 overflow-y-auto bg-gray-50 mt-20">
            <div class="max-w-7xl mx-auto">
                <!-- HEADER -->
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-4 rounded-xl">
                            <i class="ph ph-user-list text-4xl text-white"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Laporan Per Shift User</h1>
                            <p class="text-gray-600">Laporan detail shift kasir berdasarkan user</p>
                        </div>
                    </div>
                </div>

                <!-- FILTER SECTION -->
                <div class="bg-white p-6 rounded-2xl shadow-xl mb-8">
                    <form method="GET" action="{{ route('laporan.shift') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Filter User -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="ph ph-user mr-2"></i>Pilih User (Kasir)
                                </label>
                                <select name="user_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">-- Semua User --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filter Dari Tanggal -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="ph ph-calendar mr-2"></i>Dari Tanggal
                                </label>
                                <input type="date" name="from" value="{{ request('from') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <!-- Filter Sampai Tanggal -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="ph ph-calendar mr-2"></i>Sampai Tanggal
                                </label>
                                <input type="date" name="to" value="{{ request('to') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="flex items-center gap-2 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-150 font-medium">
                                <i class="ph ph-magnifying-glass"></i>Filter
                            </button>
                            <a href="{{ route('laporan.shift') }}" class="flex items-center gap-2 px-6 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition-colors duration-150 font-medium">
                                <i class="ph ph-x"></i>Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- DATA TABLE -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gradient-to-r from-gray-800 to-gray-900 text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold">#</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold">Nama Kasir</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold">Dibuka Pada</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold">Ditutup Pada</th>
                                    <th class="px-6 py-4 text-center text-sm font-semibold">Transaksi</th>
                                    <th class="px-6 py-4 text-right text-sm font-semibold">Saldo Awal</th>
                                    <th class="px-6 py-4 text-right text-sm font-semibold">Saldo Akhir</th>
                                    <th class="px-6 py-4 text-right text-sm font-semibold">Selisih</th>
                                    <th class="px-6 py-4 text-center text-sm font-semibold">Status</th>
                                    <th class="px-6 py-4 text-center text-sm font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($shiftData as $shift)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $shift->user->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $shift->dibuka_pada->format('d M Y H:i') ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $shift->ditutup_pada?->format('d M Y H:i') ?? '-' }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="inline-flex flex-col items-center space-y-1">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                                    Total: {{ $shift->transaksi_count }}
                                                </span>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-green-100 text-green-800">
                                                    <i class="ph ph-check mr-1"></i>Lunas: {{ $shift->transaksi_lunas }}
                                                </span>
                                                @if($shift->transaksi_void > 0)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-red-100 text-red-800">
                                                        <i class="ph ph-x mr-1"></i>Void: {{ $shift->transaksi_void }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-right text-gray-900 font-medium">Rp {{ number_format($shift->saldo_awal ?? 0, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 text-sm text-right text-gray-900 font-medium">Rp {{ number_format($shift->saldo_akhir ?? 0, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 text-sm text-right font-bold {{ ($shift->selisih ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                            Rp {{ number_format($shift->selisih ?? 0, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $shift->status == 'buka' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst($shift->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('laporan.shift.show', $shift->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                                                <i class="ph ph-eye"></i>Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="px-6 py-8 text-center text-gray-500">
                                            <i class="ph ph-warning text-4xl inline-block mb-2"></i>
                                            <p>Tidak ada data shift ditemukan</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- SUMMARY FOOTER -->
                    @if($shiftData->count() > 0)
                        <div class="bg-gray-100 px-6 py-4 border-t border-gray-200">
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">Total Shift</p>
                                    <p class="text-2xl font-bold text-gray-800">{{ $shiftData->count() }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Total Transaksi</p>
                                    <p class="text-2xl font-bold text-blue-600">{{ $shiftData->sum('transaksi_count') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Total Lunas</p>
                                    <p class="text-2xl font-bold text-green-600">{{ $shiftData->sum('transaksi_lunas') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Total Void</p>
                                    <p class="text-2xl font-bold text-red-600">{{ $shiftData->sum('transaksi_void') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Total Saldo Akhir</p>
                                    <p class="text-2xl font-bold text-purple-600">Rp {{ number_format($shiftData->sum('saldo_akhir'), 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>

</body>
</html>
