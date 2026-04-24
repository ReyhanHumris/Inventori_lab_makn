<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventori Lab MAKN Ende</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    
    <div class="flex min-h-screen bg-slate-50">
        
        <aside class="w-64 bg-white border-r border-slate-200 fixed h-full shadow-sm">
            <div class="p-6">
                <h1 class="text-xl font-bold text-emerald-700">Inventori Lab MAKN</h1>
            </div>
            
            <nav class="flex-1 px-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl {{ request()->routeIs('dashboard') ? 'bg-emerald-600 text-white' : 'text-slate-600' }}">
                    <span class="material-symbols-outlined mr-3">dashboard</span> Dashboard
                </a>

                {{-- Menu Manajemen (Kepala Lab) --}}
                @if(auth()->user()->role == 'kepala')
                    <div class="pt-4 pb-2"><p class="px-4 text-[10px] font-bold text-slate-400 uppercase">Manajemen</p></div>
                    <a href="{{ route('kelola-barang') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl {{ request()->routeIs('kelola-barang') ? 'bg-emerald-600 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                        <span class="material-symbols-outlined mr-3">inventory_2</span> Menu Barang
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-sm font-semibold text-slate-600 rounded-xl hover:bg-slate-100">
                        <span class="material-symbols-outlined mr-3">assessment</span> Menu Laporan
                    </a>
                @endif

                {{-- Menu Transaksi (Petugas & Kepala Lab) --}}
                @if(auth()->user()->role == 'petugas' || auth()->user()->role == 'kepala')
                    <div class="pt-4 pb-2"><p class="px-4 text-[10px] font-bold text-slate-400 uppercase">Transaksi</p></div>
                    <a href="#" class="flex items-center px-4 py-3 text-sm font-semibold text-slate-600 rounded-xl hover:bg-slate-100">
                        <span class="material-symbols-outlined mr-3">outbox</span> Peminjaman
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-sm font-semibold text-slate-600 rounded-xl hover:bg-slate-100">
                        <span class="material-symbols-outlined mr-3">move_to_inbox</span> Pengembalian
                    </a>
                @endif
            </nav>
        </aside>

        <main class="flex-1 ml-64 p-8">
            {{ $slot }}
        </main>

    </div>
</body>
</html>