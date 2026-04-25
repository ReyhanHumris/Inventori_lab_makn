<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>Inventori Lab MAKN Ende</title>
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }
        .no-scroll { overflow: hidden; position: fixed; width: 100%; }
        
        @media print {
        /* Sembunyikan Navigasi & Sidebar */
        nav, aside, .print\:hidden {
            display: none !important;
        }
        /* Pastikan background putih & teks hitam saat print */
        body {
            background: white !important;
        }
    }

        /* Scrollbar halus */
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    </style>
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900" 
      x-data="{ open: false }" 
      :class="{ 'no-scroll': open }">
    
    {{-- HEADER MOBILE --}}
    <header class="lg:hidden bg-white border-b border-slate-200 px-4 py-3 flex items-center gap-4 sticky top-0 z-[110] shadow-sm">
        <button 
            type="button"
            @click.stop="open = !open" 
            class="p-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors relative z-[111]">
            <span class="material-symbols-outlined" x-text="open ? 'close' : 'menu'">menu</span>
        </button>
        
        <div class="flex items-center gap-2">
            <img src="{{ asset('assets/images/logo-makn.png') }}" alt="Logo" class="w-7 h-7 object-contain">
            <span class="text-sm font-black text-emerald-700 uppercase tracking-tight italic">Lab Inventory</span>
        </div>
    </header>

    <div class="flex min-h-screen">
        
        {{-- SIDEBAR --}}
        {{-- PERBAIKAN: Menggunakan h-screen dan inset-y-0 untuk menjamin tinggi penuh di mobile --}}
        <aside 
            :class="open ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="w-64 bg-white border-r border-slate-200 fixed inset-y-0 left-0 h-screen z-[120] shadow-xl lg:shadow-sm flex flex-col transition-transform duration-300 ease-in-out"
            x-cloak>
            
            {{-- 1. Logo (Flex-none agar tidak menyusut) --}}
            <div class="p-6 flex-none bg-white">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center p-1.5 border border-emerald-100">
                        <img src="{{ asset('assets/images/logo-makn.png') }}" alt="Logo MAKN" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h1 class="text-base font-black text-slate-800 leading-none uppercase italic">Lab Inventory</h1>
                        <p class="text-[9px] font-bold text-emerald-600 uppercase tracking-widest mt-1">MAKN ENDE</p>
                    </div>
                </div>
            </div>
            
            {{-- 2. Menu Navigasi (Flex-1 + overflow-y-auto) --}}
            <nav class="flex-1 px-4 space-y-1 overflow-y-auto custom-scrollbar pb-6">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-100' : 'text-slate-600 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined mr-3">dashboard</span> Dashboard
                </a>

                <div class="pt-4 pb-2">
                    <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Manajemen</p>
                </div>
                <a href="{{ route('kelola-barang') }}" 
                   class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('kelola-barang') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-100' : 'text-slate-600 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined mr-3">inventory_2</span> Menu Barang
                </a>
                <a href="{{ route('laporan') }}" 
                    wire:navigate 
                    class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('laporan') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined mr-3">assessment</span> Menu Laporan
                </a>

                <div class="pt-4 pb-2">
                    <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Transaksi</p>
                </div>
                <a href="{{ route('peminjaman') }}" 
                   class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('peminjaman') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-100' : 'text-slate-600 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined mr-3">outbox</span> Peminjaman
                </a>
                <a href="#" class="flex items-center px-4 py-3 text-sm font-semibold text-slate-600 rounded-xl hover:bg-slate-50">
                    <span class="material-symbols-outlined mr-3">move_to_inbox</span> Pengembalian
                </a>
            </nav>

            {{-- 3. Profil & Logout (Flex-none + Sticky/Fixed at Bottom) --}}
            {{-- PERBAIKAN: Menghapus mt-auto diganti dengan flex-none untuk kepastian posisi --}}
            <div class="p-4 border-t border-slate-100 bg-white flex-none mb-safe">
                <div class="px-4 py-3 bg-slate-50 rounded-xl mb-2 flex items-center gap-3 border border-slate-100 overflow-hidden">
                    <div class="w-8 h-8 flex-none bg-emerald-600 rounded-lg flex items-center justify-center text-white text-[10px] font-bold shadow-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-slate-500 capitalize font-medium truncate">{{ auth()->user()->role }} Lab</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-3 text-sm font-bold text-rose-500 rounded-xl hover:bg-rose-50 group transition-all">
                        <span class="material-symbols-outlined mr-3 group-hover:translate-x-1 transition-transform">logout</span>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- OVERLAY --}}
        <div 
            x-show="open" 
            @click="open = false" 
            x-transition:enter="transition opacity ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            class="fixed inset-0 bg-slate-900/40 z-[90] lg:hidden"
            x-cloak>
        </div>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 lg:ml-64 p-4 md:p-8 w-full min-h-screen relative z-0">
            {{ $slot }}
        </main>

    </div>
</body>
</html>