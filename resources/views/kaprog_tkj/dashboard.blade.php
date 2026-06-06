@extends('layouts.app')

@section('title', 'Dashboard Kaprog TKJ')

@section('content')
<div class="min-h-screen py-10 relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-44 -left-44 w-96 h-96 rounded-full bg-emerald-500/15 blur-3xl"></div>
        <div class="absolute top-24 right-0 w-80 h-80 rounded-full bg-cyan-500/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-1/4 w-72 h-72 rounded-full bg-teal-500/10 blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 lg:px-8 relative z-10 max-w-7xl">
        <div class="mb-10 rounded-3xl panel-card p-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.28em] text-emerald-300">Dashboard Kaprog TKJ</p>
                    <h1 class="mt-4 text-4xl sm:text-5xl font-bold text-white">Halo, {{ Auth::user()->name }}</h1>
                    <p class="mt-3 text-slate-300 max-w-2xl">Kelola inventori alat dan semua peminjaman TKJ dengan tampilan yang ramping dan fokus pada produktivitas.</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="flex-shrink-0">
                    @csrf
                    <button type="submit" class="btn-primary inline-flex items-center gap-2">
                        <i class="fas fa-sign-out-alt"></i>Logout
                    </button>
                </form>
            </div>
        </div>

        @include('components.notification-panel')

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4 mb-10"
            <div class="rounded-3xl glass-panel p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.25em] font-semibold text-blue-200">Total Alat</p>
                        <p class="mt-4 text-4xl font-bold text-white">{{ $alatCount }}</p>
                        <p class="mt-2 text-sm text-slate-400">Alat tersedia</p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-3xl bg-blue-500/15 text-blue-300 border border-blue-500/20">
                        <i class="fas fa-box text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="rounded-3xl glass-panel p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.25em] font-semibold text-emerald-200">Tersedia</p>
                        <p class="mt-4 text-4xl font-bold text-white">{{ $alatAvailable }}</p>
                        <p class="mt-2 text-sm text-slate-400">Siap digunakan</p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-3xl bg-emerald-500/15 text-emerald-300 border border-emerald-500/20">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="rounded-3xl glass-panel p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.25em] font-semibold text-amber-200">Digunakan</p>
                        <p class="mt-4 text-4xl font-bold text-white">{{ $alatUsed }}</p>
                        <p class="mt-2 text-sm text-slate-400">Sedang dipinjam</p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-3xl bg-amber-500/15 text-amber-300 border border-amber-500/20">
                        <i class="fas fa-hourglass-end text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="rounded-3xl glass-panel p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.25em] font-semibold text-rose-200">Peminjaman</p>
                        <p class="mt-4 text-4xl font-bold text-white">{{ $peminjamanCount }}</p>
                        <p class="mt-2 text-sm text-slate-400">Total tercatat</p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-3xl bg-rose-500/15 text-rose-300 border border-rose-500/20">
                        <i class="fas fa-hand-holding-box text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <h2 class="text-2xl font-bold text-white mb-6">Menu Utama</h2>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                <a href="{{ route('kaprog_tkj.alat') }}" class="group relative overflow-hidden rounded-3xl glass-panel border border-slate-700/40 p-7 text-white transition hover:shadow-2xl hover:-translate-y-1">
                    <div class="mb-5 text-5xl text-blue-300"><i class="fas fa-box"></i></div>
                    <h3 class="text-xl font-bold mb-2">Daftar Alat</h3>
                    <p class="text-slate-400 text-sm">Lihat semua alat TKJ.</p>
                </a>
                <a href="{{ route('kaprog_tkj.search-alat') }}" class="group relative overflow-hidden rounded-3xl glass-panel border border-slate-700/40 p-7 text-white transition hover:shadow-2xl hover:-translate-y-1">
                    <div class="mb-5 text-5xl text-purple-300"><i class="fas fa-magnifying-glass"></i></div>
                    <h3 class="text-xl font-bold mb-2">Cari Alat</h3>
                    <p class="text-slate-400 text-sm">Temukan alat dengan cepat.</p>
                </a>
                <a href="{{ route('kaprog_tkj.peminjaman') }}" class="group relative overflow-hidden rounded-3xl glass-panel border border-slate-700/40 p-7 text-white transition hover:shadow-2xl hover:-translate-y-1">
                    <div class="mb-5 text-5xl text-emerald-300"><i class="fas fa-boxes"></i></div>
                    <h3 class="text-xl font-bold mb-2">Peminjaman</h3>
                    <p class="text-slate-400 text-sm">Pantau semua peminjaman.</p>
                </a>
            </div>
        </div>

        <div class="mt-10 rounded-3xl glass-panel border border-slate-700/40 p-6">
            <div class="flex items-start gap-4">
                <div class="rounded-full bg-emerald-100 p-3 mt-1">
                    <i class="fas fa-info-circle text-emerald-600 text-lg"></i>
                </div>
                <div>
                    <h3 class="font-bold text-white mb-1">Informasi Penting</h3>
                    <p class="text-slate-300 text-sm">Sebagai Kaprog TKJ, Anda memiliki akses penuh untuk mengelola inventori alat dan memantau semua peminjaman jurusan TKJ. Gunakan menu di atas untuk mengelola data dengan efisien.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
