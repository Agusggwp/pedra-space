<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Stok - Kasir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body {
            background: #f8fafc;
            color: #1e293b;
            min-height: 100vh;
        }
        .card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            border: 1px solid #e2e8f0;
        }
        .input-focus:focus {
            outline: none;
            ring: 4px solid #3b82f6;
            border-color: #3b82f6;
        }
        .btn-primary {
            background: #3b82f6;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(59,130,246,0.3);
        }
    </style>
</head>
<body class="bg-gray-50">

<div class="container max-w-5xl mx-auto py-10 px-6">

    <!-- Header -->
    <div class="text-center mb-10">
        <h1 class="text-5xl font-bold text-gray-800 mb-3">
            Update Stok Produk
        </h1>
        <p class="text-xl text-gray-600">Tambah atau kurangi stok dengan cepat & mudah</p>
        <a href="{{ route('kasir.dashboard') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 mt-6 text-lg font-medium">
            ← Kembali ke Dashboard
        </a>
    </div>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="bg-green-50 border-2 border-green-300 text-green-800 p-6 rounded-2xl text-center text-xl font-semibold mb-8 shadow-lg">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border-2 border-red-300 text-red-800 p-6 rounded-2xl text-center text-xl font-semibold mb-8 shadow-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Form Card -->
    <div class="card p-10">
        <form action="{{ route('kasir.update-stok') }}" method="POST">
            @csrf

            <div class="grid md:grid-cols-3 gap-8">

                <!-- Pilih Produk -->
                <div>
                    <label class="block text-lg font-semibold text-gray-700 mb-3">
                        Pilih Produk
                    </label>
                    <select name="produk_id" class="w-full p-5 rounded-2xl border-2 border-gray-300 text-gray-800 text-lg input-focus" required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach($produks as $p)
                            <option value="{{ $p->id }}">
                                {{ $p->nama }} (Stok saat ini: {{ $p->stok }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Jumlah -->
                <div>
                    <label class="block text-lg font-semibold text-gray-700 mb-3">
                        Jumlah (+ tambah / - kurangi)
                    </label>
                    <input type="number" name="jumlah" 
                           class="w-full p-5 rounded-2xl border-2 border-gray-300 text-center text-3xl font-bold text-gray-800 input-focus"
                           placeholder="50 atau -10" required>
                    <p class="text-center mt-3 text-gray-600">
                        <strong>Positif</strong> = tambah stok<br>
                        <strong>Negatif</strong> = kurangi stok
                    </p>
                </div>

                <!-- Keterangan -->
                <div>
                    <label class="block text-lg font-semibold text-gray-700 mb-3">
                        Keterangan <span class="text-gray-500 font-normal">(opsional)</span>
                    </label>
                    <input type="text" name="keterangan" 
                           class="w-full p-5 rounded-2xl border-2 border-gray-300 text-lg input-focus"
                           placeholder="Contoh: Restock dari supplier, barang rusak, dll">
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="text-center mt-12">
                <button type="submit" class="btn-primary text-white px-16 py-6 rounded-3xl text-2xl font-bold shadow-2xl inline-flex items-center gap-4">
                    <i class="ph ph-package text-3xl"></i>
                    UPDATE STOK SEKARANG
                </button>
            </div>
        </form>
    </div>

    <!-- Info -->
    <div class="text-center mt-12 text-gray-600">
        <p class="text-lg">Pastikan jumlah yang dimasukkan sudah benar sebelum update.</p>
        <p class="text-sm mt-2">Sistem akan otomatis mencegah pengurangan stok melebihi jumlah tersedia.</p>
    </div>
</div>

</body>
</html>