<div x-data="{ openModal: false }" @close-modal.window="openModal = false">
    <div class="pt-8 pb-12 px-4 md:px-8 bg-slate-50 min-h-screen">
        <div class="max-w-6xl mx-auto">
            
            @if (session()->has('message'))
                <div class="mb-4 p-4 bg-emerald-100 text-emerald-700 rounded-xl font-bold shadow-sm">
                    {{ session('message') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-4 p-4 bg-rose-100 text-rose-700 rounded-xl font-bold shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-2xl font-black text-slate-800 tracking-tight">Daftar Peminjam Aktif</h2>
                    <p class="text-slate-500">Pantau status pengembalian alat secara real-time.</p>
                </div>
                <button @click="openModal = true" class="flex items-center justify-center gap-2 px-6 py-3 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg">
                    <span class="material-symbols-outlined">add_circle</span> Tambah Peminjaman
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 flex items-center gap-5 shadow-sm">
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-3xl">group</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Peminjam</p>
                        <p class="text-2xl font-black text-slate-800">{{ $stats['total'] }} Orang</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-200 flex items-center gap-5 shadow-sm">
                    <div class="w-14 h-14 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-3xl">history_toggle_off</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Terlambat</p>
                        <p class="text-2xl font-black text-rose-600">{{ $stats['terlambat'] }} Orang</p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Peminjam</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Alat & Jumlah</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Batas Kembali</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($peminjam_aktif as $p)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-xs">
                                        {{ strtoupper(substr($p->nama_peminjam, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800">{{ $p->nama_peminjam }}</p>
                                        <p class="text-[11px] text-slate-500 font-medium">ID: {{ $p->nim }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-semibold text-slate-700">{{ $p->barang->nama_barang ?? 'Alat Dihapus' }}</p>
                                <p class="text-xs text-slate-500">{{ $p->jumlah }} Unit</p>
                            </td>
                            <td class="px-6 py-4 text-sm {{ $p->tgl_kembali < now() ? 'text-rose-600 font-bold' : 'text-slate-600' }}">
                                {{ date('d M, H:i', strtotime($p->tgl_kembali)) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button 
                                    wire:click="kembalikanBarang({{ $p->id }})" 
                                    wire:confirm="Yakin barang ini sudah dikembalikan ke Lab?"
                                    class="px-4 py-2 bg-emerald-50 text-emerald-600 rounded-lg text-xs font-bold hover:bg-emerald-600 hover:text-white transition-all">
                                    Kembalikan
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center opacity-40">
                                    <span class="material-symbols-outlined text-5xl mb-2">inventory_2</span>
                                    <p class="text-slate-500 font-medium">Belum ada peminjaman aktif.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div x-show="openModal" x-cloak class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[100] flex items-center justify-center p-4">
    <div @click.away="openModal = false" class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden transform transition-all">
        {{-- Header Modal --}}
        <div class="px-8 py-6 bg-emerald-600 text-white flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined">edit_square</span>
                <h3 class="text-xl font-bold">Form Peminjaman Aset</h3>
            </div>
            <button @click="openModal = false" class="hover:rotate-90 transition-transform">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        {{-- Body Form --}}
        <form wire:submit.prevent="simpanPeminjaman" class="p-8 space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Peminjam</label>
                    <input wire:model="nama_peminjam" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-600 outline-none transition-all" placeholder="Contoh: Andi Wijaya" type="text"/>
                    @error('nama_peminjam') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">NIM / NIDN</label>
                    <input wire:model="nim" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-600 outline-none transition-all" placeholder="12345678" type="text"/>
                    @error('nim') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Pilih Barang</label>
                <div class="relative">
                    <select wire:model.live="barang_id" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-600 outline-none appearance-none transition-all bg-white">
                        <option value="">Pilih aset dari inventaris...</option>
                        @foreach($daftar_barang as $b)
                            <option value="{{ $b->id }}">{{ $b->nama_barang }} (Tersedia: {{ $b->stok_tersedia }})</option>
                        @endforeach
                    </select>
                    <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">keyboard_arrow_down</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Jumlah Pinjam</label>
                    <input wire:model.live="jumlah" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-600 outline-none transition-all" type="number"/>
                    
                    {{-- Alert Stok Habis (Tampil jika jumlah > stok tersedia) --}}
                    @if($barang_id && $jumlah > ($daftar_barang->find($barang_id)->stok_tersedia ?? 0))
                        <div class="flex items-center gap-2 p-2 bg-rose-50 border border-rose-100 rounded-lg text-rose-600 mt-2">
                            <span class="material-symbols-outlined text-sm">error</span>
                            <p class="text-[10px] font-semibold">Stok tidak cukup. Sisa: {{ $daftar_barang->find($barang_id)->stok_tersedia }} unit.</p>
                        </div>
                    @endif
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Batas Kembali</label>
                    <input wire:model="tgl_kembali" type="datetime-local" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-600 outline-none transition-all">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Keperluan</label>
                <textarea wire:model="keperluan" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-600 outline-none transition-all" placeholder="Deskripsikan tujuan peminjaman..." rows="3"></textarea>
                @error('keperluan') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4 flex gap-4">
                <button @click="openModal = false" type="button" class="flex-1 px-6 py-4 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-all">
                    Batal
                </button>
                <button type="submit" 
                    class="flex-[2] px-6 py-4 bg-emerald-600 text-white font-bold rounded-xl shadow-lg hover:bg-emerald-700 transition-all flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                    @if($barang_id && $jumlah > ($daftar_barang->find($barang_id)->stok_tersedia ?? 0)) disabled @endif>
                    <span class="material-symbols-outlined">save</span>
                    Simpan Transaksi
                </button>
            </div>
        </form>
    </div>
</div>
    </div>
</div>