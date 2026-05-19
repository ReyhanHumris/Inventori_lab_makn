<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-3">
                <span class="p-2.5 bg-slate-100 rounded-2xl text-slate-700 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25A2.25 2.25 0 0 1 13.5 8.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                </span>
                Ringkasan Dashboard
            </h2>
            <p class="text-slate-500 text-sm mt-1">Status aset terkini dan aktivitas laboratorium hari ini secara real-time.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="px-4 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl font-semibold text-xs hover:bg-slate-50 transition-colors shadow-sm">
                Ekspor Laporan
            </button>
            @if(auth()->user()->role == 'kepala')
            <a href="{{ route('kelola-barang') }}" class="px-4 py-2.5 bg-emerald-600 text-white rounded-xl font-bold text-xs hover:bg-emerald-700 transition-colors shadow-sm flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Aset
            </a>
            @endif
        </div>
    </div>

    <!-- Stats Summary Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Total Aset -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between hover:shadow transition-shadow group cursor-default">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <span class="p-3 bg-emerald-50 rounded-xl text-emerald-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                    </span>
                    <span class="text-emerald-600 text-[10px] font-bold bg-emerald-50 px-2.5 py-0.5 rounded-full uppercase tracking-wider">Total Aset</span>
                </div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Barang Inventaris</p>
                <h3 class="text-3xl font-bold text-slate-900 leading-none">{{ $totalBarang }} <span class="text-sm font-semibold text-slate-400">Unit</span></h3>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 grid grid-cols-2 gap-4">
                <div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Tersedia</p>
                    <p class="font-bold text-xl text-emerald-650 mt-0.5">{{ $stats['tersedia'] }} <span class="text-[10px] font-medium text-slate-450">Unit</span></p>
                </div>
                <div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Dipinjam</p>
                    <p class="font-bold text-xl text-blue-600 mt-0.5">{{ $stats['dipinjam'] }} <span class="text-[10px] font-medium text-slate-450">Unit</span></p>
                </div>
            </div>
        </div>

        <!-- Status Pemeliharaan -->
        @php
            $persenBaik = $totalBarang > 0 ? round((($totalBarang - $stats['rusak']) / $totalBarang) * 100) : 100;
        @endphp
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between hover:shadow transition-shadow group cursor-default">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <span class="p-3 bg-teal-50 rounded-xl text-teal-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A1.875 1.875 0 1114.6 18.4l-5.83-5.83m0 0a2.25 2.25 0 113.18-3.18l5.83 5.83m-5.83-5.83l-1 .1-1 .1m1-.2l.1-1 .1-1m-4.42 8a3 3 0 004.24 4.24m0 0l-5.83-5.83m5.83 5.83l1 .1-1 .1" />
                        </svg>
                    </span>
                    <span class="text-teal-605 text-[10px] font-bold bg-teal-50 px-2.5 py-0.5 rounded-full uppercase tracking-wider">Pemeliharaan</span>
                </div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Rasio Kelayakan Aset</p>
                <h3 class="text-3xl font-bold text-slate-900 leading-none">{{ $persenBaik }}% <span class="text-xs font-semibold text-slate-400">Kondisi Baik</span></h3>
            </div>
            <div class="mt-6 space-y-2">
                <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden shadow-inner">
                    <div class="bg-emerald-500 h-full rounded-full transition-all duration-300" style="width: {{ $persenBaik }}%"></div>
                </div>
                <div class="text-[9px] text-slate-450 italic flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-rose-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                    <span>{{ $stats['rusak'] }} unit alat dalam status rusak / perlu perbaikan.</span>
                </div>
            </div>
        </div>

        <!-- Aktivitas Sistem -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between hover:shadow transition-shadow group cursor-default">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <span class="p-3 bg-blue-50 rounded-xl text-blue-650 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a9 9 0 1 1-11.814 0A9 9 0 0 1 21 12z" />
                        </svg>
                    </span>
                    <span class="text-blue-650 text-[10px] font-bold bg-blue-50 px-2.5 py-0.5 rounded-full uppercase tracking-wider">Status Sistem</span>
                </div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Koneksi Layanan</p>
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <p class="text-xs text-slate-700 font-semibold">Server App</p>
                        </div>
                        <span class="text-[8px] font-bold uppercase text-emerald-650 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">ONLINE</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <p class="text-xs text-slate-700 font-semibold">Database Server</p>
                        </div>
                        <span class="text-[8px] font-bold uppercase text-emerald-650 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">CONNECTED</span>
                    </div>
                </div>
            </div>
            <div class="mt-6 pt-3 border-t border-slate-50 text-[9px] text-slate-400 font-medium">
                Pembaruan otomatis real-time aktif.
            </div>
        </div>
    </div>

    <!-- Data Barang Terbaru Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden transition-all duration-300">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <div>
                <h4 class="font-bold text-slate-900 text-sm">Penambahan Aset Terbaru</h4>
                <p class="text-xs text-slate-550 mt-0.5">5 barang teratas yang baru ditambahkan ke inventaris.</p>
            </div>
            <span class="text-[9px] font-bold text-emerald-650 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-100 tracking-wider">DATABASE</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest pl-8">Nama Barang</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Kategori</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Rasio Stok</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest pr-8">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($barangs as $barang)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4 pl-8">
                            <p class="font-bold text-sm text-slate-900">{{ $barang->nama_barang }}</p>
                            <p class="text-[10px] text-slate-450 font-mono mt-0.5">ID: #{{ str_pad($barang->id, 4, '0', STR_PAD_LEFT) }}</p>
                        </td>
                        <td class="px-6 py-4 text-xs font-semibold text-slate-600">
                            <span class="px-2 py-0.5 bg-slate-100 rounded-md">{{ $barang->kategori }}</span>
                        </td>
                        <td class="px-6 py-4 text-xs font-bold text-slate-700">
                            <span class="bg-slate-50 px-2 py-0.5 border border-slate-100 rounded-md font-bold text-slate-800">{{ $barang->stok_tersedia }} / {{ $barang->stok_total }}</span>
                        </td>
                        <td class="px-6 py-4 pr-8">
                            <a href="{{ route('kelola-barang') }}" class="inline-flex p-2 text-slate-400 hover:text-slate-900 hover:bg-slate-50 rounded-lg transition-colors" title="Buka Detail">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-400 italic">
                            <div class="flex flex-col items-center justify-center space-y-1 opacity-50">
                                <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                </svg>
                                <span class="text-sm font-medium">Belum ada data barang terdaftar.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>