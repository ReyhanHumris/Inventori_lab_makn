<div class="max-w-[1440px] mx-auto p-4 md:p-6 lg:p-8 space-y-8 bg-slate-50 min-h-screen">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-3">
                <span class="p-2.5 bg-slate-100 rounded-2xl text-slate-700 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.03 0 1.9.693 2.166 1.638m-7.377 0A48.536 48.536 0 0112 3m0 0c2.917 0 5.747.294 8.5.862m-21 1.402L3 20.25a2.25 2.25 0 0 0 2.25 2.25h13.5A2.25 2.25 0 0 0 21 20.25V6.108" />
                    </svg>
                </span>
                Audit Trail & Aktivitas
            </h2>
            <p class="text-slate-500 text-sm mt-1">Halaman audit eksklusif Kepala Laboratorium untuk memantau semua perubahan data dan aktivitas sistem secara real-time.</p>
        </div>
        <button wire:click="clearLogs()" 
                wire:confirm="Apakah Anda yakin ingin mengosongkan semua riwayat log aktivitas audit sistem? Tindakan ini permanen."
                class="px-4 py-2.5 bg-rose-50 text-rose-700 border border-rose-100 rounded-xl font-semibold text-xs hover:bg-rose-600 hover:text-white transition-all shadow-sm">
            Kosongkan Riwayat Log
        </button>
    </div>

    <!-- Alert Notifications -->
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
             class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-xl text-sm font-semibold flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-2 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
            </svg>
            {{ session('message') }}
        </div>
    @endif

    <!-- Search bar -->
    <div class="flex justify-between items-center bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <div class="relative w-full max-w-sm">
            <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
            <input wire:model.live="search" class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:bg-white outline-none transition-colors" placeholder="Cari aktivitas, deskripsi, atau nama pengguna..."/>
        </div>
    </div>

    <!-- Audit Logs Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider pl-8 w-24">Waktu</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider w-40">Pengguna (Role)</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider w-48">Aktivitas</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Deskripsi Aksi</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider text-center pr-8 w-32">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-150 text-xs">
                    @forelse($logs as $log)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 pl-8 text-slate-400 font-mono">
                            {{ $log->created_at->format('d M Y') }}
                            <p class="text-[9px] mt-0.5">{{ $log->created_at->format('H:i:s') }} WITA</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">{{ $log->user->name ?? 'System / Anonymous' }}</div>
                            <p class="text-[9px] text-slate-450 uppercase font-semibold mt-0.5 tracking-wider">
                                {{ $log->user->role ?? 'N/A' }}
                            </p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-0.5 text-[9px] font-bold rounded-full uppercase tracking-wider
                                {{ Str::contains($log->aktivitas, 'Hapus') ? 'bg-rose-50 border border-rose-100 text-rose-800' : 
                                   (Str::contains($log->aktivitas, 'Tambah') || Str::contains($log->aktivitas, 'Persetujuan') ? 'bg-emerald-50 border border-emerald-100 text-emerald-800' : 'bg-blue-50 border border-blue-100 text-blue-800') }}">
                                {{ $log->aktivitas }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-650 font-medium">
                            {{ $log->deskripsi }}
                        </td>
                        <td class="px-6 py-4 text-center pr-8 text-slate-400 font-mono font-medium">
                            {{ $log->ip_address ?? '127.0.0.1' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 italic">
                            Belum ada riwayat aktivitas sistem tercatat.
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
</div>
