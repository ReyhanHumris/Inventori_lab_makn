<div class="min-h-screen bg-background">
    <main class="p-container-margin max-w-[1440px] mx-auto">
        
        <div class="mb-lg">
            <h2 class="font-headline-md text-headline-md text-on-background">
                Dashboard {{ $user->role == 'kepala' ? 'Kepala Lab' : 'Petugas' }} 
            </h2>
            <p class="font-body-md text-body-md text-on-surface-variant">
                Selamat datang, <strong>{{ $user->name }}</strong>. Silakan kelola inventaris.
            </p>
        </div>

        <div class="grid grid-cols-12 gap-lg">
            
            @if($user->role == 'kepala')
                <div class="col-span-12 lg:col-span-6 bg-emerald-700 rounded-xl p-8 text-white shadow-lg">
                    <h3 class="text-xl font-bold mb-2">Manajemen Barang</h3>
                    <p class="mb-6">Update data aset IT MAKN Ende.</p>
                    <a href="/kelola-barang" class="bg-white text-emerald-700 px-6 py-2 rounded-lg font-bold">Buka Menu</a>
                </div>
            @else
                <div class="col-span-12 lg:col-span-6 bg-blue-600 rounded-xl p-8 text-white shadow-lg">
                    <h3 class="text-xl font-bold mb-2">Transaksi Peminjaman</h3>
                    <p class="mb-6">Proses pinjam barang untuk siswa/guru.</p>
                    <button class="bg-white text-blue-600 px-6 py-2 rounded-lg font-bold">Input Pinjaman</button>
                </div>
            @endif

            <div class="col-span-12 md:col-span-4 bg-white p-6 rounded-xl border border-slate-200">
                <p class="text-xs font-bold text-slate-500">ASET TERSEDIA</p>
                <p class="text-2xl font-bold text-emerald-600">{{ $stats['tersedia'] }} Unit</p>
            </div>
            
            </div>
    </main>
</div>