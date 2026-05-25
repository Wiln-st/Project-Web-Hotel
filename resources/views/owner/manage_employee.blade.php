<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrandStay - Kelola Karyawan</title>
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

                <!-- KANAN: Tabel Data Karyawan (Mengambil 2 Kolom) -->
                <div class="lg:col-span-2 bg-slate-900 border border-slate-800 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="p-6 pb-4 border-b border-slate-800 dark:border-slate-800 light:border-gray-100 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-white dark:text-white light:text-slate-900">
                            <i class="fas fa-users text-amber-500 mr-2"></i>Daftar Staf Aktif
                        </h3>
                        <span class="text-xs bg-slate-800 text-slate-400 px-2.5 py-1 rounded-full font-medium dark:bg-slate-800 light:bg-gray-100 light:text-gray-600">{{ $employees->count() }} Terdaftar</span>
                    </div>

                    <!-- Area Tabel Responsif -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-800/80 dark:border-slate-800/80 light:border-gray-100 bg-slate-950/20 text-slate-400 text-xs uppercase font-bold tracking-wider">
                                    <th class="py-4 px-6">Nama</th>
                                    <th class="py-4 px-6">No. HP</th>
                                    <th class="py-4 px-6">Email</th>
                                    <th class="py-4 px-6">Role</th>
                                    <th class="py-4 px-6 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800/50 dark:divide-slate-800/50 light:divide-gray-100 text-sm">

                                @forelse($employees as $employee)
                                <!-- Baris Karyawan 1 (Active) -->
                                <tr class="hover:bg-slate-850/30 dark:hover:bg-slate-850/30 light:hover:bg-gray-50/80 transition">
                                    <td class="py-4 px-6 font-semibold text-white dark:text-white light:text-slate-800">{{$employee->name}}</td>
                                    <td class="py-4 px-6 text-slate-300 dark:text-slate-300 light:text-slate-600">{{$employee->phone}}</td>
                                    <td class="py-4 px-6 text-slate-400 dark:text-slate-400 light:text-gray-500">{{$employee->email}}</td>
                                    <td class="py-4 px-6 text-slate-400 dark:text-slate-400 light:text-gray-500">{{$employee->role}}</td>
                                    <td class="py-4 px-6 text-center">
                                        @if($employee->status == 'active')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                            Active
                                        </span>
                                        @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-800 text-slate-400 border border-slate-700">
                                            Non-Active
                                        </span>
                                        @endif
                                    </td>
                                </tr>

                                @empty
                                <tr>
                                    <td colspan="5" class="py-10 text-center text-slate-500">
                                        Belum ada data karyawan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>

</body>
<script>
    function togglePassword() {

        const passwordInput =
            document.getElementById('passwordInput');

        const eyeIcon =
            document.getElementById('eyeIcon');

        if (passwordInput.type === 'password') {

            passwordInput.type = 'text';

            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');

        } else {

            passwordInput.type = 'password';

            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }
</script>

</html>