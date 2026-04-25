<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login - Lab Inventory MAKN Ende</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet" />

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#006c49",
                        "primary-container": "#10b981",
                        "on-primary": "#ffffff",
                        "secondary": "#565e74",
                        "background": "#f8f9ff",
                    }
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>

<body class="bg-background text-slate-900 min-h-screen flex flex-col items-center justify-center p-4 relative overflow-x-hidden">

    <div class="absolute inset-0 z-0 pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[70%] h-[70%] rounded-full bg-emerald-100/40 blur-[100px]"></div>
        <div class="absolute bottom-[10%] -right-[10%] w-[50%] h-[50%] rounded-full bg-blue-50/50 blur-[100px]"></div>
    </div>

    <div class="w-full max-w-[400px] z-10 flex flex-col items-center">
        
        <div class="flex flex-col items-center mb-8 text-center">
            <div class="w-20 h-20 bg-white rounded-2xl flex items-center justify-center mb-4 shadow-sm border border-slate-100 p-2 overflow-hidden">
                <img src="{{ asset('assets/images/logo-makn.png') }}" alt="Logo MAKN Ende" class="w-full h-full object-contain">
            </div>
            <h1 class="text-2xl md:text-3xl font-black tracking-tight text-slate-800 uppercase italic leading-tight">Lab Inventory</h1>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">MAKN Ende • Manajemen Aset</p>
        </div>

        <main class="w-full bg-white border border-slate-100 p-8 md:p-10 rounded-[2rem] shadow-xl shadow-emerald-100/20 relative">
            <header class="mb-8">
                <h2 class="text-xl font-bold text-slate-800 mb-1">Selamat Datang</h2>
                <p class="text-xs text-slate-500">Silakan masuk dengan akun resmi Anda.</p>
            </header>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider ml-1 text-xs">Email Pengguna</label>
                    <div class="relative group">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 group-focus-within:text-primary transition-colors text-[20px]">alternate_email</span>
                        <input name="email" type="email" value="{{ old('email') }}" required autofocus
                            class="w-full h-12 pl-12 pr-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-primary transition-all outline-none text-sm" 
                            placeholder="nama@email.com">
                    </div>
                    @error('email')
                        <span class="text-rose-500 text-[10px] font-bold ml-1 italic">{{ $message }}</span>
                    @enderror
                </div>

                <div class="space-y-2" x-data="{ show: false }">
                    <div class="flex justify-between items-center px-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider text-xs">Kata Sandi</label>
                        <a class="text-[10px] font-bold text-primary hover:underline uppercase" href="#">Lupa?</a>
                    </div>
                    <div class="relative group">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 group-focus-within:text-primary transition-colors text-[20px]">lock</span>
                        <input name="password" :type="show ? 'text' : 'password'" required
                            class="w-full h-12 pl-12 pr-12 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-primary transition-all outline-none text-sm" 
                            placeholder="••••••••">
                        <button @click="show = !show" type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <span class="material-symbols-outlined text-[20px]" x-text="show ? 'visibility_off' : 'visibility'">visibility</span>
                        </button>
                    </div>
                </div>

                <div class="flex items-center px-1">
                    <label class="flex items-center cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-4 h-4 border-slate-200 rounded text-primary focus:ring-primary/20">
                        <span class="ml-3 text-xs font-semibold text-slate-500 group-hover:text-slate-700 transition-colors">Ingat saya di perangkat ini</span>
                    </label>
                </div>

                <button type="submit" class="w-full h-12 bg-slate-900 text-white font-bold text-xs uppercase tracking-[0.2em] rounded-2xl hover:bg-primary hover:shadow-lg hover:shadow-emerald-200 active:scale-[0.98] transition-all duration-300 flex items-center justify-center gap-2">
                    Masuk ke Sistem
                    <span class="material-symbols-outlined text-sm">login</span>
                </button>
            </form>

            <footer class="mt-8 pt-6 border-t border-slate-50 text-center">
                <p class="text-[11px] text-slate-400 font-medium">Bantuan teknis? <a class="text-primary font-bold hover:underline" href="#">Hubungi Admin IT</a></p>
            </footer>
        </main>

        <p class="mt-8 text-[9px] font-bold text-slate-300 uppercase tracking-[0.3em]">© 2024 Lab IT MAKN Ende</p>
    </div>

</body>
</html>