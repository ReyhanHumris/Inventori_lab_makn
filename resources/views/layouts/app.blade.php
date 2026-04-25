<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventori Lab MAKN Ende</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-slate-50" x-data="{ open: false }">
    
    <header class="lg:hidden bg-white border-b border-slate-200 px-4 py-3 flex items-center justify-between sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <img src="{{ asset('assets/images/logo-makn.png') }}" alt="Logo" class="w-8 h-8 object-contain">
            <span class="text-sm font-bold text-emerald-700 uppercase tracking-tight">Lab Inventory</span>
        </div>
        <button @click="open = !open" class="p-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
            <span class="material-symbols-outlined" x-text="open ? 'close' : 'menu'">menu</span>
        </button>
    </header>

    <div class="flex min-h-screen">
        
        <aside 
            :class="open ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="w-64 bg-white border-r border-slate-200 fixed h-full z-40 shadow-sm flex flex-col transition-transform duration-300 ease-in-out">
            
            <div class="p-6 flex items-center gap-3">
                <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center p-1.5 border border-emerald-100">
                    <img src="{{ asset('assets/images/logo-makn.png') }}" alt="Logo MAKN" class="w-full h-full object-contain">
                </div>
                <div>
                    <h1 class="text-base font-black text-slate-800 leading-none">LAB INVENTORY</h1>
                    <p class="text-[9px] font-bold text-emerald-600 uppercase tracking-widest mt-1">MAKN ENDE</p>
                </div>
            </div>
            
            <nav class="flex-1 px-4 space-y-2 overflow-y-auto pt-2">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl {{ request()->routeIs('dashboard') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-100' : 'text-slate-600 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined mr-3">dashboard</span> Dashboard
                </a>

                {{-- Menu Manajemen (Kepala Lab) --}}
                @if(auth()->user()->role == 'kepala')
                    <div class="pt-4 pb-2"><p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Manajemen</p></div>
                    <a href="{{ route('kelola-barang') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl {{ request()->routeIs('kelola-barang') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-100' : 'text-slate-600 hover:bg-slate-50' }}">
                        <span class="material-symbols-outlined mr-3">inventory_2</span> Menu Barang
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-sm font-semibold text-slate-600 rounded-xl hover:bg-slate-50 transition-colors">
                        <span class="material-symbols-outlined mr-3">assessment</span> Menu Laporan
                    </a>
                @endif

                {{-- Menu Transaksi (Petugas & Kepala Lab) --}}
                @if(auth()->user()->role == 'petugas' || auth()->user()->role == 'kepala')
                    <div class="pt-4 pb-2"><p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Transaksi</p></div>
                    <a href="#" class="flex items-center px-4 py-3 text-sm font-semibold text-slate-600 rounded-xl hover:bg-slate-50 transition-colors">
                        <span class="material-symbols-outlined mr-3">outbox</span> Peminjaman
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-sm font-semibold text-slate-600 rounded-xl hover:bg-slate-50 transition-colors">
                        <span class="material-symbols-outlined mr-3">move_to_inbox</span> Pengembalian
                    </a>
                @endif
            </nav>

            <div class="p-4 border-t border-slate-100 space-y-2">
                <div class="px-4 py-3 bg-slate-50 rounded-xl mb-2 flex items-center gap-3">
                    <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center text-white text-xs font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-slate-500 capitalize">{{ auth()->user()->role }} Lab</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-3 text-sm font-bold text-rose-500 rounded-xl hover:bg-rose-50 transition-all duration-300 group">
                        <span class="material-symbols-outlined mr-3 group-hover:translate-x-1 transition-transform">logout</span>
                        Keluar Sistem
                    </button>
                </form>
            </div>
        </aside>

        <div 
            x-show="open" 
            @click="open = false" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-slate-900/40 z-30 lg:hidden">
        </div>

        <main class="flex-1 lg:ml-64 p-4 md:p-8 w-full overflow-x-hidden">
            {{ $slot }}
        </main>

    </div>
</body>
</html>