<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrandStay - Notifikasi Pusat</title>
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
            <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-white dark:text-white light:text-slate-900">Notifikasi</h1>
                    <p class="text-sm text-slate-400 dark:text-slate-400 light:text-gray-500 mt-1">Pantau arus aktivitas pemesanan, pergerakan tamu, dan pembaruan status operasional kamar secara *real-time*.</p>
                </div>

                <!-- Tombol Hapus Semua Notifikasi sekaligus -->
                <div>
                    <button type="button" onclick="hapusSemuaNotifikasi()" class="w-full sm:w-auto bg-slate-900 hover:bg-slate-850 text-red-400 font-semibold px-4 py-2.5 rounded-xl border border-slate-800 hover:border-red-500/30 transition flex items-center justify-center gap-2 text-xs shadow-sm">
                        <i class="fas fa-trash-alt"></i> Bersihkan Semua Notifikasi
                    </button>
                </div>
            </div>

            <!-- Container Utama Notifikasi -->
            <div class="max-w-4xl space-y-4">

                <!-- 1. NOTIFIKASI INFO CHECK-OUT (Butuh Konfirmasi Ketersediaan Kamar) -->
                <div class="notification-item bg-slate-900 border border-slate-800 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200 p-5 rounded-2xl shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <!-- Icon Badge -->
                        <div class="p-3 rounded-xl bg-amber-500/10 text-amber-500 border border-amber-500/20 flex-shrink-0">
                            <i class="fas fa-sign-out-alt text-lg"></i>
                        </div>
                        <!-- Konten Teks -->
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs bg-amber-500/10 text-amber-400 border border-amber-500/20 px-2 py-0.5 rounded-md font-semibold">Check-Out</span>
                                <span class="text-[11px] text-slate-500">Baru saja</span>
                            </div>
                            <p class="text-sm font-semibold text-white dark:text-white light:text-slate-800 mt-1.5">
                                Budi Santoso telah check-out dari Kamar 102.
                            </p>
                            <p class="text-xs text-slate-400 dark:text-slate-400 light:text-gray-500 mt-0.5">
                                Konfirmasi reservasi selesai untuk mengembalikan status kamar menjadi siap disewa kembali.
                            </p>
                        </div>
                    </div>

                    <!-- Tombol Aksi Kanan -->
                    <div class="flex items-center gap-2 self-end md:self-center">
                        <!-- Tombol Centang Konfirmasi Kamar Tersedia -->
                        <button type="button" onclick="konfirmasiKamarTersedia('Kamar 102', this)" class="bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-bold text-xs px-3 py-2 rounded-xl transition flex items-center gap-1.5 shadow-sm shadow-emerald-500/10" title="Konfirmasi Kamar Tersedia">
                            <i class="fas fa-check-circle text-sm"></i> Kamar Tersedia
                        </button>
                        <!-- Tombol Hapus Notifikasi -->
                        <button type="button" onclick="hapusNotifikasiTunggal(this)" class="text-slate-500 hover:text-red-400 p-2 rounded-xl hover:bg-slate-800 dark:hover:bg-slate-800 light:hover:bg-gray-100 transition" title="Hapus">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>


                <!-- 2. NOTIFIKASI UPDATE STATUS KAMAR (Informasi Maintenance Selesai) -->
                <div class="notification-item bg-slate-900 border border-slate-800 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200 p-5 rounded-2xl shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <!-- Icon Badge -->
                        <div class="p-3 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex-shrink-0">
                            <i class="fas fa-tools text-lg"></i>
                        </div>
                        <!-- Konten Teks -->
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2 py-0.5 rounded-md font-semibold">Sistem Kamar</span>
                                <span class="text-[11px] text-slate-500">15 menit yang lalu</span>
                            </div>
                            <p class="text-sm font-semibold text-white dark:text-white light:text-slate-800 mt-1.5">
                                Kamar 4 telah tersedia kembali di sistem.
                            </p>
                            <p class="text-xs text-slate-400 dark:text-slate-400 light:text-gray-500 mt-0.5">
                                Status kamar diubah secara otomatis setelah sebelumnya berada dalam masa pemeliharaan (*maintenance*).
                            </p>
                        </div>
                    </div>

                    <!-- Tombol Aksi Kanan -->
                    <div class="flex items-center gap-2 self-end md:self-center">
                        <button type="button" onclick="hapusNotifikasiTunggal(this)" class="text-slate-500 hover:text-red-400 p-2 rounded-xl hover:bg-slate-800 dark:hover:bg-slate-800 light:hover:bg-gray-100 transition" title="Hapus Notifikasi">
                            <i class="fas fa-trash-alt text-xs"></i>
                        </button>
                    </div>
                </div>


                <!-- 3. NOTIFIKASI INFO CHECK-IN -->
                <div class="notification-item bg-slate-900 border border-slate-800 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200 p-5 rounded-2xl shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <!-- Icon Badge -->
                        <div class="p-3 rounded-xl bg-blue-500/10 text-blue-400 border border-blue-500/20 flex-shrink-0">
                            <i class="fas fa-sign-in-alt text-lg"></i>
                        </div>
                        <!-- Konten Teks -->
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs bg-blue-500/10 text-blue-400 border border-blue-500/20 px-2 py-0.5 rounded-md font-semibold">Check-In</span>
                                <span class="text-[11px] text-slate-500">1 jam yang lalu</span>
                            </div>
                            <p class="text-sm font-semibold text-white dark:text-white light:text-slate-800 mt-1.5">
                                Kunjungan Baru: Melinda Putri sukses melakukan check-in.
                            </p>
                            <p class="text-xs text-slate-400 dark:text-slate-400 light:text-gray-500 mt-0.5">
                                Tamu telah diverifikasi kartu identitasnya dan menempati Kamar 204 (Tipe Deluxe).
                            </p>
                        </div>
                    </div>

                    <!-- Tombol Aksi Kanan -->
                    <div class="flex items-center gap-2 self-end md:self-center">
                        <button type="button" onclick="hapusNotifikasiTunggal(this)" class="text-slate-500 hover:text-red-400 p-2 rounded-xl hover:bg-slate-800 dark:hover:bg-slate-800 light:hover:bg-gray-100 transition" title="Hapus Notifikasi">
                            <i class="fas fa-trash-alt text-xs"></i>
                        </button>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- ================= JAVASCRIPT SYSTEM ================= -->
    <script>
        // Fungsi Tombol Centang (Konfirmasi Kamar Kembali Tersedia)
        function konfirmasiKamarTersedia(namaKamar, buttonElement) {
            alert(`Konfirmasi Sukses! Status ${namaKamar} telah diset menjadi 'Tersedia' dan siap digunakan.`);
            
            // Opsional: Hapus kartu notifikasi ini setelah dikonfirmasi agar list bersih
            const card = buttonElement.closest('.notification-item');
            if(card) card.remove();
        }

        // Fungsi Hapus Notifikasi Tunggal (Menggunakan tombol silang / sampah kecil)
        function hapusNotifikasiTunggal(buttonElement) {
            const card = buttonElement.closest('.notification-item');
            if (card) {
                card.remove();
            }
        }

        // Fungsi Bersihkan Semua Notifikasi Sekaligus (Tombol Atas)
        function hapusSemuaNotifikasi() {
            const konfirmasi = confirm("Apakah Anda yakin ingin menghapus seluruh riwayat notifikasi saat ini?");
            if (konfirmasi) {
                const items = document.querySelectorAll('.notification-item');
                items.forEach(item => item.remove());
                alert("Semua notifikasi telah dibersihkan.");
            }
        }
    </script>
</body>

</html>