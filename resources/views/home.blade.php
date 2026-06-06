@extends('layouts.app')

@section('title', 'Beranda - Peminjaman Alat TI SMKN 6 Malang')

@section('content')
<div class="relative overflow-hidden py-12">
    <!-- Enhanced Animated Background Decoration -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <!-- Floating Orbs with More Effects -->
        <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-gradient-to-br from-cyan-500/40 to-blue-500/10 blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 rounded-full bg-gradient-to-br from-purple-500/40 to-pink-500/10 blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 w-80 h-80 rounded-full bg-gradient-to-br from-emerald-500/30 to-transparent blur-3xl animate-pulse" style="animation-delay: 4s;"></div>
        
        <!-- Additional Decorative Orbs -->
        <div class="absolute top-1/4 right-1/3 w-64 h-64 rounded-full bg-gradient-to-tl from-blue-600/20 to-cyan-500/10 blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-1/4 left-1/3 w-72 h-72 rounded-full bg-gradient-to-br from-pink-500/20 to-purple-500/10 blur-3xl animate-pulse" style="animation-delay: 3s;"></div>
        
        <!-- Animated Grid Lines with Enhanced Opacity -->
        <svg class="absolute inset-0 w-full h-full opacity-10" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="url(#gridGradient)" stroke-width="1.5"/>
                </pattern>
                <linearGradient id="gridGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" style="stop-color:#06b6d4;stop-opacity:0.8" />
                    <stop offset="50%" style="stop-color:#8b5cf6;stop-opacity:0.6" />
                    <stop offset="100%" style="stop-color:#ec4899;stop-opacity:0.8" />
                </linearGradient>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)" />
        </svg>
    </div>

    <!-- Hero Section -->
    <section class="relative w-full px-0 sm:px-4 lg:px-8 mb-16">
        <div class="grid gap-12 lg:grid-cols-[1.1fr_0.9fr] items-center">
            <!-- Left - Image with Card -->
            <div class="relative h-[360px] sm:h-[500px] rounded-3xl overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/30 to-purple-500/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-20"></div>
                <img src="{{ asset('images/BG.jpg') }}" alt="Background" class="absolute inset-0 h-full w-full object-cover brightness-90 group-hover:brightness-110 transition-all duration-500">
                <div class="absolute inset-0 bg-gradient-to-br from-slate-950/70 via-slate-950/40 to-slate-950/60"></div>
                
                <div class="absolute inset-0 flex items-center justify-center p-6">
                    <div class="enhanced-card rounded-3xl border border-cyan-500/40 bg-gradient-to-br from-slate-900/98 via-slate-950/95 to-slate-950/98 backdrop-blur-3xl px-10 py-12 shadow-2xl transform group-hover:scale-105 transition-all duration-500 overflow-hidden relative before:absolute before:inset-0 before:bg-gradient-to-br before:from-cyan-500/5 before:via-transparent before:to-purple-500/5 before:opacity-0 group-hover:before:opacity-100 before:transition-opacity before:duration-500 before:rounded-3xl">
                        <!-- Card Decoration Layers -->
                        <div class="absolute inset-0 opacity-50 pointer-events-none">
                            <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-cyan-400/30 to-transparent rounded-full blur-3xl -mr-20 -mt-20 group-hover:blur-2xl transition-all duration-500"></div>
                            <div class="absolute bottom-0 left-0 w-32 h-32 bg-gradient-to-tr from-purple-400/20 to-transparent rounded-full blur-3xl -ml-16 -mb-16 group-hover:blur-2xl transition-all duration-500"></div>
                            <div class="absolute top-1/2 right-1/4 w-24 h-24 bg-gradient-to-br from-blue-400/25 to-transparent rounded-full blur-2xl group-hover:blur-xl transition-all duration-500"></div>
                        </div>
                        
                        <!-- Decorative Border Glow -->
                        <div class="absolute inset-0 rounded-3xl bg-gradient-to-r from-cyan-500/0 via-purple-500/0 to-cyan-500/0 group-hover:from-cyan-500/10 group-hover:via-purple-500/10 group-hover:to-cyan-500/10 transition-all duration-500 opacity-0 group-hover:opacity-100"></div>
                        
                        <div class="flex justify-center mb-8 relative z-10">
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-br from-cyan-500 to-purple-500 rounded-full blur opacity-75 group-hover:opacity-100 transition-opacity duration-500 animate-pulse"></div>
                                <div class="absolute inset-0 bg-gradient-to-br from-cyan-400 to-purple-400 rounded-full blur-lg opacity-40 group-hover:opacity-60 transition-opacity duration-500" style="animation: spin 8s linear infinite;"></div>
                                <div class="absolute -inset-2 bg-gradient-to-r from-cyan-500/30 to-purple-500/30 rounded-full blur-2xl group-hover:blur-3xl transition-all duration-500"></div>
                                <img src="{{ asset('images/LOG0.png') }}" alt="SMK Negeri 6 Malang" class="relative h-40 w-40 rounded-full border-4 border-cyan-400/90 bg-white/5 object-cover shadow-2xl hover:scale-110 transition-transform duration-300">
                            </div>
                        </div>
                        <div class="text-center relative z-10">
                            <div class="inline-block px-4 py-2 mb-4 rounded-full bg-gradient-to-r from-cyan-500/30 to-purple-500/30 border border-cyan-500/50 backdrop-blur-sm hover:from-cyan-500/40 hover:to-purple-500/40 hover:border-cyan-500/70 transition-all duration-300">
                                <span class="text-xs font-bold uppercase tracking-[0.4em] text-cyan-200 drop-shadow">✨ SMK Negeri 6 Malang</span>
                            </div>
                            <h2 class="text-4xl font-black text-white leading-tight drop-shadow-lg mb-2 bg-gradient-to-r from-white via-cyan-200 to-white bg-clip-text text-transparent">Sistem Peminjaman Alat TI</h2>
                            <p class="mt-4 text-sm text-slate-300 leading-relaxed drop-shadow">Platform resmi untuk siswa dan guru SMKN 6 Malang</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right - Content -->
            <div class="space-y-8 relative z-10">
                <div class="inline-flex items-center gap-3 rounded-full border border-cyan-500/40 bg-gradient-to-r from-cyan-500/20 to-blue-500/10 px-6 py-3 w-fit hover:border-cyan-500/60 hover:bg-gradient-to-r hover:from-cyan-500/30 hover:to-blue-500/20 transition-all duration-300 group cursor-pointer backdrop-blur-sm shadow-lg shadow-cyan-500/10 hover:shadow-cyan-500/20">
                    <div class="h-2.5 w-2.5 rounded-full bg-cyan-400 animate-pulse group-hover:bg-cyan-300"></div>
                    <span class="text-xs font-bold uppercase tracking-widest text-cyan-300 group-hover:text-cyan-200 drop-shadow">Sistem Manajemen Alat TI</span>
                </div>
                
                <h1 class="text-4xl sm:text-5xl lg:text-7xl font-black text-white leading-tight drop-shadow-lg animate-in fade-in slide-in-from-bottom-8 duration-1000">
                    <span class="block">Sistem</span>
                    <span class="bg-gradient-to-r from-cyan-400 via-blue-400 via-purple-400 to-pink-400 bg-clip-text text-transparent drop-shadow-lg">Peminjaman Alat TI</span>
                </h1>
                
                <p class="text-base text-slate-300 max-w-lg leading-relaxed">Kelola semua proses peminjaman alat teknologi informasi di SMKN 6 Malang dalam satu platform yang cepat, rapi, dan responsif untuk kemudahan bersama.</p>
                
                















                <div class="hero-strip">
                    <div class="hero-chip group hover:shadow-lg hover:shadow-cyan-500/20 hover:bg-cyan-500/20 transition-all duration-300 cursor-pointer">
                        <i class="fas fa-bolt text-cyan-400 group-hover:text-cyan-300"></i>
                        <span>Responsif cepat dan ringan</span>
                    </div>
                    <div class="hero-chip group hover:shadow-lg hover:shadow-purple-500/20 hover:bg-purple-500/20 transition-all duration-300 cursor-pointer">
                        <i class="fas fa-layer-group text-purple-400 group-hover:text-purple-300"></i>
                        <span>Antarmuka modern dan terstruktur</span>
                    </div>
                    <div class="hero-chip group hover:shadow-lg hover:shadow-emerald-500/20 hover:bg-emerald-500/20 transition-all duration-300 cursor-pointer">
                        <i class="fas fa-user-check text-emerald-400 group-hover:text-emerald-300"></i>
                        <span>Kontrol akses pengguna lengkap</span>
                    </div>
                </div>

                <div class="rounded-3xl border border-cyan-500/25 bg-gradient-to-br from-cyan-500/15 via-slate-950/70 to-slate-950/85 p-8 shadow-2xl shadow-cyan-500/15 mt-8 hover:shadow-3xl hover:shadow-cyan-500/30 transition-all duration-300 group backdrop-blur-sm">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <div class="inline-flex items-center gap-2 mb-2 px-3 py-1 rounded-full bg-cyan-500/20 border border-cyan-500/40">
                                <i class="fas fa-users text-cyan-300 text-xs"></i>
                                <span class="text-xs font-semibold text-cyan-300">Tim Kami</span>
                            </div>
                            <h2 class="mt-2 text-2xl font-bold text-white">Buka Menu Pengembang</h2>
                            <p class="mt-3 max-w-2xl text-slate-300">Tim kami merancang aplikasi ini untuk SMKN 6 Malang. Klik untuk melihat profil pengembang, dan alasan mengapa aplikasi ini di buat.</p>
                        </div>
                        <a href="{{ route('home.developers') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-gradient-to-br from-cyan-500 via-cyan-500 to-blue-600 px-10 py-4 text-sm font-bold text-white shadow-xl transition-all duration-300 hover:from-cyan-400 hover:via-cyan-400 hover:to-blue-500 hover:shadow-2xl hover:shadow-cyan-500/70 hover:scale-110 active:scale-95 group/btn relative overflow-hidden before:absolute before:inset-0 before:bg-gradient-to-r before:from-white/20 before:to-transparent before:opacity-0 group-hover:before:opacity-100 before:transition-opacity before:duration-300 uppercase tracking-wider">
                            <i class="fas fa-users group-hover/btn:rotate-12 transition-transform duration-300"></i>
                            <span>Tim Pengembang</span>
                        </a>
                    </div>
                </div>

                <div class="hero-stats">
                    <div class="hero-stat group">
                        <span class="text-4xl font-black text-cyan-300 group-hover:text-cyan-200 transition-colors">
                            <span class="counter" data-target="100">0</span>+
                        </span>
                        <p class="text-slate-300 group-hover:text-white transition-colors">Alat dan perangkat tercatat dengan rapi untuk semua pengguna.</p>
                    </div>
                    <div class="hero-stat group">
                        <span class="text-4xl font-black text-purple-300 group-hover:text-purple-200 transition-colors">
                            <span class="counter" data-target="10">0</span>+
                        </span>
                        <p class="text-slate-300 group-hover:text-white transition-colors">Peran pengguna lengkap: admin,wali kelas, kakonsli SIJA, dan kaprog TKJ.</p>
                    </div>
                    <div class="hero-stat group">
                        <span class="text-4xl font-black text-emerald-300 group-hover:text-emerald-200 transition-colors">
                            24
                        </span>/7
                        <p class="text-slate-300 group-hover:text-white transition-colors">Fitur tersedia kapan saja dengan desain responsif untuk perangkat apapun.</p>
                    </div>
                </div>
                <div class="mt-8">
                    <button id="landing-load-more" class="btn-load-more group w-full sm:w-auto px-10 py-4 text-sm sm:text-base font-semibold shadow-2xl transition-all duration-300 active:scale-95 relative overflow-hidden" aria-controls="landing-collapsible" aria-expanded="false">
                        <span class="absolute inset-0 bg-gradient-to-r from-white/10 via-white/20 to-white/10 opacity-0 transition-opacity duration-300 group-hover:opacity-100"></span>
                        <span class="relative inline-flex items-center gap-2">
                            <i class="fas fa-chevron-down transition-transform duration-300 group-hover:-translate-y-1"></i>
                            <span>Tampilkan Lebih Banyak</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </section>


    <div id="landing-collapsible" class="hidden space-y-16" aria-hidden="true">
    <section class="w-full px-0 sm:px-4 lg:px-8 mb-16">
            <div class="grid gap-6 md:grid-cols-3 lg:grid-cols-5">
            <div class="enhanced-card rounded-3xl p-8 text-center border-cyan-500/20 bg-gradient-to-br from-slate-950/80 to-slate-950/50 hover:from-slate-900/90 hover:to-slate-900/70 hover:border-cyan-500/50 hover:bg-slate-900/90 hover:shadow-2xl hover:shadow-cyan-500/30 transition-all duration-300 group cursor-pointer transform hover:scale-110 hover:translate-y-2 relative before:absolute before:inset-0 before:bg-gradient-to-br before:from-cyan-500/10 before:to-transparent before:opacity-0 group-hover:before:opacity-100 before:transition-opacity before:duration-300 before:rounded-3xl backdrop-blur-sm">
                <div class="mb-4 inline-flex h-16 w-16 items-center justify-center rounded-3xl bg-gradient-to-br from-cyan-500/20 to-cyan-500/5 text-cyan-300 shadow-lg group-hover:from-cyan-500/40 group-hover:to-cyan-500/20 group-hover:text-cyan-200 group-hover:shadow-xl group-hover:shadow-cyan-500/30 transition-all duration-300 relative z-10">
                    <i class="fas fa-bolt text-2xl group-hover:scale-125 transition-transform duration-300"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2 group-hover:text-cyan-200 transition-colors relative z-10">Akses Cepat</h3>
                <p class="text-sm text-slate-400 group-hover:text-slate-300 transition-colors relative z-10">Login, cari alat, dan ajukan peminjaman dalam tiga langkah mudah.</p>
            </div>
            <div class="enhanced-card rounded-3xl p-8 text-center border-purple-500/20 bg-gradient-to-br from-slate-950/80 to-slate-950/50 hover:from-slate-900/90 hover:to-slate-900/70 hover:border-purple-500/50 hover:bg-slate-900/90 hover:shadow-2xl hover:shadow-purple-500/30 transition-all duration-300 group cursor-pointer transform hover:scale-110 hover:translate-y-2 relative before:absolute before:inset-0 before:bg-gradient-to-br before:from-purple-500/10 before:to-transparent before:opacity-0 group-hover:before:opacity-100 before:transition-opacity before:duration-300 before:rounded-3xl backdrop-blur-sm">
                <div class="mb-4 inline-flex h-16 w-16 items-center justify-center rounded-3xl bg-gradient-to-br from-purple-500/20 to-purple-500/5 text-purple-300 shadow-lg group-hover:from-purple-500/40 group-hover:to-purple-500/20 group-hover:text-purple-200 group-hover:shadow-xl group-hover:shadow-purple-500/30 transition-all duration-300 relative z-10">
                    <i class="fas fa-shield-alt text-2xl group-hover:scale-125 transition-transform duration-300"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2 group-hover:text-purple-200 transition-colors relative z-10">Peran Terstruktur</h3>
                <p class="text-sm text-slate-400 group-hover:text-slate-300 transition-colors relative z-10">Setiap pengguna mendapat akses yang tepat: admin, siswa, wali kelas, atau dosen.</p>
            </div>
            <div class="enhanced-card rounded-3xl p-8 text-center border-emerald-500/20 bg-gradient-to-br from-slate-950/80 to-slate-950/50 hover:from-slate-900/90 hover:to-slate-900/70 hover:border-emerald-500/50 hover:bg-slate-900/90 hover:shadow-2xl hover:shadow-emerald-500/30 transition-all duration-300 group cursor-pointer transform hover:scale-110 hover:translate-y-2 relative before:absolute before:inset-0 before:bg-gradient-to-br before:from-emerald-500/10 before:to-transparent before:opacity-0 group-hover:before:opacity-100 before:transition-opacity before:duration-300 before:rounded-3xl backdrop-blur-sm">
                <div class="mb-4 inline-flex h-16 w-16 items-center justify-center rounded-3xl bg-gradient-to-br from-emerald-500/20 to-emerald-500/5 text-emerald-300 shadow-lg group-hover:from-emerald-500/40 group-hover:to-emerald-500/20 group-hover:text-emerald-200 group-hover:shadow-xl group-hover:shadow-emerald-500/30 transition-all duration-300 relative z-10">
                    <i class="fas fa-chart-line text-2xl group-hover:scale-125 transition-transform duration-300"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2 group-hover:text-emerald-200 transition-colors relative z-10">Kontrol Penuh</h3>
                <p class="text-sm text-slate-400 group-hover:text-slate-300 transition-colors relative z-10">Pantau status peminjaman, kelola laporan, dan jaga inventaris tetap rapi.</p>
            </div>
            <div class="enhanced-card rounded-3xl p-8 text-center border-amber-500/20 bg-gradient-to-br from-slate-950/80 to-slate-950/50 hover:from-slate-900/90 hover:to-slate-900/70 hover:border-amber-500/50 hover:bg-slate-900/90 hover:shadow-2xl hover:shadow-amber-500/30 transition-all duration-300 group cursor-pointer transform hover:scale-110 hover:translate-y-2 relative before:absolute before:inset-0 before:bg-gradient-to-br before:from-amber-500/10 before:to-transparent before:opacity-0 group-hover:before:opacity-100 before:transition-opacity before:duration-300 before:rounded-3xl backdrop-blur-sm">
                <div class="mb-4 inline-flex h-16 w-16 items-center justify-center rounded-3xl bg-gradient-to-br from-amber-500/20 to-amber-500/5 text-amber-300 shadow-lg group-hover:from-amber-500/40 group-hover:to-amber-500/20 group-hover:text-amber-200 group-hover:shadow-xl group-hover:shadow-amber-500/30 transition-all duration-300 relative z-10">
                    <i class="fas fa-tachometer-alt text-2xl group-hover:scale-125 transition-transform duration-300"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2 group-hover:text-amber-200 transition-colors relative z-10">Performa Stabil</h3>
                <p class="text-sm text-slate-400 group-hover:text-slate-300 transition-colors relative z-10">Loading cepat dan navigasi lancar di semua perangkat.</p>
            </div>
            <div class="enhanced-card rounded-3xl p-8 text-center border-pink-500/20 bg-gradient-to-br from-slate-950/80 to-slate-950/50 hover:from-slate-900/90 hover:to-slate-900/70 hover:border-pink-500/50 hover:bg-slate-900/90 hover:shadow-2xl hover:shadow-pink-500/30 transition-all duration-300 group cursor-pointer transform hover:scale-110 hover:translate-y-2 relative before:absolute before:inset-0 before:bg-gradient-to-br before:from-pink-500/10 before:to-transparent before:opacity-0 group-hover:before:opacity-100 before:transition-opacity before:duration-300 before:rounded-3xl backdrop-blur-sm">
                <div class="mb-4 inline-flex h-16 w-16 items-center justify-center rounded-3xl bg-gradient-to-br from-pink-500/20 to-pink-500/5 text-pink-300 shadow-lg group-hover:from-pink-500/40 group-hover:to-pink-500/20 group-hover:text-pink-200 group-hover:shadow-xl group-hover:shadow-pink-500/30 transition-all duration-300 relative z-10">
                    <i class="fas fa-heart text-2xl group-hover:scale-125 transition-transform duration-300"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2 group-hover:text-pink-200 transition-colors relative z-10">Desain Bersahabat</h3>
                <p class="text-sm text-slate-400 group-hover:text-slate-300 transition-colors relative z-10">UI yang intuitif membuat pengguna cepat beradaptasi.</p>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="w-full px-0 sm:px-4 lg:px-8 mb-16">
        <div class="glass-card rounded-3xl border-cyan-500/30 p-12 overflow-hidden">
            <div class="absolute inset-0 opacity-40 pointer-events-none">
                <div class="absolute top-0 left-0 w-80 h-80 bg-gradient-to-br from-cyan-500/30 to-transparent rounded-full blur-3xl -ml-32 -mt-32"></div>
            </div>
            <div class="mb-12 relative z-10">
                <div class="inline-flex items-center gap-2 rounded-full border border-cyan-500/40 bg-gradient-to-r from-cyan-500/20 to-blue-500/10 px-6 py-2.5">
                    <i class="fas fa-spark text-cyan-400"></i>
                    <span class="text-xs font-bold uppercase tracking-widest text-cyan-300">Fitur Unggulan</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-black text-white mt-6">Proses Peminjaman yang Terstruktur</h2>
            </div>
            
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 relative z-10">
                <div class="hover-lift enhanced-card rounded-2xl border border-cyan-500/25 bg-gradient-to-br from-cyan-500/15 to-blue-500/8 p-7 shadow-lg transition-all duration-300 hover:border-cyan-500/50 hover:shadow-xl hover:shadow-cyan-500/20 hover:scale-105 group cursor-pointer">
                    <div class="flex items-center justify-between mb-5">
                        <div class="text-3xl font-black text-cyan-400 drop-shadow group-hover:scale-110 transition-transform duration-300">01</div>
                        <i class="fas fa-list-ul text-cyan-400/70 text-2xl group-hover:text-cyan-300 group-hover:scale-110 transition-all duration-300"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-cyan-200 transition-colors">Daftar Alat</h3>
                    <p class="text-sm text-slate-400 leading-relaxed group-hover:text-slate-300 transition-colors">Kelola inventaris alat TI dengan sistem database terstruktur</p>
                </div>

                <div class="hover-lift enhanced-card rounded-2xl border border-purple-500/25 bg-gradient-to-br from-purple-500/15 to-pink-500/8 p-7 shadow-lg transition-all duration-300 hover:border-purple-500/50 hover:shadow-xl hover:shadow-purple-500/20 hover:scale-105 group cursor-pointer">
                    <div class="flex items-center justify-between mb-5">
                        <div class="text-3xl font-black text-purple-400 drop-shadow group-hover:scale-110 transition-transform duration-300">02</div>
                        <i class="fas fa-exchange-alt text-purple-400/70 text-2xl group-hover:text-purple-300 group-hover:scale-110 transition-all duration-300"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-purple-200 transition-colors">Kelola Peminjaman</h3>
                    <p class="text-sm text-slate-400 leading-relaxed group-hover:text-slate-300 transition-colors">Proses peminjaman yang efisien dan terukur</p>
                </div>

                <div class="hover-lift enhanced-card rounded-2xl border border-emerald-500/25 bg-gradient-to-br from-emerald-500/15 to-teal-500/8 p-7 shadow-lg transition-all duration-300 hover:border-emerald-500/50 hover:shadow-xl hover:shadow-emerald-500/20 hover:scale-105 group cursor-pointer">
                    <div class="flex items-center justify-between mb-5">
                        <div class="text-3xl font-black text-emerald-400 drop-shadow group-hover:scale-110 transition-transform duration-300">03</div>
                        <i class="fas fa-chart-bar text-emerald-400/70 text-2xl group-hover:text-emerald-300 group-hover:scale-110 transition-all duration-300"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-emerald-200 transition-colors">Pantau Status</h3>
                    <p class="text-sm text-slate-400 leading-relaxed group-hover:text-slate-300 transition-colors">Lacak peminjaman secara real-time dengan akurat</p>
                </div>

                <div class="hover-lift enhanced-card rounded-2xl border border-orange-500/25 bg-gradient-to-br from-orange-500/15 to-red-500/8 p-7 shadow-lg transition-all duration-300 hover:border-orange-500/50 hover:shadow-xl hover:shadow-orange-500/20 hover:scale-105 group cursor-pointer">
                    <div class="flex items-center justify-between mb-5">
                        <div class="text-3xl font-black text-orange-400 drop-shadow group-hover:scale-110 transition-transform duration-300">04</div>
                        <i class="fas fa-undo-alt text-orange-400/70 text-2xl group-hover:text-orange-300 group-hover:scale-110 transition-all duration-300"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-orange-200 transition-colors">Pengembalian</h3>
                    <p class="text-sm text-slate-400 leading-relaxed group-hover:text-slate-300 transition-colors">Urus pengembalian alat dengan cepat dan mudah</p>
                </div>

                <div class="hover-lift enhanced-card rounded-2xl border border-rose-500/25 bg-gradient-to-br from-rose-500/15 to-pink-500/8 p-7 shadow-lg transition-all duration-300 hover:border-rose-500/50 hover:shadow-xl hover:shadow-rose-500/20 hover:scale-105 group cursor-pointer">
                    <div class="flex items-center justify-between mb-5">
                        <div class="text-3xl font-black text-rose-400 drop-shadow group-hover:scale-110 transition-transform duration-300">05</div>
                        <i class="fas fa-file-alt text-rose-400/70 text-2xl group-hover:text-rose-300 group-hover:scale-110 transition-all duration-300"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-rose-200 transition-colors">Laporan Mudah</h3>
                    <p class="text-sm text-slate-400 leading-relaxed group-hover:text-slate-300 transition-colors">Buat laporan lengkap dengan mudah dan detail</p>
                </div>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- Benefits Section -->
    <section class="mx-auto max-w-6xl px-4 lg:px-8 mb-16">
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 rounded-full border border-emerald-500/40 bg-gradient-to-r from-emerald-500/20 to-teal-500/10 px-6 py-2.5 mb-6">
                <i class="fas fa-star text-emerald-400"></i>
                <span class="text-xs font-bold uppercase tracking-widest text-emerald-300">Keunggulan Kami</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-black text-white">Sistem Terdepan untuk Manajemen Alat</h2>
        </div>
        
        <div class="grid gap-8 md:grid-cols-3">
            <div class="hover-lift enhanced-card rounded-2xl border border-cyan-500/25 bg-gradient-to-br from-slate-900/70 to-slate-900/40 p-10 shadow-lg backdrop-blur-sm hover:border-cyan-500/50 hover:shadow-xl hover:shadow-cyan-500/20 transition-all duration-300 group">
                <div class="mb-6 inline-flex h-16 w-16 items-center justify-center rounded-2xl border border-cyan-500/40 bg-gradient-to-br from-cyan-500/20 to-blue-500/10 hover:from-cyan-500/30 hover:to-blue-500/20 transition-all shadow-lg group-hover:scale-110">
                    <i class="fas fa-database text-3xl text-cyan-400 group-hover:text-cyan-300 transition-colors"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4 group-hover:text-cyan-200 transition-colors">Inventaris Rapi</h3>
                <p class="text-slate-300 leading-relaxed group-hover:text-slate-200 transition-colors">Kelola semua alat dengan sistem database yang terstruktur, aman, dan mudah diakses dari mana saja.</p>
            </div>

            <div class="hover-lift enhanced-card rounded-2xl border border-purple-500/25 bg-gradient-to-br from-slate-900/70 to-slate-900/40 p-10 shadow-lg backdrop-blur-sm hover:border-purple-500/50 hover:shadow-xl hover:shadow-purple-500/20 transition-all duration-300 group">
                <div class="mb-6 inline-flex h-16 w-16 items-center justify-center rounded-2xl border border-purple-500/40 bg-gradient-to-br from-purple-500/20 to-pink-500/10 hover:from-purple-500/30 hover:to-pink-500/20 transition-all shadow-lg group-hover:scale-110">
                    <i class="fas fa-shield-alt text-3xl text-purple-400 group-hover:text-purple-300 transition-colors"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4 group-hover:text-purple-200 transition-colors">Peran Jelas</h3>
                <p class="text-slate-300 leading-relaxed group-hover:text-slate-200 transition-colors">Sistem akses berbasis peran untuk admin, siswa, wali kelas, kakonsli, dan kaprog dengan kontrol penuh.</p>
            </div>

            <div class="hover-lift enhanced-card rounded-2xl border border-emerald-500/25 bg-gradient-to-br from-slate-900/70 to-slate-900/40 p-10 shadow-lg backdrop-blur-sm hover:border-emerald-500/50 hover:shadow-xl hover:shadow-emerald-500/20 transition-all duration-300 group">
                <div class="mb-6 inline-flex h-16 w-16 items-center justify-center rounded-2xl border border-emerald-500/40 bg-gradient-to-br from-emerald-500/20 to-teal-500/10 hover:from-emerald-500/30 hover:to-teal-500/20 transition-all shadow-lg group-hover:scale-110">
                    <i class="fas fa-paint-brush text-3xl text-emerald-400 group-hover:text-emerald-300 transition-colors"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4 group-hover:text-emerald-200 transition-colors">Tampilan Modern</h3>
                <p class="text-slate-300 leading-relaxed group-hover:text-slate-200 transition-colors">Antarmuka profesional dengan desain responsif yang menarik, intuitif, dan mudah digunakan.</p>
            </div>
        </div>
    </section>

    <!-- Workflow Section -->
    <section class="mx-auto max-w-5xl px-4 lg:px-8 mb-16">
        <div class="glass-card rounded-3xl border-cyan-500/30 p-12 overflow-hidden">
            <div class="absolute inset-0 opacity-40 pointer-events-none">
                <div class="absolute top-0 right-0 w-80 h-80 bg-gradient-to-br from-blue-500/30 to-transparent rounded-full blur-3xl -mr-32 -mt-32"></div>
            </div>
            <div class="mb-12 relative z-10">
                <div class="inline-flex items-center gap-2 rounded-full border border-cyan-500/40 bg-gradient-to-r from-cyan-500/20 to-blue-500/10 px-6 py-2.5">
                    <i class="fas fa-sitemap text-cyan-400"></i>
                    <span class="text-xs font-bold uppercase tracking-widest text-cyan-300">Alur Sistem</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-black text-white mt-6">Struktur Alur Sistem Lengkap</h2>
            </div>

            <div class="space-y-4 relative z-10">
                <div class="enhanced-list-item group rounded-2xl border border-cyan-500/25 bg-gradient-to-r from-cyan-500/15 to-blue-500/8 p-6 hover:border-cyan-500/50 hover:shadow-lg hover:shadow-cyan-500/20 transition-all duration-300 cursor-pointer hover:translate-x-2">
                    <div class="flex items-start gap-5">
                        <div class="flex-shrink-0">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-cyan-500 to-blue-500 font-bold text-white text-lg shadow-lg group-hover:scale-110 transition-transform duration-300">1</div>
                        </div>
                        <div class="flex-grow pt-1">
                            <h4 class="font-bold text-white text-lg group-hover:text-cyan-200 transition-colors">Beranda</h4>
                            <p class="text-sm text-slate-300 mt-2 group-hover:text-slate-200 transition-colors">Halaman awal dengan informasi lengkap sistem dan tombol daftar/login yang mudah diakses.</p>
                        </div>
                    </div>
                </div>

                <div class="enhanced-list-item group rounded-2xl border border-purple-500/25 bg-gradient-to-r from-purple-500/15 to-pink-500/8 p-6 hover:border-purple-500/50 hover:shadow-lg hover:shadow-purple-500/20 transition-all duration-300 cursor-pointer hover:translate-x-2">
                    <div class="flex items-start gap-5">
                        <div class="flex-shrink-0">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-purple-500 to-pink-500 font-bold text-white text-lg shadow-lg group-hover:scale-110 transition-transform duration-300">2</div>
                        </div>
                        <div class="flex-grow pt-1">
                            <h4 class="font-bold text-white text-lg group-hover:text-purple-200 transition-colors">Registrasi</h4>
                            <p class="text-sm text-slate-300 mt-2 group-hover:text-slate-200 transition-colors">Pendaftaran akun dengan pilihan peran: admin, siswa, wali kelas, kakonsli, atau kaprog dengan verifikasi.</p>
                        </div>
                    </div>
                </div>

                <div class="enhanced-list-item group rounded-2xl border border-emerald-500/25 bg-gradient-to-r from-emerald-500/15 to-teal-500/8 p-6 hover:border-emerald-500/50 hover:shadow-lg hover:shadow-emerald-500/20 transition-all duration-300 cursor-pointer hover:translate-x-2">
                    <div class="flex items-start gap-5">
                        <div class="flex-shrink-0">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-emerald-500 to-teal-500 font-bold text-white text-lg shadow-lg group-hover:scale-110 transition-transform duration-300">3</div>
                        </div>
                        <div class="flex-grow pt-1">
                            <h4 class="font-bold text-white text-lg group-hover:text-emerald-200 transition-colors">Dashboard</h4>
                            <p class="text-sm text-slate-300 mt-2 group-hover:text-slate-200 transition-colors">Dashboard personal yang dikustomisasi dengan fitur khusus sesuai peran masing-masing pengguna.</p>
                        </div>
                    </div>
                </div>

                <div class="enhanced-list-item group rounded-2xl border border-orange-500/25 bg-gradient-to-r from-orange-500/15 to-red-500/8 p-6 hover:border-orange-500/50 hover:shadow-lg hover:shadow-orange-500/20 transition-all duration-300 cursor-pointer hover:translate-x-2">
                    <div class="flex items-start gap-5">
                        <div class="flex-shrink-0">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-orange-500 to-red-500 font-bold text-white text-lg shadow-lg group-hover:scale-110 transition-transform duration-300">4-9</div>
                        </div>
                        <div class="flex-grow pt-1">
                            <h4 class="font-bold text-white text-lg group-hover:text-orange-200 transition-colors">Area Khusus Peran</h4>
                            <p class="text-sm text-slate-300 mt-2 group-hover:text-slate-200 transition-colors">Admin, Siswa, Wali Kelas, Kakonsli SIJA, dan Kaprog TKJ memiliki area khusus dengan fitur yang disesuaikan untuk kebutuhan mereka.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="w-full px-0 sm:px-4 lg:px-8 mb-20">
        <div class="glass-card rounded-[32px] border-cyan-500/30 bg-gradient-to-br from-slate-900/50 via-slate-950/50 to-slate-950/60 p-12 text-center hover:border-cyan-500/60 hover:shadow-3xl hover:shadow-cyan-500/30 transition-all duration-500 backdrop-blur-lg relative overflow-hidden before:absolute before:inset-0 before:bg-gradient-to-br before:from-cyan-500/5 before:via-transparent before:to-purple-500/5 before:opacity-0 group-hover:before:opacity-100 before:transition-opacity before:duration-500 group">
            <div class="mb-6 inline-flex h-24 w-24 items-center justify-center rounded-full bg-gradient-to-br from-cyan-500 via-blue-500 to-purple-600 text-white shadow-2xl hover:from-cyan-400 hover:via-blue-400 hover:to-purple-500 hover:shadow-3xl hover:shadow-cyan-500/60 transition-all duration-300 hover:scale-125 relative z-10">
                <i class="fas fa-rocket text-3xl"></i>
            </div>
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6 drop-shadow-lg">Siap Meningkatkan Pengalaman Peminjaman Alat?</h2>
            <p class="mx-auto mb-10 max-w-3xl text-base text-slate-300 leading-relaxed drop-shadow">Mulai gunakan sistem hari ini dan rasakan kemudahan mengelola inventaris, peminjaman, serta laporan dalam satu tampilan yang modern, efisien, dan responsif.</p>
            <div class="flex flex-col items-center justify-center gap-4 sm:flex-row sm:gap-6">
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-3 rounded-full bg-gradient-to-br from-cyan-500 via-cyan-500 to-blue-600 px-12 py-5 text-base font-bold text-white shadow-2xl transition-all duration-300 hover:from-cyan-400 hover:via-cyan-400 hover:to-blue-500 hover:shadow-3xl hover:shadow-cyan-500/70 hover:scale-110 active:scale-95 group/btn relative overflow-hidden before:absolute before:inset-0 before:bg-gradient-to-r before:from-white/30 before:via-white/10 before:to-transparent before:opacity-0 group-hover:before:opacity-100 before:transition-opacity before:duration-300 uppercase tracking-wider">
                    <i class="fas fa-user-plus group-hover/btn:scale-125 transition-transform duration-300"></i>
                    <span>Buat Akun Gratis</span>
                </a>
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-3 rounded-full border-2 border-cyan-500/50 bg-gradient-to-br from-slate-900/60 via-slate-950/60 to-slate-950/70 px-12 py-5 text-base font-bold text-cyan-300 shadow-2xl transition-all duration-300 hover:border-cyan-500/80 hover:from-slate-900/80 hover:via-slate-950/80 hover:to-slate-950/90 hover:text-cyan-200 hover:shadow-3xl hover:shadow-cyan-500/40 hover:scale-110 active:scale-95 group/btn relative overflow-hidden before:absolute before:inset-0 before:bg-gradient-to-r before:from-white/10 before:to-transparent before:opacity-0 group-hover:before:opacity-50 before:transition-opacity before:duration-300 uppercase tracking-wider">
                    <i class="fas fa-sign-in-alt group-hover/btn:scale-125 transition-transform duration-300"></i>
                    <span>Masuk Sekarang</span>
                </a>
            </div>
        </div>
    </section>
    </div>

@push('styles')
<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes shimmer {
        0% {
            background-position: -1000px 0;
        }
        100% {
            background-position: 1000px 0;
        }
    }

    @keyframes pulse-glow {
        0%, 100% {
            box-shadow: 0 0 20px rgba(6, 182, 212, 0.3);
        }
        50% {
            box-shadow: 0 0 40px rgba(6, 182, 212, 0.6);
        }
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-20px);
        }
    }

    @keyframes spin-slow {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    .animate-in {
        animation: fadeInUp 0.6s ease-out;
    }

    .hero-chip {
        @apply inline-flex items-center gap-2 px-4 py-3 rounded-full bg-gradient-to-r from-slate-800/50 to-slate-900/50 border border-slate-700/50 text-sm font-semibold text-slate-300 backdrop-blur-sm transition-all duration-300;
    }

    .hero-stat {
        @apply text-center p-4;
    }

    .btn-primary {
        @apply inline-flex items-center justify-center rounded-full bg-gradient-to-br from-cyan-500 to-blue-600 text-white font-semibold;
    }

    .btn-load-more {
        @apply inline-flex items-center justify-center rounded-full bg-gradient-to-r from-sky-400 via-cyan-300 to-blue-500 text-white font-semibold ring-1 ring-sky-300/40 shadow-2xl shadow-sky-500/20;
    }

    .btn-load-more:hover {
        @apply scale-105 shadow-3xl;
    }

    .btn-load-more::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top left, rgba(255,255,255,0.35), transparent 40%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .btn-load-more:hover::before {
        opacity: 1;
    }

    .btn-load-more span {
        position: relative;
        z-index: 1;
    }

    .enhanced-card {
        @apply relative;
    }

    .glass-card {
        @apply relative bg-gradient-to-br from-slate-950/40 to-slate-950/60 backdrop-blur-2xl;
    }

    .gradient-text {
        @apply bg-clip-text text-transparent;
    }

    /* Hover-lift effect */
    .hover-lift {
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .hover-lift:hover {
        transform: translateY(-8px);
    }

    /* Enhanced list item */
    .enhanced-list-item {
        @apply relative;
    }

    .enhanced-list-item:hover {
        transform: translateX(8px);
    }

    /* Section divider */
    .section-divider {
        @apply h-px bg-gradient-to-r from-transparent via-cyan-500/50 to-transparent my-16;
    }

    /* Counter animation */
    .counter {
        @apply font-black text-2xl;
    }

    /* Floating animation */
    @media (prefers-reduced-motion: no-preference) {
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .hero-chip {
            animation: fadeInUp 0.6s ease-out backwards;
        }
    }
</style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            const btn = document.getElementById('landing-load-more');
            const collapsible = document.getElementById('landing-collapsible');
            if (!btn || !collapsible) return;
            let expanded = false;
            btn.addEventListener('click', function(e){
                e.preventDefault();
                if (!expanded) {
                    collapsible.classList.remove('hidden');
                    collapsible.setAttribute('aria-hidden','false');
                    btn.innerHTML = '<i class="fas fa-chevron-up inline-block mr-2"></i><span>Tampilkan Lebih Sedikit</span>';
                    btn.setAttribute('aria-expanded','true');
                    setTimeout(()=> collapsible.scrollIntoView({behavior:'smooth', block:'start'}), 80);
                    expanded = true;
                } else {
                    collapsible.classList.add('hidden');
                    collapsible.setAttribute('aria-hidden','true');
                    btn.innerHTML = '<i class="fas fa-chevron-down inline-block mr-2"></i><span>Tampilkan Lebih Banyak</span>';
                    btn.setAttribute('aria-expanded','false');
                    window.scrollTo({top:0, behavior:'smooth'});
                    expanded = false;
                }
            });

            // Counter animation
            const counters = document.querySelectorAll('.counter');
            if (counters.length > 0) {
                const observerOptions = {
                    threshold: 0.5,
                    rootMargin: '0px'
                };

                const observer = new IntersectionObserver(function(entries) {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const counter = entry.target;
                            const target = parseInt(counter.getAttribute('data-target'));
                            let current = 0;
                            const increment = Math.ceil(target / 30);

                            const counterInterval = setInterval(() => {
                                current += increment;
                                if (current >= target) {
                                    counter.textContent = target;
                                    clearInterval(counterInterval);
                                } else {
                                    counter.textContent = current;
                                }
                            }, 50);

                            observer.unobserve(counter);
                        }
                    });
                }, observerOptions);

                counters.forEach(counter => observer.observe(counter));
            }
        });
    </script>
@endpush

</div>
@endsection
