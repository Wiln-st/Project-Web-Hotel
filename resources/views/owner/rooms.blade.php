<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrandStay</title>
    <!-- Tailwind CSS -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    @vite('resources/css/app.css')
    @include('partials.fouc-script')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-slate-950 text-slate-100 min-h-screen font-sans antialiased transition-colors duration-300 dark:bg-slate-950 light:bg-gray-50 light:text-slate-800">
    @include('owner.partials.sidebar')
    <div class="flex min-h-screen">
        <!-- ================= MAIN CONTENT ================= -->
        <main class="flex-1 ml-64 p-8 lg:p-10 overflow-y-auto">

            <!-- Header & Role Selector (Untuk Simulasi Demo owner vs Employee) -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-white dark:text-white light:text-slate-900">Kelola Kamar</h1>
                    <p class="text-sm text-slate-400 dark:text-slate-400 light:text-gray-500 mt-1">Manajemen status ketersediaan, reservasi, dan pemeliharaan kamar.</p>
                </div>
            </div>

            <!-- ================= STATUS SUMMARY COUNTER ================= -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <!-- Tersedia -->
                <div class="bg-slate-900 border border-slate-800 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200 p-5 rounded-xl shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Available</p>
                        <span class="p-1.5 bg-emerald-500/10 text-emerald-400 rounded-lg text-xs"><i class="fas fa-check"></i></span>
                    </div>
                    <h3 class="text-2xl font-bold text-white dark:text-white light:text-slate-900 mt-2">{{$availableRooms}} <span class="text-xs font-normal text-slate-500">Kamar</span></h3>
                </div>
                <!-- Penuh -->
                <div class="bg-slate-900 border border-slate-800 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200 p-5 rounded-xl shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Occupied</p>
                        <span class="p-1.5 bg-rose-500/10 text-rose-400 rounded-lg text-xs"><i class="fas fa-door-closed"></i></span>
                    </div>
                    <h3 class="text-2xl font-bold text-white dark:text-white light:text-slate-900 mt-2">{{$fullRooms}} <span class="text-xs font-normal text-slate-500">Kamar</span></h3>
                </div>
                <!-- Dipesan -->
                <div class="bg-slate-900 border border-slate-800 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200 p-5 rounded-xl shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Booked</p>
                        <span class="p-1.5 bg-sky-500/10 text-sky-400 rounded-lg text-xs"><i class="fas fa-bookmark"></i></span>
                    </div>
                    <h3 class="text-2xl font-bold text-white dark:text-white light:text-slate-900 mt-2">{{$bookedRooms}} <span class="text-xs font-normal text-slate-500">Kamar</span></h3>
                </div>
                <!-- Maintenance -->
                <div class="bg-slate-900 border border-slate-800 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200 p-5 rounded-xl shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Maintenance</p>
                        <span class="p-1.5 bg-amber-500/10 text-amber-400 rounded-lg text-xs"><i class="fas fa-screwdriver-wrench"></i></span>
                    </div>
                    <h3 class="text-2xl font-bold text-white dark:text-white light:text-slate-900 mt-2">{{$maintenanceRooms}} <span class="text-xs font-normal text-slate-500">Kamar</span></h3>
                </div>
            </div>

            <!-- ================= BAR FILTER DATA (KATEGORI & STATUS) ================= -->

            <form action="{{ route('owner.rooms.index') }}" method="GET">

                <div class="bg-slate-900 border border-slate-800 p-4 rounded-2xl mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                    <!-- LEFT SIDE -->
                    <div class="flex items-center gap-2">
                        <span class="p-2 bg-slate-800 text-slate-400 rounded-xl text-sm">
                            <i class="fas fa-filter"></i>
                        </span>
                        <p class="text-sm font-semibold text-slate-300">Filter Data</p>
                    </div>

                    <!-- RIGHT SIDE -->
                    <div class="flex flex-col sm:flex-row items-center gap-3">

                        <!-- BUTTON TAMBAH KAMAR -->
                        <button type="button"
                            data-url="{{ route('owner.rooms.index') }}"
                            onclick="window.location.href=this.dataset.url"
                            class="bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold px-4 py-2.5 rounded-xl text-sm flex items-center gap-2">
                            <i class="fas fa-arrow-rotate-left"></i>
                        </button>

                        <!-- FILTER KATEGORI -->
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500 text-xs">
                                <i class="fas fa-layer-group"></i>
                            </span>
                            <select name="kategori" onchange="this.form.submit()" class="w-full sm:w-48 pl-9 pr-8 py-2 bg-slate-950 border border-slate-800 text-xs text-slate-300 rounded-xl outline-none focus:ring-1 focus:ring-amber-500 dark:bg-slate-950 dark:border-slate-800 light:bg-gray-50 light:border-gray-300 light:text-slate-800 cursor-pointer appearance-none">
                                <option value="" disabled selected>Semua Kategori</option>
                                <option value="Superior" {{ request('kategori') == 'Superior' ? 'selected' : '' }}>Superior</option>
                                <option value="Deluxe" {{ request('kategori') == 'Deluxe' ? 'selected' : '' }}>Deluxe</option>
                                <option value="Suite" {{ request('kategori') == 'Suite' ? 'selected' : '' }}>Suite</option>
                            </select>
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-[10px] text-slate-500"> <i class="fas fa-chevron-down"></i> </span>
                        </div>

                        <!-- FILTER STATUS -->
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500 text-xs">
                                <i class="fas fa-circle-info"></i>
                            </span>
                            <select name="status" onchange="this.form.submit()" class="w-full sm:w-48 pl-9 pr-8 py-2 bg-slate-950 border border-slate-800 text-xs text-slate-300 rounded-xl outline-none focus:ring-1 focus:ring-amber-500 dark:bg-slate-950 dark:border-slate-800 light:bg-gray-50 light:border-gray-300 light:text-slate-800 cursor-pointer appearance-none">
                                <option value="" disabled selected>Semua Status</option>
                                <option value="available" {{ request('status') == 'avalable' ? 'selected' : '' }}>Tersedia</option>
                                <option value="occupied" {{ request('status') == 'occupied' ? 'selected' : '' }}>Penuh</option>
                                <option value="booked" {{ request('status') == 'booked' ? 'selected' : '' }}>Dipesan</option>
                                <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Pemeliharaan</option>
                            </select>
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-[10px] text-slate-500">
                                <i class="fas fa-chevron-down"></i>
                            </span>
                        </div>

                    </div>

                </div>

            </form>

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
                                    <button onclick="openModal('infoModal',this)"
                                        data-id="{{ $room->id }}"
                                        data-room="{{ $room->room_number }}"
                                        data-type="{{ $room->room_type_id }}"
                                        data-price="{{ number_format($room->roomType->price) }}"
                                        data-status="{{ $room->realtime_status }}"

                                        data-customer="{{ optional($room->activeReservation)->customer_name ?? '-' }}"
                                        data-checkin="{{ optional($room->activeReservation)->check_in ?? '-' }}"
                                        data-checkout="{{ optional($room->activeReservation)->check_out ?? '-' }}"

                                        class="flex items-center w-full px-4 py-2 hover:bg-slate-900 dark:hover:bg-slate-900 light:hover:bg-gray-100">
                                        <i class="fas fa-info-circle w-5 text-amber-500"></i>
                                        Info Kamar
                                    </button>
    

                                </div>
                            </div>
                        </div>

                        <div class="border-t border-slate-800/60 dark:border-slate-800/60 light:border-gray-100 pt-3 mt-4 flex justify-between items-center">
                            <span class="text-sm font-bold text-amber-500">Rp {{ number_format($room->roomType->price, 0, ',', '.') }}<span class="text-xs font-normal text-slate-500">/malam</span></span>
                            <span class="px-2.5 py-1 text-xs font-bold rounded-md
                            @if($room->status == 'available')
                                bg-green-500/10 text-green-400

                            @elseif($room->status == 'occupied')
                                bg-red-500/10 text-red-400

                            @elseif($room->status == 'booked')
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
                        <p id="modalRoomNumber" class="font-bold text-white dark:text-white light:text-slate-900 mt-0.5"></p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Kategori</p>
                        <p id="modalRoomType" class="font-bold text-white dark:text-white light:text-slate-900 mt-0.5"></p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Harga Sewa</p>
                        <p id="modalRoomPrice" class="font-bold text-amber-500 mt-0.5">Rp 750,000 /malam</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Status Kamar</p>
                        <span id="modalRoomStatus" class="inline-block mt-1 px-2 py-0.5 text-xs font-bold rounded"></span>
                    </div>
                </div>
                <div class="pt-3 border-t border-slate-800 dark:border-slate-800 light:border-gray-100">
                    <p class="text-xs text-slate-400">Nama Pemesan</p>
                    <p id="modalCustomer" class="font-bold text-white dark:text-white light:text-slate-900 mt-0.5"></p>
                </div>
            </div>
            <div class="p-4 bg-slate-950/40 dark:bg-slate-950/40 light:bg-gray-50 border-t border-slate-800 dark:border-slate-800 light:border-gray-100 flex justify-end gap-3">
                <button onclick="closeModal('infoModal')" class="px-4 py-2 bg-slate-800 text-slate-300 rounded-lg text-xs font-semibold hover:bg-slate-700 light:bg-gray-200 light:text-slate-700 light:hover:bg-gray-300">Tutup</button>
            </div>
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

        function openModal(id, button) {

            document.getElementById(id).classList.remove('hidden');

            // isi data modal
            document.getElementById('modalRoomNumber')
                .innerText = 'Kamar ' + button.dataset.room;

            document.getElementById('modalRoomType')
                .innerText = button.dataset.type;

            document.getElementById('modalRoomPrice')
                .innerText = 'Rp ' + button.dataset.price;

            document.getElementById('modalCustomer')
                .innerText = button.dataset.customer;

            // status
            const status = button.dataset.status;

            let badge = '';

            if (status == 'available') {

                badge =
                    `
            <span class="px-2 py-1 rounded bg-emerald-500/10 text-emerald-400 text-xs font-bold">
                Available
            </span>
        `;

            } else if (status == 'penuh') {

                badge =
                    `
            <span class="px-2 py-1 rounded bg-rose-500/10 text-rose-400 text-xs font-bold">
                Penuh
            </span>
        `;

            } else {

                badge =
                    `
            <span class="px-2 py-1 rounded bg-amber-500/10 text-amber-400 text-xs font-bold">
                Maintenance
            </span>
        `;
            }

            document.getElementById('modalRoomStatus')
                .innerHTML = badge;

            // SET DATA EDIT BUTTON
            const editBtn = document.getElementById('btnEditRoom');

            editBtn.dataset.id = button.dataset.id;
            editBtn.dataset.room = button.dataset.room;
            editBtn.dataset.type = button.dataset.type;
            editBtn.dataset.status = button.dataset.status;

            // onclick edit
            editBtn.onclick = function() {
                openEditModal(this);
            }

        }

        function openEditModal(button) {

            // buka modal
            document
                .getElementById('editRoomModal')
                .classList.remove('hidden');

            // ambil dataset
            const id = button.dataset.id;
            const room = button.dataset.room;
            const type = button.dataset.type;
            const status = button.dataset.status;

            // isi form
            document.getElementById('editRoomNumber')
                .value = room;

            document.getElementById('editRoomType')
                .value = type;

            document.getElementById('editRoomStatus')
                .value = status;

            // action form
            document.getElementById('editRoomForm')
                .action = `/owner/rooms/${id}`;
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