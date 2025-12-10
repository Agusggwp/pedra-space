<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — NexaPOS</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .input-focus {
            transition: all 0.35s ease;
        }
        .input-focus:focus {
            transform: translateY(-4px);
            border-color: #000;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }
        .btn-hover {
            transition: all 0.4s ease;
        }
        .btn-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-6xl grid lg:grid-cols-2 bg-white rounded-3xl shadow-2xl overflow-hidden">

        <!-- KIRI: Branding Minimalis Putih -->
        <div class="hidden lg:flex flex-col justify-between p-16 xl:p-24 bg-white">
            <div class="text-center">
                <img src="{{ asset('storage/logo/pedra.png') }}"
                     onerror="this.src='https://cdn-icons-png.flaticon.com/512/854/854866.png'"
                     class="w-48 h-48 mx-auto mb-12 rounded-3xl shadow-xl border border-gray-100">

                <h1 class="text-6xl font-black text-gray-900 tracking-tight">
                    PEDRA SPACE
                </h1>
                <p class="mt-4 text-2xl font-light text-gray-600">
                    Point of Sales 
                </p>

                <p class="mt-10 text-lg text-gray-500 max-w-sm mx-auto leading-relaxed">
                    Sistem kasir modern yang dirancang khusus untuk bisnis Anda berkembang lebih cepat.
                </p>
            </div>

            <div class="text-center">
                <p class="text-sm text-gray-400">Dikembangkan oleh</p>
                <a href="https://artdevata.net" target="_blank" 
                   class="inline-flex items-center gap-3 mt-2 text-lg font-bold text-gray-800 hover:text-black transition">
                    <img src="{{ asset('storage/logo/art.png') }}"
                         onerror="this.src='https://via.placeholder.com/40'"
                         class="w-9 h-9 rounded-full border border-gray-200">
                    <span>ARTDEVATA</span>
                </a>
            </div>
        </div>

        <!-- KANAN: Form Login -->
        <div class="flex flex-col justify-center px-10 py-16 lg:px-20 xl:px-28 bg-white">
            <div class="flex justify-center mb-12 lg:hidden">
                <img src="{{ asset('storage/logo/nexapos.png') }}"
                     onerror="this.src='https://cdn-icons-png.flaticon.com/512/854/854866.png'"
                     class="w-28 h-28 rounded-3xl shadow-lg">
            </div>

            <div class="max-w-md mx-auto w-full">
                <h2 class="text-4xl font-bold text-gray-900 text-center lg:text-left">
                    Selamat Datang
                </h2>
                <p class="mt-3 text-lg text-gray-600 text-center lg:text-left">
                    Masukkan akun Anda
                </p>

                <form method="POST" action="/login" class="mt-12 space-y-8">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Email</label>
                        <input type="email"
                               name="email"
                               required
                               class="input-focus w-full px-6 py-5 text-lg bg-white border-2 border-gray-200 rounded-2xl outline-none placeholder-gray-400"
                               placeholder="nama@gmail.com">
                    </div>

                    <!-- Password + Show/Hide -->
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Password</label>
                        <input type="password"
                               id="password"
                               name="password"
                               required
                               class="input-focus w-full px-6 py-5 pr-16 text-lg bg-white border-2 border-gray-200 rounded-2xl outline-none placeholder-gray-400"
                               placeholder="••••••••••••">
                        
                        <!-- Tombol Toggle Password -->
                        <button type="button"
                                onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 flex items-center pr-6 pt-10 text-gray-500 hover:text-gray-800 focus:outline-none">
                            <!-- Icon Mata Terbuka (Show) -->
                            <svg id="eye-open" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <!-- Icon Mata Tertutup (Hide) -->
                            <svg id="eye-closed" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 012.09-2.825m2.813-1.35A9.98 9.98 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.03 10.03 0 01-4.825 5.875" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 3l18 18" />
                            </svg>
                        </button>
                    </div>

                    <!-- Tombol Login -->
                    <button type="submit"
                            class="btn-hover w-full py-6 mt-10 bg-black hover:bg-gray-900 text-white font-bold text-lg rounded-2xl shadow-2xl">
                        Masuk ke Dashboard
                    </button>
                </form>

                <p class="mt-16 text-center text-sm text-gray-400">
                    © 2025 Artdevata — All Rights Reserved
                </p>
            </div>
        </div>
    </div>

    <!-- Script untuk toggle password -->
    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            } else {
                passwordField.type = 'password';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            }
        }
    </script>

</body>
</html>