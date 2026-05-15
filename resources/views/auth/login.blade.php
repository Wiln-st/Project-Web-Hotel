<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Hotel</title>

    <!-- Tailwind CSS -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    @vite('resources/css/app.css')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <div class="min-h-screen flex items-center justify-center bg-slate-950 px-4">
        <div class="max-w-md w-full bg-slate-900 rounded-2xl shadow-2xl p-8 border border-slate-800">
            <!-- Header -->
            <div class="text-center mb-10">
                <div class="inline-flex p-3 bg-amber-500 rounded-xl mb-4">
                    <i class="fas fa-hotel text-2xl text-slate-900"></i>
                </div>
                <h2 class="text-3xl font-bold text-white">Welcome Back</h2>
                <p class="text-slate-400 mt-2">Please enter your details to login</p>
            </div>

            @if(session('error'))
            <div class="bg-red-100 text-red-600 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
            @endif

            <form action="/login" method="POST" class="space-y-6">
                @csrf
                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" name="email" class="w-full pl-10 pr-4 py-3 bg-slate-800 border border-slate-700 text-white rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent outline-none transition" placeholder="admin@hotel.com">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" id="passwordInput" class="w-full pl-10 pr-12 py-3 bg-slate-800 border border-slate-700 text-white rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent outline-none transition" placeholder="••••••••">

                        <!-- Fitur Mata -->
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-500 hover:text-amber-500 transition">
                            <i id="eyeIcon" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Login Button -->
                <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold py-3 rounded-lg transform transition active:scale-95">
                    Log In
                </button>
            </form>
        </div>
    </div>

    <!-- Script Fitur Mata -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('passwordInput');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>