<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrandStay</title>
    <!-- Tailwind CSS -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    @vite('resources/css/app.css')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-slate-950 text-slate-100 min-h-screen font-sans antialiased transition-colors duration-300 dark:bg-slate-950 light:bg-gray-50 light:text-slate-800">
    @include('admin.partials.sidebar')

    <div class="flex min-h-screen">

        <!-- ================= MAIN CONTENT AREA ================= -->
        <main class="flex-1 ml-64 p-8 lg:p-10 overflow-y-auto">

            <!-- Header Dashboard -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-white dark:text-white light:text-slate-900">Dashboard</h1>
                    <p class="text-sm text-slate-400 dark:text-slate-400 light:text-gray-500 mt-1">Selamat datang kembali, Admin. Berikut ringkasan performa hotel hari ini.</p>
                </div>
                <!-- Date Filter Badge -->
                <div class="flex items-center gap-3 bg-slate-900 dark:bg-slate-900 light:bg-white border border-slate-800 dark:border-slate-800 light:border-gray-200 px-4 py-2 rounded-xl text-sm shadow-sm w-fit">
                    <i class="fas fa-calendar text-amber-500"></i>
                    <span class="font-medium text-slate-300 dark:text-slate-300 light:text-slate-700">{{ $today->translatedFormat('d F Y') }}</span>
                </div>
            </div>

            <!-- ================= SECTION 1: TOTAL SALDO ================= -->
            <div class="mb-8">
                <div class="relative overflow-hidden bg-gradient-to-br from-slate-900 to-slate-800 dark:from-slate-900 dark:to-slate-800 light:from-slate-900 light:to-slate-950 p-6 rounded-2xl border border-slate-800 dark:border-slate-800 light:border-transparent shadow-xl">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="p-2 bg-amber-500/10 text-amber-500 rounded-lg text-xs font-bold uppercase tracking-wider">Total Saldo Hotel</span>
                    </div>
                    <p class="text-sm text-slate-400 dark:text-slate-400 light:text-slate-300">Saldo Berjalan Saat Ini</p>
                    <h2 class="text-4xl font-black text-white mt-1 tracking-tight">Rp 1,245,850,000</h2>
                </div>
            </div>

            <!-- ================= SECTION 2: PEMASUKAN & PENGELUARAN ================= -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Card Pemasukan -->
                <div class="bg-slate-900 border border-slate-800 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200 p-6 rounded-2xl shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="p-3 bg-emerald-500/10 text-emerald-500 rounded-xl">
                                <i class="fas fa-arrow-down-long text-lg"></i>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-slate-400 dark:text-slate-400 light:text-gray-500 uppercase tracking-wider">Total Pemasukan</p>
                                <h3 class="text-2xl font-bold text-white dark:text-white light:text-slate-900 mt-0.5">Rp 84,250,000 <span class="text-xs font-normal text-slate-400">/bln</span></h3>
                            </div>
                        </div>
                    </div>
                    <!-- Fake Chart Visualizer -->
                    <div class="space-y-2 mt-6">

                        <div class="w-full bg-slate-800 dark:bg-slate-800 light:bg-gray-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-emerald-500 h-full rounded-full" style="width: 75%"></div>
                        </div>
                    </div>
                </div>

                <!-- Card Pengeluaran -->
                <div class="bg-slate-900 border border-slate-800 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200 p-6 rounded-2xl shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="p-3 bg-rose-500/10 text-rose-500 rounded-xl">
                                <i class="fas fa-arrow-up-long text-lg"></i>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-slate-400 dark:text-slate-400 light:text-gray-500 uppercase tracking-wider">Total Pengeluaran</p>
                                <h3 class="text-2xl font-bold text-white dark:text-white light:text-slate-900 mt-0.5">Rp 19,400,000 <span class="text-xs font-normal text-slate-400">/bln</span></h3>
                            </div>
                        </div>
                    </div>
                    <!-- Fake Chart Visualizer -->
                    <div class="space-y-2 mt-6">
                        <div class="w-full bg-slate-800 dark:bg-slate-800 light:bg-gray-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-rose-500 h-full rounded-full" style="width: 65%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= SECTION 3: INFO CHECK-IN/OUT KAMAR ================= -->
            <div class="bg-slate-900 border border-slate-800 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-800 dark:border-slate-800 light:border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-door-open text-amber-500"></i>
                        <h3 class="text-lg font-bold text-white dark:text-white light:text-slate-900">Aktivitas Kamar Hari Ini</h3>
                    </div>
                    <span class="text-xs text-slate-400 dark:text-slate-400 light:text-gray-500">Real-time update</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-950/40 dark:bg-slate-950/40 light:bg-gray-50/70 border-b border-slate-800 dark:border-slate-800 light:border-gray-100 text-xs font-bold uppercase text-slate-400 dark:text-slate-400 light:text-gray-500 tracking-wider">
                                <th class="p-4">Tamu</th>
                                <th class="p-4">No. Kamar</th>
                                <th class="p-4">Tipe Kamar</th>
                                <th class="p-4">Waktu</th>
                                <th class="p-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800 dark:divide-slate-800 light:divide-gray-100 text-sm font-medium">
                            <!-- Baris 1: Check In -->
                            <tr class="hover:bg-slate-800/30 dark:hover:bg-slate-800/30 light:hover:bg-gray-50/50 transition">
                                <td class="p-4 text-white dark:text-white light:text-slate-900">Farhan Rizky</td>
                                <td class="p-4 text-slate-300 dark:text-slate-300 light:text-slate-700">Room 302</td>
                                <td class="p-4 text-slate-400 dark:text-slate-400 light:text-gray-500">Deluxe Suite</td>
                                <td class="p-4 text-slate-300 dark:text-slate-300 light:text-slate-700">14:00 WIB</td>
                                <td class="p-4 text-center">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-400 light:bg-emerald-50 light:text-emerald-600">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>Check-In
                                    </span>
                                </td>
                            </tr>
                            <!-- Baris 2: Check Out -->
                            <tr class="hover:bg-slate-800/30 dark:hover:bg-slate-800/30 light:hover:bg-gray-50/50 transition">
                                <td class="p-4 text-white dark:text-white light:text-slate-900">Siti Rahmaawati</td>
                                <td class="p-4 text-slate-300 dark:text-slate-300 light:text-slate-700">Room 105</td>
                                <td class="p-4 text-slate-400 dark:text-slate-400 light:text-gray-500">Superior Standard</td>
                                <td class="p-4 text-slate-300 dark:text-slate-300 light:text-slate-700">12:00 WIB</td>
                                <td class="p-4 text-center">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-500/10 text-amber-400 light:bg-amber-50 light:text-amber-600">
                                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>Check-Out
                                    </span>
                                </td>
                            </tr>
                            <!-- Baris 3: Check In -->
                            <tr class="hover:bg-slate-800/30 dark:hover:bg-slate-800/30 light:hover:bg-gray-50/50 transition">
                                <td class="p-4 text-white dark:text-white light:text-slate-900">Michael Owen</td>
                                <td class="p-4 text-slate-300 dark:text-slate-300 light:text-slate-700">Room 412</td>
                                <td class="p-4 text-slate-400 dark:text-slate-400 light:text-gray-500">Presidential Suite</td>
                                <td class="p-4 text-slate-300 dark:text-slate-300 light:text-slate-700">15:30 WIB</td>
                                <td class="p-4 text-center">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-400 light:bg-emerald-50 light:text-emerald-600">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>Check-In
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>


</body>

</html>