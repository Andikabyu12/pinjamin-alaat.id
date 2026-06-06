@extends('layouts.app')

@section('title', '404 Not Found')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-10 sm:px-6 lg:px-8">
    <div class="w-full max-w-4xl">
        <!-- Main Error Card -->
        <div class="rounded-[32px] border border-white/10 bg-slate-900/85 p-8 sm:p-12 text-center shadow-2xl backdrop-blur-lg mb-8">
            <span class="inline-flex items-center justify-center rounded-full bg-cyan-500/15 p-4 text-cyan-300 mb-6 text-4xl animate-bounce">
                <i class="fas fa-exclamation-triangle"></i>
            </span>
            <h1 class="text-6xl sm:text-7xl font-bold bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">404</h1>
            <p class="mt-6 text-lg sm:text-xl text-slate-300 font-medium">Halaman yang Anda cari tidak ditemukan atau sudah berpindah.</p>
            <p class="mt-3 text-sm sm:text-base text-slate-400">Pastikan alamat sudah benar, atau gunakan akses cepat di bawah untuk melanjutkan.</p>
        </div>

        <!-- Quick Access Grid -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Back to Home Button -->
            <a href="{{ route('home') }}" class="group relative overflow-hidden rounded-xl border border-cyan-400/30 bg-gradient-to-br from-cyan-500/15 to-blue-600/10 p-6 transition-all duration-300 hover:border-cyan-400/60 hover:from-cyan-500/25 hover:to-blue-600/20 hover:shadow-xl hover:shadow-cyan-500/25 active:scale-95">
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-0 group-hover:opacity-10 transition-opacity duration-500" style="animation: slideRight 0.6s ease-in-out;"></div>
                <div class="relative z-10 flex items-center justify-center gap-3 flex-col">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg bg-cyan-400/20 group-hover:bg-cyan-400/30 transition-colors">
                        <i class="fas fa-home text-cyan-400 text-xl"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-cyan-300 group-hover:text-cyan-200 transition-colors">Kembali ke Beranda</p>
                        <p class="text-xs text-slate-400 mt-1">Halaman utama aplikasi</p>
                    </div>
                </div>
                <div class="absolute -right-10 -bottom-10 w-20 h-20 bg-cyan-400 rounded-full opacity-0 group-hover:opacity-5 transition-opacity duration-300"></div>
            </a>

            <!-- Dashboard Button -->
            @auth
            <a href="{{ route('dashboard') }}" class="group relative overflow-hidden rounded-xl border border-purple-400/30 bg-gradient-to-br from-purple-500/15 to-pink-600/10 p-6 transition-all duration-300 hover:border-purple-400/60 hover:from-purple-500/25 hover:to-pink-600/20 hover:shadow-xl hover:shadow-purple-500/25 active:scale-95">
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                <div class="relative z-10 flex items-center justify-center gap-3 flex-col">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg bg-purple-400/20 group-hover:bg-purple-400/30 transition-colors">
                        <i class="fas fa-chart-line text-purple-400 text-xl"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-purple-300 group-hover:text-purple-200 transition-colors">Buka Dashboard</p>
                        <p class="text-xs text-slate-400 mt-1">Panel utama Anda</p>
                    </div>
                </div>
                <div class="absolute -right-10 -bottom-10 w-20 h-20 bg-purple-400 rounded-full opacity-0 group-hover:opacity-5 transition-opacity duration-300"></div>
            </a>
            @else
            <a href="{{ route('login') }}" class="group relative overflow-hidden rounded-xl border border-emerald-400/30 bg-gradient-to-br from-emerald-500/15 to-teal-600/10 p-6 transition-all duration-300 hover:border-emerald-400/60 hover:from-emerald-500/25 hover:to-teal-600/20 hover:shadow-xl hover:shadow-emerald-500/25 active:scale-95">
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                <div class="relative z-10 flex items-center justify-center gap-3 flex-col">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg bg-emerald-400/20 group-hover:bg-emerald-400/30 transition-colors">
                        <i class="fas fa-sign-in-alt text-emerald-400 text-xl"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-emerald-300 group-hover:text-emerald-200 transition-colors">Masuk Sekarang</p>
                        <p class="text-xs text-slate-400 mt-1">Akses akun Anda</p>
                    </div>
                </div>
                <div class="absolute -right-10 -bottom-10 w-20 h-20 bg-emerald-400 rounded-full opacity-0 group-hover:opacity-5 transition-opacity duration-300"></div>
            </a>
            @endauth

            <!-- Daftar Button -->
            @guest
            <a href="{{ route('register') }}" class="group relative overflow-hidden rounded-xl border border-rose-400/30 bg-gradient-to-br from-rose-500/15 to-orange-600/10 p-6 transition-all duration-300 hover:border-rose-400/60 hover:from-rose-500/25 hover:to-orange-600/20 hover:shadow-xl hover:shadow-rose-500/25 active:scale-95">
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                <div class="relative z-10 flex items-center justify-center gap-3 flex-col">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg bg-rose-400/20 group-hover:bg-rose-400/30 transition-colors">
                        <i class="fas fa-user-plus text-rose-400 text-xl"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-rose-300 group-hover:text-rose-200 transition-colors">Daftar Akun</p>
                        <p class="text-xs text-slate-400 mt-1">Buat akun baru</p>
                    </div>
                </div>
                <div class="absolute -right-10 -bottom-10 w-20 h-20 bg-rose-400 rounded-full opacity-0 group-hover:opacity-5 transition-opacity duration-300"></div>
            </a>
            @endguest

            <!-- Hubungi Support Button -->
            <a href="javascript:void(0)" class="group relative overflow-hidden rounded-xl border border-amber-400/30 bg-gradient-to-br from-amber-500/15 to-orange-600/10 p-6 transition-all duration-300 hover:border-amber-400/60 hover:from-amber-500/25 hover:to-orange-600/20 hover:shadow-xl hover:shadow-amber-500/25 active:scale-95">
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                <div class="relative z-10 flex items-center justify-center gap-3 flex-col">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg bg-amber-400/20 group-hover:bg-amber-400/30 transition-colors">
                        <i class="fas fa-headset text-amber-400 text-xl"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-amber-300 group-hover:text-amber-200 transition-colors">Hubungi Support</p>
                        <p class="text-xs text-slate-400 mt-1">Butuh bantuan?</p>
                    </div>
                </div>
                <div class="absolute -right-10 -bottom-10 w-20 h-20 bg-amber-400 rounded-full opacity-0 group-hover:opacity-5 transition-opacity duration-300"></div>
            </a>
        </div>

        <!-- Additional Info -->
        <div class="mt-10 rounded-xl border border-white/5 bg-slate-900/40 p-6 text-center">
            <p class="text-slate-400 text-sm">Kode Error: <span class="font-mono text-cyan-400">404 NOT FOUND</span></p>
            <p class="mt-2 text-xs text-slate-500">Jika masalah berlanjut, silakan hubungi tim support kami.</p>
        </div>
    </div>
</div>

<style>
    @keyframes slideRight {
        from {
            transform: translateX(-100%);
        }
        to {
            transform: translateX(100%);
        }
    }
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .animate-bounce {
        animation: bounce 2s infinite;
    }
</style>
@endsection
