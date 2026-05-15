<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Hotel</title>

    <!-- Tailwind CSS -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
     @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">

        <!-- Title -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Login</h1>
            <p class="text-gray-500 mt-2">
                Silakan masuk ke akun Anda
            </p>
        </div>

        <!-- Form -->
        <form action="/login" method="POST" class="space-y-5">

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Email
                </label>

                <input 
                    type="email"
                    name="email"
                    placeholder="Masukkan email" 
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                >
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Password
                </label>

                <input 
                    type="password"
                    name="password"
                    placeholder="Masukkan password"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                >
            </div>

            <!-- Button -->
            <button 
                type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-xl transition duration-200"
            >
                Login
            </button>

        </form>

    </div>

</body>
</html>