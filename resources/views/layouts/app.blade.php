<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>Inventori Lab MAKN Ende</title>
    
    <!-- Google Fonts (Comfortable, professional, human-selected typography) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- QR Code Generator & Scanner CDNs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @livewireStyles
    <style>
        [x-cloak] { display: none !important; }
        .no-scroll { overflow: hidden; position: fixed; width: 100%; }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        @media print {
            nav, aside, .print\:hidden, header {
                display: none !important;
            }
            body {
                background: white !important;
            }
            main {
                margin-left: 0 !important;
                padding: 0 !important;
            }
        }

        /* Scrollbar halus */
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="antialiased text-slate-800" 
      x-data="{ open: false }" 
      :class="{ 'no-scroll': open }">
    
    {{-- HEADER MOBILE --}}
    <header class="lg:hidden bg-white border-b border-slate-200 px-5 py-3 flex items-center justify-between sticky top-0 z-[110] shadow-sm">
        <div class="flex items-center gap-3">
            <button 
                type="button"
                @click.stop="open = !open" 
                class="p-2 text-slate-600 hover:bg-slate-50 rounded-xl transition-all active:scale-90 relative z-[111]">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    <path x-show="open" stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
            
            <div class="flex items-center gap-2">
                <img src="{{ asset('assets/images/logo-makn.png') }}" alt="Logo" class="w-8 h-8 object-contain">
                <span class="text-sm font-bold text-slate-900 uppercase tracking-wider italic">Lab Inventory</span>
            </div>
        </div>
    </header>

    <div class="flex min-h-screen">
        
        {{-- SIDEBAR --}}
        <aside 
            :class="open ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="w-72 bg-white border-r border-slate-200 fixed inset-y-0 left-0 h-screen z-[120] flex flex-col transition-transform duration-300 ease-in-out"
            x-cloak>
            
            {{-- 1. Logo Header --}}
            <div class="p-6 flex-none bg-white border-b border-slate-100">
                <div class="flex items-center gap-3 group cursor-default">
                    <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center p-2 border border-emerald-100/50">
                        <img src="{{ asset('assets/images/logo-makn.png') }}" alt="Logo MAKN" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h1 class="text-sm font-bold text-slate-900 leading-none uppercase tracking-wide italic">Lab Inventory</h1>
                        <p class="text-[9px] font-bold text-emerald-600 uppercase tracking-widest mt-1.5">MAKN ENDE</p>
                    </div>
                </div>
            </div>
            
            {{-- 2. Menu Navigasi --}}
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto custom-scrollbar">
                <!-- Dashboard Link -->
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center px-4 py-3 text-xs uppercase tracking-wider font-semibold rounded-xl transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-650 hover:bg-slate-50 hover:text-slate-900 hover:translate-x-1' }}">
                    <svg class="mr-3 w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25A2.25 2.25 0 0 1 13.5 8.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                    Dashboard
                </a>

                <div class="pt-5 pb-1">
                    <p class="px-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Manajemen</p>
                </div>
                
                <!-- Kelola Barang Link -->
                <a href="{{ route('kelola-barang') }}" 
                   class="flex items-center px-4 py-3 text-xs uppercase tracking-wider font-semibold rounded-xl transition-all duration-200 group {{ request()->routeIs('kelola-barang') ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-655 hover:bg-slate-50 hover:text-slate-900 hover:translate-x-1' }}">
                    <svg class="mr-3 w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                    Menu Barang
                </a>

                @if(auth()->user()->role !== 'peminjam')
                <!-- Pemeliharaan Alat Link -->
                <a href="{{ route('kelola-maintenance') }}" 
                   class="flex items-center px-4 py-3 text-xs uppercase tracking-wider font-semibold rounded-xl transition-all duration-200 group {{ request()->routeIs('kelola-maintenance') ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-655 hover:bg-slate-50 hover:text-slate-900 hover:translate-x-1' }}">
                    <svg class="mr-3 w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.653 2.653 0 0021 17.25l-5.877-5.877M11.42 15.17L5.12 8.87M11.42 15.17a3 3 0 10-3-3l6.3 6.3M5.12 8.87a3.375 3.375 0 00-4.77 4.77l5.877 5.877M5.12 8.87L11.1 2.9M2.1 21a9 9 0 0115.3-6.3L21 21" />
                    </svg>
                    Pemeliharaan Alat
                </a>
                @endif
                
                @if(auth()->user()->role !== 'peminjam')
                <!-- Laporan Link -->
                <a href="{{ route('laporan') }}" 
                   class="flex items-center px-4 py-3 text-xs uppercase tracking-wider font-semibold rounded-xl transition-all duration-200 group {{ request()->routeIs('laporan') ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-655 hover:bg-slate-50 hover:text-slate-900 hover:translate-x-1' }}">
                    <svg class="mr-3 w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9z" />
                    </svg>
                    Menu Laporan
                </a>
                @endif

                @if(auth()->user()->role == 'kepala')
                <!-- Kelola User Link (Only for Kepala Lab) -->
                <a href="{{ route('kelola-user') }}" 
                   class="flex items-center px-4 py-3 text-xs uppercase tracking-wider font-semibold rounded-xl transition-all duration-200 group {{ request()->routeIs('kelola-user') ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-655 hover:bg-slate-50 hover:text-slate-900 hover:translate-x-1' }}">
                    <svg class="mr-3 w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0 1 10.089 20c-2.3 0-4.47-.521-6.413-1.458A4.125 4.125 0 0 1 7.53 14.5a4.125 4.125 0 0 1 7.47 3.073M12 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM19.5 8.25a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                    Kelola Pengguna
                </a>

                <!-- Audit Trail Link (Only for Kepala Lab) -->
                <a href="{{ route('audit-trail') }}" 
                   class="flex items-center px-4 py-3 text-xs uppercase tracking-wider font-semibold rounded-xl transition-all duration-200 group {{ request()->routeIs('audit-trail') ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-655 hover:bg-slate-50 hover:text-slate-900 hover:translate-x-1' }}">
                    <svg class="mr-3 w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.03 0 1.9.693 2.166 1.638m-7.377 0A48.536 48.536 0 0112 3m0 0c2.917 0 5.747.294 8.5.862m-21 1.402L3 20.25a2.25 2.25 0 0 0 2.25 2.25h13.5A2.25 2.25 0 0 0 21 20.25V6.108" />
                    </svg>
                    Audit Trail
                </a>
                @endif

                <div class="pt-5 pb-1">
                    <p class="px-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Transaksi</p>
                </div>
                
                <!-- Transaksi Peminjaman Link -->
                <a href="{{ route('peminjaman') }}" 
                   class="flex items-center px-4 py-3 text-xs uppercase tracking-wider font-semibold rounded-xl transition-all duration-200 group {{ request()->routeIs('peminjaman') ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-655 hover:bg-slate-50 hover:text-slate-900 hover:translate-x-1' }}">
                    <svg class="mr-3 w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                    </svg>
                    Peminjaman
                </a>
            </nav>

            {{-- 3. Profil & Logout --}}
            <div class="p-4 border-t border-slate-100 bg-white flex-none mb-safe space-y-1">
                <div class="px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-2xl flex items-center gap-3 overflow-hidden cursor-default">
                    <div class="w-8 h-8 flex-none bg-emerald-600 rounded-lg flex items-center justify-center text-white text-xs font-semibold shadow-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-slate-800 truncate leading-tight">{{ auth()->user()->name }}</p>
                        <p class="text-[9px] text-emerald-600 capitalize font-bold tracking-wider mt-1">{{ auth()->user()->role }} Lab</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-2.5 text-xs uppercase tracking-wider font-bold text-rose-500 rounded-xl hover:bg-rose-50 group transition-all duration-200">
                        <svg class="mr-3.5 w-5 h-5 transition-transform duration-300 group-hover:-translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                        </svg>
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
            x-transition:leave="transition opacity ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-slate-900/30 backdrop-blur-[1px] z-[90] lg:hidden"
            x-cloak>
        </div>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 lg:ml-72 p-6 md:p-8 lg:p-10 w-full min-h-screen relative z-0 bg-slate-50/50">
            {{ $slot }}
        </main>

    </div>
    
    @livewireScripts
</body>
</html>