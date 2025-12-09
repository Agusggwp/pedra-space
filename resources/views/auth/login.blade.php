<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS - Login</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#0d5640",
                        primaryDark: "#0a3c2d",
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-white min-h-screen flex flex-col items-center justify-center p-4">

    <!-- Judul Website -->
    <h1 class="text-3xl font-bold text-primary mb-6 tracking-wide">
        POS SYSTEM
    </h1>

    <!-- Card Login -->
    <div class="w-full max-w-sm bg-white border border-gray-200 rounded-xl shadow-md p-6">

        <!-- Logo -->
        <div class="text-center mb-5">
            <img src="https://i.ibb.co/02PLBWm/LOGO-ART-DEVATA.png" 
                 alt="Logo"
                 class="w-20 mx-auto">
            <h2 class="text-lg font-semibold mt-2 text-gray-700">Art.Devata</h2>
        </div>

        <!-- Error Message -->
        @if ($errors->any())
            <div class="bg-red-500 text-white p-2 rounded-md mb-4 text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf

            <label class="block font-semibold mb-1 text-gray-700">Email</label>
            <input type="email" name="email"
                class="w-full px-3 py-2 mb-4 border rounded-lg bg-gray-50 
                       focus:ring-2 focus:ring-primary focus:outline-none"
                required>

            <label class="block font-semibold mb-1 text-gray-700">Password</label>
            <input type="password" name="password"
                class="w-full px-3 py-2 mb-4 border rounded-lg bg-gray-50 
                       focus:ring-2 focus:ring-primary focus:outline-none"
                required>

            <button type="submit"
                class="w-full bg-primary hover:bg-primaryDark text-white py-2 rounded-lg font-semibold transition">
                Login
            </button>
        </form>
    </div>

    <!-- Footer ArtDevata.net -->
   <footer class="mt-8 w-full text-center text-gray-500 text-sm">

    <a href="https://artdevata.net" target="_blank"
       class="inline-flex items-center justify-center gap-2 mb-1 hover:text-primary transition">

        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                  d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M3 7l9 6 9-6M3 7l9 6 9-6" />
        </svg>

        <span class="font-semibold underline decoration-dashed">
            ArtDevata.net
        </span>
    </a>

    <p class="text-xs text-gray-400 mt-1">
        © {{ date('Y') }} — Crafted with passion for your business
    </p>
</footer>


</body>

</html>
