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

<body class="bg-slate-950 text-slate-100 min-h-screen font-sans antialiased transition-colors duration-300 dark:bg-slate-950 light:bg-gray-50 light:text-slate-800">
    @include('admin.partials.sidebar')
    <div class="flex min-h-screen">
        <!-- ================= MAIN CONTENT ================= -->
        <main class="flex-1 ml-64 p-8 lg:p-10 overflow-y-auto">

            <!-- Header & Role Selector (Untuk Simulasi Demo Admin vs Employee) -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-white dark:text-white light:text-slate-900">Kelola Kamar</h1>
                    <p class="text-sm text-slate-400 dark:text-slate-400 light:text-gray-500 mt-1">Manajemen status ketersediaan, reservasi, dan pemeliharaan kamar.</p>
                </div>

                <!-- Tombol Tambah Kamar (Hanya Admin) -->
                <button id="btnTambahKamar" onclick="openModal('tambahKamarModal')" class="bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold px-4 py-2.5 rounded-xl text-sm flex items-center gap-2 shadow-lg shadow-amber-500/10 transition transform active:scale-95">
                    <i class="fas fa-plus"></i> Tambah Kamar
                </button>
            </div>

            <!-- ================= STATUS SUMMARY COUNTER ================= -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <!-- Tersedia -->
                <div class="bg-slate-900 border border-slate-800 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200 p-5 rounded-xl shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tersedia</p>
                        <span class="p-1.5 bg-emerald-500/10 text-emerald-400 rounded-lg text-xs"><i class="fas fa-check"></i></span>
                    </div>
                    <h3 class="text-2xl font-bold text-white dark:text-white light:text-slate-900 mt-2">24 <span class="text-xs font-normal text-slate-500">Kamar</span></h3>
                </div>
                <!-- Penuh -->
                <div class="bg-slate-900 border border-slate-800 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200 p-5 rounded-xl shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Penuh</p>
                        <span class="p-1.5 bg-rose-500/10 text-rose-400 rounded-lg text-xs"><i class="fas fa-door-closed"></i></span>
                    </div>
                    <h3 class="text-2xl font-bold text-white dark:text-white light:text-slate-900 mt-2">12 <span class="text-xs font-normal text-slate-500">Kamar</span></h3>
                </div>
                <!-- Dipesan -->
                <div class="bg-slate-900 border border-slate-800 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200 p-5 rounded-xl shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Dipesan</p>
                        <span class="p-1.5 bg-sky-500/10 text-sky-400 rounded-lg text-xs"><i class="fas fa-bookmark"></i></span>
                    </div>
                    <h3 class="text-2xl font-bold text-white dark:text-white light:text-slate-900 mt-2">8 <span class="text-xs font-normal text-slate-500">Kamar</span></h3>
                </div>
                <!-- Maintenance -->
                <div class="bg-slate-900 border border-slate-800 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200 p-5 rounded-xl shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pemeliharaan</p>
                        <span class="p-1.5 bg-amber-500/10 text-amber-400 rounded-lg text-xs"><i class="fas fa-screwdriver-wrench"></i></span>
                    </div>
                    <h3 class="text-2xl font-bold text-white dark:text-white light:text-slate-900 mt-2">3 <span class="text-xs font-normal text-slate-500">Kamar</span></h3>
                </div>
            </div>

            <!-- ================= GRID DATA KAMAR ================= -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                <!-- Card Kamar 1 (Status: Terisi / Penuh) -->
                <div class="bg-slate-900 border border-slate-800 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200 rounded-2xl overflow-visible shadow-md relative group">
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <span class="text-2xl font-extrabold text-white dark:text-white light:text-slate-900">Room 101</span>
                                <p class="text-xs text-slate-400 dark:text-slate-400 light:text-gray-500 font-medium">Deluxe King Bed</p>
                            </div>

                            <!-- Dropdown Titik Tiga -->
                            <div class="relative">
                                <button onclick="toggleActionMenu('menu1')" class="text-slate-400 hover:text-white light:hover:text-slate-900 p-1"><i class="fas fa-ellipsis-v"></i></button>
                                <div id="menu1" class="hidden absolute right-0 mt-2 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-xl z-30 py-1 text-sm text-slate-200 dark:bg-slate-800 dark:border-slate-700 light:bg-white light:border-gray-200 light:text-slate-700">
                                    <button onclick="openModal('infoModal')" class="flex items-center w-full px-4 py-2 hover:bg-slate-900 dark:hover:bg-slate-900 light:hover:bg-gray-100"><i class="fas fa-info-circle w-5 text-amber-500"></i> Info Kamar</button>
                                    <!-- Set Status (Dengan Submenu / Hover Group) -->
                                    <div class="relative group/submenu">
                                        <button class="flex items-center justify-between w-full px-4 py-2.5 hover:bg-slate-800 dark:hover:bg-slate-900 light:hover:bg-gray-100 transition">
                                            <span class="flex items-center">
                                                <i class="fas fa-sliders w-5 text-sky-500"></i> Set Status
                                            </span>
                                            <i class="fas fa-chevron-right text-[10px] text-slate-400"></i>
                                        </button>

                                        <!-- SUBMENU PILIHAN STATUS (Muncul saat menu 'Set Status' di-hover) -->
                                        <div class="absolute left-full top-0 ml-1 hidden group-hover/submenu:block w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl py-1 dark:bg-slate-850 dark:border-slate-700 light:bg-white light:border-gray-200">
                                            <button  class="flex items-center w-full px-4 py-2 hover:bg-slate-800 dark:hover:bg-slate-900 light:hover:bg-gray-100 text-xs font-semibold text-emerald-400">
                                                <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></span> Tersedia
                                            </button>
                                            <button class="flex items-center w-full px-4 py-2 hover:bg-slate-800 dark:hover:bg-slate-900 light:hover:bg-gray-100 text-xs font-semibold text-rose-400">
                                                <span class="w-2 h-2 bg-rose-500 rounded-full mr-2"></span> Penuh
                                            </button>
                                            <button class="flex items-center w-full px-4 py-2 hover:bg-slate-800 dark:hover:bg-slate-900 light:hover:bg-gray-100 text-xs font-semibold text-sky-400">
                                                <span class="w-2 h-2 bg-sky-500 rounded-full mr-2"></span> Dipesan
                                            </button>
                                            <button class="flex items-center w-full px-4 py-2 hover:bg-slate-800 dark:hover:bg-slate-900 light:hover:bg-gray-100 text-xs font-semibold text-amber-400">
                                                <span class="w-2 h-2 bg-amber-500 rounded-full mr-2"></span> Pemeliharaan
                                            </button>
                                        </div>
                                    </div>
                                    <button class="flex items-center w-full px-4 py-2 hover:bg-slate-900 dark:hover:bg-slate-900 light:hover:bg-gray-100"><i class="fas fa-calendar-plus w-5 text-emerald-500"></i> Booking</button>
                                    <button id="deleteOpt1" class="flex items-center w-full px-4 py-2 text-red-400 hover:bg-red-500/10 btn-hapus-kamar"><i class="fas fa-trash-can w-5"></i> Hapus Kamar</button>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-slate-800/60 dark:border-slate-800/60 light:border-gray-100 pt-3 mt-4 flex justify-between items-center">
                            <span class="text-sm font-bold text-amber-500">Rp 750,000<span class="text-xs font-normal text-slate-500">/malam</span></span>
                            <span class="px-2.5 py-1 text-xs font-bold rounded-md bg-rose-500/10 text-rose-400">Penuh</span>
                        </div>
                    </div>
                </div>



            </div>
        </main>
    </div>

    <!-- ================= MODAL 1: INFO KAMAR ================= -->
    <div id="infoModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-slate-900 border border-slate-800 rounded-2xl max-w-md w-full overflow-hidden shadow-2xl animate-in fade-in zoom-in-95 duration-200 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200">
            <div class="p-6 border-b border-slate-800 dark:border-slate-800 light:border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white dark:text-white light:text-slate-900"><i class="fas fa-circle-info text-amber-500 mr-2"></i>Detail Informasi Kamar</h3>
                <button onclick="closeModal('infoModal')" class="text-slate-400 hover:text-white light:hover:text-slate-900"><i class="fas fa-xmark text-lg"></i></button>
            </div>
            <div class="p-6 space-y-4 text-sm">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-slate-400">Nomor Kamar</p>
                        <p class="font-bold text-white dark:text-white light:text-slate-900 mt-0.5">Room 101</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Kategori</p>
                        <p class="font-bold text-white dark:text-white light:text-slate-900 mt-0.5">Deluxe King Bed</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Harga Sewa</p>
                        <p class="font-bold text-amber-500 mt-0.5">Rp 750,000 /malam</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Status Kamar</p>
                        <span class="inline-block mt-1 px-2 py-0.5 text-xs font-bold rounded bg-rose-500/10 text-rose-400">Penuh (In Use)</span>
                    </div>
                </div>
                <div class="pt-3 border-t border-slate-800 dark:border-slate-800 light:border-gray-100">
                    <p class="text-xs text-slate-400">Nama Pemesan</p>
                    <p class="font-bold text-white dark:text-white light:text-slate-900 mt-0.5">Andika Pratama Mulia</p>
                </div>
            </div>
            <div class="p-4 bg-slate-950/40 dark:bg-slate-950/40 light:bg-gray-50 border-t border-slate-800 dark:border-slate-800 light:border-gray-100 flex justify-end gap-3">
                <button onclick="closeModal('infoModal')" class="px-4 py-2 bg-slate-800 text-slate-300 rounded-lg text-xs font-semibold hover:bg-slate-700 light:bg-gray-200 light:text-slate-700 light:hover:bg-gray-300">Tutup</button>
                <button onclick="switchModal('infoModal', 'editPesananModal')" class="px-4 py-2 bg-amber-500 text-slate-900 rounded-lg text-xs font-bold hover:bg-amber-600 flex items-center gap-1.5"><i class="fas fa-pen-to-square"></i> Edit Pesanan</button>
            </div>
        </div>
    </div>


    <!-- ================= MODAL: TAMBAH KAMAR ================= -->
    <div id="tambahKamarModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-slate-900 border border-slate-800 rounded-2xl max-w-md w-full overflow-hidden shadow-2xl transition-all duration-300 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200">

            <!-- Modal Header -->
            <div class="p-6 border-b border-slate-800 dark:border-slate-800 light:border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white dark:text-white light:text-slate-900">
                    <i class="fas fa-bed text-amber-500 mr-2"></i>Tambah Kamar Baru
                </h3>
                <button onclick="closeModal('tambahKamarModal')" class="text-slate-400 hover:text-white light:hover:text-slate-900">
                    <i class="fas fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Modal Form -->
            <form class="p-6 space-y-4">

                <!-- Input Nomor Kamar -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5 uppercase tracking-wider">Nomor Kamar</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500">
                            <i class="fas fa-door-closed"></i>
                        </span>
                        <input type="number" id="inputNoKamar" required
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-800 border border-slate-700 text-white rounded-lg outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-700 dark:text-white light:bg-gray-50 light:border-gray-300 light:text-slate-900"
                            placeholder="Contoh: Room 204">
                    </div>
                </div>

                <!-- Select Tipe Kamar -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5 uppercase tracking-wider">Tipe Kamar</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500">
                            <i class="fas fa-layer-group"></i>
                        </span>
                        <select id="inputTipeKamar" required
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-800 border border-slate-700 text-white rounded-lg outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-700 dark:text-white light:bg-gray-50 light:border-gray-300 light:text-slate-900 cursor-pointer">
                            <option value="" disabled selected>Pilih Tipe Kamar</option>
                            <option value="Superior">Superior</option>
                            <option value="Deluxe">Deluxe</option>
                            <option value="Premium">Premium</option>
                        </select>
                    </div>
                </div>

                <!-- Select Status Awal -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5 uppercase tracking-wider">Status Awal</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500">
                            <i class="fas fa-circle-info"></i>
                        </span>
                        <select id="inputStatusKamar" required
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-800 border border-slate-700 text-white rounded-lg outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-700 dark:text-white light:bg-gray-50 light:border-gray-300 light:text-slate-900 cursor-pointer">
                            <option value="Tersedia">Tersedia</option>
                            <option value="Penuh">Penuh</option>
                            <option value="Dipesan">Dipesan</option>
                            <option value="Pemeliharaan">Pemeliharaan (Maintenance)</option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-800 dark:border-slate-800 light:border-gray-100">
                    <button type="button" onclick="closeModal('tambahKamarModal')"
                        class="px-4 py-2.5 bg-slate-800 text-slate-300 rounded-lg text-xs font-semibold hover:bg-slate-700 light:bg-gray-200 light:text-slate-700 light:hover:bg-gray-300 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-amber-500 text-slate-900 rounded-lg text-xs font-bold hover:bg-amber-600 shadow-lg shadow-amber-500/10 transition transform active:scale-95 flex items-center gap-2">
                        <i class="fas fa-save"></i> Simpan Kamar
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- ================= JAVASCRIPT LOGIKAL INTERAKTIF ================= -->
    <script>
        // 1. Fungsi Toggle Dropdown Menu Titik Tiga
        function toggleActionMenu(id) {
            // Tutup menu lain yang sedang terbuka
            const menus = document.querySelectorAll('[id^="menu"]');
            menus.forEach(menu => {
                if (menu.id !== id) menu.classList.add('hidden');
            });
            document.getElementById(id).classList.toggle('hidden');
        }

        // Tutup dropdown otomatis jika klik di luar area card
        window.addEventListener('click', function(e) {
            if (!e.target.closest('.relative')) {
                document.querySelectorAll('[id^="menu"]').forEach(m => m.classList.add('hidden'));
            }
        });

        // 2. Fungsi Kontrol Modal Pop Up

        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        function switchModal(closeId, openId) {
            closeModal(closeId);
            openModal(openId);
        }
    </script>
</body>

</html>