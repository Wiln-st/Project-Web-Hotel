<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrandStay - Kelola Karyawan</title>
    @vite('resources/css/app.css')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-slate-950 text-slate-100 min-h-screen font-sans antialiased transition-colors duration-300 dark:bg-slate-950 light:bg-gray-50 light:text-slate-800">
    @include('admin.partials.sidebar')
    
    <div class="flex min-h-screen">

        <!-- ================= MAIN CONTENT ================= -->
        <main class="flex-1 ml-64 p-8 lg:p-10 overflow-y-auto">
            
            <!-- Header Halaman -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-white dark:text-white light:text-slate-900">Kelola Karyawan</h1>
                    <p class="text-sm text-slate-400 dark:text-slate-400 light:text-gray-500 mt-1">Manajemen hak akses, pembuatan akun baru, dan kontrol status aktif staf hotel.</p>
                </div>
                
                <!-- Tombol Refresh Status Karyawan -->
                <div>
                    <button type="button" onclick="refreshStatus()" class="w-full md:w-auto bg-slate-800 hover:bg-slate-750 text-slate-200 font-semibold px-5 py-2.5 rounded-xl border border-slate-700 transition flex items-center justify-center gap-2 text-sm shadow-sm">
                        <i class="fas fa-sync-alt text-amber-500"></i> Refresh Status Karyawan
                    </button>
                </div>
            </div>

            <!-- Grid Layout Form & Tabel -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- KIRI: Form Membuat Akun Baru (1 Kolom) -->
                <div class="bg-slate-900 border border-slate-800 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200 p-6 rounded-2xl shadow-sm h-fit">
                    <h3 class="text-lg font-bold text-white dark:text-white light:text-slate-900 mb-4 pb-3 border-b border-slate-800 dark:border-slate-800 light:border-gray-100">
                        <i class="fas fa-user-plus text-amber-500 mr-2"></i>Tambah Karyawan
                    </h3>
                    
                    <!-- Form input (Action kosong untuk diisi route Laravel Anda) -->
                    <form action="#" method="POST" class="space-y-4">
                        <!-- Nama -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">Nama Lengkap</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500"><i class="fas fa-user text-xs"></i></span>
                                <input type="text" name="name" required class="w-full pl-9 pr-4 py-2 bg-slate-800 border border-slate-700 text-white text-sm rounded-lg outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-700 dark:text-white light:bg-gray-50 light:border-gray-300 light:text-slate-900" placeholder="Nama Karyawan">
                            </div>
                        </div>

                        <!-- No HP -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">No. Handphone</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500"><i class="fas fa-phone text-xs"></i></span>
                                <input type="tel" name="phone" required class="w-full pl-9 pr-4 py-2 bg-slate-800 border border-slate-700 text-white text-sm rounded-lg outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-700 dark:text-white light:bg-gray-50 light:border-gray-300 light:text-slate-900" placeholder="08xxxxxxxxxx">
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">Email Resmi</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500"><i class="fas fa-envelope text-xs"></i></span>
                                <input type="email" name="email" required class="w-full pl-9 pr-4 py-2 bg-slate-800 border border-slate-700 text-white text-sm rounded-lg outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-700 dark:text-white light:bg-gray-50 light:border-gray-300 light:text-slate-900" placeholder="staf@grandstay.com">
                            </div>
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">Password</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500"><i class="fas fa-lock text-xs"></i></span>
                                <input type="password" name="password" required class="w-full pl-9 pr-4 py-2 bg-slate-800 border border-slate-700 text-white text-sm rounded-lg outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-700 dark:text-white light:bg-gray-50 light:border-gray-300 light:text-slate-900" placeholder="••••••••">
                            </div>
                        </div>

                        <!-- Button Submit -->
                        <div class="pt-2">
                            <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-slate-900 font-extrabold py-2.5 rounded-xl shadow-md shadow-amber-500/10 transition flex items-center justify-center gap-2 text-sm">
                                <i class="fas fa-plus-circle"></i> Daftarkan Karyawan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- KANAN: Tabel Data Karyawan (Mengambil 2 Kolom) -->
                <div class="lg:col-span-2 bg-slate-900 border border-slate-800 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="p-6 pb-4 border-b border-slate-800 dark:border-slate-800 light:border-gray-100 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-white dark:text-white light:text-slate-900">
                            <i class="fas fa-users text-amber-500 mr-2"></i>Daftar Staf Aktif
                        </h3>
                        <span class="text-xs bg-slate-800 text-slate-400 px-2.5 py-1 rounded-full font-medium dark:bg-slate-800 light:bg-gray-100 light:text-gray-600">3 Terdaftar</span>
                    </div>

                    <!-- Area Tabel Responsif -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-800/80 dark:border-slate-800/80 light:border-gray-100 bg-slate-950/20 text-slate-400 text-xs uppercase font-bold tracking-wider">
                                    <th class="py-4 px-6">Nama</th>
                                    <th class="py-4 px-6">No. HP</th>
                                    <th class="py-4 px-6">Email</th>
                                    <th class="py-4 px-6 text-center">Status</th>
                                    <th class="py-4 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800/50 dark:divide-slate-800/50 light:divide-gray-100 text-sm">
                                
                                <!-- Baris Karyawan 1 (Active) -->
                                <tr class="hover:bg-slate-850/30 dark:hover:bg-slate-850/30 light:hover:bg-gray-50/80 transition">
                                    <td class="py-4 px-6 font-semibold text-white dark:text-white light:text-slate-800">Ahmad Subarjo</td>
                                    <td class="py-4 px-6 text-slate-300 dark:text-slate-300 light:text-slate-600">081234567890</td>
                                    <td class="py-4 px-6 text-slate-400 dark:text-slate-400 light:text-gray-500">ahmad@grandstay.com</td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                            Active
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <button type="button" onclick="konfirmasiHapus('Ahmad Subarjo')" class="text-slate-500 hover:text-red-400 p-2 rounded-lg hover:bg-red-500/10 transition" title="Hapus Karyawan">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Baris Karyawan 2 (Active) -->
                                <tr class="hover:bg-slate-850/30 dark:hover:bg-slate-850/30 light:hover:bg-gray-50/80 transition">
                                    <td class="py-4 px-6 font-semibold text-white dark:text-white light:text-slate-800">Siti Nurhaliza</td>
                                    <td class="py-4 px-6 text-slate-300 dark:text-slate-300 light:text-slate-600">085712345678</td>
                                    <td class="py-4 px-6 text-slate-400 dark:text-slate-400 light:text-gray-500">siti.n@grandstay.com</td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                            Active
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <button type="button" onclick="konfirmasiHapus('Siti Nurhaliza')" class="text-slate-500 hover:text-red-400 p-2 rounded-lg hover:bg-red-500/10 transition" title="Hapus Karyawan">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Baris Karyawan 3 (Non-Active) -->
                                <tr class="hover:bg-slate-850/30 dark:hover:bg-slate-850/30 light:hover:bg-gray-50/80 transition">
                                    <td class="py-4 px-6 font-semibold text-white dark:text-white light:text-slate-800">Budi Santoso</td>
                                    <td class="py-4 px-6 text-slate-300 dark:text-slate-300 light:text-slate-600">089987654321</td>
                                    <td class="py-4 px-6 text-slate-400 dark:text-slate-400 light:text-gray-500">budi.s@grandstay.com</td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-800 text-slate-400 border border-slate-700 dark:bg-slate-800 dark:text-slate-400 light:bg-gray-100 light:text-gray-400 light:border-gray-200">
                                            Non-Active
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <button type="button" onclick="konfirmasiHapus('Budi Santoso')" class="text-slate-500 hover:text-red-400 p-2 rounded-lg hover:bg-red-500/10 transition" title="Hapus Karyawan">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- ================= JAVASCRIPT SYSTEM ================= -->
    <script>
        // Fungsi simulasi tombol Refresh Status Karyawan
        function refreshStatus() {
            // Tempatkan pemanggilan AJAX / reload halaman Laravel Anda di sini
            alert("Sistem sedang menyinkronkan status aktivitas seluruh karyawan...");
        }

        // Fungsi Alert Konfirmasi Hapus Karyawan
        function konfirmasiHapus(namaKaryawan) {
            const setuju = confirm(`Apakah Anda yakin ingin menghapus akun karyawan "${namaKaryawan}" secara permanen?\nTindakan ini tidak dapat dibatalkan.`);
            
            if (setuju) {
                // Eksekusi form/request hapus data dari Laravel Anda di sini
                alert(`Akun untuk ${namaKaryawan} berhasil dihapus.`);
            }
        }
    </script>
</body>

</html>