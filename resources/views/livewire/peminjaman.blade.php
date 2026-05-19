<div x-data="{ openModal: false }" 
     @close-modal.window="openModal = false" 
     @open-booking-modal-from-qr.window="openModal = true" 
     class="p-4 md:p-6 lg:p-8 space-y-8 bg-slate-50 min-h-screen">
    
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-3">
                <span class="p-2.5 bg-slate-100 rounded-2xl text-slate-700 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                    </svg>
                </span>
                Peminjaman Aset
            </h2>
            <p class="text-slate-500 text-sm mt-1">Pantau, catat, dan kelola proses peminjaman alat laboratorium secara real-time.</p>
        </div>
        <div class="flex gap-3">
            <!-- QR Scanner Action -->
            <button onclick="startQRScanner()" type="button" class="px-4 py-2.5 bg-slate-950 text-white rounded-xl text-xs font-semibold hover:bg-black transition-all flex items-center shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                </svg>
                Scan QR Aset
            </button>
            <button @click="openModal = true" class="group px-4 py-2.5 bg-emerald-600 text-white rounded-xl font-semibold text-xs hover:bg-emerald-700 transition-colors flex items-center shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                {{ auth()->user()->role === 'peminjam' ? 'Ajukan Booking Baru' : 'Tambah Peminjaman Baru' }}
            </button>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
             class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-xl text-sm font-semibold flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-2 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
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

    <!-- Interactive Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Total Peminjam Mobilizer -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4 hover:shadow transition-shadow cursor-default">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center font-bold">
                <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0 1 10.089 20c-2.3 0-4.47-.521-6.413-1.458A4.125 4.125 0 0 1 7.53 14.5a4.125 4.125 0 0 1 7.47 3.073M12 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM19.5 8.25a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider pl-0.5">Peminjam Aktif</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-0.5 leading-none">{{ $stats['total'] }} <span class="text-xs font-normal text-slate-500">Orang</span></h3>
            </div>
        </div>

        <!-- Peminjam Terlambat -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4 hover:shadow transition-shadow cursor-default">
            <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center font-bold">
                <svg class="w-6 h-6 text-rose-600" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider pl-0.5">Peminjaman Terlambat</p>
                <h3 class="text-2xl font-bold text-rose-600 mt-0.5 leading-none">{{ $stats['terlambat'] }} <span class="text-xs font-normal text-rose-400">Orang</span></h3>
            </div>
        </div>
    </div>

    {{-- ANTREAN PERSETUJUAN (SELF-SERVICE REQUESTS) - Only for Officers/Admins --}}
    @if(auth()->user()->role !== 'peminjam' && count($daftar_pengajuan) > 0)
    <div class="bg-amber-50/40 border border-amber-200/60 rounded-2xl overflow-hidden shadow-sm transition-all">
        <div class="p-6 border-b border-amber-200/50 flex justify-between items-center bg-amber-50">
            <div>
                <h4 class="font-bold text-amber-900 text-sm">Menunggu Persetujuan Booking (Self-Service)</h4>
                <p class="text-xs text-amber-700 mt-0.5">Daftar pengajuan peminjaman mandiri dari Siswa / Guru.</p>
            </div>
            <span class="text-[9px] font-bold text-amber-800 bg-amber-100 px-2.5 py-1 rounded-full border border-amber-200 tracking-wider uppercase">Persetujuan Pending</span>
        </div>
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr class="bg-amber-50/20 border-b border-amber-150">
                        <th class="px-6 py-4 text-[10px] font-bold text-amber-850 uppercase tracking-wider pl-8">Peminjam</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-amber-855 uppercase tracking-wider">Aset & Jumlah</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-amber-850 uppercase tracking-wider">Batas Rencana Kembali</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-amber-850 uppercase tracking-wider text-center pr-8">Opsi Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-amber-100 text-sm">
                    @foreach($daftar_pengajuan as $req)
                    <tr class="hover:bg-amber-50/30 transition-colors">
                        <td class="px-6 py-4 pl-8">
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $req->nama_peminjam }}</p>
                                <p class="text-[10px] text-slate-500 font-mono mt-0.5">HP/WhatsApp: {{ $req->nim }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-bold text-slate-700">{{ $req->barang->nama_barang ?? 'Aset Dihapus' }}</p>
                            <p class="text-[10px] text-slate-500 mt-0.5 font-medium">{{ $req->jumlah }} Unit diajukan</p>
                        </td>
                        <td class="px-6 py-4 text-xs font-semibold text-slate-600">
                            {{ date('d M Y H:i', strtotime($req->tgl_kembali)) }}
                        </td>
                        <td class="px-6 py-4 text-center pr-8">
                            <div class="flex justify-center items-center gap-2">
                                <button wire:click="setujuiBooking({{ $req->id }})" class="px-3 py-1.5 bg-emerald-600 text-white rounded-lg text-xs font-bold hover:bg-emerald-700 shadow-sm transition-colors">
                                    Setujui
                                </button>
                                <button wire:click="tolakBooking({{ $req->id }})" class="px-3 py-1.5 bg-rose-50 text-rose-700 border border-rose-100 rounded-lg text-xs font-bold hover:bg-rose-600 hover:text-white shadow-sm transition-all">
                                    Tolak
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Active Borrowers Table Card -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm transition-all duration-300">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <div>
                <h4 class="font-bold text-slate-900 text-sm">
                    {{ auth()->user()->role === 'peminjam' ? 'Riwayat & Pengajuan Saya' : 'Daftar Peminjam Aktif' }}
                </h4>
                <p class="text-xs text-slate-500 mt-0.5">
                    {{ auth()->user()->role === 'peminjam' ? 'Daftar pengajuan booking dan barang yang sedang Anda pinjam.' : 'Pantau dan verifikasi proses pengembalian alat laboratorium.' }}
                </p>
            </div>
            <span class="text-[9px] font-bold text-emerald-650 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-100 tracking-wider uppercase">Monitoring Aktif</span>
        </div>
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-450 uppercase tracking-wider pl-8">Peminjam</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-455 uppercase tracking-wider">Aset & Jumlah</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-450 uppercase tracking-wider">Batas Waktu Pengembalian</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-450 uppercase tracking-wider text-center pr-8">Status / Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($peminjam_aktif as $p)
                    @php
                        $isOverdue = $p->tgl_kembali < now() && $p->status === 'Dipinjam';
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4 pl-8">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-xs flex-shrink-0">
                                    {{ strtoupper(substr($p->nama_peminjam, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">{{ $p->nama_peminjam }}</p>
                                    <p class="text-[10px] text-slate-450 font-mono mt-0.5">No. WhatsApp/NIM: {{ $p->nim }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-bold text-slate-700">{{ $p->barang->nama_barang ?? 'Aset Telah Dihapus' }}</p>
                            <p class="text-[10px] text-slate-455 mt-0.5 font-medium">{{ $p->jumlah }} Unit dipinjam</p>
                        </td>
                        <td class="px-6 py-4 text-xs">
                            <div class="flex items-center gap-2 {{ $isOverdue ? 'text-rose-600 font-bold' : 'text-slate-600 font-medium' }}">
                                <svg class="w-4 h-4 text-current flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <div>
                                    <p>{{ date('d M Y', strtotime($p->tgl_kembali)) }}</p>
                                    <p class="text-[9px] text-slate-400 mt-0.5">Pukul: {{ date('H:i', strtotime($p->tgl_kembali)) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center pr-8">
                            @if(auth()->user()->role === 'peminjam')
                                {{-- Siswa / Guru hanya melihat lencana status --}}
                                <span class="inline-flex items-center px-3 py-1 text-[9px] font-bold rounded-full uppercase tracking-wider 
                                    {{ $p->status === 'Diajukan' ? 'bg-amber-50 border border-amber-100 text-amber-800' : ($p->status === 'Dipinjam' ? 'bg-blue-50 border border-blue-100 text-blue-800' : 'bg-emerald-50 border border-emerald-100 text-emerald-800') }}">
                                    {{ $p->status }}
                                </span>
                            @else
                                {{-- Petugas & Kepala Lab bisa memverifikasi dan kirim reminder --}}
                                <div class="flex justify-center items-center gap-2">
                                    <button 
                                        wire:click="kembalikanBarang({{ $p->id }})" 
                                        wire:confirm="Yakin barang ini sudah dikembalikan ke Lab dengan kondisi baik?"
                                        class="px-3.5 py-1.5 bg-emerald-50 text-emerald-650 border border-emerald-100 rounded-lg text-xs font-semibold hover:bg-emerald-600 hover:text-white transition-all shadow-sm">
                                        Konfirmasi Kembali
                                    </button>

                                    @if($isOverdue)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $p->nim) }}?text={{ urlencode('Halo ' . $p->nama_peminjam . ', kami mengingatkan bahwa barang ' . ($p->barang->nama_barang ?? 'Aset') . ' yang Anda pinjam dari Lab MAKN Ende sudah melewati batas waktu pengembalian pada ' . date('d M Y H:i', strtotime($p->tgl_kembali)) . '. Harap segera dikembalikan dalam kondisi baik. Terima kasih!') }}" 
                                       target="_blank"
                                       class="inline-flex items-center gap-1 px-3 py-1.5 bg-amber-50 text-amber-700 border border-amber-150 rounded-lg text-xs font-semibold hover:bg-amber-600 hover:text-white transition-all shadow-sm">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                                        </svg>
                                        WhatsApp
                                    </a>
                                    @endif
                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center justify-center space-y-2 opacity-50">
                                <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                </svg>
                                <p class="text-xs font-semibold">Saat ini belum ada transaksi peminjaman.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Form Peminjaman -->
    <div x-show="openModal" x-cloak class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] z-[100] flex items-center justify-center p-4">
        <div @click.away="openModal = false" class="bg-white w-full max-w-lg rounded-2xl shadow-xl overflow-hidden transform transition-all z-10">
            
            {{-- Header Modal --}}
            <div class="px-6 py-4 bg-emerald-600 text-white flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.83 20.013a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                    <h3 class="text-lg font-bold">{{ auth()->user()->role === 'peminjam' ? 'Form Booking Mandiri' : 'Form Peminjaman Aset' }}</h3>
                </div>
                <button @click="openModal = false" class="p-1 hover:bg-white/10 rounded-full transition-colors flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            {{-- Body Form --}}
            <form wire:submit.prevent="simpanPeminjaman" class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Lengkap Peminjam</label>
                        <input wire:model="nama_peminjam" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:bg-white outline-none transition-colors" placeholder="Contoh: Andi Wijaya" type="text"/>
                        @error('nama_peminjam') <span class="text-rose-550 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">No. WhatsApp Aktif (628...)</label>
                        <input wire:model="nim" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:bg-white outline-none transition-colors" placeholder="Contoh: 628123456789" type="text"/>
                        @error('nim') <span class="text-rose-550 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Pilih Alat Inventaris</label>
                    <div class="relative">
                        <select wire:model.live="barang_id" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:bg-white outline-none appearance-none bg-none">
                            <option value="">Pilih aset dari daftar inventaris...</option>
                            @foreach($daftar_barang as $b)
                                <option value="{{ $b->id }}">{{ $b->nama_barang }} (Sisa Stok: {{ $b->stok_tersedia }} unit)</option>
                            @endforeach
                        </select>
                        <svg class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                    @error('barang_id') <span class="text-rose-550 text-[10px] font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Jumlah Unit Dipinjam</label>
                        <input wire:model.live="jumlah" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:bg-white outline-none transition-colors" type="number" min="1"/>
                        @error('jumlah') <span class="text-rose-550 text-[10px] font-bold">{{ $message }}</span> @enderror
                        
                        {{-- Alert Stok Habis --}}
                        @if($barang_id && $jumlah > ($daftar_barang->find($barang_id)->stok_tersedia ?? 0))
                            <div class="flex items-center gap-1.5 p-2 bg-rose-50 border border-rose-100 rounded-xl text-rose-700 mt-2">
                                <svg class="w-4 h-4 text-rose-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                </svg>
                                <p class="text-[9px] font-bold">Stok tidak mencukupi! Tersisa: {{ $daftar_barang->find($barang_id)->stok_tersedia }} unit.</p>
                            </div>
                        @endif
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Batas Waktu Pengembalian</label>
                        <input wire:model="tgl_kembali" type="datetime-local" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:bg-white outline-none transition-colors">
                        @error('tgl_kembali') <span class="text-rose-550 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Keperluan / Keterangan</label>
                    <textarea wire:model="keperluan" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:bg-white outline-none transition-colors" placeholder="Deskripsikan secara singkat tujuan peminjaman aset ini..." rows="3"></textarea>
                    @error('keperluan') <span class="text-rose-550 text-[10px] font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4 flex gap-3">
                    <button @click="openModal = false" type="button" class="flex-1 px-4 py-2 bg-slate-100 text-slate-500 font-semibold rounded-xl hover:bg-slate-200 transition-colors text-xs">
                        Batalkan
                    </button>
                    <button type="submit" 
                        class="flex-[2] px-4 py-2 bg-emerald-600 text-white font-bold rounded-xl transition-colors text-xs flex items-center justify-center gap-1.5"
                        @if($barang_id && $jumlah > ($daftar_barang->find($barang_id)->stok_tersedia ?? 0)) disabled @endif>
                        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        {{ auth()->user()->role === 'peminjam' ? 'Kirim Pengajuan Booking' : 'Simpan Transaksi' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

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

    <!-- QR Scanner Logic -->
    <script>
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
                        // Dispatch to Livewire to select this asset and open the form modal
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