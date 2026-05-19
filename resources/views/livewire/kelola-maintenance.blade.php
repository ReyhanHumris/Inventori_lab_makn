<div class="max-w-[1440px] mx-auto p-4 md:p-6 lg:p-8 space-y-8 bg-slate-50 min-h-screen">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-3">
                <span class="p-2.5 bg-slate-100 rounded-2xl text-slate-700 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.653 2.653 0 0021 17.25l-5.877-5.877M11.42 15.17L5.12 8.87M11.42 15.17a3 3 0 10-3-3l6.3 6.3M5.12 8.87a3.375 3.375 0 00-4.77 4.77l5.877 5.877M5.12 8.87L11.1 2.9M2.1 21a9 9 0 0115.3-6.3L21 21M9 9l.008-.008H9V9z" />
                    </svg>
                </span>
                Pemeliharaan & Perbaikan
            </h2>
            <p class="text-slate-500 text-sm mt-1">Pantau dan catat riwayat perawatan, kalibrasi, serta servis perangkat lab.</p>
        </div>
        <button wire:click="create()" class="group px-4 py-2.5 bg-emerald-600 text-white rounded-xl font-semibold text-xs hover:bg-emerald-700 transition-colors flex items-center shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Catat Pemeliharaan Baru
        </button>
    </div>

    <!-- Alert Notifications -->
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
             class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-xl text-sm font-semibold flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-2 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('message') }}
        </div>
    @endif

    <!-- Interactive Stats Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Pemeliharaan -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4 hover:shadow transition-shadow cursor-default">
            <div class="w-12 h-12 bg-slate-50 text-slate-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.03 0 1.9.693 2.166 1.638m-7.377 0A48.536 48.536 0 0112 3m0 0c2.917 0 5.747.294 8.5.862m-21 1.402L3 20.25a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 20.25V6.108M3 18.75h18" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider pl-0.5">Total Kegiatan Servis</p>
                <h3 class="text-2xl font-bold mt-0.5 text-slate-900">{{ $stats['total_pemeliharaan'] }} <span class="text-xs font-normal text-slate-500">Kali</span></h3>
            </div>
        </div>

        <!-- Sedang Proses -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4 hover:shadow transition-shadow cursor-default">
            <div class="w-12 h-12 bg-amber-50 text-amber-605 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider pl-0.5">Sedang Dalam Proses</p>
                <h3 class="text-2xl font-bold mt-0.5 text-amber-600">{{ $stats['sedang_proses'] }} <span class="text-xs font-normal text-amber-500">Aset</span></h3>
            </div>
        </div>

        <!-- Total Pengeluaran Biaya -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4 hover:shadow transition-shadow cursor-default">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.22.08a2.25 2.25 0 002.56-1.336a2.25 2.25 0 00-2.56-1.336l-.44-.16a2.25 2.25 0 01-1.28-2.672a2.25 2.25 0 012.56 1.336a2.25 2.25 0 01-2.56-1.336l-.22-.08M9 6h6m-3-3v3m0 12v3" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider pl-0.5">Total Pengeluaran Perbaikan</p>
                <h3 class="text-xl font-bold mt-0.5 text-slate-900">Rp {{ number_format($stats['total_biaya'], 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <!-- Search bar -->
    <div class="flex justify-between items-center bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <div class="relative w-full max-w-sm">
            <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
            <input wire:model.live="search" class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:bg-white outline-none transition-colors" placeholder="Cari nama perangkat/jenis pemeliharaan..."/>
        </div>
    </div>

    <!-- Maintenance Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider pl-8">Barang / Aset</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Jenis Tindakan</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Biaya Pemeliharaan</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tanggal Kegiatan</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Petugas</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider text-center pr-8">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-150">
                    @forelse($logs as $log)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 pl-8">
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $log->barang->nama_barang ?? 'Aset Dihapus' }}</p>
                                <p class="text-[10px] text-slate-500 mt-0.5 italic">Ket: {{ Str::limit($log->keterangan, 35) }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 text-xs font-semibold bg-slate-100 rounded-lg text-slate-650">
                                {{ $log->jenis_pemeliharaan }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs font-bold text-slate-800">
                            Rp {{ number_format($log->biaya, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-500">
                            {{ $log->tanggal->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-xs font-semibold text-slate-700">
                            {{ $log->user->name ?? 'System' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-0.5 text-[9px] font-semibold rounded-full uppercase tracking-wider 
                                {{ $log->status == 'Selesai' ? 'bg-emerald-50 border border-emerald-100 text-emerald-800' : ($log->status == 'Proses' ? 'bg-amber-50 border border-amber-100 text-amber-800 animate-pulse' : 'bg-rose-50 border border-rose-100 text-rose-800') }}">
                                {{ $log->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center pr-8">
                            <div class="flex justify-center items-center space-x-2">
                                <button wire:click="edit({{ $log->id }})" class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-slate-50 rounded-lg transition-colors flex items-center justify-center" title="Edit">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.83 20.013a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </button>
                                <button wire:click="confirmDelete({{ $log->id }})" class="p-2 text-slate-400 hover:text-rose-650 hover:bg-slate-50 rounded-lg transition-colors flex items-center justify-center" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-400 italic">
                            Belum ada riwayat pemeliharaan perangkat laboratorium.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $logs->links() }}
        </div>
        @endif
    </div>

    <!-- Modal Form (Create/Edit) -->
    <div x-data="{ open: @entangle('isModalOpen') }" x-show="open" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div x-show="open" class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px]" @click="open = false"></div>
        
        <div x-show="open" class="relative bg-white w-full max-w-md rounded-2xl shadow-xl p-8 overflow-hidden z-10">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-slate-900">{{ $log_id ? 'Perbarui Log Pemeliharaan' : 'Catatan Pemeliharaan Baru' }}</h3>
                <button @click="open = false" class="p-1.5 hover:bg-slate-100 rounded-full transition-colors text-slate-400 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="store" class="space-y-4">
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Pilih Perangkat / Aset</label>
                    <div class="relative">
                        <select wire:model="barang_id" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:bg-white outline-none appearance-none bg-none">
                            <option value="">Pilih Aset...</option>
                            @foreach($barangs as $b)
                                <option value="{{ $b->id }}">{{ $b->nama_barang }}</option>
                            @endforeach
                        </select>
                        <svg class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                    @error('barang_id') <span class="text-rose-550 text-[10px] font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Jenis Tindakan</label>
                        <div class="relative">
                            <select wire:model="jenis_pemeliharaan" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:bg-white outline-none appearance-none bg-none">
                                <option value="Servis">Servis Rutin</option>
                                <option value="Perbaikan">Perbaikan Kerusakan</option>
                                <option value="Kalibrasi">Kalibrasi Alat</option>
                                <option value="Pembersihan">Pembersihan Berkala</option>
                            </select>
                            <svg class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                        @error('jenis_pemeliharaan') <span class="text-rose-550 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Biaya Perbaikan (Rp)</label>
                        <input type="number" wire:model="biaya" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:bg-white outline-none transition-colors">
                        @error('biaya') <span class="text-rose-550 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tanggal Tindakan</label>
                        <input type="date" wire:model="tanggal" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:bg-white outline-none transition-colors">
                        @error('tanggal') <span class="text-rose-550 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status Pemeliharaan</label>
                        <div class="relative">
                            <select wire:model="status" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:bg-white outline-none appearance-none bg-none">
                                <option value="Proses">Dalam Proses</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Gagal">Gagal / Afkir</option>
                            </select>
                            <svg class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                        @error('status') <span class="text-rose-550 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Rincian Keterangan / Kerusakan</label>
                    <textarea wire:model="keterangan" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:bg-white outline-none transition-colors" placeholder="Jelaskan kondisi kerusakan atau tindakan yang diambil..." rows="3"></textarea>
                    @error('keterangan') <span class="text-rose-550 text-[10px] font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="button" @click="open = false" class="flex-1 py-2 text-xs font-bold text-slate-400 hover:text-slate-655 transition-colors">Batalkan</button>
                    <button type="submit" class="flex-[2] py-2 bg-emerald-600 text-white rounded-xl text-xs font-semibold hover:bg-emerald-700 transition-colors">
                        Simpan Catatan
                    </button>
                </div>
            </form>
        </div>      
    </div>

    <!-- Modal Konfirmasi Hapus -->
    @if($selectedId)
        <div class="fixed inset-0 z-[999] flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px]" @click="$wire.set('selectedId', null)"></div>
            
            <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-xl p-8 overflow-hidden z-10">
                <div class="text-center">
                    <div class="w-12 h-12 bg-rose-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-rose-600" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Hapus Log Pemeliharaan</h3>
                    <p class="text-slate-500 text-xs mb-6">Apakah Anda yakin ingin menghapus catatan log ini? Tindakan ini tidak dapat dibatalkan.</p>
                    
                    <div class="flex gap-3">
                        <button wire:click="$set('selectedId', null)" class="flex-1 py-2 text-xs font-bold text-slate-400 hover:text-slate-650 transition-colors">Batal</button>
                        <button wire:click="delete" class="flex-1 py-2 bg-rose-600 text-white rounded-xl text-xs font-semibold hover:bg-rose-750 transition-colors">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
