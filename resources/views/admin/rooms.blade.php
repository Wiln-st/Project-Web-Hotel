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
                    <h3 class="text-2xl font-bold text-white dark:text-white light:text-slate-900 mt-2">{{$availableRooms}} <span class="text-xs font-normal text-slate-500">Kamar</span></h3>
                </div>
                <!-- Penuh -->
                <div class="bg-slate-900 border border-slate-800 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200 p-5 rounded-xl shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Penuh</p>
                        <span class="p-1.5 bg-rose-500/10 text-rose-400 rounded-lg text-xs"><i class="fas fa-door-closed"></i></span>
                    </div>
                    <h3 class="text-2xl font-bold text-white dark:text-white light:text-slate-900 mt-2">{{$fullRooms}} <span class="text-xs font-normal text-slate-500">Kamar</span></h3>
                </div>
                <!-- Dipesan -->
                <div class="bg-slate-900 border border-slate-800 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200 p-5 rounded-xl shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Dipesan</p>
                        <span class="p-1.5 bg-sky-500/10 text-sky-400 rounded-lg text-xs"><i class="fas fa-bookmark"></i></span>
                    </div>
                    <h3 class="text-2xl font-bold text-white dark:text-white light:text-slate-900 mt-2">{{$bookedRooms}} <span class="text-xs font-normal text-slate-500">Kamar</span></h3>
                </div>
                <!-- Maintenance -->
                <div class="bg-slate-900 border border-slate-800 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200 p-5 rounded-xl shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pemeliharaan</p>
                        <span class="p-1.5 bg-amber-500/10 text-amber-400 rounded-lg text-xs"><i class="fas fa-screwdriver-wrench"></i></span>
                    </div>
                    <h3 class="text-2xl font-bold text-white dark:text-white light:text-slate-900 mt-2">{{$maintenanceRooms}} <span class="text-xs font-normal text-slate-500">Kamar</span></h3>
                </div>
            </div>

            <!-- ================= BAR FILTER DATA (KATEGORI & STATUS) ================= -->
            <div class="bg-slate-900 border border-slate-800 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200 p-4 rounded-2xl mb-8 flex flex-col sm:flex-row gap-4 items-center justify-between">
                <div class="flex items-center gap-2 self-start sm:self-auto">
                    <span class="p-2 bg-slate-800 text-slate-400 dark:bg-slate-800 light:bg-gray-100 light:text-slate-500 rounded-xl text-sm">
                        <i class="fas fa-filter"></i>
                    </span>
                    <p class="text-sm font-semibold text-slate-300 dark:text-slate-300 light:text-slate-700">Filter Data</p>
                </div>
                    <div class="grid grid-cols-2 gap-3 w-full sm:w-auto">
                        <!-- Filter Kategori Kamar -->
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500 text-xs">
                                <i class="fas fa-layer-group"></i>
                            </span>
                            <select name="filter_kategori" onchange="this.form.submit()" class="w-full sm:w-48 pl-9 pr-8 py-2 bg-slate-950 border border-slate-800 text-xs text-slate-300 rounded-xl outline-none focus:ring-1 focus:ring-amber-500 dark:bg-slate-950 dark:border-slate-800 light:bg-gray-50 light:border-gray-300 light:text-slate-800 cursor-pointer appearance-none">
                                <option value="">Semua Kategori</option>
                                <option value="Superior">Superior</option>
                                <option value="Deluxe">Deluxe</option>
                                <option value="Suite">Suite</option>
                            </select>
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-[10px] text-slate-500">
                                <i class="fas fa-chevron-down"></i>
                            </span>
                        </div>

                        <!-- Filter Status Kamar -->
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500 text-xs">
                                <i class="fas fa-circle-info"></i>
                            </span>
                            <select name="filter_status" onchange="this.form.submit()" class="w-full sm:w-48 pl-9 pr-8 py-2 bg-slate-950 border border-slate-800 text-xs text-slate-300 rounded-xl outline-none focus:ring-1 focus:ring-amber-500 dark:bg-slate-950 dark:border-slate-800 light:bg-gray-50 light:border-gray-300 light:text-slate-800 cursor-pointer appearance-none">
                                <option value="">Semua Status</option>
                                <option value="tersedia">Tersedia</option>
                                <option value="penuh">Penuh</option>
                                <option value="dipesan">Dipesan</option>
                                <option value="pemeliharaan">Pemeliharaan</option>
                            </select>
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-[10px] text-slate-500">
                                <i class="fas fa-chevron-down"></i>
                            </span>
                        </div>
                    </div>

            </div>

            <!-- ================= GRID DATA KAMAR ================= -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($rooms as $room)

                <!-- Card Kamar 1 (Status: Terisi / Penuh) -->
                <div class="bg-slate-900 border border-slate-800 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200 rounded-2xl overflow-visible shadow-md relative group">
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <span class="text-2xl font-extrabold text-white dark:text-white light:text-slate-900">Kamar {{ $room->room_number }}</span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-md
                                    @if($room->roomType->name == 'Deluxe')
                                        bg-purple-500/10 text-purple-400
                                    @elseif($room->roomType->name == 'Superior')
                                        bg-teal-400/10 text-teal-400
                                    @else
                                        bg-yellow-400/10 text-yellow-400
                                    @endif
                                    ">
                                    {{ $room->roomType->name }}
                                </span>
                            </div>

                            <!-- Dropdown Titik Tiga -->
                            <div class="relative">
                                <button onclick="toggleActionMenu('menu{{ $room->id }}')" class="text-slate-400 hover:text-white light:hover:text-slate-900 p-1"><i class="fas fa-ellipsis-v"></i></button>
                                <div id="menu{{ $room->id }}" class="hidden absolute right-0 mt-2 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-xl z-30 py-1 text-sm text-slate-200 dark:bg-slate-800 dark:border-slate-700 light:bg-white light:border-gray-200 light:text-slate-700">
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
                                            <button class="flex items-center w-full px-4 py-2 hover:bg-slate-800 dark:hover:bg-slate-900 light:hover:bg-gray-100 text-xs font-semibold text-emerald-400">
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
                                    <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kamar ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex items-center w-full px-4 py-2 text-red-400 hover:bg-red-500/10"><i class="fas fa-trash-can w-5"></i> Hapus Kamar</button>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <div class="border-t border-slate-800/60 dark:border-slate-800/60 light:border-gray-100 pt-3 mt-4 flex justify-between items-center">
                            <span class="text-sm font-bold text-amber-500">Rp {{ number_format($room->roomType->price, 0, ',', '.') }}<span class="text-xs font-normal text-slate-500">/malam</span></span>
                            <span class="px-2.5 py-1 text-xs font-bold rounded-md
                            @if($room->status == 'tersedia')
                                bg-green-500/10 text-green-400

                            @elseif($room->status == 'penuh')
                                bg-red-500/10 text-red-400

                            @elseif($room->status == 'dipesan')
                                bg-sky-500/10 text-sky-400

                            @else
                                bg-amber-500/10 text-amber-400
                            @endif">
                                {{ ucfirst($room->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                @endforeach
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
            <form action="{{ route('rooms.store') }}" method="POST" class="p-6 space-y-4">
                @csrf

                <!-- Input Nomor Kamar -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5 uppercase tracking-wider">Nomor Kamar</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500">
                            <i class="fas fa-door-closed"></i>
                        </span>
                        <input type="number" id="inputNoKamar" name="room_number" required min="1"
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-800 border border-slate-700 text-white rounded-lg outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-700 dark:text-white light:bg-gray-50 light:border-gray-300 light:text-slate-900"
                            placeholder="Contoh: Room 004">
                    </div>
                </div>

                <!-- Select Tipe Kamar -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5 uppercase tracking-wider">Tipe Kamar</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500">
                            <i class="fas fa-layer-group"></i>
                        </span>
                        <select id="inputTipeKamar" name="room_type_id" required
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-800 border border-slate-700 text-white rounded-lg outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-700 dark:text-white light:bg-gray-50 light:border-gray-300 light:text-slate-900 cursor-pointer">
                            <option value="" disabled selected>Pilih Tipe Kamar</option>
                            @foreach($types as $type)
                            <option value="{{ $type->id }}">
                                {{ $type->name }}
                            </option>
                            @endforeach
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
                        <select id="inputStatusKamar" name="status" required
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-800 border border-slate-700 text-white rounded-lg outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-700 dark:text-white light:bg-gray-50 light:border-gray-300 light:text-slate-900 cursor-pointer">
                            <option value="tersedia">Tersedia</option>
                            <option value="penuh">Penuh</option>
                            <option value="dipesan">Dipesan</option>
                            <option value="pemeliharaan">Pemeliharaan (Maintenance)</option>
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