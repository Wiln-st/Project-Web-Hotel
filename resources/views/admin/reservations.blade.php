<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrandStay - Form Reservasi</title>
    @vite('resources/css/app.css')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-slate-950 text-slate-100 min-h-screen font-sans antialiased transition-colors duration-300 dark:bg-slate-950 light:bg-gray-50 light:text-slate-800">
    @include('admin.partials.sidebar')
    <div class="flex min-h-screen">

        <!-- ================= MAIN CONTENT ================= -->
        <main class="flex-1 ml-64 p-8 lg:p-10 overflow-y-auto">
            <div class="mb-8">
                <h1 class="text-3xl font-bold tracking-tight text-white dark:text-white light:text-slate-900">Form Reservasi</h1>
                <p class="text-sm text-slate-400 dark:text-slate-400 light:text-gray-500 mt-1">Input data reservasi tamu baru secara manual dengan sistem kalkulasi biaya otomatis.</p>
            </div>

            <!-- Alert Box Error (Dipindah ke luar Grid agar full width dan rapi)
            @if(session('error'))
            <div id="alertError" class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm flex items-center justify-between backdrop-blur-sm">
                <div class="flex items-center gap-3">
                    <i class="fas fa-exclamation-circle text-lg text-red-500"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button type="button" onclick="document.getElementById('alertError').remove()" class="text-slate-400 hover:text-white transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif -->

            <!-- Grid Layout Form & Ringkasan Biaya -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Kiri: Input Form (Mengambil 2 Kolom) -->
                <form id="formReservasi" action="{{ route('reservation.store') }}" method="POST" class="lg:col-span-2 space-y-6 bg-slate-900 border border-slate-800 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200 p-6 rounded-2xl shadow-sm">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Pemesan -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">Nama Pemesan</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500"><i class="fas fa-user"></i></span>
                                <input type="text" name="customer_name" required class="w-full pl-10 pr-4 py-2.5 bg-slate-800 border border-slate-700 text-white rounded-lg outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-700 dark:text-white light:bg-gray-50 light:border-gray-300 light:text-slate-900" placeholder="Nama Lengkap Tamu">
                            </div>
                        </div>

                        <!-- No HP -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">No. Handphone</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500"><i class="fas fa-phone"></i></span>
                                <input type="tel" name="phone" required class="w-full pl-10 pr-4 py-2.5 bg-slate-800 border border-slate-700 text-white rounded-lg outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-700 dark:text-white light:bg-gray-50 light:border-gray-300 light:text-slate-900" placeholder="08xxxxxxxxxx">
                            </div>
                        </div>

                        <!-- Loop Pemilihan Kamar Berdasarkan Kategori -->
                        @foreach($roomTypes as $type)
                        <div class="md:col-span-1">
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                    Kamar {{ $type->name }} <span class="text-[10px] text-slate-500 font-normal block md:inline md:ml-1">(Rp {{ number_format($type->price, 0, ',', '.') }}/malam)</span>
                                </label>
                            <div class="text-[11px] text-amber-500 font-medium flex items-center cursor-default">
                                    <i class="fas fa-door-open mr-1"></i>
                                    {{ $type->rooms->count() }} Kamar Tersedia
                                </div>
                            </div>
                            <div class="relative">
                                <select name="room_ids[]" multiple size="3" class="room-selector w-full p-2 bg-slate-800 border border-slate-700 text-white text-sm rounded-lg outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-700 dark:text-white light:bg-gray-50 light:border-gray-300 light:text-slate-900 overflow-y-auto scrollbar-none [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
                                    @foreach($type->rooms as $room)
                                    <option value="{{ $room->id }}" data-price="{{ $type->price }}" class="py-1 px-2 checked:bg-amber-500 checked:text-slate-900 cursor-pointer rounded mb-0.5">
                                        Kamar {{ $room->room_number }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endforeach

                        <!-- Tombol Reset Semua Kamar sekaligus jika kategori berjumlah ganjil / genap tetap presisi -->
                        <div class="md:col-span-1 flex justify-end items-end">
                            <button type="button" onclick="resetAllSelect()" class=" w-full justify-center text-xs bg-slate-800 hover:bg-slate-750 text-slate-300 px-4 py-2 rounded-xl border border-slate-700 transition flex items-center gap-2 cursor-pointer">
                                <i class="fas fa-arrow-rotate-left"></i> Reset Semua Pilihan Kamar
                            </button>
                        </div>

                        <!-- Tgl Check-In -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">Tanggal Check-In</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500"><i class="fas fa-calendar-plus"></i></span>
                                <input type="date" name="check_in" id="tglCheckIn" required class="w-full pl-10 pr-4 py-2.5 bg-slate-800 border border-slate-700 text-white rounded-lg outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-700 dark:text-white light:bg-gray-50 light:border-gray-300 light:text-slate-900 cursor-pointer">
                            </div>
                        </div>

                        <!-- Tgl Check-Out -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">Tanggal Check-Out</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500"><i class="fas fa-calendar-minus"></i></span>
                                <input type="date" name="check_out" id="tglCheckOut" required class="w-full pl-10 pr-4 py-2.5 bg-slate-800 border border-slate-700 text-white rounded-lg outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-700 dark:text-white light:bg-gray-50 light:border-gray-300 light:text-slate-900 cursor-pointer">
                            </div>
                        </div>
                    </div>

                    <!-- Checklist Fasilitas Tambahan -->
                    <div class="pt-4 border-t border-slate-800/60 dark:border-slate-800/60 light:border-gray-100">
                        <label class="block text-xs font-semibold text-slate-400 mb-3 uppercase tracking-wider">Fasilitas Tambahan (Per Hari)</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Makanan/Minuman -->
                            <label class="flex items-center p-3 bg-slate-950/40 border border-slate-800 rounded-xl cursor-pointer select-none hover:border-amber-500/50 transition dark:bg-slate-950/40 dark:border-slate-800 light:bg-gray-50 light:border-gray-200">
                                <input type="checkbox" name="facilities[]" id="facMakan" value="Makan" class="rounded bg-slate-800 border-slate-700 text-amber-500 focus:ring-amber-500 w-4 h-4 mr-3">
                                <div>
                                    <p class="text-sm font-bold text-white dark:text-white light:text-slate-800">Makanan & Minuman</p>
                                    <p class="text-xs text-slate-400 mt-0.5">+Rp 75.000</p>
                                </div>
                            </label>
                            <!-- Parkir Eksklusif -->
                            <label class="flex items-center p-3 bg-slate-950/40 border border-slate-800 rounded-xl cursor-pointer select-none hover:border-amber-500/50 transition dark:bg-slate-950/40 dark:border-slate-800 light:bg-gray-50 light:border-gray-200">
                                <input type="checkbox" name="facilities[]" id="facParkir" value="Parkir" class="rounded bg-slate-800 border-slate-700 text-amber-500 focus:ring-amber-500 w-4 h-4 mr-3">
                                <div>
                                    <p class="text-sm font-bold text-white dark:text-white light:text-slate-800">Parkir Eksklusif</p>
                                    <p class="text-xs text-slate-400 mt-0.5">+Rp 10.000</p>
                                </div>
                            </label>
                            <!-- Free High-Speed Wifi -->
                            <label class="flex items-center p-3 bg-slate-950/40 border border-slate-800 rounded-xl cursor-pointer select-none hover:border-amber-500/50 transition dark:bg-slate-950/40 dark:border-slate-800 light:bg-gray-50 light:border-gray-200">
                                <input type="checkbox" name="facilities[]" id="facWifi" value="Wifi" checked class="rounded bg-slate-800 border-slate-700 text-amber-500 focus:ring-amber-500 w-4 h-4 mr-3">
                                <div>
                                    <p class="text-sm font-bold text-white dark:text-white light:text-slate-800">Free High-Speed Wi-Fi</p>
                                    <p class="text-xs text-emerald-400 mt-0.5">Gratis</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </form>

                <!-- Kanan: Live Calculate Summary (1 Kolom) -->
                <div class="bg-gradient-to-br from-slate-900 to-slate-850 border border-slate-800 p-6 rounded-2xl shadow-xl h-fit sticky top-28 dark:from-slate-900 dark:to-slate-850 dark:border-slate-800 light:from-white light:to-gray-50 light:border-gray-200">
                    <h3 class="text-lg font-bold text-white dark:text-white light:text-slate-900 mb-4 pb-3 border-b border-slate-800 dark:border-slate-800 light:border-gray-100"><i class="fas fa-receipt text-amber-500 mr-2"></i>Ringkasan Biaya</h3>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-400">Harga Dasar Kamar</span>
                            <span id="lblHargaDasar" class="font-semibold text-white dark:text-white light:text-slate-800">Rp 0</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Durasi Menginap</span>
                            <span id="lblDurasi" class="font-semibold text-white dark:text-white light:text-slate-800">0 Malam</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Tambahan Fasilitas</span>
                            <span id="lblFasilitas" class="font-semibold text-white dark:text-white light:text-slate-800">Rp 0</span>
                        </div>

                        <div class="pt-4 mt-4 border-t border-dashed border-slate-700 dark:border-slate-700 light:border-gray-200">
                            <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Total Semua Harga</p>
                            <h2 id="lblTotalHarga" class="text-3xl font-black text-amber-500 mt-1 tracking-tight">Rp 0</h2>
                        </div>
                    </div>

                    <button type="submit" form="formReservasi" class="w-full bg-amber-500 hover:bg-amber-600 text-slate-900 font-extrabold py-3.5 rounded-xl mt-6 shadow-lg shadow-amber-500/10 transform transition active:scale-[0.97] flex items-center justify-center gap-2">
                        <i class="fas fa-calendar-check"></i> Konfirmasi Reservasi
                    </button>
                </div>

            </div>
        </main>
    </div>

    <!-- ================= JAVASCRIPT SYSTEM ================= -->
    <script>
        // Fungsi untuk mereset pilihan satu multiselect tertentu
        function resetSingleSelect(buttonElement) {
            // Cari element select terdekat yang berada dalam satu wrapper dengan button
            const select = buttonElement.closest('.md:col-span-1').querySelector('.room-selector');
            if (select) {
                select.selectedIndex = -1; // Membatalkan seluruh blok pilihan select
                hitungTotal(); // Trigger kalkulasi ulang harga live
            }
        }

        // Fungsi untuk mereset seluruh multiselect kamar sekaligus
        function resetAllSelect() {
            const selectors = document.querySelectorAll('.room-selector');
            selectors.forEach(select => {
                select.selectedIndex = -1;
            });
            hitungTotal();
        }

        // Hitung durasi (checkout - checkin)
        function hitungDurasi() {
            const checkIn = document.getElementById('tglCheckIn').value;
            const checkOut = document.getElementById('tglCheckOut').value;

            if (!checkIn || !checkOut) return 0;

            const start = new Date(checkIn);
            const end = new Date(checkOut);
            const diff = (end - start) / (1000 * 60 * 60 * 24);

            return diff > 0 ? diff : 0;
        }

        // Ambil akumulasi harga seluruh kamar terpilih di semua select box
        function getHargaKamar() {
            let totalHargaDasar = 0;
            const selectors = document.querySelectorAll('.room-selector');

            selectors.forEach(select => {
                const selectedOptions = select.selectedOptions;
                for (let option of selectedOptions) {
                    const price = parseInt(option.getAttribute('data-price')) || 0;
                    totalHargaDasar += price;
                }
            });

            return totalHargaDasar;
        }

        // Hitung total tarif fasilitas tambahan dasar
        function hitungFasilitas() {
            let total = 0;
            const hargaFasilitas = {
                'makan': 75000,
                'parkir': 10000,
                'wifi': 0
            };

            if (document.getElementById('facMakan').checked) total += hargaFasilitas['makan'];
            if (document.getElementById('facParkir').checked) total += hargaFasilitas['parkir'];
            if (document.getElementById('facWifi').checked) total += hargaFasilitas['wifi'];

            return total;
        }

        // Utama: Hitung total keseluruhan dan perbarui visual UI Ringkasan Biaya
        function hitungTotal() {
            const hargaKamarTotal = getHargaKamar();
            const durasi = hitungDurasi();
            const fasilitasPerHari = hitungFasilitas();

            const totalFasilitas = fasilitasPerHari * durasi;
            const totalKeseluruhan = (hargaKamarTotal * durasi) + totalFasilitas;

            // Update Tampilan UI Ringkasan
            document.getElementById('lblHargaDasar').innerText = `Rp ` + hargaKamarTotal.toLocaleString('id-ID');
            document.getElementById('lblDurasi').innerText = durasi + ` Malam`;
            document.getElementById('lblFasilitas').innerText = `Rp ` + totalFasilitas.toLocaleString('id-ID');
            document.getElementById('lblTotalHarga').innerText = `Rp ` + totalKeseluruhan.toLocaleString('id-ID');
        }

        // Daftarkan Event Listener untuk Auto-Kalkulasi saat ada perubahan
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('tglCheckIn').addEventListener('change', hitungTotal);
            document.getElementById('tglCheckOut').addEventListener('change', hitungTotal);

            document.getElementById('facMakan').addEventListener('change', hitungTotal);
            document.getElementById('facParkir').addEventListener('change', hitungTotal);
            document.getElementById('facWifi').addEventListener('change', hitungTotal);

            // Pasang event pada ketiga kolom select tipe kamar
            document.querySelectorAll('.room-selector').forEach(select => {
                select.addEventListener('change', hitungTotal);
            });

            // Set default minimal tanggal hari ini untuk check-in
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('tglCheckIn').setAttribute('min', today);
            document.getElementById('tglCheckOut').setAttribute('min', today);
        });
    </script>
</body>

</html>