<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Tailwind CSS -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    @vite('resources/css/app.css')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <aside class="flex flex-col w-64 h-screen px-5 py-8 overflow-y-auto bg-slate-900 border-r border-slate-700 fixed">
        <!-- Brand Logo -->
        <div class="flex items-center gap-x-3 px-2">
            <div class="p-2 bg-amber-500 rounded-lg">
                <i class="fas fa-hotel text-slate-900"></i>
            </div>
            <span class="text-xl font-bold text-white tracking-tight">Grand<span class="text-amber-500">Stay</span></span>
        </div>

        <div class="flex flex-col justify-between flex-1 mt-10">
            <nav class="space-y-2">
                <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Main Menu</p>

                <!-- Dashboard -->
                <a href="#" class="flex items-center px-3 py-2.5 text-amber-500 bg-slate-800/50 border-l-4 border-amber-500 rounded-r-lg transition-all">
                    <i class="fas fa-chart-line w-5"></i>
                    <span class="mx-3 font-medium">Dashboard</span>
                </a>

                <!-- Kelola Kamar -->
                <a href="#" class="flex items-center px-3 py-2.5 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-all group">
                    <i class="fas fa-door-open w-5 group-hover:text-amber-500"></i>
                    <span class="mx-3 font-medium">Kelola Kamar</span>
                </a>

                <!-- Reservasi -->
                <a href="#" class="flex items-center px-3 py-2.5 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-all group">
                    <i class="fas fa-calendar-check w-5 group-hover:text-amber-500"></i>
                    <span class="mx-3 font-medium">Reservasi</span>
                </a>

                <!-- Histori Pesanan -->
                <a href="#" class="flex items-center px-3 py-2.5 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-all group">
                    <i class="fas fa-clock-rotate-left w-5 group-hover:text-amber-500"></i>
                    <span class="mx-3 font-medium">Histori Pesanan</span>
                </a>

                <!-- Kelola Karyawan -->
                <a href="#" class="flex items-center px-3 py-2.5 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-all group">
                    <i class="fas fa-user-gear w-5 group-hover:text-amber-500"></i>
                    <span class="mx-3 font-medium">Kelola Karyawan</span>
                </a>

                <!-- Notifikasi -->
                <a href="#" class="flex items-center px-3 py-2.5 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-all group relative">
                    <i class="fas fa-bell w-5 group-hover:text-amber-500"></i>
                    <span class="mx-3 font-medium">Notifikasi</span>
                    <span class="absolute right-2 top-3 w-2 h-2 bg-red-500 rounded-full"></span>
                </a>
            </nav>

            <div class="mt-auto pt-6 border-t border-slate-800 space-y-2">
                <!-- Mode Toggle -->
                <button class="flex items-center w-full px-3 py-2.5 text-slate-400 hover:text-white transition-all">
                    <i class="fas fa-moon"></i>
                    <span class="mx-3 font-medium">Dark Mode</span>
                </button>

                <!-- Logout -->
                 <form method="POST" action="{{ route('logout') }}">
                    @csrf
                     <button type="submit" class="flex items-center px-3 py-2.5 text-red-400 hover:bg-red-500/10 rounded-lg transition-all">
                         <i class="fas fa-power-off w-5"></i>
                         <span class="mx-3 font-medium">Logout</span>
                     </button>
                 </form>
            </div>
        </div>
    </aside>
</body>

</html>