<div class="max-w-[1440px] mx-auto p-4 md:p-6 lg:p-8 space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-3">
                <span class="p-2.5 bg-slate-100 rounded-2xl text-slate-700 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0 1 10.089 20c-2.3 0-4.47-.521-6.413-1.458A4.125 4.125 0 0 1 7.53 14.5a4.125 4.125 0 0 1 7.47 3.073M12 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM19.5 8.25a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                </span>
                Kelola Pengguna
            </h2>
            <p class="text-slate-500 text-sm mt-1">Daftarkan dan atur hak akses pengguna (petugas/kepala lab) di sistem ini.</p>
        </div>
        <button wire:click="create()" class="px-4 py-2.5 bg-emerald-600 text-white rounded-xl font-semibold text-xs hover:bg-emerald-700 transition-colors shadow-sm">
            Tambah Pengguna
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

    @if (session()->has('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
             class="p-4 bg-rose-50 border border-rose-100 text-rose-800 rounded-xl text-sm font-semibold flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-2 text-rose-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- Search bar -->
    <div class="flex justify-between items-center bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <div class="relative w-full max-w-sm">
            <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
            <input wire:model.live="search" class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:bg-white outline-none transition-colors" placeholder="Cari nama atau email..."/>
        </div>
    </div>

    <!-- User Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left min-w-[800px]">
                <thead>
                    <tr class="bg-slate-550/5 border-b border-slate-200">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider pl-8">Nama</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tanggal Terdaftar</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider text-center pr-8">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-150">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 pl-8">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-xs flex-shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <span class="font-bold text-sm text-slate-900">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-650">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 text-[10px] font-semibold rounded-full uppercase tracking-wider {{ $user->role == 'kepala' ? 'bg-slate-800 text-white' : ($user->role == 'petugas' ? 'bg-slate-100 text-slate-700' : 'bg-emerald-50 text-emerald-800 border border-emerald-100') }}">
                                {{ $user->role == 'kepala' ? 'Kepala Lab' : ($user->role == 'petugas' ? 'Petugas' : 'Peminjam') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-500">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-center pr-8">
                            <div class="flex justify-center items-center space-x-2">
                                <button wire:click="edit({{ $user->id }})" class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-slate-50 rounded-lg transition-colors flex items-center justify-center" title="Edit">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.83 20.013a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </button>
                                @if($user->id != auth()->user()->id)
                                <button wire:click="confirmDelete({{ $user->id }})" class="p-2 text-slate-400 hover:text-rose-650 hover:bg-slate-50 rounded-lg transition-colors flex items-center justify-center" title="Hapus">
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
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 italic">Belum ada pengguna terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $users->links() }}
        </div>
        @endif
    </div>

    <!-- Modal Form (Create/Edit) -->
    <div x-data="{ open: @entangle('isModalOpen') }" x-show="open" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div x-show="open" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="open = false"></div>
        
        <div x-show="open" class="relative bg-white w-full max-w-md rounded-2xl shadow-xl p-8 overflow-hidden z-10">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-slate-900">{{ $user_id ? 'Perbarui Akun' : 'Akun Baru' }}</h3>
                <button @click="open = false" class="p-1.5 hover:bg-slate-100 rounded-full transition-colors text-slate-400 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="store" class="space-y-4">
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Lengkap</label>
                    <input type="text" wire:model="name" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:bg-white outline-none transition-colors">
                    @error('name') <span class="text-rose-550 text-[10px] font-bold">{{ $message }}</span> @enderror
                </div>
                
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Alamat Email</label>
                    <input type="email" wire:model="email" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:bg-white outline-none transition-colors">
                    @error('email') <span class="text-rose-550 text-[10px] font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kata Sandi {{ $user_id ? '(kosongkan jika tidak diganti)' : '' }}</label>
                    <input type="password" wire:model="password" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:bg-white outline-none transition-colors">
                    @error('password') <span class="text-rose-550 text-[10px] font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Peran (Role)</label>
                    <div class="flex flex-wrap gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" wire:model="role" value="peminjam" class="text-emerald-600 focus:ring-emerald-500">
                            <span class="text-sm font-medium text-slate-700">Peminjam</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" wire:model="role" value="petugas" class="text-emerald-600 focus:ring-emerald-500">
                            <span class="text-sm font-medium text-slate-700">Petugas</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" wire:model="role" value="kepala" class="text-emerald-600 focus:ring-emerald-500">
                            <span class="text-sm font-medium text-slate-700">Kepala Lab</span>
                        </label>
                    </div>
                    @error('role') <span class="text-rose-550 text-[10px] font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="button" @click="open = false" class="flex-1 py-2 text-xs font-bold text-slate-400 hover:text-slate-655 transition-colors">Batalkan</button>
                    <button type="submit" class="flex-[2] py-2 bg-emerald-600 text-white rounded-xl text-xs font-semibold hover:bg-emerald-700 transition-colors">
                        {{ $user_id ? 'Simpan Perubahan' : 'Tambahkan Akun' }}
                    </button>
                </div>
            </form>
        </div>      
    </div>

    <!-- Modal Konfirmasi Hapus -->
    @if($selectedId)
        <div class="fixed inset-0 z-[999] flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="$wire.set('selectedId', null)"></div>
            
            <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-xl p-8 overflow-hidden z-10">
                <div class="text-center">
                    <div class="w-12 h-12 bg-rose-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-rose-600" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Hapus Pengguna</h3>
                    <p class="text-slate-500 text-xs mb-6">Apakah Anda yakin ingin menghapus akun ini? Akun tersebut tidak akan bisa login kembali.</p>
                    
                    <div class="flex gap-3">
                        <button wire:click="$set('selectedId', null)" class="flex-1 py-2 text-xs font-bold text-slate-400 hover:text-slate-650 transition-colors">Batal</button>
                        <button wire:click="delete" class="flex-1 py-2 bg-rose-600 text-white rounded-xl text-xs font-semibold hover:bg-rose-750 transition-colors">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
