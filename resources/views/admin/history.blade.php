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

            <!-- ============================ SECTION HISTORI RESERVASI ========================== -->
            <div class="mt-12 bg-slate-900 border border-slate-800 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200 rounded-2xl p-6 shadow-md">

                <!-- Header Histori & Aksi Utama (Cari & Ekspor) -->
                <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4 mb-6 pb-6 border-b border-slate-800/60 dark:border-slate-800/60 light:border-gray-100">
                    <div>
                        <h2 class="text-xl font-bold text-white dark:text-white light:text-slate-900 flex items-center gap-2">
                            <i class="fas fa-history text-amber-500 text-sm"></i> Histori Pesanan
                        </h2>
                        <p class="text-xs text-slate-400 dark:text-slate-400 light:text-gray-500 mt-0.5">Daftar riwayat transaksi dan reservasi kamar pelanggan.</p>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center gap-3 w-full xl:w-auto">
                        <!-- Form Cari Pesanan -->
                        <div class="relative w-full sm:w-72">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500 text-xs">
                                <i class="fas fa-magnifying-glass"></i>
                            </span>
                            <input type="text" name="search_reservation" placeholder="Cari nama atau nomor hp..." class="w-full pl-9 pr-4 py-2.5 bg-slate-950 border border-slate-800 text-xs text-slate-300 rounded-xl outline-none focus:ring-1 focus:ring-amber-500 dark:bg-slate-950 dark:border-slate-800 light:bg-gray-50 light:border-gray-300 light:text-slate-800">
                        </div>

                        <!-- Tombol Export (Excel / PDF) -->
                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            <button type="button" class="flex-1 sm:flex-none bg-emerald-600/10 hover:bg-emerald-600/20 text-emerald-400 font-semibold px-4 py-2.5 rounded-xl text-xs flex items-center justify-center gap-2 border border-emerald-500/20 transition active:scale-95">
                                <i class="fas fa-file-excel"></i> Export Excel
                            </button>
                            <button type="button" class="flex-1 sm:flex-none bg-rose-600/10 hover:bg-rose-600/20 text-rose-400 font-semibold px-4 py-2.5 rounded-xl text-xs flex items-center justify-center gap-2 border border-rose-500/20 transition active:scale-95">
                                <i class="fas fa-file-pdf"></i> Export PDF
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Statistik Ringkasan / Total Pesanan -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                    <div class="p-4 bg-slate-950/40 border border-slate-800/80 rounded-xl dark:bg-slate-950/40 dark:border-slate-800/80 light:bg-gray-50 light:border-gray-200">
                        <p class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Total Reservasi</p>
                        <p class="text-lg font-bold text-white dark:text-white light:text-slate-900 mt-0.5">1,248 <span class="text-xs font-normal text-slate-500">Pesanan</span></p>
                    </div>
                    <div class="p-4 bg-slate-950/40 border border-slate-800/80 rounded-xl dark:bg-slate-950/40 dark:border-slate-800/80 light:bg-gray-50 light:border-gray-200">
                        <p class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Reservasi Aktif</p>
                        <p class="text-lg font-bold text-sky-400 mt-0.5">42 <span class="text-xs font-normal text-slate-500">Check-In</span></p>
                    </div>
                    <div class="p-4 bg-slate-950/40 border border-slate-800/80 rounded-xl dark:bg-slate-950/40 dark:border-slate-800/80 light:bg-gray-50 light:border-gray-200">
                        <p class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Total Pendapatan</p>
                        <p class="text-lg font-bold text-amber-500 mt-0.5">Rp 458.200.000</p>
                    </div>
                </div>

                <!-- Tabel Pesanan -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-800 dark:border-slate-800 light:border-gray-200 text-[11px] font-semibold text-slate-400 uppercase tracking-wider bg-slate-950/20">
                                <th class="py-3 px-4">Nama Pesanan</th>
                                <th class="py-3 px-4">No HP</th>
                                <th class="py-3 px-4 text-center">No Kamar</th>
                                <th class="py-3 px-4">Kategori</th>
                                <th class="py-3 px-4">Harga /Malam</th>
                                <th class="py-3 px-4">Harga /Malam</th>
                                <th class="py-3 px-4">Harga /Malam</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs text-slate-300 dark:text-slate-300 light:text-slate-700 divide-y divide-slate-800/40 dark:divide-slate-800/40 light:divide-gray-100">

                            <!-- Contoh Baris Data 1 -->
                            <tr class="hover:bg-slate-850/40 dark:hover:bg-slate-850/40 light:hover:bg-gray-50/80 transition">
                                <td class="py-3.5 px-4 font-semibold text-white dark:text-white light:text-slate-900">Ahmad Subarjo</td>
                                <td class="py-3.5 px-4 font-mono text-slate-400 light:text-slate-600">0812-3456-7890</td>
                                <td class="py-3.5 px-4 text-center"><span class="bg-slate-800 text-slate-200 px-2 py-0.5 rounded font-bold light:bg-gray-100 light:text-slate-700">102</span></td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-teal-400/10 text-teal-400">Superior</span>
                                </td>
                                <td class="py-3.5 px-4 font-medium text-amber-500">Rp 450.000</td>
                                <td class="py-3.5 px-4 text-center">
                                    <form action="#" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat pesanan ini? Tindakan ini tidak dapat dibatalkan.')" class="inline-block">
                                        <button type="submit" class="p-1.5 bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white rounded-lg transition" title="Hapus Riwayat">
                                            <i class="fas fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Contoh Baris Data 2 -->
                            <tr class="hover:bg-slate-850/40 dark:hover:bg-slate-850/40 light:hover:bg-gray-50/80 transition">
                                <td class="py-3.5 px-4 font-semibold text-white dark:text-white light:text-slate-900">Clara Anastasya</td>
                                <td class="py-3.5 px-4 font-mono text-slate-400 light:text-slate-600">0857-9988-1122</td>
                                <td class="py-3.5 px-4 text-center"><span class="bg-slate-800 text-slate-200 px-2 py-0.5 rounded font-bold light:bg-gray-100 light:text-slate-700">305</span></td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-purple-500/10 text-purple-400">Deluxe</span>
                                </td>
                                <td class="py-3.5 px-4 font-medium text-amber-500">Rp 750.000</td>
                                <td class="py-3.5 px-4 text-center">
                                    <form action="#" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat pesanan ini? Tindakan ini tidak dapat dibatalkan.')" class="inline-block">
                                        <button type="submit" class="p-1.5 bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white rounded-lg transition" title="Hapus Riwayat">
                                            <i class="fas fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Contoh Baris Data 3 -->
                            <tr class="hover:bg-slate-850/40 dark:hover:bg-slate-850/40 light:hover:bg-gray-50/80 transition">
                                <td class="py-3.5 px-4 font-semibold text-white dark:text-white light:text-slate-900">Budi Santoso</td>
                                <td class="py-3.5 px-4 font-mono text-slate-400 light:text-slate-600">0821-4433-5566</td>
                                <td class="py-3.5 px-4 text-center"><span class="bg-slate-800 text-slate-200 px-2 py-0.5 rounded font-bold light:bg-gray-100 light:text-slate-700">210</span></td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-orange-400/10 text-orange-400">Suite</span>
                                </td>
                                <td class="py-3.5 px-4 font-medium text-amber-500">Rp 1.200.000</td>
                                <td class="py-3.5 px-4 text-center">
                                    <form action="#" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat pesanan ini? Tindakan ini tidak dapat dibatalkan.')" class="inline-block">
                                        <button type="submit" class="p-1.5 bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white rounded-lg transition" title="Hapus Riwayat">
                                            <i class="fas fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <!-- Pagination Sederhana (Opsional untuk estetika tabel data) -->
                <div class="flex items-center justify-between mt-5 pt-4 border-t border-slate-800/60 dark:border-slate-800/60 light:border-gray-100 text-xs text-slate-400">
                    <p>Menampilkan 1-3 dari 1,248 data</p>
                    <div class="flex items-center gap-1">
                        <button class="p-2 bg-slate-950 border border-slate-800 rounded-lg hover:text-white disabled:opacity-50"><i class="fas fa-chevron-left"></i></button>
                        <button class="p-2 bg-slate-950 border border-slate-800 rounded-lg hover:text-white"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>

            </div>

        </main>
    </div>


</body>

</html>