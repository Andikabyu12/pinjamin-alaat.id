@extends('layouts.app')

@section('content')
<div class="relative min-h-screen py-12">
    <!-- Decorative Background Elements -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-32 -right-32 w-80 h-80 rounded-full bg-gradient-to-br from-purple-500/20 to-transparent blur-3xl"></div>
        <div class="absolute top-1/3 -left-32 w-96 h-96 rounded-full bg-gradient-to-br from-cyan-500/15 to-transparent blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-72 h-72 rounded-full bg-gradient-to-br from-pink-500/10 to-transparent blur-3xl"></div>
    </div>

    @if(Auth::user()->role == 'admin')
        <div class="mx-auto max-w-7xl px-4 lg:px-8 space-y-8 relative z-10">
            <div class="grid gap-6 lg:grid-cols-[1.7fr_0.9fr]">
                <div class="enhanced-card rounded-3xl bg-gradient-to-br from-purple-600/95 via-purple-700/85 to-pink-600/95 p-10 border border-purple-400/40 backdrop-blur-xl overflow-hidden relative">
                    <div class="absolute inset-0 opacity-40 pointer-events-none">
                        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-purple-400/30 to-transparent rounded-full blur-3xl -mr-32 -mt-32"></div>
                        <div class="absolute bottom-0 left-4 w-72 h-72 bg-gradient-to-br from-pink-400/20 to-transparent rounded-full blur-3xl"></div>
                    </div>
                    <div class="relative z-10 space-y-8">
                        <div class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-xs uppercase tracking-[0.32em] text-white/80 shadow-lg shadow-purple-900/15">
                            <span class="inline-flex h-2.5 w-2.5 rounded-full bg-cyan-300 animate-pulse"></span>
                           
                        </div>
                        <div class="grid gap-6 lg:grid-cols-[1fr_0.8fr] items-center">
                            <div>
                                <p class="text-sm uppercase tracking-[0.15em] font-bold text-purple-100">Panel Admin</p>
                                <h1 class="text-5xl md:text-6xl font-black mt-3 text-white drop-shadow-lg">Admin Panel</h1>
                                <p class="text-purple-100 mt-4">Selamat datang, <span class="font-bold text-white">{{ Auth::user()->name }}</span></p>
                                <p class="text-purple-200 text-sm mt-3 max-w-xl">Kelola alat, siswa, peminjaman, dan pengguna sistem dengan mudah dalam tampilan yang ramping dan modern.</p>
                            </div>
                            <form method="POST" action="{{ route('logout') }}" class="flex-shrink-0">
                                @csrf
                                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-white/30 bg-white/15 px-6 py-3 text-white font-semibold transition-all duration-300 hover:bg-white/30 hover:shadow-xl hover:scale-105">
                                    <i class="fas fa-sign-out-alt"></i>Logout
                                </button>
                            </form>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-3">
                            <div class="rounded-3xl border border-white/10 bg-white/5 p-4 shadow-[0_20px_60px_rgba(15,23,42,0.20)]">
                                <p class="text-xs uppercase tracking-[0.25em] text-slate-300">Status Sistem</p>
                                <p class="mt-4 text-3xl font-bold text-white">Stabil</p>
                                <p class="text-sm text-slate-400 mt-2">Semua layanan berjalan normal.</p>
                            </div>
                            
                            <div class="rounded-3xl border border-white/10 bg-white/5 p-4 shadow-[0_20px_60px_rgba(15,23,42,0.20)]">
                                <p class="text-xs uppercase tracking-[0.25em] text-slate-300">Pengguna</p>
                                <p class="mt-4 text-3xl font-bold text-white">{{ $totalUsers ?? 0 }}</p>
                                <p class="text-sm text-slate-400 mt-2">Jumlah akun terdaftar.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="glass-panel rounded-3xl border border-white/10 p-8">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] font-semibold text-slate-400">Ringkasan Cepat</p>
                            <h2 class="mt-3 text-2xl font-bold text-white">Sistem Saat Ini</h2>
                        </div>
                        <div class="inline-flex rounded-full bg-slate-950/70 px-4 py-2 text-sm text-slate-200 border border-slate-700">Dashboard</div>
                    </div>
                    <div class="space-y-5">
                        <div class="rounded-3xl bg-slate-950/70 border border-slate-700/60 p-5">
                            <p class="text-sm text-slate-400">Total Alat</p>
                            <p class="mt-3 text-3xl font-black text-cyan-300">{{ $totalAlat ?? 0 }}</p>
                        </div>
                        <div class="rounded-3xl bg-slate-950/70 border border-slate-700/60 p-5">
                            <p class="text-sm text-slate-400">Transaksi Peminjaman</p>
                            <p class="mt-3 text-3xl font-black text-emerald-300">{{ $totalPeminjaman ?? 0 }}</p>
                        </div>
                        <div class="rounded-3xl bg-slate-950/70 border border-slate-700/60 p-5">
                            <p class="text-sm text-slate-400">Pengguna Aktif</p>
                            <p class="mt-3 text-3xl font-black text-violet-300">{{ $totalUsers ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @include('components.notification-panel')

            <!-- Stats Grid -->
            <div class="grid gap-6 md:grid-cols-3">
                <div class="hover-lift enhanced-card rounded-2xl bg-gradient-to-br from-blue-500/20 to-blue-600/10 border border-blue-500/30 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-blue-300">Total Alat</p>
                            <p class="text-5xl font-black text-blue-100 mt-4">{{ $totalAlat ?? 0 }}</p>
                        </div>
                        <div class="h-20 w-20 rounded-2xl bg-gradient-to-br from-blue-500/30 to-blue-600/20 flex items-center justify-center hover:scale-110 transition-transform duration-300 shadow-lg">
                            <i class="fas fa-cube text-4xl text-blue-400"></i>
                        </div>
                    </div>
                    <div class="section-divider"></div>
                    <p class="text-xs text-blue-300/80 mt-4 font-medium">Inventaris aktif di sistem</p>
                </div>

                <div class="hover-lift enhanced-card rounded-2xl bg-gradient-to-br from-emerald-500/20 to-emerald-600/10 border border-emerald-500/30 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-emerald-300">Peminjaman</p>
                            <p class="text-5xl font-black text-emerald-100 mt-4">{{ $totalPeminjaman ?? 0 }}</p>
                        </div>
                        <div class="h-20 w-20 rounded-2xl bg-gradient-to-br from-emerald-500/30 to-emerald-600/20 flex items-center justify-center hover:scale-110 transition-transform duration-300 shadow-lg">
                            <i class="fas fa-handshake text-4xl text-emerald-400"></i>
                        </div>
                    </div>
                    <div class="section-divider"></div>
                    <p class="text-xs text-emerald-300/80 mt-4 font-medium">Total transaksi tercatat</p>
                </div>

                <div class="hover-lift enhanced-card rounded-2xl bg-gradient-to-br from-purple-500/20 to-purple-600/10 border border-purple-500/30 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-purple-300">Users Aktif</p>
                            <p class="text-5xl font-black text-purple-100 mt-4">{{ $totalUsers ?? 0 }}</p>
                        </div>
                        <div class="h-20 w-20 rounded-2xl bg-gradient-to-br from-purple-500/30 to-purple-600/20 flex items-center justify-center hover:scale-110 transition-transform duration-300 shadow-lg">
                            <i class="fas fa-users text-4xl text-purple-400"></i>
                        </div>
                    </div>
                    <div class="section-divider"></div>
                    <p class="text-xs text-purple-300/80 mt-4 font-medium">Pengguna terdaftar sistem</p>
                </div>
            </div>

        </div>

    @elseif(Auth::user()->role == 'siswa')
        <div class="mx-auto max-w-7xl px-4 lg:px-8 space-y-8 relative z-10">
            <div class="grid gap-6 lg:grid-cols-[1.6fr_0.9fr]">
                <div class="enhanced-card rounded-3xl bg-gradient-to-br from-emerald-600/95 via-emerald-700/85 to-teal-600/95 p-10 border border-emerald-400/40 backdrop-blur-xl overflow-hidden relative">
                    <div class="absolute inset-0 opacity-40 pointer-events-none">
                        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-emerald-400/30 to-transparent rounded-full blur-3xl -mr-32 -mt-32"></div>
                    </div>
                    <div class="relative z-10 space-y-8">
                        <div class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-xs uppercase tracking-[0.32em] text-white/80 shadow-lg shadow-emerald-900/15">
                            <span class="inline-flex h-2.5 w-2.5 rounded-full bg-sky-300 animate-pulse"></span>
                            Akses Siswa Cepat
                        </div>
                        <div class="grid gap-6 lg:grid-cols-[1fr_0.7fr] items-center">
                            <div>
                                <p class="text-sm uppercase tracking-[0.15em] font-bold text-emerald-100">Dashboard Siswa</p>
                                <h1 class="text-5xl md:text-6xl font-black mt-3 text-white drop-shadow-lg">Selamat Datang</h1>
                                <p class="text-emerald-100 mt-4">Halo, <span class="font-bold text-white">{{ Auth::user()->name }}</span> 👋</p>
                                <p class="text-emerald-200 text-sm mt-3 max-w-xl">Kelola peminjaman alat TI dengan cepat dan mudah melalui menu yang siap pakai.</p>
                            </div>
                            <form method="POST" action="{{ route('logout') }}" class="flex-shrink-0">
                                @csrf
                                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-white/30 bg-white/15 px-6 py-3 text-white font-semibold transition-all duration-300 hover:bg-white/30 hover:shadow-xl hover:scale-105">
                                    <i class="fas fa-sign-out-alt"></i>Logout
                                </button>
                            </form>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-3">
                            <div class="rounded-3xl border border-white/10 bg-white/5 p-4 shadow-[0_20px_60px_rgba(15,23,42,0.20)]">
                                <p class="text-xs uppercase tracking-[0.25em] text-slate-300">Total Peminjaman</p>
                                <p class="mt-4 text-3xl font-bold text-white">{{ $totalUserPeminjamans ?? 0 }}</p>
                                <p class="text-sm text-slate-400 mt-2">Seluruh request Anda</p>
                            </div>
                            <div class="rounded-3xl border border-white/10 bg-white/5 p-4 shadow-[0_20px_60px_rgba(15,23,42,0.20)]">
                                <p class="text-xs uppercase tracking-[0.25em] text-slate-300">Peminjaman Aktif</p>
                                <p class="mt-4 text-3xl font-bold text-emerald-300">{{ $activePeminjamans ?? 0 }}</p>
                                <p class="text-sm text-slate-400 mt-2">Pending & approved saat ini</p>
                            </div>
                            <div class="rounded-3xl border border-white/10 bg-white/5 p-4 shadow-[0_20px_60px_rgba(15,23,42,0.20)]">
                                <p class="text-xs uppercase tracking-[0.25em] text-slate-300">Dikembalikan</p>
                                <p class="mt-4 text-3xl font-bold text-teal-300">{{ $returnedPeminjamans ?? 0 }}</p>
                                <p class="text-sm text-slate-400 mt-2">Transaksi selesai</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('components.notification-panel')

            <div class="grid gap-6 md:grid-cols-3">
                <div class="hover-lift enhanced-card rounded-2xl bg-gradient-to-br from-cyan-500/20 to-cyan-600/10 border border-cyan-500/30 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-cyan-300">Request Pending</p>
                            <p class="text-5xl font-black text-cyan-100 mt-4">{{ $pendingPeminjamans ?? 0 }}</p>
                        </div>
                        <div class="h-20 w-20 rounded-2xl bg-gradient-to-br from-cyan-500/30 to-cyan-600/20 flex items-center justify-center hover:scale-110 transition-transform duration-300 shadow-lg">
                            <i class="fas fa-clock text-4xl text-cyan-400"></i>
                        </div>
                    </div>
                    <div class="section-divider"></div>
                    <p class="text-xs text-cyan-300/80 mt-4 font-medium">Permintaan yang menunggu persetujuan</p>
                </div>

                <div class="hover-lift enhanced-card rounded-2xl bg-gradient-to-br from-emerald-500/20 to-emerald-600/10 border border-emerald-500/30 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-emerald-300">Disetujui</p>
                            <p class="text-5xl font-black text-emerald-100 mt-4">{{ $approvedPeminjamans ?? 0 }}</p>
                        </div>
                        <div class="h-20 w-20 rounded-2xl bg-gradient-to-br from-emerald-500/30 to-emerald-600/20 flex items-center justify-center hover:scale-110 transition-transform duration-300 shadow-lg">
                            <i class="fas fa-check-circle text-4xl text-emerald-400"></i>
                        </div>
                    </div>
                    <div class="section-divider"></div>
                    <p class="text-xs text-emerald-300/80 mt-4 font-medium">Peminjaman yang sudah disetujui</p>
                </div>

                <div class="hover-lift enhanced-card rounded-2xl bg-gradient-to-br from-slate-500/20 to-slate-600/10 border border-slate-500/30 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-300">Total Alat Dipinjam</p>
                            <p class="text-5xl font-black text-slate-100 mt-4">{{ $activePeminjamans ?? 0 }}</p>
                        </div>
                        <div class="h-20 w-20 rounded-2xl bg-gradient-to-br from-slate-500/30 to-slate-600/20 flex items-center justify-center hover:scale-110 transition-transform duration-300 shadow-lg">
                            <i class="fas fa-box-open text-4xl text-slate-400"></i>
                        </div>
                    </div>
                    <div class="section-divider"></div>
                    <p class="text-xs text-slate-300/80 mt-4 font-medium">Jumlah peminjaman aktif yang sedang berjalan</p>
                </div>
            </div>

            <div class="glass-panel rounded-3xl border border-white/10 p-8">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] font-semibold text-slate-400">Ringkasan Cepat</p>
                            <h2 class="mt-3 text-2xl font-bold text-white">Fitur Siswa</h2>
                        </div>
                        <div class="inline-flex rounded-full bg-slate-950/70 px-4 py-2 text-sm text-slate-200 border border-slate-700">Akses</div>
                    </div>
                    <div class="space-y-5">
                        <div class="rounded-3xl bg-slate-950/70 border border-slate-700/60 p-5">
                            <p class="text-sm text-slate-400">Lihat Daftar Alat</p>
                            <p class="mt-3 text-3xl font-black text-cyan-300">Akses Cepat</p>
                        </div>
                        <div class="rounded-3xl bg-slate-950/70 border border-slate-700/60 p-5">
                            <p class="text-sm text-slate-400">Ajukan Peminjaman</p>
                            <p class="mt-3 text-3xl font-black text-emerald-300">Mudah</p>
                        </div>
                        <div class="rounded-3xl bg-slate-950/70 border border-slate-700/60 p-5">
                            <p class="text-sm text-slate-400">Riwayat Anda</p>
                            <p class="mt-3 text-3xl font-black text-slate-100">Terupdate</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    @else
        <div class="mx-auto max-w-7xl px-4 lg:px-8 space-y-8 relative z-10">
            <!-- Header Card -->
            <div class="enhanced-card rounded-3xl bg-gradient-to-br from-indigo-600/95 via-indigo-700/85 to-purple-600/95 p-10 border border-indigo-400/40 backdrop-blur-xl overflow-hidden">
                <div class="absolute inset-0 opacity-40 pointer-events-none">
                    <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-indigo-400/30 to-transparent rounded-full blur-3xl -mr-32 -mt-32"></div>
                </div>
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 relative z-10">
                    <div>
                        <p class="text-sm uppercase tracking-[0.15em] font-bold text-indigo-100">Dashboard {{ ucfirst(Auth::user()->role) }}</p>
                        <h1 class="text-5xl md:text-6xl font-black mt-2 text-white drop-shadow-lg">{{ ucfirst(Auth::user()->role) }}</h1>
                        <p class="text-indigo-100 mt-3">Selamat datang, <span class="font-bold text-white">{{ Auth::user()->name }}</span></p>
                        <p class="text-indigo-200 text-sm mt-2 max-w-lg">Kelola data dan peminjaman untuk area Anda dengan efisien</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="flex-shrink-0">
                        @csrf
                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-white/20 hover:bg-white/30 border border-white/40 px-6 py-3 text-white font-semibold transition-all duration-300 hover:shadow-lg hover:scale-105">
                            <i class="fas fa-sign-out-alt"></i>Logout
                        </button>
                    </form>
                </div>
            </div>

            @include('components.notification-panel')

            @php
                $roleName = ucfirst(str_replace('_', ' ', Auth::user()->role));
            @endphp
            <div class="grid gap-6 lg:grid-cols-[1.7fr_0.9fr]">
                <div class="enhanced-card rounded-3xl bg-gradient-to-br from-slate-900/95 via-slate-800/90 to-slate-950/95 p-10 border border-slate-700/40 overflow-hidden relative">
                    <div class="absolute inset-0 opacity-40 pointer-events-none">
                        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-cyan-400/25 to-transparent rounded-full blur-3xl -mr-32 -mt-32"></div>
                        <div class="absolute bottom-0 left-4 w-72 h-72 bg-gradient-to-br from-indigo-500/15 to-transparent rounded-full blur-3xl"></div>
                    </div>
                    <div class="relative z-10">
                        <p class="text-sm uppercase tracking-[0.15em] font-bold text-slate-400">Dashboard {{ $roleName }}</p>
                        <h2 class="text-4xl font-black text-white mt-3">Selamat Datang, {{ Auth::user()->name }}</h2>
                        <p class="text-slate-300 mt-4 max-w-2xl">Area kerja ini dibuat khusus untuk peran <span class="font-semibold text-cyan-300">{{ $roleName }}</span>. Temukan semua akses penting di satu tempat dengan tampilan modern dan responsif.</p>

                        <div class="grid gap-4 sm:grid-cols-3 mt-10">
                            <div class="rounded-3xl border border-white/10 bg-white/5 p-5 shadow-[0_20px_60px_rgba(15,23,42,0.18)]">
                                <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Tugas Utama</p>
                                <p class="mt-4 text-3xl font-bold text-white">Akses Cepat</p>
                                <p class="text-sm text-slate-400 mt-2">Menu dan fitur yang paling sering digunakan.</p>
                            </div>
                            <div class="rounded-3xl border border-white/10 bg-white/5 p-5 shadow-[0_20px_60px_rgba(15,23,42,0.18)]">
                                <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Status</p>
                                <p class="mt-4 text-3xl font-bold text-cyan-300">Siap</p>
                                <p class="text-sm text-slate-400 mt-2">Tampilan yang segar dan profesional.</p>
                            </div>
                            <div class="rounded-3xl border border-white/10 bg-white/5 p-5 shadow-[0_20px_60px_rgba(15,23,42,0.18)]">
                                <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Waktu</p>
                                <p class="mt-4 text-3xl font-bold text-indigo-300">Responsif</p>
                                <p class="text-sm text-slate-400 mt-2">Didesain untuk semua ukuran layar.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="glass-panel rounded-3xl border border-slate-700/50 p-8">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] font-semibold text-slate-400">Akses Cepat</p>
                            <h2 class="mt-3 text-2xl font-bold text-white">Menu Pilihan</h2>
                        </div>
                        <div class="inline-flex rounded-full bg-slate-950/70 px-4 py-2 text-sm text-slate-200 border border-slate-700">Pilihan</div>
                    </div>
                    <div class="space-y-4">
                        <a href="{{ route('dashboard') }}" class="group rounded-2xl border border-slate-700/60 bg-slate-950/70 p-5 flex items-center gap-4 hover:border-cyan-400/40 hover:bg-slate-900 transition">
                            <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-cyan-500/15 text-cyan-300">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-white">Ringkasan Dashboard</p>
                                <p class="text-sm text-slate-400">Kembali ke tampilan utama.</p>
                            </div>
                        </a>
                        <a href="{{ route('peminjaman.index') }}" class="group rounded-2xl border border-slate-700/60 bg-slate-950/70 p-5 flex items-center gap-4 hover:border-emerald-400/40 hover:bg-slate-900 transition">
                            <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-500/15 text-emerald-300">
                                <i class="fas fa-boxes"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-white">Daftar Peminjaman</p>
                                <p class="text-sm text-slate-400">Periksa semua peminjaman yang tersedia.</p>
                            </div>
                        </a>
                        <a href="{{ route('alats.index') }}" class="group rounded-2xl border border-slate-700/60 bg-slate-950/70 p-5 flex items-center gap-4 hover:border-sky-400/40 hover:bg-slate-900 transition">
                            <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-sky-500/15 text-sky-300">
                                <i class="fas fa-cube"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-white">Inventaris Alat</p>
                                <p class="text-sm text-slate-400">Kelola daftar alat dengan mudah.</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection