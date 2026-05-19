<div class="p-4 md:p-6 lg:p-8 space-y-8 bg-slate-50 min-h-screen">
    <div class="max-w-6xl mx-auto space-y-8">
        
        {{-- HEADER & FILTER (Sembunyi saat print) --}}
        <div class="print:hidden space-y-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-3">
                    <span class="p-2.5 bg-slate-100 rounded-2xl text-slate-700 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9z" />
                        </svg>
                    </span>
                    Laporan Inventaris
                </h2>
                <p class="text-slate-500 text-sm mt-1">Generate, filter, dan cetak dokumen laporan peminjaman laboratorium.</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-end gap-6 hover:shadow transition-shadow duration-300">
                <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-6 w-full">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Dari Tanggal</label>
                        <input wire:model.live="tgl_mulai" type="date" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:bg-white outline-none transition-colors">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Sampai Tanggal</label>
                        <input wire:model.live="tgl_selesai" type="date" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:bg-white outline-none transition-colors">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Status Transaksi</label>
                        <div class="relative">
                            <select wire:model.live="status_filter" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:bg-white outline-none appearance-none bg-none">
                                <option value="semua">Semua Transaksi</option>
                                <option value="Dipinjam">Sedang Dipinjam</option>
                                <option value="Kembali">Sudah Kembali</option>
                            </select>
                            <svg class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </div>
                </div>
                <button onclick="window.print()" class="w-full md:w-auto flex items-center justify-center gap-2 px-5 py-2.5 bg-slate-900 text-white font-semibold text-xs rounded-xl hover:bg-black transition-colors shadow-sm">
                    <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 19.125h10.56a2.25 2.25 0 0 0 2.25-2.25V9A2.25 2.25 0 0 0 17.28 6.75H6.72A2.25 2.25 0 0 0 4.47 9v7.875a2.25 2.25 0 0 0 2.25 2.25Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V4.5a2.25 2.25 0 0 1 2.25-2.25h1.5A2.25 2.25 0 0 1 15 4.5v2.25m-6 0h6m-6 7.5h6m-6 3h6" />
                    </svg> 
                    Cetak Dokumen
                </button>
            </div>
        </div>

        {{-- AREA CETAK LAPORAN --}}
        <div class="bg-white p-8 md:p-12 rounded-2xl border border-slate-200 shadow-sm print:shadow-none print:border-none print:p-0">
            
            {{-- KOP SURAT --}}
            <div class="text-center mb-10 border-b-4 border-double border-slate-900 pb-6">
                <h1 class="text-xl font-bold uppercase tracking-tight text-slate-900">Laporan Inventaris Laboratorium</h1>
                <p class="text-xs font-bold text-emerald-700 uppercase tracking-widest mt-1">MAKN ENDE - Jurusan PPLG</p>
                <p class="text-[9px] text-slate-400 mt-2 font-mono">Data diunduh pada: {{ now()->format('d F Y, H:i') }} WITA</p>
            </div>

            {{-- RINGKASAN DATA --}}
            <div class="grid grid-cols-2 gap-6 mb-8">
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 text-center">
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-1">Total Stok Aset</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $total_barang }} <span class="text-xs font-normal text-slate-500">Unit</span></p>
                </div>
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 text-center">
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-1">Dalam Kondisi Rusak</p>
                    <p class="text-2xl font-bold text-rose-600">{{ $barang_rusak }} <span class="text-xs font-normal text-rose-500">Aset</span></p>
                </div>
            </div>

            {{-- TABEL DATA --}}
            <div class="overflow-x-auto rounded-xl border border-slate-200 custom-scrollbar">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="p-3 text-[10px] font-bold uppercase text-slate-450 tracking-wider text-center w-12">No</th>
                            <th class="p-3 text-[10px] font-bold uppercase text-slate-455 tracking-wider">Nama Peminjam</th>
                            <th class="p-3 text-[10px] font-bold uppercase text-slate-455 tracking-wider">Perangkat / Alat</th>
                            <th class="p-3 text-[10px] font-bold uppercase text-slate-450 tracking-wider text-center w-20">Jumlah</th>
                            <th class="p-3 text-[10px] font-bold uppercase text-slate-450 tracking-wider">Tanggal Pinjam</th>
                            <th class="p-3 text-[10px] font-bold uppercase text-slate-450 tracking-wider text-center pr-6 w-28">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($laporan_data as $index => $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-3 text-center font-bold text-slate-400">{{ $index + 1 }}</td>
                            <td class="p-3">
                                <p class="font-bold text-slate-800">{{ $item->nama_peminjam }}</p>
                                <p class="text-[9px] text-slate-400 font-mono">NIM: {{ $item->nim }}</p>
                            </td>
                            <td class="p-3 font-semibold text-slate-700">{{ $item->barang->nama_barang ?? 'Aset Dihapus' }}</td>
                            <td class="p-3 text-center font-bold text-slate-800">{{ $item->jumlah }}</td>
                            <td class="p-3 text-xs text-slate-500">
                                {{ date('d M Y', strtotime($item->tgl_pinjam)) }}
                                <p class="text-[9px] text-slate-400 mt-0.5">Batas: {{ date('d M Y', strtotime($item->tgl_kembali)) }}</p>
                            </td>
                            <td class="p-3 text-center pr-6">
                                <span class="inline-flex items-center px-2 py-0.5 text-[9px] font-bold rounded-full uppercase tracking-wider {{ $item->status == 'Dipinjam' ? 'bg-amber-50 border border-amber-100 text-amber-800' : 'bg-emerald-50 border border-emerald-100 text-emerald-800' }}">
                                    <span class="w-1 h-1 rounded-full mr-1.5 {{ $item->status == 'Dipinjam' ? 'bg-amber-500 animate-pulse' : 'bg-emerald-500' }}"></span>
                                    {{ $item->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center space-y-2 opacity-50">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                                    </svg>
                                    <span class="text-xs font-semibold italic">Tidak ada transaksi yang cocok dengan filter tanggal/status.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- TANDA TANGAN --}}
            <div class="hidden print:grid grid-cols-2 mt-20 text-center">
                <div class="space-y-20">
                    <p class="text-sm">Mengetahui,<br>Kepala Laboratorium</p>
                    <p class="text-sm font-bold underline">( ........................................ )</p>
                </div>
                <div class="space-y-20">
                    <p class="text-sm">Ende, {{ now()->format('d F Y') }}<br>Petugas Lab</p>
                    <p class="text-sm font-bold underline">{{ auth()->user()->name }}</p>
                </div>
            </div>
        </div>
    </div>
</div>