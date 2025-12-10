<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Void / Refund - POS Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        <main class="flex-1 p-6 md:p-8 lg:p-10 bg-gray-50">

            <!-- Judul Halaman -->
            <div class="mb-8">
                <h2 class="text-3xl md:text-4xl font-bold text-red-700 flex items-center gap-4">
                    <i class="ph ph-prohibit text-6xl md:text-6xl"></i>
                    Void / Batalkan Transaksi
                </h2>
            </div>

            <!-- Flash Message -->
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-5 rounded-xl mb-8 flex items-center gap-4 shadow">
                    <i class="ph ph-check-circle text-3xl"></i>
                    <span class="text-lg">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-5 rounded-xl mb-8 flex items-center gap-4 shadow">
                    <i class="ph ph-x-circle text-3xl"></i>
                    <span class="text-lg">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Tabel Transaksi -->
            <!-- TABEL VOID/REFUND – SEMPURNA DI TABLET -->
<div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-red-700 to-red-900 text-white">
                <tr>
                    <th class="py-4 px-3 text-left text-xs font-bold uppercase tracking-wider">ID</th>
                    <th class="py-4 px-3 text-left text-xs font-bold uppercase tracking-wider">Tanggal</th>
                    <th class="py-4 px-3 text-left text-xs font-bold uppercase tracking-wider">Kasir</th>
                    <th class="py-4 px-3 text-left text-xs font-bold uppercase tracking-wider">Total</th>
                    <th class="py-4 px-3 text-left text-xs font-bold uppercase tracking-wider">Metode</th>
                    <th class="py-4 px-3 text-left text-xs font-bold uppercase tracking-wider">Status</th>
                    <th class="py-4 px-3 text-center text-xs font-bold uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($transaksis as $t)
                <tr class="{{ $t->status === 'void' ? 'bg-gray-100 opacity-75' : 'hover:bg-gray-50' }} transition duration-200">
                    <!-- ID -->
                    <td class="py-4 px-3">
                        <span class="font-mono font-bold text-base text-gray-800">#{{ $t->id }}</span>
                    </td>

                    <!-- TANGGAL -->
                    <td class="py-4 px-3 text-gray-700 text-sm">
                        <div>{{ $t->created_at->format('d/m/Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $t->created_at->format('H:i') }}</div>
                    </td>

                    <!-- KASIR -->
                    <td class="py-4 px-3">
                        <div class="font-semibold text-gray-900">{{ $t->user->name }}</div>
                    </td>

                    <!-- TOTAL -->
                    <td class="py-4 px-3">
                        <div class="font-bold text-xl text-red-600 whitespace-nowrap">
                            Rp {{ number_format($t->total) }}
                        </div>
                    </td>

                    <!-- METODE -->
                    <td class="py-4 px-3">
                        <span class="inline-block px-4 py-1.5 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800">
                            {{ $t->metode_pembayaran }}
                        </span>
                    </td>

                    <!-- STATUS -->
                    <td class="py-4 px-3">
                        @if($t->status === 'void')
                            <span class="inline-block px-4 py-2 rounded-full bg-gray-600 text-white font-bold text-sm shadow">
                                Dibatalkan
                            </span>
                        @else
                            <span class="inline-block px-4 py-2 rounded-full bg-green-600 text-white font-bold text-sm shadow">
                                Lunas
                            </span>
                        @endif
                    </td>

                    <!-- AKSI -->
                    <td class="py-4 px-3">
                        <div class="flex justify-center">
                            @if($t->status !== 'void')
                                <button onclick="openModal('modal-{{ $t->id }}')"
                                        class="bg-red-600 hover:bg-red-700 text-white font-medium text-sm px-6 py-3 rounded-lg shadow transition transform hover:scale-105 flex items-center gap-2 min-w-32 justify-center">
                                    <i class="ph ph-prohibit text-lg"></i>
                                    Void
                                </button>
                            @else
                                <div class="text-center text-sm">
                                    <div class="text-gray-600">Dibatalkan oleh</div>
                                    <div class="font-bold text-gray-800">{{ $t->voidBy?->name ?? '-' }}</div>
                                </div>
                            @endif
                        </div>
                    </td>
                </tr>

                <!-- MODAL VOID (tetap sama, sudah cantik) -->
                <div id="modal-{{ $t->id }}" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center hidden z-50">
                    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-8 relative">
                        <button onclick="closeModal('modal-{{ $t->id }}')" class="absolute top-4 right-6 text-3xl text-gray-500 hover:text-gray-700">
                            <i class="ph ph-x"></i>
                        </button>
                        <h3 class="text-2xl font-bold text-red-700 mb-6 text-center">
                            Konfirmasi Pembatalan
                        </h3>
                        <div class="text-center mb-6">
                            <p class="text-base">Yakin ingin <strong class="text-red-600">membatalkan</strong> transaksi ini?</p>
                            <p class="text-2xl font-bold text-red-600 mt-3">Rp {{ number_format($t->total) }}</p>
                            <p class="text-gray-600 mt-2">Kasir: {{ $t->user->name }}</p>
                        </div>

                        <form action="{{ route('admin.void.proses', $t) }}" method="POST">
                            @csrf
                            <div class="mb-6">
                                <label class="block text-gray-700 font-medium mb-2">
                                    Alasan Pembatalan <span class="text-red-500">*</span>
                                </label>
                                <textarea name="keterangan" required rows="4"
                                          class="w-full px-5 py-4 rounded-xl border border-gray-300 focus:border-red-500 focus:ring-4 focus:ring-red-100 transition resize-none text-sm"
                                          placeholder="Contoh: Customer batal, salah input, barang rusak, dll..."></textarea>
                            </div>

                            <div class="flex justify-center gap-4">
                                <button type="button" onclick="closeModal('modal-{{ $t->id }}')"
                                        class="px-7 py-3 bg-gray-500 hover:bg-gray-600 text-white font-bold rounded-xl shadow transition">
                                    Batal
                                </button>
                                <button type="submit"
                                        class="px-7 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-lg transition transform hover:scale-105">
                                    Ya, Batalkan!
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-20">
                        <div class="text-gray-400">
                            <i class="ph ph-receipt-x text-9xl mb-6 opacity-20"></i>
                            <p class="text-2xl font-medium">Belum ada transaksi</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    </div>

    <!-- Paginasi -->
    <div class="p-5 bg-gray-50 border-t border-gray-200">
        <div class="flex justify-center">
            {{ $transaksis->links() }}
        </div>
    </div>
</div>

        </main>
    </div>
</div>

<script>
    // Modal Void
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    // Tutup modal saat klik di luar
    document.querySelectorAll('[id^="modal-"]').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal(modal.id);
        });
    });
</script>

</body>
</html>