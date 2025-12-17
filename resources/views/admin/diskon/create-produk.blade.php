<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($diskon) ? 'Edit' : 'Tambah' }} Diskon Produk - POS Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">

<div class="flex min-h-screen">
    @include('components.sidebar')

    <div class="flex-1 flex flex-col min-w-0">
        @include('components.topbar')

        <main class="flex-1 p-6 md:p-8 lg:p-10 overflow-y-auto bg-gray-50">
            <div class="mb-8 mt-20">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-700">
                    {{ isset($diskon) ? 'Edit' : 'Tambah' }} Diskon Produk
                </h2>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-5 rounded-xl mb-8">
                    <h4 class="font-bold mb-2">Validasi Gagal</h4>
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-lg p-8 max-w-2xl">
                <form action="{{ isset($diskon) ? route('admin.diskon.produk.update', $diskon) : route('admin.diskon.produk.store') }}" method="POST">
                    @csrf
                    @if(isset($diskon)) @method('PUT') @endif

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Produk <span class="text-red-500">*</span></label>
                        <select name="produk_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Produk --</option>
                            @foreach($produks as $produk)
                                <option value="{{ $produk->id }}" {{ (old('produk_id') ?? (isset($diskon) ? $diskon->produk_id : '')) == $produk->id ? 'selected' : '' }}>
                                    {{ $produk->nama }} ({{ $produk->kode }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Persentase (%)</label>
                            <input type="number" name="persentase" step="0.01" min="0" max="100" value="{{ old('persentase', isset($diskon) ? $diskon->persentase : '') }}" placeholder="Contoh: 10" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Atau masukkan nominal</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Nominal (Rp)</label>
                            <input type="number" name="nominal" min="0" value="{{ old('nominal', isset($diskon) ? $diskon->nominal : '') }}" placeholder="Contoh: 5000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" placeholder="Deskripsi diskon (opsional)" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('deskripsi', isset($diskon) ? $diskon->deskripsi : '') }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Berlaku Dari</label>
                            <input type="date" name="berlaku_dari" value="{{ old('berlaku_dari', isset($diskon) && $diskon->berlaku_dari ? $diskon->berlaku_dari->format('Y-m-d') : '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Berlaku Sampai</label>
                            <input type="date" name="berlaku_sampai" value="{{ old('berlaku_sampai', isset($diskon) && $diskon->berlaku_sampai ? $diskon->berlaku_sampai->format('Y-m-d') : '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="aktif" value="1" {{ (old('aktif', isset($diskon) ? $diskon->aktif : true)) ? 'checked' : '' }} class="w-4 h-4 text-blue-600">
                            <span class="text-sm font-semibold text-gray-700">Aktif</span>
                        </label>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors">
                            {{ isset($diskon) ? 'Update' : 'Simpan' }}
                        </button>
                        <a href="{{ route('admin.diskon.produk') }}" class="px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-semibold transition-colors">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

</body>
</html>
