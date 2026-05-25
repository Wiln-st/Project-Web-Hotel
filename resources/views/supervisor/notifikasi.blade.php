<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrandStay - Notifikasi Pusat</title>
    @vite('resources/css/app.css')
    @include('partials.fouc-script')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-slate-950 text-slate-100 min-h-screen font-sans antialiased transition-colors duration-300 dark:bg-slate-950 light:bg-gray-50 light:text-slate-800">
    @include('supervisor.partials.sidebar')

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
                <div class="flex items-center gap-3">
                    <form action="{{ route('supervisor.notifications.refresh') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold px-4 py-2.5 rounded-xl text-sm flex items-center gap-2">
                            <i class="fas fa-arrow-rotate-left"></i>
                        </button>
                    </form>
                    <form action="{{ route('supervisor.notifications.clearAll') }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button
                            type="submit" class="w-full sm:w-auto bg-slate-900 hover:bg-slate-850 text-red-400 font-semibold px-4 py-2.5 rounded-xl border border-slate-800 hover:border-red-500/30 transition flex items-center justify-center gap-2 text-xs shadow-sm">
                            <i class="fas fa-trash-can"></i>
                            Bersihkan Semua Notifikasi
                        </button>
                    </form>
                </div>
            </div>

            <!-- Container Utama Notifikasi -->
            <div class="max-w-4xl space-y-4">

                @foreach($notifications as $notification)
                <div class="notification-item bg-slate-900 border border-slate-800 dark:bg-slate-900 dark:border-slate-800 light:bg-white light:border-gray-200 p-5 rounded-2xl shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <!-- Icon Badge -->
                        <div class="p-3 rounded-xl 
                        @if($notification->type == 'check_in')
                            bg-blue-500/10 text-blue-400 border border-blue-500/20
                        @elseif($notification->type == 'check_out')
                            bg-amber-500/10 text-amber-400 border border-amber-500/20
                        @elseif($notification->type == 'room_system')
                            bg-emerald-500/10 text-emerald-400 border border-emerald-500/20
                        @else
                            bg-purple-500/10 text-purple-400 border border-purple-500/20
                        @endif
                            flex-shrink-0
                        ">
                            @if($notification->type == 'check_in')
                            <i class="fas fa-sign-in-alt text-lg"></i>
                            @elseif($notification->type == 'check_out')
                            <i class="fas fa-sign-out-alt text-lg"></i>
                            @elseif($notification->type == 'room_system')
                            <i class="fas fa-tools text-lg"></i>
                            @else
                            <i class="fas fa-calendar-check text-lg"></i>
                            @endif
                        </div>
                        <!-- Konten Teks -->
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs px-2 py-0.5 rounded-md font-semibold
                                @if($notification->type == 'check_in')
                                    bg-blue-500/10 text-blue-400 border border-blue-500/20
                                @elseif($notification->type == 'check_out')
                                    bg-amber-500/10 text-amber-400 border border-amber-500/20
                                @elseif($notification->type == 'room_system')
                                    bg-emerald-500/10 text-emerald-400 border border-emerald-500/20
                                @else
                                    bg-purple-500/10 text-purple-400 border border-purple-500/20
                                @endif
                                ">
                                    @if($notification->type == 'check_in')
                                    Check-In
                                    @elseif($notification->type == 'check_out')
                                    Check-Out
                                    @elseif($notification->type == 'room_system')
                                    Sistem Kamar
                                    @else
                                    Reservasi
                                    @endif
                                </span>
                                <span class="text-[11px] text-slate-500">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm font-semibold text-white dark:text-white light:text-slate-800 mt-1.5">
                                {{$notification->title}}
                            </p>
                            <p class="text-xs text-slate-400 dark:text-slate-400 light:text-gray-500 mt-0.5">
                                {{$notification->message}}
                            </p>
                        </div>
                    </div>

                    <!-- Tombol Aksi Kanan -->
                    <div class="flex items-center gap-2 self-end md:self-center">

                        {{-- BUTTON CHECK-IN --}}
                        @if($notification->type == 'check_in')
                        <form action="{{ route('supervisor.notifications.checkIn', $notification->id) }}" method="POST">
                            @csrf

                            <button type="submit"
                                class="bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-bold text-xs px-3 py-2 rounded-xl transition flex items-center gap-1.5 shadow-sm shadow-emerald-500/10">

                                <i class="fas fa-check-circle text-sm"></i>
                                Check-In
                            </button>
                        </form>
                        @endif


                        {{-- BUTTON CHECK-OUT --}}
                        @if($notification->type == 'check_out')
                        <form action="{{ route('supervisor.notifications.checkOut', $notification->id) }}" method="POST">
                            @csrf

                            <button type="submit"
                                class="bg-sky-500 hover:bg-sky-600 text-slate-950 font-bold text-xs px-3 py-2 rounded-xl transition flex items-center gap-1.5 shadow-sm shadow-sky-500/10">

                                <i class="fas fa-right-from-bracket text-sm"></i>
                                Check-Out
                            </button>
                        </form>
                        @endif


                        <!-- Tombol Hapus -->
                        <form action="{{ route('supervisor.notifications.destroy', $notification->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button
                                class="text-slate-500 hover:text-red-400 p-2 rounded-xl hover:bg-slate-800 transition"
                                title="Hapus">

                                <i class="fas fa-trash-alt text-xs"></i>
                            </button>
                        </form>

                    </div>
                </div>
                @endforeach

            </div>
        </main>
    </div>

    <!-- ================= JAVASCRIPT SYSTEM ================= -->
    <script>
    </script>
</body>

</html>