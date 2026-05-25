<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrandStay - Finansial Owner</title>
    @vite('resources/css/app.css')
    @include('partials.fouc-script')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-slate-950 text-slate-100 min-h-screen font-sans antialiased transition-colors duration-300 dark:bg-slate-950 light:bg-gray-50 light:text-slate-800">
    @include('owner.partials.sidebar')

    <div class="flex min-h-screen">

        <!-- ================= MAIN CONTENT AREA ================= -->
        <main class="flex-1 ml-64 p-8 lg:p-10 overflow-y-auto">

            <!-- Header Dashboard -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-white dark:text-white light:text-slate-900">Dashboard Keuangan</h1>
                    <p class="text-sm text-slate-400 dark:text-slate-400 light:text-gray-500 mt-1">Selamat datang kembali, owner. Berikut ringkasan performa hotel hari ini.</p>
                </div>
                <!-- Date Filter Badge -->
                <div class="flex items-center gap-3 bg-slate-900 dark:bg-slate-900 light:bg-white border border-slate-800 dark:border-slate-800 light:border-gray-200 px-4 py-2 rounded-xl text-sm shadow-sm w-fit">
                    <i class="fas fa-calendar text-amber-500"></i>
                    <span class="font-medium text-slate-300 dark:text-slate-300 light:text-slate-700">{{ $today->translatedFormat('d F Y') }}</span>
                </div>
            </div>

            <!-- ================= SECTION 1: TOTAL SALDO ================= -->
            <div class="mb-8">
                <div class="relative overflow-hidden bg-gradient-to-br from-slate-900 to-slate-800 dark:from-slate-900 dark:to-slate-800 light:from-slate-900 light:to-slate-950 p-6 rounded-2xl border border-slate-800 dark:border-slate-800 light:border-transparent shadow-xl flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="p-2 bg-amber-500/10 text-amber-500 rounded-lg text-xs font-bold uppercase tracking-wider">Total Saldo Hotel</span>
                        </div>
                        <p class="text-sm text-slate-400 dark:text-slate-400 light:text-slate-300">Saldo Berjalan Saat Ini</p>
                        <h2 class="text-4xl font-black text-white mt-1 tracking-tight">Rp {{ number_format($totalBalance, 0, ',', '.') }}</h2>
                    </div>

                    <!-- TOMBOL TAMBAH TRANSAKSI (Ditempatkan di area strategis atas) -->
                    <button type="button" onclick="openTransactionModal()" class="bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold px-5 py-3 rounded-xl transition flex items-center gap-2 text-sm shadow-lg shadow-amber-500/10 h-fit whitespace-nowrap">
                        <i class="fas fa-plus-circle text-base"></i> Catat Transaksi Baru
                    </button>
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
                                <h3 class="text-2xl font-bold text-white dark:text-white light:text-slate-900 mt-0.5">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
                            </div>
                        </div>
                    </div>
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
                                <h3 class="text-2xl font-bold text-white dark:text-white light:text-slate-900 mt-0.5">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-2 mt-6">
                        <div class="w-full bg-slate-800 dark:bg-slate-800 light:bg-gray-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-rose-500 h-full rounded-full" style="width: 65%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= SECTION 3: TABEL PEMASUKAN & PENGELUARAN TERBARU ================= -->
            <div class="bg-slate-900 border border-slate-800 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-800 dark:border-slate-800 light:border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-exchange-alt text-amber-500"></i>
                        <h3 class="text-lg font-bold text-white dark:text-white light:text-slate-900">Transaksi Baru-baru Ini</h3>
                    </div>
                    <span class="text-xs bg-slate-800 text-slate-400 dark:bg-slate-800 light:bg-gray-100 light:text-gray-500 px-2.5 py-1 rounded-md">Arus Kas Hari Ini</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-950/40 dark:bg-slate-950/40 light:bg-gray-50/70 border-b border-slate-800 dark:border-slate-800 light:border-gray-100 text-xs font-bold uppercase text-slate-400 dark:text-slate-400 light:text-gray-500 tracking-wider">
                                <th class="p-4 w-1/12 text-center">Jenis</th>
                                <th class="p-4 w-5/12">Keterangan Transaksi</th>
                                <th class="p-4 w-3/12">Nominal</th>
                                <th class="p-4 w-2/12 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800 dark:divide-slate-800 light:divide-gray-100 text-sm font-medium">

                            @forelse ($transactions as $transaction)
                            <tr class="hover:bg-slate-800/30 transition">

                                <!-- ICON -->
                                <td class="p-4 text-center">

                                    @if($transaction->type == 'pemasukan')
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-400">
                                        <i class="fas fa-arrow-down text-xs"></i>
                                    </span>
                                    @else
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-rose-500/10 text-rose-400">
                                        <i class="fas fa-arrow-up text-xs"></i>
                                    </span>
                                    @endif

                                </td>

                                <!-- TITLE -->
                                <td class="p-4">
                                    <p class="text-white font-semibold">
                                        {{ $transaction->description }}
                                    </p>

                                    <p class="text-[11px] text-slate-500 mt-0.5">
                                        {{ $transaction->created_at->format('d M Y H:i') }}
                                    </p>
                                </td>

                                <!-- NOMINAL -->
                                <td class="p-4 font-bold">

                                    @if($transaction->type == 'pemasukan')

                                    <span class="text-emerald-400">
                                        + Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </span>

                                    @else

                                    <span class="text-rose-400">
                                        - Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </span>

                                    @endif

                                </td>

                                <!-- AKSI -->
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">

                                        <!-- DELETE -->
                                        <form action="{{ route('owner.transactions.destroy', $transaction->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="text-slate-500 hover:text-rose-400 p-2 rounded-lg hover:bg-slate-800 transition">

                                                <i class="fas fa-trash-alt text-xs"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td colspan="4" class="text-center py-10 text-slate-500">
                                    Belum ada transaksi
                                </td>
                            </tr>

                            @endforelse

                        </tbody>
                    </table>
                    <div class="p-4 border-t border-slate-800">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- =========================================================
         MODAL DIALOG: INPUT/EDIT TRANSAKSI (HARDCODED HIDDEN VIA INLINE 'hidden')
         ========================================================= -->
    <div id="transactionModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
        <div class="w-full max-w-md bg-slate-900 border border-slate-800 rounded-2xl shadow-2xl p-6 dark:bg-slate-900 light:bg-white light:border-gray-200">

            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-800 light:border-gray-100">
                <h3 class="text-lg font-bold text-white light:text-slate-900 flex items-center gap-2">
                    <i class="fas fa-wallet text-amber-500"></i> Formulir Transaksi Baru
                </h3>
                <button type="button" onclick="closeTransactionModal()" class="text-slate-400 hover:text-white light:hover:text-slate-800 p-1">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <!-- Form Konten -->
            <form action="{{ route('owner.transactions.store') }}" method="POST">
                @csrf

                <!-- Jenis Transaksi -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Jenis Transaksi *</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center justify-center gap-2 p-3 bg-slate-800 border border-slate-700 text-sm font-semibold rounded-xl cursor-pointer text-emerald-400 has-[:checked]:ring-2 has-[:checked]:ring-emerald-500 has-[:checked]:bg-emerald-500/10 dark:bg-slate-800 light:bg-gray-50 light:border-gray-300">
                            <input type="radio" name="type" value="pemasukan" class="sr-only" checked>
                            <i class="fas fa-arrow-down text-xs"></i> Pemasukan
                        </label>
                        <label class="flex items-center justify-center gap-2 p-3 bg-slate-800 border border-slate-700 text-sm font-semibold rounded-xl cursor-pointer text-rose-400 has-[:checked]:ring-2 has-[:checked]:ring-rose-500 has-[:checked]:bg-rose-500/10 dark:bg-slate-800 light:bg-gray-50 light:border-gray-300">
                            <input type="radio" name="type" value="pengeluaran" class="sr-only">
                            <i class="fas fa-arrow-up text-xs"></i> Pengeluaran
                        </label>
                    </div>
                </div>

                <!-- Keterangan -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider my-2">Keterangan / Deskripsi</label>
                    <div class="relative">
                        <span class="absolute top-3 left-3 text-slate-500"><i class="fas fa-pen text-xs"></i></span>
                        <textarea name="description" rows="3" required class="w-full pl-9 pr-4 py-2 bg-slate-800 border border-slate-700 text-white text-sm rounded-xl outline-none focus:ring-2 focus:ring-amber-500 dark:bg-slate-800 dark:border-slate-700 light:bg-gray-50 light:border-gray-300 light:text-slate-900" placeholder="Contoh: Pembayaran laundry kain linen kamar deluxe..."></textarea>
                    </div>
                </div>

                <!-- Jumlah Nominal -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Jumlah Nominal (Rp) *</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-sm font-bold text-slate-500">Rp</span>
                        <input type="number" name="amount" required class="w-full pl-10 pr-4 py-2.5 bg-slate-800 border border-slate-700 text-white font-bold text-sm rounded-xl outline-none focus:ring-2 focus:ring-amber-500 dark:bg-slate-800 dark:border-slate-700 light:bg-gray-50 light:border-gray-300 light:text-slate-900" placeholder="0">
                    </div>
                </div>

                <!-- Action Button Modal -->
                <div class="pt-2 flex items-center gap-3">
                    <button type="button" onclick="closeTransactionModal()" class="w-1/2 border border-slate-700 text-slate-300 hover:bg-slate-800 text-sm font-semibold py-2.5 rounded-xl transition dark:border-slate-700 light:border-gray-300 light:text-slate-600">
                        Batal
                    </button>
                    <button type="submit" class="w-1/2 bg-amber-500 hover:bg-amber-600 text-slate-950 text-sm font-black py-2.5 rounded-xl transition shadow-md shadow-amber-500/10">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================= JAVASCRIPT SYSTEM (HANYA MENGATUR STATE BUKA/TUTUP) ================= -->
    <script>
        const modal = document.getElementById('transactionModal');

        function openTransactionModal() {
            modal.classList.remove('hidden');
        }

        function closeTransactionModal() {
            modal.classList.add('hidden');
        }

        function editTransaksi(id) {
            alert(`Sistem memuat data ID Transaksi [${id}] ke dalam formulir...`);
            openTransactionModal();
        }

        function hapusTransaksi(namaItem) {
            confirm(`Apakah Anda yakin ingin menghapus catatan transaksi untuk:\n"${namaItem}"?`);
        }
    </script>
</body>

</html>