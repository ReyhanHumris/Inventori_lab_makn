<div class="pt-8 pb-12 px-4 md:px-8 bg-slate-50 min-h-screen">
    <div class="max-w-6xl mx-auto">
        
        {{-- HEADER & FILTER (Sembunyi saat print) --}}
        <div class="print:hidden mb-8 space-y-6">
            <div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">Laporan Inventaris</h2>
                <p class="text-slate-500">Generate dan cetak laporan transaksi laboratorium.</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-end gap-4">
                <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-4 w-full">
                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase ml-1">Dari Tanggal</label>
                        <input wire:model.live="tgl_mulai" type="date" class="w-full mt-1 px-4 py-2 rounded-xl border border-slate-200 outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase ml-1">Sampai Tanggal</label>
                        <input wire:model.live="tgl_selesai" type="date" class="w-full mt-1 px-4 py-2 rounded-xl border border-slate-200 outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase ml-1">Status Barang</label>
                        <select wire:model.live="status_filter" class="w-full mt-1 px-4 py-2 rounded-xl border border-slate-200 outline-none">
                            <option value="semua">Semua Transaksi</option>
                            <option value="Dipinjam">Sedang Dipinjam</option>
                            <option value="Kembali">Sudah Kembali</option>
                        </select>
                    </div>
                </div>
                <button onclick="window.print()" class="flex items-center justify-center gap-2 px-6 py-2.5 bg-slate-800 text-white font-bold rounded-xl hover:bg-black transition-all shadow-lg">
                    <span class="material-symbols-outlined text-sm">print</span> Cetak
                </button>
            </div>
        </div>

        {{-- AREA CETAK LAPORAN --}}
        <div class="bg-white p-8 md:p-12 rounded-3xl border border-slate-200 shadow-sm print:shadow-none print:border-none print:p-0">
            
            {{-- KOP SURAT --}}
            <div class="text-center mb-10 border-b-4 border-double border-slate-900 pb-6">
                <h1 class="text-2xl font-black uppercase tracking-tighter text-slate-900">Laporan Inventaris Laboratorium</h1>
                <p class="text-sm font-bold text-emerald-700 uppercase tracking-widest">MAKN ENDE - Jurusan PPLG</p>
                <p class="text-[10px] text-slate-500 mt-1 italic">Data diunduh pada: {{ now()->format('d F Y, H:i') }}</p>
            </div>

            {{-- RINGKASAN DATA --}}
            <div class="grid grid-cols-2 gap-6 mb-8">
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 text-center">
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Total Unit Barang</p>
                    <p class="text-2xl font-black text-slate-800">{{ $total_barang }}</p>
                </div>
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 text-center">
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Kondisi Rusak</p>
                    <p class="text-2xl font-black text-rose-600">{{ $barang_rusak }}</p>
                </div>
            </div>

            {{-- TABEL DATA --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse border border-slate-200">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="p-4 border border-slate-200 text-[10px] font-black uppercase text-slate-500">No</th>
                            <th class="p-4 border border-slate-200 text-[10px] font-black uppercase text-slate-500">Peminjam</th>
                            <th class="p-4 border border-slate-200 text-[10px] font-black uppercase text-slate-500">Alat</th>
                            <th class="p-4 border border-slate-200 text-[10px] font-black uppercase text-slate-500 text-center">Jumlah</th>
                            <th class="p-4 border border-slate-200 text-[10px] font-black uppercase text-slate-500">Tanggal</th>
                            <th class="p-4 border border-slate-200 text-[10px] font-black uppercase text-slate-500 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($laporan_data as $index => $item)
                        <tr>
                            <td class="p-4 border border-slate-200 text-sm text-center">{{ $index + 1 }}</td>
                            <td class="p-4 border border-slate-200 text-sm">
                                <p class="font-bold text-slate-800">{{ $item->nama_peminjam }}</p>
                                <p class="text-[10px] text-slate-400">ID: {{ $item->nim }}</p>
                            </td>
                            <td class="p-4 border border-slate-200 text-sm font-medium">{{ $item->barang->nama_barang }}</td>
                            <td class="p-4 border border-slate-200 text-sm text-center font-bold">{{ $item->jumlah }}</td>
                            <td class="p-4 border border-slate-200 text-xs">
                                {{ date('d/m/Y', strtotime($item->tgl_pinjam)) }}
                            </td>
                            <td class="p-4 border border-slate-200 text-center uppercase">
                                <span class="text-[9px] font-black {{ $item->status == 'Dipinjam' ? 'text-orange-600' : 'text-emerald-600' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-slate-400 italic">Tidak ada data transaksi ditemukan.</td>
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