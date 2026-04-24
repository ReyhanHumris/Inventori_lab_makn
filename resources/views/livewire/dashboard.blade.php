<div>
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Ringkasan Dashboard</h2>
            <p class="text-slate-500 text-sm">Status aset dan aktivitas laboratorium hari ini.</p>
        </div>
        <div class="flex space-x-3">
            <button class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl font-bold text-xs hover:bg-slate-50 transition-all flex items-center shadow-sm">
                <span class="material-symbols-outlined text-sm mr-2">download</span> Ekspor Laporan
            </button>
            @if(auth()->user()->role == 'kepala')
            <a href="{{ route('kelola-barang') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-xl font-bold text-xs hover:bg-emerald-700 transition-all flex items-center shadow-lg shadow-emerald-200">
                <span class="material-symbols-outlined text-sm mr-2">add</span> Tambah Aset
            </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6 mb-8">
        <div class="col-span-12 lg:col-span-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <span class="material-symbols-outlined text-emerald-600 p-2 bg-emerald-50 rounded-xl">inventory</span>
                    <span class="text-emerald-600 text-[10px] font-bold bg-emerald-100 px-2 py-1 rounded-lg uppercase">Total Aset</span>
                </div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Barang Inventaris</p>
                <h3 class="text-4xl font-black text-slate-900">{{ $totalBarang }} <span class="text-lg font-medium text-slate-400">Unit</span></h3>
            </div>
            <div class="mt-6 pt-6 border-t border-slate-50 grid grid-cols-2 gap-4">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Tersedia</p>
                    <p class="font-bold text-emerald-600">{{ $totalBarang }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Dipinjam</p>
                    <p class="font-bold text-blue-600">0</p>
                </div>
            </div>
        </div>

        <div class="col-span-12 lg:col-span-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h4 class="font-bold text-slate-900 text-sm">Status Pemeliharaan</h4>
                <span class="material-symbols-outlined text-slate-400 text-sm">build</span>
            </div>
            <div class="space-y-4">
                <div class="flex justify-between text-xs font-bold">
                    <span class="text-slate-500">Kondisi Baik</span>
                    <span>100%</span>
                </div>
                <div class="w-full bg-slate-100 h-2 rounded-full">
                    <div class="bg-emerald-500 h-full w-full rounded-full"></div>
                </div>
                <p class="text-[10px] text-slate-400 mt-4 italic">*Semua aset dalam kondisi prima hari ini.</p>
            </div>
        </div>

        <div class="col-span-12 lg:col-span-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h4 class="font-bold text-slate-900 text-sm mb-4">Aktivitas Sistem</h4>
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                    <p class="text-xs text-slate-600 font-medium">Sistem Inventori Aktif</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                    <p class="text-xs text-slate-600 font-medium">Database Terkoneksi</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h4 class="font-bold text-slate-900 text-sm">Data Barang Terbaru</h4>
            <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-100">REALTIME DATA</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Nama Barang</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Kategori</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($barangs as $barang)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-bold text-sm text-slate-900">{{ $barang->nama_barang }}</p>
                            <p class="text-[10px] text-slate-400">ID: #{{ $barang->id }}</p>
                        </td>
                        <td class="px-6 py-4 text-xs font-medium text-slate-600">Hardware</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-bold rounded-lg uppercase">Tersedia</span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="text-slate-400 hover:text-emerald-600 transition-colors">
                                <span class="material-symbols-outlined text-lg">visibility</span>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-slate-400 text-sm italic">Belum ada data barang.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>