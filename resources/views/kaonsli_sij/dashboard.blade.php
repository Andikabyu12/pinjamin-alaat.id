@extends('layouts.app')

@section('title', 'Dashboard Kakonsli SIJA')

@section('content')
<div class="min-h-screen py-10 relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-44 -left-44 w-96 h-96 rounded-full bg-violet-500/15 blur-3xl"></div>
        <div class="absolute top-24 right-0 w-80 h-80 rounded-full bg-cyan-500/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-1/4 w-72 h-72 rounded-full bg-fuchsia-500/10 blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 lg:px-8 relative z-10 max-w-7xl">
        <div class="mb-10 rounded-3xl panel-card p-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.28em] text-purple-300">Dashboard Kakonsli SIJA</p>
                    <h1 class="mt-4 text-4xl sm:text-5xl font-bold text-white">Halo, {{ Auth::user()->name }}</h1>
                    <p class="mt-3 text-slate-300 max-w-2xl">Kelola data siswa dan seluruh peminjaman SIJA dengan tampilan yang modern, sederhana, dan fokus.</p>
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

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4 mb-10">
            <div class="rounded-3xl glass-panel p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.25em] font-semibold text-purple-200">Total Siswa</p>
                        <p class="mt-4 text-4xl font-bold text-white">{{ $siswaCount }}</p>
                        <p class="mt-2 text-sm text-slate-400">Siswa terdaftar</p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-3xl bg-purple-500/15 text-purple-300 border border-purple-500/20">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="rounded-3xl glass-panel p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.25em] font-semibold text-emerald-200">Total Peminjaman</p>
                        <p class="mt-4 text-4xl font-bold text-white">{{ $peminjamanCount }}</p>
                        <p class="mt-2 text-sm text-slate-400">Total tercatat</p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-3xl bg-emerald-500/15 text-emerald-300 border border-emerald-500/20">
                        <i class="fas fa-hand-holding-box text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="rounded-3xl glass-panel p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.25em] font-semibold text-amber-200">Menunggu</p>
                        <p class="mt-4 text-4xl font-bold text-white">{{ $peminjamanPending }}</p>
                        <p class="mt-2 text-sm text-slate-400">Perlu perhatian</p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-3xl bg-amber-500/15 text-amber-300 border border-amber-500/20">
                        <i class="fas fa-hourglass-end text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="rounded-3xl glass-panel p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.25em] font-semibold text-rose-200">Disetujui</p>
                        <p class="mt-4 text-4xl font-bold text-white">{{ $peminjamanApproved }}</p>
                        <p class="mt-2 text-sm text-slate-400">Peminjaman aktif</p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-3xl bg-rose-500/15 text-rose-300 border border-rose-500/20">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <h2 class="text-2xl font-bold text-white mb-6">Menu Utama</h2>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                <a href="{{ route('kaonsli_sij.siswa') }}" class="group relative overflow-hidden rounded-3xl glass-panel border border-slate-700/40 p-7 text-white transition hover:shadow-2xl hover:-translate-y-1">
                    <div class="mb-5 text-5xl text-blue-300"><i class="fas fa-list-ul"></i></div>
                    <h3 class="text-xl font-bold mb-2">Daftar Siswa</h3>
                    <p class="text-slate-400 text-sm">Lihat semua siswa SIJA.</p>
                </a>
                <a href="{{ route('kaonsli_sij.search-siswa') }}" class="group relative overflow-hidden rounded-3xl glass-panel border border-slate-700/40 p-7 text-white transition hover:shadow-2xl hover:-translate-y-1">
                    <div class="mb-5 text-5xl text-purple-300"><i class="fas fa-magnifying-glass"></i></div>
                    <h3 class="text-xl font-bold mb-2">Cari Siswa</h3>
                    <p class="text-slate-400 text-sm">Temukan siswa dengan cepat.</p>
                </a>
                <a href="{{ route('kaonsli_sij.peminjaman') }}" class="group relative overflow-hidden rounded-3xl glass-panel border border-slate-700/40 p-7 text-white transition hover:shadow-2xl hover:-translate-y-1">
                    <div class="mb-5 text-5xl text-emerald-300"><i class="fas fa-boxes"></i></div>
                    <h3 class="text-xl font-bold mb-2">Peminjaman</h3>
                    <p class="text-slate-400 text-sm">Pantau semua peminjaman alat.</p>
                </a>
                <a href="{{ route('kaonsli_sij.search-peminjaman') }}" class="group relative overflow-hidden rounded-3xl glass-panel border border-slate-700/40 p-7 text-white transition hover:shadow-2xl hover:-translate-y-1">
                    <div class="mb-5 text-5xl text-orange-300"><i class="fas fa-search"></i></div>
                    <h3 class="text-xl font-bold mb-2">Cari Peminjaman</h3>
                    <p class="text-slate-400 text-sm">Temukan peminjaman dengan cepat.</p>
                </a>
            </div>
        </div>

        <div class="mt-10 rounded-3xl glass-panel border border-slate-700/40 p-6">
            <div class="flex items-start gap-4">
                <div class="rounded-full bg-purple-100 p-3 mt-1">
                    <i class="fas fa-info-circle text-purple-600 text-lg"></i>
                </div>
                <div>
                    <h3 class="font-bold text-white mb-1">Informasi Penting</h3>
                    <p class="text-slate-300 text-sm">Sebagai Kakonsli SIJA, Anda dapat melihat data siswa dan peminjaman alat secara langsung. Gunakan menu utama untuk menavigasi, memantau, dan mengelola semua aktivitas SIJA dengan lebih cepat.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
