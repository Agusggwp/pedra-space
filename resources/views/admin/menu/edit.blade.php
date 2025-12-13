<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu - POS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">

<div class="flex min-h-screen">
    @include('components.sidebar')

    <div class="flex-1 flex flex-col min-w-0 min-h-screen overflow-hidden">
        @include('components.topbar')

        <main class="flex-1 p-6 md:p-8 lg:p-10 overflow-y-auto bg-gray-50 mt-20">
            <div class="max-w-4xl mx-auto">
                <!-- HEADER -->
                <div class="flex items-center gap-4 mb-8">
                    <div class="bg-gradient-to-r from-orange-500 to-red-500 p-4 rounded-xl">
                        <i class="ph ph-pencil text-4xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Edit Menu</h1>
                        <p class="text-gray-600">{{ $menu->nama }}</p>
                    </div>
                </div>

                <form action="{{ route('admin.menu.update', $menu) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-lg p-8">
                    @csrf @method('PUT')

                    <!-- INFO DASAR -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="ph ph-info"></i> Informasi Dasar
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Menu <span class="text-red-500">*</span></label>
                                <input type="text" name="nama" class="form-control w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ $menu->nama }}" required>
                                @error('nama') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                                <select name="kategori" class="form-select w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                    <option value="beverage" {{ $menu->kategori == 'beverage' ? 'selected' : '' }}>Minuman</option>
                                    <option value="food" {{ $menu->kategori == 'food' ? 'selected' : '' }}>Makanan</option>
                                    <option value="snack" {{ $menu->kategori == 'snack' ? 'selected' : '' }}>Snack</option>
                                </select>
                                @error('kategori') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <!-- Harga Base -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                                <input type="number" name="harga_base" step="1000" min="0" class="form-control w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ $menu->harga_base }}" required>
                                @error('harga_base') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Harga Beli -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Harga Modal/Beli (Rp)</label>
                                <input type="number" name="harga_beli" step="1000" min="0" class="form-control w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ $menu->harga_beli ?? '' }}">
                                @error('harga_beli') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mt-4">
                            <!-- Foto -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Menu</label>
                                <input type="file" name="foto" class="form-control w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" accept="image/*">
                                @if($menu->foto)
                                    <small class="text-gray-500">Foto saat ini tersimpan</small>
                                @endif
                                @error('foto') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mt-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3">{{ $menu->deskripsi }}</textarea>
                            @error('deskripsi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- CUSTOMIZATION OPTIONS -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                                <i class="ph ph-gear"></i> Customization Options
                            </h3>
                            <button type="button" onclick="addOption()" class="btn btn-sm bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-semibold flex items-center gap-2">
                                <i class="ph ph-plus"></i> Tambah Option
                            </button>
                        </div>

                        <div id="optionsContainer" class="space-y-4">
                            @foreach($menu->options as $option)
                                <div class="option-item bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-2">
                                        <div>
                                            <label class="text-sm font-semibold text-gray-700">Tipe Option</label>
                                            <select name="options[{{ $loop->index }}][tipe]" class="form-control w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" required>
                                                <option value="">-- Pilih Tipe --</option>
                                                <option value="sugar_level" {{ $option->tipe == 'sugar_level' ? 'selected' : '' }}>Tingkat Gula</option>
                                                <option value="milk_type" {{ $option->tipe == 'milk_type' ? 'selected' : '' }}>Jenis Susu</option>
                                                <option value="temperature" {{ $option->tipe == 'temperature' ? 'selected' : '' }}>Suhu Minuman</option>
                                                <option value="size" {{ $option->tipe == 'size' ? 'selected' : '' }}>Ukuran</option>
                                                <option value="extra" {{ $option->tipe == 'extra' ? 'selected' : '' }}>Tambahan</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="text-sm font-semibold text-gray-700">Nama Option</label>
                                            <input type="text" name="options[{{ $loop->index }}][nama_option]" value="{{ $option->nama_option }}" class="form-control w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                        </div>
                                        <div>
                                            <label class="text-sm font-semibold text-gray-700">Tambah Harga (Rp)</label>
                                            <input type="number" name="options[{{ $loop->index }}][nilai]" step="1000" min="0" value="{{ $option->nilai }}" class="form-control w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                        </div>
                                    </div>
                                    <button type="button" onclick="removeOption(this)" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                        <i class="ph ph-trash"></i> Hapus
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- BUTTONS -->
                    <div class="flex gap-3">
                        <button type="submit" class="btn btn-primary flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                            <i class="ph ph-check"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                            <i class="ph ph-x"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script>
let optionCount = {{ $menu->options->count() }};
const optionTypes = {
    'sugar_level': 'Tingkat Gula',
    'milk_type': 'Jenis Susu',
    'temperature': 'Suhu Minuman',
    'size': 'Ukuran',
    'extra': 'Tambahan'
};

function addOption() {
    const container = document.getElementById('optionsContainer');
    optionCount++;
    
    let typeOptions = '<option value="">-- Pilih Tipe --</option>';
    for (const [key, label] of Object.entries(optionTypes)) {
        typeOptions += `<option value="${key}">${label}</option>`;
    }
    
    const html = `
        <div class="option-item bg-gray-50 rounded-lg p-4 border border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-2">
                <div>
                    <label class="text-sm font-semibold text-gray-700">Tipe Option</label>
                    <select name="options[${optionCount}][tipe]" class="form-control w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" required>
                        ${typeOptions}
                    </select>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700">Nama Option</label>
                    <input type="text" name="options[${optionCount}][nama_option]" placeholder="misal: Less Sugar, Almond Milk, Ice" class="form-control w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" required>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700">Tambah Harga (Rp)</label>
                    <input type="number" name="options[${optionCount}][nilai]" step="1000" min="0" placeholder="0" class="form-control w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                </div>
            </div>
            <button type="button" onclick="removeOption(this)" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                <i class="ph ph-trash"></i> Hapus
            </button>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', html);
}

function removeOption(btn) {
    btn.closest('.option-item').remove();
}
</script>

</body>
</html>
