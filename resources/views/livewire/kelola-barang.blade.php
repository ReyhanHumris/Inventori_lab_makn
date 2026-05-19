<div class="max-w-[1440px] mx-auto p-4 md:p-6 lg:p-8 space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-3">
                <span class="p-2.5 bg-slate-100 rounded-2xl text-slate-700 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                </span>
                Daftar Inventaris Barang
            </h2>
            <p class="text-slate-500 text-sm mt-1">Kelola, pantau, dan organisasikan semua aset laboratorium secara efisien.</p>
        </div>
        @if(auth()->user()->role !== 'peminjam')
        <button wire:click="create()" class="group px-4 py-2.5 bg-emerald-600 text-white rounded-xl font-semibold text-xs hover:bg-emerald-700 transition-colors flex items-center shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Barang Baru
        </button>
        @endif
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

    @if (session()->has('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
             class="p-4 bg-rose-50 border border-rose-100 text-rose-800 rounded-xl text-sm font-semibold flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-2 text-rose-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- Interactive Stats Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Aset -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4 hover:shadow transition-shadow cursor-default">
            <div class="w-12 h-12 bg-slate-50 text-slate-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider pl-0.5">Total Barang Inventaris</p>
                <h3 class="text-2xl font-bold mt-0.5 text-slate-900">{{ $summary['total_aset'] }} <span class="text-xs font-normal text-slate-500">Jenis</span></h3>
            </div>
        </div>

        <!-- Tersedia -->
        @php
            $persenTersedia = $summary['total_stok'] > 0 ? round(($summary['total_tersedia'] / $summary['total_stok']) * 100) : 0;
        @endphp
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between hover:shadow transition-shadow cursor-default">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider pl-0.5">Stok Siap Digunakan</p>
                    <div class="flex justify-between items-end mt-0.5">
                        <h3 class="text-2xl font-bold text-slate-900 leading-none">{{ $summary['total_tersedia'] }} <span class="text-xs font-normal text-slate-500">/ {{ $summary['total_stok'] }} Unit</span></h3>
                        <span class="text-xs font-bold text-emerald-650 leading-none">{{ $persenTersedia }}%</span>
                    </div>
                </div>
            </div>
            <div class="w-full bg-slate-100 h-1.5 rounded-full mt-4 overflow-hidden shadow-inner">
                <div class="bg-emerald-550 h-full rounded-full transition-all duration-300" style="width: {{ $persenTersedia }}%"></div>
            </div>
        </div>

        <!-- Dipinjam -->
        @php
            $persenDipinjam = $summary['total_stok'] > 0 ? round(($summary['total_dipinjam'] / $summary['total_stok']) * 100) : 0;
        @endphp
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between hover:shadow transition-shadow cursor-default">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider pl-0.5">Sedang Dipinjam Aktif</p>
                    <div class="flex justify-between items-end mt-0.5">
                        <h3 class="text-2xl font-bold text-slate-900 leading-none">{{ $summary['total_dipinjam'] }} <span class="text-xs font-normal text-slate-500">Unit</span></h3>
                        <span class="text-xs font-bold text-blue-605 leading-none">{{ $persenDipinjam }}%</span>
                    </div>
                </div>
            </div>
            <div class="w-full bg-slate-100 h-1.5 rounded-full mt-4 overflow-hidden shadow-inner">
                <div class="bg-blue-600 h-full rounded-full transition-all duration-300" style="width: {{ $persenDipinjam }}%"></div>
            </div>
        </div>
    </div>

    <!-- Search & Filters with QR scanner -->
    <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex flex-1 gap-3 max-w-lg items-center w-full">
            <div class="relative flex-1 group">
                <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607z" />
                </svg>
                <input wire:model.live="search" class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:bg-white outline-none transition-colors" placeholder="Cari nama perangkat..." type="text"/>
            </div>
            <button onclick="startQRScanner()" type="button" class="px-4 py-2 bg-slate-900 text-white rounded-xl text-xs font-semibold hover:bg-black transition-colors flex items-center gap-1.5 shadow-sm">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                </svg>
                Scan QR Code
            </button>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden transition-all duration-300">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left min-w-[1000px]">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider pl-8">Nama Barang</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Ketersediaan Stok</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kondisi</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider text-center pr-8">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-150">
                    @forelse($barangs as $barang)
                    @php
                        $dipinjam = $barang->stok_total - $barang->stok_tersedia;
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4 pl-8">
                            <div class="font-bold text-sm text-slate-900">{{ $barang->nama_barang }}</div>
                            <div class="text-[10px] text-slate-450 font-mono mt-0.5">ID: #{{ str_pad($barang->id, 4, '0', STR_PAD_LEFT) }}</div>
                        </td>
                        <td class="px-6 py-4 text-xs font-semibold text-slate-600">
                            <span class="px-2.5 py-1 bg-slate-100 rounded-lg">{{ $barang->kategori }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-800 bg-slate-50 border border-slate-150 px-2 py-0.5 rounded-lg w-max">{{ $barang->stok_tersedia }} / {{ $barang->stok_total }}</span>
                                <span class="text-[9px] text-slate-400 mt-1 font-semibold uppercase tracking-wider pl-0.5">Tersedia / Total</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-0.5 text-[9px] font-semibold rounded-full uppercase tracking-wider {{ $barang->kondisi == 'Baik' ? 'bg-emerald-50 border border-emerald-100 text-emerald-800' : 'bg-rose-50 border border-rose-100 text-rose-800' }}">
                                <span class="w-1 h-1 rounded-full mr-1.5 {{ $barang->kondisi == 'Baik' ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                {{ $barang->kondisi }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-0.5 text-[9px] font-semibold rounded-full uppercase tracking-wider {{ $dipinjam > 0 ? 'bg-amber-50 border border-amber-100 text-amber-800' : 'bg-emerald-50 border border-emerald-100 text-emerald-800' }}">
                                <span class="w-1 h-1 rounded-full mr-1.5 {{ $dipinjam > 0 ? 'bg-amber-500' : 'bg-emerald-500' }}"></span>
                                {{ $dipinjam > 0 ? 'Dipinjam' : 'Tersedia' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center pr-8">
                            <div class="flex justify-center items-center space-x-1">
                                <button wire:click="showDetail({{ $barang->id }})" class="p-2 text-slate-400 hover:text-slate-900 hover:bg-slate-50 rounded-lg transition-colors flex items-center justify-center" title="Detail Barang">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </button>
                                @if(auth()->user()->role !== 'peminjam')
                                <button wire:click="edit({{ $barang->id }})" class="p-2 text-slate-400 hover:text-slate-900 hover:bg-slate-50 rounded-lg transition-colors flex items-center justify-center" title="Edit Barang">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.83 20.013a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </button>
                                <button type="button" wire:click="confirmDelete({{ $barang->id }})" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-slate-50 rounded-lg transition-colors flex items-center justify-center" title="Hapus Barang">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400 italic">
                            <div class="flex flex-col items-center justify-center space-y-2 opacity-50">
                                <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                </svg>
                                <span class="text-sm font-semibold">Belum ada data barang atau tidak ditemukan.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        @if($barangs->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $barangs->links() }}
        </div>
        @endif
    </div>

    <!-- Modal Form (Create/Edit) -->
    <div x-data="{ open: @entangle('isModalOpen') }" x-show="open" x-cloak
         class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div x-show="open" class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px]" @click="open = false"></div>
        
        <div x-show="open" class="relative bg-white w-full max-w-md rounded-2xl shadow-xl p-8 overflow-hidden z-10">
            <div class="relative">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 leading-tight">{{ $barang_id ? 'Perbarui Aset' : 'Aset Baru' }}</h3>
                        <p class="text-slate-400 text-xs mt-1">Lengkapi informasi inventaris di bawah ini.</p>
                    </div>
                    <button @click="open = false" class="p-1.5 hover:bg-slate-100 rounded-full transition-colors text-slate-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="store" class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Perangkat</label>
                        <input type="text" wire:model="nama_barang" placeholder="Contoh: MacBook Pro M3" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:bg-white outline-none transition-colors">
                        @error('nama_barang') <span class="text-rose-550 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Jumlah Stok</label>
                            <input type="number" wire:model="stok" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:bg-white outline-none transition-colors">
                            @error('stok') <span class="text-rose-550 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kategori</label>
                            <div class="relative">
                                <select wire:model="kategori" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:bg-white outline-none appearance-none bg-none">
                                    <option value="">Pilih Kategori</option>
                                    <option value="Hardware">Hardware</option>
                                    <option value="Peripheral">Peripheral</option>
                                    <option value="Networking">Networking</option>
                                </select>
                                <svg class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                            @error('kategori') <span class="text-rose-550 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Kondisi Saat Ini</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" wire:model="kondisi" value="Baik" class="text-emerald-600 focus:ring-emerald-500">
                                <span class="text-sm font-medium text-slate-700">Baik</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" wire:model="kondisi" value="Rusak" class="text-emerald-600 focus:ring-emerald-500">
                                <span class="text-sm font-medium text-slate-700">Perbaikan</span>
                            </label>
                        </div>
                        @error('kondisi') <span class="text-rose-550 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="button" @click="open = false" class="flex-1 py-2 text-xs font-bold text-slate-400 hover:text-slate-650 transition-colors">Batalkan</button>
                        <button type="submit" class="flex-[2] py-2 bg-emerald-600 text-white rounded-xl text-xs font-semibold hover:bg-emerald-700 transition-colors">
                            {{ $barang_id ? 'Simpan Perubahan' : 'Tambahkan Aset' }}
                        </button>
                    </div>
                </form>
            </div>
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Hapus Barang</h3>
                    <p class="text-slate-500 text-xs mb-6">Apakah Anda yakin ingin menghapus barang ini? Tindakan ini tidak dapat dibatalkan.</p>
                    
                    <div class="flex gap-3">
                        <button wire:click="$set('selectedId', null)" :disabled="$wire.isDeleting" class="flex-1 py-2 text-xs font-bold text-slate-400 hover:text-slate-655 transition-colors">Batalkan</button>
                        <button wire:click="delete({{ $selectedId }})" :disabled="$wire.isDeleting" class="flex-1 py-2 bg-rose-600 text-white rounded-xl text-xs font-semibold hover:bg-rose-750 transition-colors">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Detail Barang -->
    @if($isDetailOpen && $detailBarang)
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px]" wire:click="closeDetail()"></div>
            
            <div class="relative bg-white w-full max-w-2xl rounded-2xl shadow-xl p-8 md:p-10 overflow-hidden z-10 max-h-[90vh] overflow-y-auto custom-scrollbar">
                <div class="relative space-y-6">
                    <!-- Header Detail -->
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="px-2.5 py-0.5 bg-slate-100 text-slate-700 text-[10px] font-bold rounded-full uppercase tracking-wider">{{ $detailBarang->kategori }}</span>
                            <h3 class="text-2xl font-bold text-slate-900 mt-2 leading-tight">{{ $detailBarang->nama_barang }}</h3>
                            <p class="text-slate-450 text-[10px] font-mono mt-1">ID ASET: #{{ str_pad($detailBarang->id, 4, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <button wire:click="closeDetail()" class="p-1.5 hover:bg-slate-100 rounded-full transition-colors text-slate-400 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Layout Grid: Kiri Detail & Kanan QR Code -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                        <div class="md:col-span-2 space-y-4">
                            <!-- Grid Info Status & Stok -->
                            <div class="grid grid-cols-3 gap-4">
                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-1">Stok Tersedia</p>
                                    <p class="text-xl font-bold text-emerald-600">{{ $detailBarang->stok_tersedia }} <span class="text-xs font-normal text-slate-500">Unit</span></p>
                                </div>
                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-1">Sedang Dipinjam</p>
                                    <p class="text-xl font-bold text-amber-600">{{ $detailBarang->stok_total - $detailBarang->stok_tersedia }} <span class="text-xs font-normal text-slate-500">Unit</span></p>
                                </div>
                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-1">Stok Total</p>
                                    <p class="text-xl font-bold text-slate-800">{{ $detailBarang->stok_total }} <span class="text-xs font-normal text-slate-500">Unit</span></p>
                                </div>
                            </div>

                            <!-- Stock Availability Progress Bar -->
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                @php
                                    $persenKetersediaan = $detailBarang->stok_total > 0 ? round(($detailBarang->stok_tersedia / $detailBarang->stok_total) * 100) : 0;
                                @endphp
                                <div class="flex justify-between items-center text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                                    <span>Persentase Ketersediaan</span>
                                    <span class="text-emerald-600 font-bold text-xs">{{ $persenKetersediaan }}%</span>
                                </div>
                                <div class="w-full bg-slate-200 h-1.5 rounded-full overflow-hidden shadow-inner">
                                    <div class="bg-emerald-500 h-full rounded-full transition-all duration-300" style="width: {{ $persenKetersediaan }}%"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Generator QR Code Aset -->
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60 flex flex-col items-center justify-center text-center space-y-3">
                            <p class="text-[9px] font-bold text-slate-450 uppercase tracking-wider">QR Code Inventaris</p>
                            <canvas id="qr-code-canvas" class="bg-white p-2 rounded-xl border border-slate-200 shadow-sm"></canvas>
                            <button onclick="cetakQRCode()" class="flex items-center gap-1.5 text-[10px] font-bold text-emerald-600 hover:text-emerald-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 19.125h10.56a2.25 2.25 0 0 0 2.25-2.25V9A2.25 2.25 0 0 0 17.28 6.75H6.72A2.25 2.25 0 0 0 4.47 9v7.875a2.25 2.25 0 0 0 2.25 2.25Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V4.5a2.25 2.25 0 0 1 2.25-2.25h1.5A2.25 2.25 0 0 1 15 4.5v2.25m-6 0h6m-6 7.5h6m-6 3h6" />
                                </svg>
                                Cetak QR Code
                            </button>
                        </div>
                    </div>

                    <!-- Riwayat Peminjaman -->
                    <div class="space-y-3">
                        <h4 class="text-xs font-bold text-slate-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            Riwayat Peminjaman Aktif & Terakhir
                        </h4>
                        <div class="border border-slate-200 rounded-xl overflow-hidden max-h-48 overflow-y-auto bg-white">
                            <table class="w-full text-left border-collapse">
                                <tbody class="divide-y divide-slate-100 text-xs">
                                    @forelse($detailBarang->peminjaman as $p)
                                        <tr>
                                            <td class="px-4 py-3">
                                                <p class="font-bold text-slate-800">{{ $p->nama_peminjam }}</p>
                                                <p class="text-[9px] text-slate-450 font-mono mt-0.5">ID/NIM: {{ $p->nim }}</p>
                                            </td>
                                            <td class="px-4 py-3 text-slate-700 font-bold">
                                                {{ $p->jumlah }} Unit
                                            </td>
                                            <td class="px-4 py-3 text-slate-500 space-y-0.5">
                                                <p class="font-semibold">{{ date('d M Y', strtotime($p->tgl_pinjam)) }}</p>
                                                <p class="text-[9px] text-slate-400">Batas: {{ date('d M Y', strtotime($p->tgl_kembali)) }}</p>
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <span class="inline-flex items-center px-2 py-0.5 text-[9px] font-semibold rounded-full uppercase tracking-wider {{ $p->status == 'Dipinjam' ? 'bg-amber-50 border border-amber-100 text-amber-800' : 'bg-emerald-50 border border-emerald-100 text-emerald-800' }}">
                                                    {{ $p->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-8 text-center text-slate-400 italic">
                                                Belum ada riwayat peminjaman aset ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Footer Detail -->
                    <div class="pt-4 border-t border-slate-150 flex justify-end">
                        <button wire:click="closeDetail()" class="px-5 py-2 bg-slate-900 text-white rounded-xl text-xs font-semibold hover:bg-slate-800 transition-colors">Tutup Detail</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- QR Scanner Hidden Dialog Modal -->
    <div id="qr-scanner-modal" class="hidden fixed inset-0 z-[200] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px]" onclick="stopQRScanner()"></div>
        <div class="relative bg-white w-full max-w-md rounded-2xl shadow-xl p-6 z-10 flex flex-col items-center">
            <div class="flex justify-between items-center w-full mb-4">
                <h3 class="text-lg font-bold text-slate-900">Scan QR Code Barang</h3>
                <button onclick="stopQRScanner()" class="p-1 hover:bg-slate-100 rounded-full text-slate-400 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="scanner-reader" class="w-full bg-slate-50 rounded-xl overflow-hidden border border-slate-200" style="min-height: 250px;"></div>
            <p class="text-xs text-slate-400 mt-4 text-center">Arahkan kamera perangkat Anda ke stiker QR Code barang laboratorium.</p>
        </div>
    </div>

    <!-- QR Code Script & Print Logic -->
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('show-detail-qr', (event) => {
                setTimeout(() => {
                    const canvas = document.getElementById('qr-code-canvas');
                    if (canvas) {
                        new QRious({
                            element: canvas,
                            value: 'BARANG_ID:' + event.id,
                            size: 130,
                            level: 'H'
                        });
                    }
                }, 100);
            });
        });

        function cetakQRCode() {
            const canvas = document.getElementById('qr-code-canvas');
            if (canvas) {
                const dataUrl = canvas.toDataURL();
                const windowPrint = window.open('', '', 'width=400,height=400');
                windowPrint.document.write('<html><head><title>Cetak QR Code</title><style>body{display:flex;flex-direction:column;align-items:center;justify-content:center;height:100vh;margin:0;font-family:sans-serif;} img{width:180px;height:180px;padding:10px;border:2px solid #ccc;border-radius:10px;} h2{margin-top:15px;font-size:16px;text-transform:uppercase;color:#333;} p{font-size:11px;color:#666;margin:4px 0 0 0;font-family:monospace;}</style></head><body>');
                windowPrint.document.write('<img src="' + dataUrl + '">');
                windowPrint.document.write('<h2>{{ $detailBarang ? $detailBarang->nama_barang : "QR Code Barang" }}</h2>');
                windowPrint.document.write('<p>ID ASET: #{{ $detailBarang ? str_pad($detailBarang->id, 4, "0", STR_PAD_LEFT) : "" }}</p>');
                windowPrint.document.write('<script>window.onload = function() { window.print(); window.close(); }<\/script>');
                windowPrint.document.write('</body></html>');
                windowPrint.document.close();
            }
        }

        let html5QrcodeScanner = null;

        function startQRScanner() {
            document.getElementById('qr-scanner-modal').classList.remove('hidden');
            html5QrcodeScanner = new Html5Qrcode("scanner-reader");
            html5QrcodeScanner.start(
                { facingMode: "environment" }, 
                {
                    fps: 10,
                    qrbox: { width: 220, height: 220 }
                },
                (decodedText, decodedResult) => {
                    stopQRScanner();
                    if (decodedText.startsWith('BARANG_ID:')) {
                        const barangId = decodedText.split(':')[1];
                        // Dispatch to Livewire to open detail modal instantly
                        Livewire.dispatch('qr-scanned', { id: barangId });
                    } else {
                        alert('QR Code tidak valid untuk aset Lab MAKN Ende: ' + decodedText);
                    }
                },
                (errorMessage) => {
                    // Scanning fails (not critical)
                }
            ).catch(err => {
                alert("Gagal memanggil kamera scanner: " + err);
                stopQRScanner();
            });
        }

        function stopQRScanner() {
            document.getElementById('qr-scanner-modal').classList.add('hidden');
            if (html5QrcodeScanner) {
                html5QrcodeScanner.stop().then(() => {
                    html5QrcodeScanner = null;
                }).catch(err => console.log("Gagal menonaktifkan kamera scanner: " + err));
            }
        }
    </script>
</div>