<div class="max-w-[1440px] mx-auto">
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Manajemen Barang</h2>
            <p class="text-slate-500 text-sm">Kelola semua aset laboratorium dari satu tempat.</p>
        </div>
        <button wire:click="create()" class="group px-4 py-2 bg-emerald-600 text-white rounded-xl font-bold text-xs hover:bg-emerald-700 transition-all duration-300 flex items-center shadow-lg shadow-emerald-200">
            <span class="material-symbols-outlined text-sm mr-2 group-hover:rotate-90 transition-transform duration-300">add</span> 
            Tambah Barang Baru
        </button>
    </div>

    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2"
             class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl text-sm font-bold flex items-center">
            <span class="material-symbols-outlined mr-2">check_circle</span>
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2"
             class="mb-6 p-4 bg-rose-50 border border-rose-100 text-rose-700 rounded-2xl text-sm font-bold flex items-center">
            <span class="material-symbols-outlined mr-2">error</span>
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-6">
        <div class="relative max-w-sm group">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-emerald-500 transition-colors">search</span>
            <input wire:model.live="search" class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all duration-300 shadow-sm" placeholder="Cari nama barang..." type="text"/>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-200">
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Nama Barang</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Kategori</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Stok</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Kondisi</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Status</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($barangs as $barang)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="font-bold text-sm text-slate-900 group-hover:text-emerald-700 transition-colors">{{ $barang->nama_barang }}</div>
                            <div class="text-[10px] text-slate-400 font-mono">ID: #{{ str_pad($barang->id, 4, '0', STR_PAD_LEFT) }}</div>
                        </td>
                        <td class="px-6 py-4 text-xs font-medium text-slate-600">{{ $barang->kategori }}</td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-slate-700 bg-slate-100 px-2.5 py-1 rounded-lg">{{ $barang->stok_total }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 text-[10px] font-black rounded-full uppercase tracking-wider {{ $barang->kondisi == 'Baik' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $barang->kondisi == 'Baik' ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                {{ $barang->kondisi }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $dipinjam = \DB::table('peminjamen')->where('barang_id', $barang->id)->where('status', 'dipinjam')->count();
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 text-[10px] font-black rounded-full uppercase tracking-wider {{ $dipinjam > 0 ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700' }}">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $dipinjam > 0 ? 'bg-amber-500' : 'bg-emerald-500' }}"></span>
                                {{ $dipinjam > 0 ? 'Dipinjam' : 'Tersedia' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center space-x-1">
                                <button wire:click="edit({{ $barang->id }})" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-200">
                                    <span class="material-symbols-outlined text-xl">edit_square</span>
                                </button>
                                <button type="button" wire:click="confirmDelete({{ $barang->id }})" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all duration-200">
                                    <span class="material-symbols-outlined text-xl">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div x-data="{ open: @entangle('isModalOpen') }" x-show="open" 
         class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;">
        
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-[2px]" @click="open = false"></div>
        
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="relative bg-white w-full max-w-lg rounded-[2rem] shadow-2xl p-10 overflow-hidden">
                
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-32 h-32 bg-emerald-50 rounded-full blur-3xl"></div>

                <div class="relative">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h3 class="text-2xl font-bold text-slate-900 leading-tight">{{ $barang_id ? 'Perbarui Aset' : 'Aset Baru' }}</h3>
                            <p class="text-slate-400 text-xs mt-1">Lengkapi informasi inventaris di bawah ini.</p>
                        </div>
                        <button @click="open = false" class="p-2 hover:bg-slate-100 rounded-full transition-colors text-slate-400">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <form wire:submit.prevent="store" class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Perangkat</label>
                            <input type="text" wire:model="nama_barang" placeholder="Contoh: MacBook Pro M3" class="w-full px-5 py-3 bg-slate-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500 transition-all outline-none">
                            @error('nama_barang') <span class="text-rose-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="grid grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Jumlah Stok</label>
                                <input type="number" wire:model="stok" class="w-full px-5 py-3 bg-slate-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500 transition-all outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kategori</label>
                                <select wire:model="kategori" class="w-full px-5 py-3 bg-slate-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500 transition-all outline-none appearance-none">
                                    <option value="">Pilih Kategori</option>
                                    <option value="Hardware">Hardware</option>
                                    <option value="Peripheral">Peripheral</option>
                                    <option value="Networking">Networking</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kondisi Saat Ini</label>
                            <div class="flex space-x-6">
                                <label class="flex items-center group cursor-pointer">
                                    <div class="relative flex items-center justify-center">
                                        <input type="radio" wire:model="kondisi" value="Baik" class="sr-only">
                                        <div class="w-5 h-5 border-2 border-slate-200 rounded-full group-hover:border-emerald-500 transition-colors"></div>
                                        <div x-show="$wire.kondisi === 'Baik'" class="absolute w-2.5 h-2.5 bg-emerald-500 rounded-full shadow-sm shadow-emerald-200"></div>
                                    </div>
                                    <span class="ml-2.5 text-sm font-medium text-slate-600">Kondisi Baik</span>
                                </label>
                                <label class="flex items-center group cursor-pointer">
                                    <div class="relative flex items-center justify-center">
                                        <input type="radio" wire:model="kondisi" value="Rusak" class="sr-only">
                                        <div class="w-5 h-5 border-2 border-slate-200 rounded-full group-hover:border-rose-500 transition-colors"></div>
                                        <div x-show="$wire.kondisi === 'Rusak'" class="absolute w-2.5 h-2.5 bg-rose-500 rounded-full shadow-sm shadow-rose-200"></div>
                                    </div>
                                    <span class="ml-2.5 text-sm font-medium text-slate-600">Perlu Perbaikan</span>
                                </label>
                            </div>
                        </div>

                        <div class="pt-6 flex space-x-4">
                            <button type="button" @click="open = false" class="flex-1 py-3.5 text-xs font-black text-slate-400 hover:text-slate-600 transition-colors">Batalkan</button>
                            <button type="submit" class="flex-[2] py-3.5 bg-slate-900 text-white rounded-2xl text-xs font-black hover:bg-emerald-600 shadow-xl hover:shadow-emerald-200 transition-all duration-300">
                                {{ $barang_id ? 'Simpan Perubahan' : 'Tambahkan Aset' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>      
    </div>

    <!-- Debug: Selected ID: {{ $selectedId }} -->
    @if($selectedId)
        <div class="mb-4 p-2 bg-yellow-100 text-yellow-800 text-sm">
            Selected ID for delete: {{ $selectedId }}
        </div>
    @endif

    <!-- Modal Konfirmasi Hapus -->
    @if($selectedId)
        <div class="fixed inset-0 z-[999] overflow-y-auto">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-[2px]" @click="$wire.set('selectedId', null)"></div>
            
            <div class="relative min-h-screen flex items-center justify-center p-4">
                <div class="relative bg-white w-full max-w-sm rounded-[2rem] shadow-2xl p-8 overflow-hidden"
                     x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4">
                    
                    <div class="text-center">
                        <div class="w-16 h-16 bg-rose-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="material-symbols-outlined text-rose-600 text-2xl">delete_forever</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Hapus Barang</h3>
                        <p class="text-slate-500 text-sm mb-8">Apakah Anda yakin ingin menghapus barang ini? Tindakan ini tidak dapat dibatalkan.</p>
                        
                        <div class="flex space-x-3">
                            <button wire:click="$set('selectedId', null)" :disabled="$wire.isDeleting" class="flex-1 py-3 text-sm font-bold text-slate-400 hover:text-slate-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">Batalkan</button>
                        <button wire:click="delete({{ $selectedId }})" :disabled="$wire.isDeleting" class="flex-1 py-3 bg-rose-600 text-white rounded-2xl text-sm font-bold hover:bg-rose-700 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center">
                                <span x-show="!$wire.isDeleting">Hapus</span>
                                <span x-show="$wire.isDeleting" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Menghapus...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
        {{ $barangs->links() }}
    </div>
</div>