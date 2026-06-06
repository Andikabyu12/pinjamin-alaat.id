@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12 relative overflow-hidden">
    <!-- Decorative Background -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-40 -right-32 w-96 h-96 rounded-full bg-gradient-to-br from-purple-500/25 to-transparent blur-3xl animate-pulse"></div>
        <div class="absolute top-1/3 -left-32 w-80 h-80 rounded-full bg-gradient-to-br from-blue-500/20 to-transparent blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-72 h-72 rounded-full bg-gradient-to-br from-pink-500/15 to-transparent blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <!-- Header Card -->
        <div class="enhanced-card rounded-3xl bg-gradient-to-br from-blue-600/90 via-blue-700/80 to-purple-600/90 border border-blue-400/40 p-10 shadow-2xl backdrop-blur-xl mb-10 overflow-hidden">
            <div class="absolute inset-0 opacity-40 pointer-events-none">
                <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-blue-400/30 to-transparent rounded-full blur-3xl -mr-32 -mt-32"></div>
            </div>
            <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between relative z-10">
                <div>
                    <h1 class="text-5xl font-black text-white drop-shadow-lg">Daftar Alat & Peralatan</h1>
                    <p class="mt-3 text-blue-100 text-lg">Kelola inventaris alat teknologi informasi dengan mudah, cepat, dan terorganisir</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    @auth
                        @if(Auth::user()->role == 'admin')
                            <a href="{{ route('alats.create') }}" class="inline-flex items-center rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-600 px-8 py-4 text-base font-bold text-white shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                                <i class="fas fa-plus mr-3 text-lg"></i>Tambah Alat Baru
                            </a>
                        @elseif(Auth::user()->role == 'siswa')
                            <a href="{{ route('peminjaman.create') }}" class="inline-flex items-center rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-600 px-8 py-4 text-base font-bold text-white shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                                <i class="fas fa-hand-holding-medical mr-3 text-lg"></i>Pinjam Alat
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 px-8 py-4 text-base font-bold text-white shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                            <i class="fas fa-sign-in-alt mr-3 text-lg"></i>Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid gap-6 sm:grid-cols-3 mb-12">
            <div class="hover-lift enhanced-card rounded-2xl border border-cyan-500/30 bg-gradient-to-br from-cyan-500/20 to-blue-500/10 p-8 shadow-lg">
                <div class="text-xs font-bold uppercase tracking-widest text-cyan-300 mb-3">Total Alat</div>
                <div class="text-5xl font-black text-cyan-100 mb-2">{{ $alats->count() }}</div>
                <div class="text-sm text-cyan-200">Item tersedia saat ini</div>
            </div>
            <div class="hover-lift enhanced-card rounded-2xl border border-purple-500/30 bg-gradient-to-br from-purple-500/20 to-pink-500/10 p-8 shadow-lg">
                <div class="text-xs font-bold uppercase tracking-widest text-purple-300 mb-3">Status Pencarian</div>
                <div class="text-lg font-bold text-purple-100 mb-2">{{ $search ? 'Filter Aktif' : 'Semua Alat' }}</div>
                <div class="text-sm text-purple-200">{{ $search ? 'Hasil untuk "' . $search . '"' : 'Tidak ada filter' }}</div>
            </div>
            <div class="hover-lift enhanced-card rounded-2xl border border-emerald-500/30 bg-gradient-to-br from-emerald-500/20 to-teal-500/10 p-8 shadow-lg">
                <div class="text-xs font-bold uppercase tracking-widest text-emerald-300 mb-3">Kemudahan Akses</div>
                <div class="text-lg font-bold text-emerald-100 mb-2">Cepat & Intuitif</div>
                <div class="text-sm text-emerald-200">Gunakan pencarian untuk hasil optimal</div>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-8 rounded-2xl border border-emerald-500/50 bg-gradient-to-br from-emerald-500/20 to-emerald-600/10 p-5 text-emerald-200 font-medium shadow-lg mb-8 flex items-center gap-3">
                <i class="fas fa-check-circle text-emerald-400 text-xl"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if(isset($error) && $error)
            <div class="mb-8 rounded-2xl border border-red-500/50 bg-gradient-to-br from-red-500/20 to-red-600/10 p-5 text-red-200 font-medium shadow-lg mb-8 flex items-center gap-3">
                <i class="fas fa-exclamation-triangle text-red-400 text-xl"></i>
                <div>{{ $error }}</div>
            </div>
        @endif

        <!-- Search Box -->
        <div class="mb-10 enhanced-card rounded-2xl border border-cyan-500/30 bg-gradient-to-br from-slate-900/70 to-slate-900/40 p-8 shadow-lg backdrop-blur">
            <form action="{{ route('alats.index') }}" method="GET" class="flex flex-col gap-4 sm:flex-row sm:items-center">
                <div class="relative flex-1">
                    <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-cyan-400">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" placeholder="Cari nama alat atau kode..." value="{{ $search ?? '' }}"
                           class="w-full rounded-xl border border-slate-700/60 bg-slate-800/50 px-12 py-4 text-slate-100 placeholder-slate-500 shadow-inner transition-all duration-300 focus:border-cyan-500/70 focus:bg-slate-800/80 focus:ring-2 focus:ring-cyan-500/30 focus:outline-none">
                </div>
                <div class="flex flex-wrap gap-3">
                    <button type="submit" class="btn-primary px-8 py-4 gap-3 font-bold shadow-lg">
                        <i class="fas fa-search"></i>Cari
                    </button>
                    @if($search)
                        <a href="{{ route('alats.index') }}" class="inline-flex items-center rounded-xl border border-slate-700/60 bg-slate-800/50 px-8 py-4 text-slate-300 font-bold shadow-md hover:bg-slate-800/70 transition-all duration-300 gap-2">
                            <i class="fas fa-times"></i>Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        @guest
            <div class="mb-10 enhanced-card rounded-2xl bg-gradient-to-br from-blue-600/30 to-indigo-600/20 border border-blue-500/40 p-10 shadow-lg">
                <div class="flex flex-col md:flex-row items-center gap-6 mb-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl flex items-center justify-center shadow-lg flex-shrink-0">
                        <i class="fas fa-info-circle text-white text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-black text-blue-100">Masuk untuk Akses Lengkap</h3>
                        <p class="text-blue-200 font-medium mt-2">Silakan masuk terlebih dahulu untuk melihat detail lengkap, stok real-time, dan mengelola peminjaman alat.</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('login') }}" class="btn-primary px-8 py-3 gap-2 font-bold shadow-lg">
                        <i class="fas fa-sign-in-alt"></i>Masuk Sekarang
                    </a>
                    <a href="{{ route('register') }}" class="btn-secondary px-8 py-3 gap-2 font-bold shadow-md">
                        <i class="fas fa-user-plus"></i>Daftar Akun Baru
                    </a>
                </div>
            </div>
        @endguest

        @if($alats->count() > 0)
            <!-- Grid Layout for Alat Cards -->
            <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-3">
                @foreach($alats as $alat)
                    <div class="hover-lift group enhanced-card rounded-2xl border border-cyan-500/25 bg-gradient-to-br from-slate-900/70 to-slate-900/40 overflow-hidden shadow-lg">
                        <!-- Image Section -->
                        <div class="relative overflow-hidden h-56 bg-gradient-to-br from-slate-800 to-slate-900">
                            <div class="absolute inset-x-0 top-0 h-32 bg-gradient-to-r from-cyan-500/20 via-transparent to-purple-500/20 pointer-events-none"></div>
                            @if($alat->gambar && file_exists(public_path('uploads/alats/' . $alat->gambar)))
                                <img src="{{ asset('uploads/alats/' . $alat->gambar) }}" alt="{{ $alat->nama_alat }}" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <img src="{{ asset('images/G.jpg') }}" alt="{{ $alat->nama_alat }}" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500" />
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent opacity-60"></div>
                        </div>

                        <!-- Content Section -->
                        <div class="p-8 space-y-5">
                            <div class="flex items-start justify-between gap-4">
                                <div class="space-y-2">
                                    <div class="text-xs font-bold uppercase tracking-widest text-cyan-300">Kode Alat</div>
                                    <div class="text-2xl font-black text-cyan-100">{{ $alat->kode_alat_text ?? '-' }}</div>
                                </div>
                                <div class="icon-badge bg-gradient-to-br from-cyan-500/30 to-blue-500/20">
                                    <i class="fas fa-cube"></i>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-2xl font-bold text-white group-hover:text-cyan-300 transition-colors">{{ $alat->nama_alat }}</h3>
                                @if($alat->deskripsi)
                                    <p class="text-sm leading-relaxed text-slate-300 mt-3 line-clamp-3">{{ Str::limit($alat->deskripsi, 110) }}</p>
                                @else
                                    <p class="text-sm leading-relaxed text-slate-400 italic mt-3">Tidak ada deskripsi tersedia</p>
                                @endif
                            </div>

                            <div class="grid gap-3 sm:grid-cols-2 pt-2">
                                <div class="enhanced-list-item rounded-xl bg-slate-800/50 border border-slate-700/50 p-4">
                                    <div class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-2">Stok</div>
                                    <div class="text-2xl font-black text-cyan-300">{{ $alat->stok_baik ?? $alat->stok }}</div>
                                </div>
                                <div class="enhanced-list-item rounded-xl bg-slate-800/50 border border-slate-700/50 p-4">
                                    <div class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-2">Kondisi</div>
                                    <div class="text-lg font-bold text-emerald-300">{{ $alat->kondisi ?? 'Baik' }}</div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="grid gap-3 sm:grid-cols-2 pt-3">
                                @auth
                                    @if(Auth::user()->role == 'admin')
                                        <a href="{{ route('alats.edit', data_get($alat, 'kode_alat') ?? data_get($alat, 'kode_alat_text')) }}" class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-amber-500 to-orange-600 px-4 py-3 text-sm font-bold text-white shadow-md hover:shadow-lg transition-all duration-300 gap-2 hover:scale-105">
                                            <i class="fas fa-edit"></i>Edit
                                        </a>
                                        <form action="{{ route('alats.destroy', data_get($alat, 'kode_alat') ?? data_get($alat, 'kode_alat_text')) }}" method="POST" class="inline-flex">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-red-500 to-rose-600 px-4 py-3 text-sm font-bold text-white shadow-md hover:shadow-lg transition-all duration-300 hover:scale-105" onclick="return confirm('Yakin ingin menghapus alat ini?')">
                                                <i class="fas fa-trash mr-2"></i>Hapus
                                            </button>
                                        </form>
                                    @elseif(Auth::user()->role == 'siswa')
                                        <a href="{{ route('peminjaman.create', ['alat_id' => data_get($alat, 'kode_alat_text') ?? data_get($alat, 'kode_alat')]) }}" class="col-span-2 inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 px-4 py-4 text-base font-bold text-white shadow-lg hover:shadow-xl transition-all duration-300 gap-2 hover:scale-105">
                                            <i class="fas fa-hand-holding-medical"></i>Pinjam Alat Ini
                                        </a>
                                    @endif
                                @else
                                    <div class="col-span-2 rounded-xl bg-slate-800/50 border border-slate-700/50 p-4 text-center text-sm text-slate-400 font-medium">
                                        Masuk untuk mengelola
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if(method_exists($alats, 'hasPages') && $alats->hasPages())
                <div class="mt-12 flex justify-center">
                    {{ $alats->links() }}
                </div>
            @endif
        @else
            <div class="enhanced-card rounded-2xl border border-slate-700/50 bg-gradient-to-br from-slate-900/70 to-slate-900/40 text-center py-16 shadow-lg">
                <div class="w-24 h-24 bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <i class="fas fa-tools text-slate-500 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-200 mb-3">Belum ada data alat</h3>
                <p class="text-slate-400 mb-8 text-lg">Belum ada alat yang terdaftar dalam sistem.</p>
                @auth
                    @if(Auth::user()->role == 'admin')
                        <a href="{{ route('alats.create') }}" class="btn-primary px-8 py-4 gap-2 font-bold inline-flex items-center justify-center shadow-lg">
                            <i class="fas fa-plus"></i>Tambah Alat Pertama
                        </a>
                    @endif
                @endauth
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
