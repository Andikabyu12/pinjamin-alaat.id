<!-- Dabang Dashboard Section -->
<div class="min-h-screen py-10 relative overflow-hidden">
    <div class="container mx-auto px-4 lg:px-8 relative z-10 max-w-7xl">
        <!-- Header Section -->
        <div class="grid gap-6 lg:grid-cols-[1fr_0.7fr] mb-10">
            <!-- Welcome Card -->
            <div class="rounded-3xl bg-gradient-to-br from-amber-600/90 via-yellow-600/85 to-orange-600/90 p-8 border border-amber-400/30 overflow-hidden relative">
                <div class="absolute inset-0 opacity-30 pointer-events-none">
                    <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-amber-300/40 to-transparent rounded-full blur-3xl -mr-32 -mt-32"></div>
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-gradient-to-br from-orange-400/30 to-transparent rounded-full blur-3xl -ml-32"></div>
                </div>
                <div class="relative z-10 space-y-6">
                    <div class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-xs uppercase tracking-widest text-white/80">
                        <span class="inline-flex h-2.5 w-2.5 rounded-full bg-yellow-300 animate-pulse"></span>
                        Dabang Dashboard
                    </div>
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <div>
                            <p class="text-amber-100 text-sm uppercase tracking-wider">Selamat datang kembali</p>
                            <h1 class="text-4xl md:text-5xl font-black text-white mt-3">Halo, {{ Auth::user()->name }}</h1>
                            <p class="text-amber-100/90 mt-4 text-sm">Kelola finansial dan adminstrasi sistem peminjaman alat</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="flex-shrink-0">
                            @csrf
                            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-white/30 bg-white/15 px-6 py-3 text-white font-semibold transition-all duration-300 hover:bg-white/30 hover:shadow-xl hover:scale-105 whitespace-nowrap">
                                <i class="fas fa-sign-out-alt"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="space-y-4">
                <div class="rounded-3xl border border-slate-700/60 bg-slate-950/80 p-5 shadow-lg">
                    <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Total Peminjaman</p>
                    <p class="text-3xl font-black text-amber-300 mt-3">{{ $peminjamanCount ?? 0 }}</p>
                    <p class="text-xs text-slate-400 mt-2">Transaksi terdaftar</p>
                </div>
                <div class="rounded-3xl border border-slate-700/60 bg-slate-950/80 p-5 shadow-lg">
                    <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Alat Tersedia</p>
                    <p class="text-3xl font-black text-yellow-300 mt-3">{{ $alatCount ?? 0 }}</p>
                    <p class="text-xs text-slate-400 mt-2">Total inventaris</p>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4 mb-10">
            <div class="rounded-3xl bg-gradient-to-br from-blue-500/20 to-blue-600/10 border border-blue-500/30 p-6 shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <p class="text-xs uppercase tracking-wider font-semibold text-blue-300">Total Alat</p>
                        <p class="mt-4 text-4xl font-black text-blue-100">{{ $alatCount ?? 0 }}</p>
                        <p class="mt-3 text-sm text-slate-400">Inventaris sistem</p>
                    </div>
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-500/25 text-blue-300 border border-blue-500/40 flex-shrink-0">
                        <i class="fas fa-cube text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl bg-gradient-to-br from-emerald-500/20 to-emerald-600/10 border border-emerald-500/30 p-6 shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <p class="text-xs uppercase tracking-wider font-semibold text-emerald-300">Peminjaman Total</p>
                        <p class="mt-4 text-4xl font-black text-emerald-100">{{ $peminjamanCount ?? 0 }}</p>
                        <p class="mt-3 text-sm text-slate-400">Transaksi tercatat</p>
                    </div>
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-500/25 text-emerald-300 border border-emerald-500/40 flex-shrink-0">
                        <i class="fas fa-handshake text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl bg-gradient-to-br from-amber-500/20 to-amber-600/10 border border-amber-500/30 p-6 shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <p class="text-xs uppercase tracking-wider font-semibold text-amber-300">Pengguna Aktif</p>
                        <p class="mt-4 text-4xl font-black text-amber-100">{{ $userCount ?? 0 }}</p>
                        <p class="mt-3 text-sm text-slate-400">Akun terdaftar</p>
                    </div>
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-amber-500/25 text-amber-300 border border-amber-500/40 flex-shrink-0">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl bg-gradient-to-br from-rose-500/20 to-rose-600/10 border border-rose-500/30 p-6 shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <p class="text-xs uppercase tracking-wider font-semibold text-rose-300">Status Sistem</p>
                        <p class="mt-4 text-4xl font-black text-rose-100">Aktif</p>
                        <p class="mt-3 text-sm text-slate-400">Sistem berjalan normal</p>
                    </div>
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-rose-500/25 text-rose-300 border border-rose-500/40 flex-shrink-0">
                        <i class="fas fa-check-circle text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Section -->
        <div>
            <div class="mb-8">
                <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Menu</p>
                <h2 class="text-3xl font-black text-white mt-2">Akses Administratif</h2>
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                <a href="{{ route('peminjaman.index') }}" class="group rounded-2xl bg-gradient-to-br from-emerald-600/80 to-emerald-700/60 border border-emerald-400/40 p-6 text-white transition hover:shadow-xl hover:-translate-y-1 duration-300 overflow-hidden relative">
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gradient-to-br from-emerald-400/20 to-transparent pointer-events-none"></div>
                    <div class="relative z-10 space-y-3">
                        <div class="inline-flex items-center justify-center h-12 w-12 rounded-xl bg-white/15 border border-white/20 text-2xl group-hover:scale-110 transition-transform duration-300"><i class="fas fa-boxes"></i></div>
                        <h3 class="text-lg font-bold">Peminjaman</h3>
                        <p class="text-emerald-100/80 text-sm">Kelola semua peminjaman</p>
                    </div>
                </a>

                <a href="{{ route('alats.index') }}" class="group rounded-2xl bg-gradient-to-br from-blue-600/80 to-blue-700/60 border border-blue-400/40 p-6 text-white transition hover:shadow-xl hover:-translate-y-1 duration-300 overflow-hidden relative">
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gradient-to-br from-blue-400/20 to-transparent pointer-events-none"></div>
                    <div class="relative z-10 space-y-3">
                        <div class="inline-flex items-center justify-center h-12 w-12 rounded-xl bg-white/15 border border-white/20 text-2xl group-hover:scale-110 transition-transform duration-300"><i class="fas fa-cube"></i></div>
                        <h3 class="text-lg font-bold">Daftar Alat</h3>
                        <p class="text-blue-100/80 text-sm">Lihat semua alat</p>
                    </div>
                </a>

                <a href="{{ route('siswas.index') }}" class="group rounded-2xl bg-gradient-to-br from-purple-600/80 to-purple-700/60 border border-purple-400/40 p-6 text-white transition hover:shadow-xl hover:-translate-y-1 duration-300 overflow-hidden relative">
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gradient-to-br from-purple-400/20 to-transparent pointer-events-none"></div>
                    <div class="relative z-10 space-y-3">
                        <div class="inline-flex items-center justify-center h-12 w-12 rounded-xl bg-white/15 border border-white/20 text-2xl group-hover:scale-110 transition-transform duration-300"><i class="fas fa-users"></i></div>
                        <h3 class="text-lg font-bold">Daftar Siswa</h3>
                        <p class="text-purple-100/80 text-sm">Lihat semua siswa</p>
                    </div>
                </a>

                <a href="{{ route('admin.users') }}" class="group rounded-2xl bg-gradient-to-br from-orange-600/80 to-orange-700/60 border border-orange-400/40 p-6 text-white transition hover:shadow-xl hover:-translate-y-1 duration-300 overflow-hidden relative">
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gradient-to-br from-orange-400/20 to-transparent pointer-events-none"></div>
                    <div class="relative z-10 space-y-3">
                        <div class="inline-flex items-center justify-center h-12 w-12 rounded-xl bg-white/15 border border-white/20 text-2xl group-hover:scale-110 transition-transform duration-300"><i class="fas fa-user-shield"></i></div>
                        <h3 class="text-lg font-bold">Manajemen Users</h3>
                        <p class="text-orange-100/80 text-sm">Kelola akun pengguna</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Info Card -->
        <div class="mt-10 rounded-2xl bg-gradient-to-br from-amber-500/15 to-yellow-500/10 border border-amber-500/30 p-6 shadow-lg">
            <div class="flex items-start gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-500/20 border border-amber-500/40 flex-shrink-0 mt-0.5">
                    <i class="fas fa-clipboard-list text-amber-300 text-lg"></i>
                </div>
                <div>
                    <h3 class="font-bold text-white mb-2">Catatan Administratif</h3>
                    <p class="text-slate-300 text-sm">Sebagai Dabang, Anda memiliki akses untuk memantau semua aspek administratif dan finansial sistem peminjaman alat. Gunakan menu di atas untuk mengelola data dengan terukur dan transparan.</p>
                </div>
            </div>
        </div>
    </div>
</div>
