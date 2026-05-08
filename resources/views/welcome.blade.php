<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sarpras MAKN Ende</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="bg-white text-slate-900 antialiased">

    <nav class="flex items-center justify-between px-8 md:px-16 py-6 border-b border-slate-100">
    <div class="flex items-center gap-3">
        <div class="w-12 h-12 flex items-center justify-center">
            <img src="{{ asset('assets/images/logo-makn.png') }}" alt="Logo MAKN Ende" class="w-full h-full object-contain">
        </div>
        
        <div class="h-8 w-[1px] bg-slate-200 mx-1"></div>

        <div>
            <span class="text-xl font-extrabold tracking-tighter text-emerald-900 uppercase leading-none block">Sarpras</span>
            <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-[0.2em] block leading-none">MAKN Ende</span>
        </div>
    </div>

    <div class="hidden md:flex items-center gap-8 text-sm font-bold text-slate-500">
        <a href="#" class="hover:text-emerald-600 transition-colors">Beranda</a>
        <a href="#" class="hover:text-emerald-600 transition-colors">Katalog</a>
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 bg-emerald-600 text-white rounded-xl shadow-md hover:bg-emerald-700 transition-all">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="px-6 py-2.5 bg-slate-900 text-white rounded-xl shadow-md hover:bg-black transition-all">Masuk Sistem</a>
            @endauth
        @endif
    </div>
</nav>

    <section class="relative px-8 md:px-16 py-20 md:py-32 overflow-hidden">
        <div class="absolute top-0 right-0 -z-10 w-1/2 h-full bg-emerald-50 rounded-l-[100px] opacity-50"></div>
        
        <div class="max-w-4xl">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold mb-6 tracking-wide uppercase">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                Sistem Informasi Terpadu
            </div>
            <h1 class="text-5xl md:text-7xl font-black text-slate-900 leading-[1.1] tracking-tight mb-8">
                Kelola Inventaris Lab <br> <span class="text-emerald-600 italic">Lebih Modern.</span>
            </h1>
            <p class="text-lg md:text-xl text-slate-500 max-w-2xl mb-10 leading-relaxed">
                Digitalisasi manajemen sarana dan prasarana MAKN Ende. Monitoring aset, peminjaman alat, dan pelaporan kerusakan dalam satu platform yang transparan.
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('login') }}" class="px-8 py-4 bg-emerald-600 text-white font-bold rounded-2xl shadow-xl shadow-emerald-200 hover:bg-emerald-700 hover:-translate-y-1 transition-all flex items-center justify-center gap-2">
                    Mulai Sekarang <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
                <a href="#" class="px-8 py-4 bg-white border border-slate-200 text-slate-700 font-bold rounded-2xl hover:bg-slate-50 transition-all flex items-center justify-center gap-2">
                    Lihat Katalog Aset
                </a>
            </div>
        </div>
    </section>

    <section class="px-8 md:px-16 py-20 bg-slate-50">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-[32px] border border-slate-200 shadow-sm hover:shadow-xl transition-all group">
                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-3xl font-light">qr_code_scanner</span>
                </div>
                <h3 class="text-xl font-extrabold text-slate-800 mb-4">Pelacakan Real-time</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Pantau status ketersediaan barang di Lab PPLG secara instan. Menghindari duplikasi data dan kehilangan aset sekolah.
                </p>
            </div>

            <div class="bg-white p-8 rounded-[32px] border border-slate-200 shadow-sm hover:shadow-xl transition-all group">
                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-3xl font-light">history_edu</span>
                </div>
                <h3 class="text-xl font-extrabold text-slate-800 mb-4">Peminjaman Digital</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Siswa dapat mengajukan peminjaman alat secara online. Sistem otomatis memantau batas waktu pengembalian.
                </p>
            </div>

            <div class="bg-white p-8 rounded-[32px] border border-slate-200 shadow-sm hover:shadow-xl transition-all group">
                <div class="w-14 h-14 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-rose-600 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-3xl font-light">analytics</span>
                </div>
                <h3 class="text-xl font-extrabold text-slate-800 mb-4">Laporan Otomatis</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Generate laporan inventaris dan histori peminjaman ke format PDF siap cetak untuk keperluan administrasi madrasah.
                </p>
            </div>
        </div>
    </section>

    <footer class="px-8 md:px-16 py-12 border-t border-slate-100 text-center">
        <p class="text-slate-400 text-xs font-medium uppercase tracking-[0.2em]">
            &copy; 2026 MAKN Ende • Software & Game Development Team
        </p>
        <p class="text-slate-500 text-sm mt-2">
            Dikembangkan oleh <span class="font-bold text-slate-700">Muhammad Raihaan Humris</span>
        </p>
    </footer>

</body>
</html>