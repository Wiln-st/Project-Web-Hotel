<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Tailwind CSS -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    @vite('resources/css/app.css')
    @include('partials.fouc-script')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    @php

    $active =
    'text-amber-500 bg-slate-800/50 border-l-4 border-amber-500';

    $inactive =
    'text-slate-300 hover:bg-slate-800 hover:text-white';

    @endphp

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

                <!-- Kelola Kamar -->
                <a href="{{ route('supervisor.rooms.index') }}" 
                class="flex items-center px-3 py-2.5 rounded-lg transition-all
                {{request()->is('supervisor/rooms') ? $active : $inactive}}">
                    <i class="fas fa-door-open w-5 group-hover:text-amber-500"></i>
                    <span class="mx-3 font-medium">Kelola Kamar</span>
                </a>

                <!-- Histori Pesanan -->
                <a href="{{ route('supervisor.reservations.history') }}" 
                class="flex items-center px-3 py-2.5 rounded-lg transition-all
                {{request()->is('supervisor/reservation-history') ? $active : $inactive}}">
                    <i class="fas fa-clock-rotate-left w-5 group-hover:text-amber-500"></i>
                    <span class="mx-3 font-medium">Histori Pesanan</span>
                </a>

                <!-- Kelola Karyawan -->
                <a href="{{ route('supervisor.employees.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-all
                {{request()->is('supervisor/manage-employees') ? $active : $inactive}}">
                    <i class="fas fa-user-gear w-5 group-hover:text-amber-500"></i>
                    <span class="mx-3 font-medium">Kelola Karyawan</span>
                </a>

                <!-- Notifikasi -->
                <a href="{{ route('supervisor.notifications.index') }}" 
                class="flex items-center px-3 py-2.5 rounded-lg transition-all
                {{request()->is('supervisor/notifications') ? $active : $inactive}}">
                    <i class="fas fa-bell w-5 group-hover:text-amber-500"></i>
                    <span class="mx-3 font-medium">Notifikasi</span>
                </a>
            </nav>

            <div class="mt-auto pt-6 border-t border-slate-800 space-y-2">
                <!-- Mode Toggle -->
                <button id="sidebarThemeToggle" class="flex items-center w-full px-3 py-2.5 text-slate-400 hover:text-white transition-all">
                    <i id="sidebarThemeIcon" class="fas fa-moon"></i>
                    <span id="sidebarThemeText" class="mx-3 font-medium">Dark Mode</span>
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

    <script>
        (function () {
            const toggleBtn = document.getElementById('sidebarThemeToggle');
            const icon = document.getElementById('sidebarThemeIcon');
            const text = document.getElementById('sidebarThemeText');

            function updateSidebarUI(theme) {
                if (theme === 'light') {
                    if (icon) {
                        icon.className = 'fas fa-sun text-amber-500';
                    }
                    if (text) {
                        text.innerText = 'Light Mode';
                    }
                } else {
                    if (icon) {
                        icon.className = 'fas fa-moon text-slate-400';
                    }
                    if (text) {
                        text.innerText = 'Dark Mode';
                    }
                }
            }

            // Sync UI with active theme on render
            const activeTheme = localStorage.getItem('theme') || 'dark';
            updateSidebarUI(activeTheme);

            if (toggleBtn) {
                toggleBtn.addEventListener('click', () => {
                    let newTheme = 'dark';
                    if (document.documentElement.classList.contains('dark')) {
                        newTheme = 'light';
                        document.documentElement.classList.remove('dark');
                        document.documentElement.classList.add('light');
                    } else {
                        newTheme = 'dark';
                        document.documentElement.classList.remove('light');
                        document.documentElement.classList.add('dark');
                    }
                    localStorage.setItem('theme', newTheme);
                    updateSidebarUI(newTheme);
                });
            }
        })();
    </script>
</body>

</html>