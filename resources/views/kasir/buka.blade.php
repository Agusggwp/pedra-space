<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buka Kasir</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center py-10">

<div class="w-full max-w-md px-4">

    <!-- Card -->
    <div class="bg-white rounded-2xl p-8 shadow-xl border">

        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Buka Kasir</h2>

        <form action="{{ route('kasir.buka') }}" method="POST">
            @csrf

            <!-- Input -->
            <div class="mb-6">
                <label class="block text-lg font-semibold text-gray-700 mb-2">
                    Saldo Awal Cash Drawer
                </label>
                <input 
                    type="number" 
                    name="saldo_awal" 
                    value="0" 
                    min="0" 
                    required
                    class="w-full bg-gray-50 border border-gray-300 text-right text-xl rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
            </div>

            <!-- Button -->
            <button 
                type="submit" 
                class="w-full bg-green-600 hover:bg-green-700 text-white text-lg font-bold py-3 rounded-xl shadow transition">
                BUKA KASIR SEKARANG
            </button>
        </form>

        <!-- Tombol Kembali -->
        <a 
            href="{{ route('kasir.dashboard') }}" 
            class="block mt-5 text-center bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 rounded-xl transition">
            ← Kembali ke Dashboard
        </a>

    </div>

    <!-- Footer
    <p class="text-center text-gray-500 text-sm mt-6">
        POS by <a href="https://artdevata.net" class="underline hover:text-gray-700">ArtDevata</a>
    </p>
     -->
        
@include('kasir.partials.footer')
</div>

</body>
</html>
