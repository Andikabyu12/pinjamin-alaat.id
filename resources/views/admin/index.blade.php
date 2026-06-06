@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-950 via-indigo-950 to-slate-900 py-10 relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-44 -left-44 w-96 h-96 rounded-full bg-cyan-500/20 blur-3xl"></div>
        <div class="absolute top-20 -right-28 w-96 h-96 rounded-full bg-fuchsia-500/15 blur-3xl"></div>
        <div class="absolute bottom-0 left-1/3 w-80 h-80 rounded-full bg-slate-400/10 blur-3xl"></div>
    </div>
    <div class="container mx-auto px-4 lg:px-8 relative z-10 max-w-7xl">
        <section class="mb-10 rounded-[34px] bg-slate-900/95 border border-slate-800/80 p-8 shadow-[0_35px_95px_rgba(15,23,42,0.55)] overflow-hidden" aria-labelledby="dashboard-heading">
            <div class="flex flex-col gap-6 xl:flex-row xl:items-center xl:justify-between">
                <div class="max-w-3xl">
                    <p class="text-sm uppercase tracking-[0.28em] text-fuchsia-300">Admin Dashboard</p>
                    <h1 id="dashboard-heading" class="mt-4 text-4xl sm:text-5xl font-bold text-white">Kelola Sistem dengan Tampilan Elegan</h1>
                    <p class="mt-3 text-lg text-cyan-200">Halo, {{ Auth::user()->name }}. Selamat datang kembali.</p>
                    <p class="mt-4 text-slate-300">Lihat statistik penting, akses menu utama, dan kelola inventaris dari satu area dashboard yang menarik dan profesional.</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="flex-shrink-0">
                    @csrf
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>
        </section>

        <section class="mb-8" aria-labelledby="quick-actions-heading">
            <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p id="quick-actions-heading" class="text-sm uppercase tracking-[0.28em] text-slate-400">Menu Cepat</p>
                    <h2 class="mt-2 text-2xl font-semibold text-white">Akses fitur penting dengan mudah</h2>
                </div>
                <p class="text-sm text-slate-400 max-w-xl">Pilihan cepat untuk mengelola pengguna, daftar alat, dan kaprog dalam satu klik.</p>
            </div>
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <a href="{{ route('register.wali-kelas') }}" class="group rounded-3xl bg-slate-800/90 border border-slate-700/90 p-5 transition hover:border-cyan-400/40 hover:shadow-[0_18px_45px_rgba(56,189,248,0.18)]">
                    <div class="flex items-center gap-4">
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-cyan-500/15 text-cyan-300 transition group-hover:bg-cyan-500/25">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </span>
                        <div>
                            <h3 class="text-lg font-semibold text-white">Daftar Wali Kelas</h3>
                            <p class="text-sm text-slate-400">Lihat dan tambah wali kelas baru.</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('register.kaonsli-sij') }}" class="group rounded-3xl bg-slate-800/90 border border-slate-700/90 p-5 transition hover:border-indigo-400/40 hover:shadow-[0_18px_45px_rgba(99,102,241,0.18)]">
                    <div class="flex items-center gap-4">
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-500/15 text-indigo-300 transition group-hover:bg-indigo-500/25">
                            <i class="fas fa-user-graduate"></i>
                        </span>
                        <div>
                            <h3 class="text-lg font-semibold text-white">Daftar Kakonsli SIJA</h3>
                            <p class="text-sm text-slate-400">Kelola daftar kakonsli dengan cepat.</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('register.kaprog-tkj') }}" class="group rounded-3xl bg-slate-800/90 border border-slate-700/90 p-5 transition hover:border-emerald-400/40 hover:shadow-[0_18px_45px_rgba(16,185,129,0.18)]">
                    <div class="flex items-center gap-4">
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-500/15 text-emerald-300 transition group-hover:bg-emerald-500/25">
                            <i class="fas fa-tools"></i>
                        </span>
                        <div>
                            <h3 class="text-lg font-semibold text-white">Daftar Kaprog TKJ</h3>
                            <p class="text-sm text-slate-400">Tambah dan atur kaprog dengan cepat.</p>
                        </div>
                    </div>
                </a>
            </div>
        </section>

        <section class="mb-8" aria-labelledby="stats-heading">
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p id="stats-heading" class="text-sm uppercase tracking-[0.28em] text-slate-400">Statistik Sistem</p>
                    <h2 class="mt-2 text-2xl font-semibold text-white">Ringkasan Data Penting</h2>
                </div>
            </div>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                <a href="{{ route('admin.users') }}" class="group rounded-2xl bg-gradient-to-br from-sky-600/80 to-sky-700/60 border border-sky-400/40 p-7 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden relative">
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gradient-to-br from-sky-400/20 to-transparent pointer-events-none"></div>
                    <div class="relative z-10">
                        <div class="inline-flex items-center justify-center h-14 w-14 rounded-xl bg-white/15 border border-white/20 text-3xl group-hover:scale-110 transition-transform duration-300 mb-5">
                            <i class="fas fa-users"></i>
                        </div>
                        <p class="text-xs uppercase tracking-wider font-semibold text-sky-100 opacity-90">Total Users</p>
                        <p class="mt-3 text-4xl font-black text-sky-50">{{ App\Models\User::count() }}</p>
                        <p class="text-xs text-sky-100/70 mt-2">Kelola semua pengguna sistem</p>
                    </div>
                </a>

                <div class="group rounded-2xl bg-gradient-to-br from-indigo-600/80 to-indigo-700/60 border border-indigo-400/40 p-7 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden relative">
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gradient-to-br from-indigo-400/20 to-transparent pointer-events-none"></div>
                    <div class="relative z-10">
                        <div class="inline-flex items-center justify-center h-14 w-14 rounded-xl bg-white/15 border border-white/20 text-3xl mb-5">
                            <i class="fas fa-cube"></i>
                        </div>
                        <p class="text-xs uppercase tracking-wider font-semibold text-indigo-100 opacity-90">Jumlah Alat</p>
                        <p class="mt-3 text-4xl font-black text-indigo-50">{{ $counts['alats'] }}</p>
                        <p class="text-xs text-indigo-100/70 mt-2">Alat yang tersedia dalam sistem</p>
                    </div>
                </div>

                <div class="group rounded-2xl bg-gradient-to-br from-emerald-600/80 to-emerald-700/60 border border-emerald-400/40 p-7 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden relative">
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gradient-to-br from-emerald-400/20 to-transparent pointer-events-none"></div>
                    <div class="relative z-10">
                        <div class="inline-flex items-center justify-center h-14 w-14 rounded-xl bg-white/15 border border-white/20 text-3xl mb-5">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <p class="text-xs uppercase tracking-wider font-semibold text-emerald-100 opacity-90">Total Peminjaman</p>
                        <p class="mt-3 text-4xl font-black text-emerald-50">{{ $counts['peminjaman'] }}</p>
                        <p class="text-xs text-emerald-100/70 mt-2">Peminjaman yang sudah tercatat</p>
                    </div>
                </div>

                <div class="group rounded-2xl bg-gradient-to-br from-purple-600/80 to-purple-700/60 border border-purple-400/40 p-7 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden relative">
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gradient-to-br from-purple-400/20 to-transparent pointer-events-none"></div>
                    <div class="relative z-10">
                        <div class="inline-flex items-center justify-center h-14 w-14 rounded-xl bg-white/15 border border-white/20 text-3xl mb-5">
                            <i class="fas fa-undo"></i>
                        </div>
                        <p class="text-xs uppercase tracking-wider font-semibold text-purple-100 opacity-90">Pengembalian</p>
                        <p class="mt-3 text-4xl font-black text-purple-50">{{ $counts['returned'] }}</p>
                        <p class="text-xs text-purple-100/70 mt-2">Peminjaman yang sudah dikembalikan</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
