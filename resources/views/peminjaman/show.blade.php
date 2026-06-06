@extends('layouts.app')

@section('content')
<div class="page-shell">
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-24 left-0 w-80 h-80 rounded-full bg-cyan-500/15 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 rounded-full bg-purple-500/10 blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 lg:px-8 relative z-10">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.2em] text-cyan-300">Detail Peminjaman</p>
                <h1 class="mt-3 text-3xl font-bold text-white">{{ $peminjaman->nomor_peminjaman }}</h1>
            </div>
            <x-back-link fallback="{{ route('peminjaman.index') }}" class="btn-secondary inline-flex items-center rounded-full px-5 py-3 text-sm font-semibold">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
            </x-back-link>
        </div>

        <div class="grid gap-8 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-6">
                <div class="panel-card p-8">
                    <h2 class="text-xl font-bold text-white mb-6">Informasi Peminjaman</h2>
                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <p class="text-sm uppercase tracking-[0.18em] text-slate-400">No. Peminjaman</p>
                            <p class="mt-2 text-lg font-semibold text-white">{{ $peminjaman->nomor_peminjaman }}</p>
                        </div>
                        <div>
                            <p class="text-sm uppercase tracking-[0.18em] text-slate-400">Status</p>
                            @php
                                $statusBg = match($peminjaman->status) {
                                    'pending' => 'bg-amber-500/20 text-amber-200 border border-amber-400/30',
                                    'approved' => 'bg-emerald-500/15 text-emerald-200 border border-emerald-400/30',
                                    'returned' => 'bg-blue-500/15 text-blue-200 border border-blue-400/30',
                                    'rejected' => 'bg-rose-500/15 text-rose-200 border border-rose-400/30',
                                    default => 'bg-slate-500/15 text-slate-200 border border-slate-500/30'
                                };
                                $statusLabel = match($peminjaman->status) {
                                    'pending' => '⏱ Menunggu',
                                    'approved' => '✓ Disetujui',
                                    'returned' => '↩ Dikembalikan',
                                    'rejected' => '✗ Ditolak',
                                    default => $peminjaman->status
                                };
                            @endphp
                            <div class="flex items-center gap-3 mt-2">
                                <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ $statusBg }}">{{ $statusLabel }}</span>
                                @if(method_exists($peminjaman, 'isOverdue') && $peminjaman->isOverdue())
                                    <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold bg-rose-500/20 text-rose-200 border border-rose-400/30">Terlambat</span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <p class="text-sm uppercase tracking-[0.18em] text-slate-400">Peminjam</p>
                            <p class="mt-2 text-lg font-semibold text-white">{{ $peminjaman->user?->name ?? '-' }}</p>
                            <p class="text-sm text-slate-400">{{ $peminjaman->user?->email ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm uppercase tracking-[0.18em] text-slate-400">Kelas</p>
                            <p class="mt-2 text-lg font-semibold text-white">{{ $peminjaman->user?->kelas ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="panel-card p-8">
                    <h2 class="text-xl font-bold text-white mb-6">Detail Alat</h2>
                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <p class="text-sm uppercase tracking-[0.18em] text-slate-400">Nama Alat</p>
                            <p class="mt-2 text-lg font-semibold text-white">{{ $peminjaman->alat?->nama_alat ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm uppercase tracking-[0.18em] text-slate-400">Kode Alat</p>
                            <p class="mt-2 text-lg font-semibold text-white">{{ $peminjaman->alat?->kode_alat_text ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm uppercase tracking-[0.18em] text-slate-400">Jumlah Dipinjam</p>
                            <p class="mt-2 text-lg font-semibold text-white">{{ $peminjaman->qty }}</p>
                        </div>
                        <div>
                            <p class="text-sm uppercase tracking-[0.18em] text-slate-400">Kategori</p>
                            <p class="mt-2 text-lg font-semibold text-white">{{ $peminjaman->alat?->kategori ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="panel-card p-8">
                    <h2 class="text-xl font-bold text-white mb-6">Jadwal Peminjaman</h2>
                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <p class="text-sm uppercase tracking-[0.18em] text-slate-400">Tanggal Peminjaman</p>
                            <p class="mt-2 text-lg font-semibold text-white">{{ $peminjaman->borrowed_at ? \Carbon\Carbon::parse($peminjaman->borrowed_at)->setTimezone('Asia/Jakarta')->format('d M Y H:i') : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm uppercase tracking-[0.18em] text-slate-400">Batas Pengembalian</p>
                            <p class="mt-2 text-lg font-semibold text-white">{{ $peminjaman->return_date ? \Carbon\Carbon::parse($peminjaman->return_date)->format('d M Y') : '-' }}</p>
                        </div>
                        @if($peminjaman->returned_at)
                            <div>
                                <p class="text-sm uppercase tracking-[0.18em] text-slate-400">Tanggal Pengembalian</p>
                                <p class="mt-2 text-lg font-semibold text-white">{{ \Carbon\Carbon::parse($peminjaman->returned_at)->setTimezone('Asia/Jakarta')->format('d M Y H:i') }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="panel-card p-8">
                    <h2 class="text-xl font-bold text-white mb-6">Informasi Pengembalian</h2>
                    @if($peminjaman->photo_return || $peminjaman->return_description)
                        <div class="grid gap-6 lg:grid-cols-2">
                            <div class="space-y-4 text-slate-300">
                                @if($peminjaman->return_description)
                                    <div>
                                        <p class="text-sm uppercase tracking-[0.18em] text-slate-400">Deskripsi Pengembalian</p>
                                        <p class="mt-2 leading-relaxed">{{ $peminjaman->return_description }}</p>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm uppercase tracking-[0.18em] text-slate-400">Status Pengembalian</p>
                                    <p class="mt-2">{{ ucfirst($peminjaman->status) }} pada {{ $peminjaman->returned_at ? \Carbon\Carbon::parse($peminjaman->returned_at)->setTimezone('Asia/Jakarta')->format('d M Y H:i') : 'N/A' }}</p>
                                </div>
                            </div>
                            @if($peminjaman->photo_return)
                                <div class="rounded-3xl overflow-hidden bg-slate-950/80 border border-slate-700/40 p-4">
                                    <p class="text-sm uppercase tracking-[0.18em] text-slate-400 mb-3">Foto Bukti Pengembalian</p>
                                    <img src="{{ asset('uploads/peminjaman/' . $peminjaman->photo_return) }}" alt="Bukti Pengembalian" class="h-64 w-full rounded-[24px] object-cover shadow-lg" />
                                </div>
                            @endif
                        </div>
                    @else
                        <p class="text-slate-300">Pengembalian dicatat otomatis setelah konfirmasi. Jika peminjaman sudah dikembalikan, foto dan deskripsi akan tampil di sini.</p>
                    @endif
                </div>

                @if($peminjaman->status === 'approved' && ((auth()->user()->role === 'siswa' && $peminjaman->user_id === auth()->id()) || in_array(auth()->user()->role, ['admin', 'kaonsli_sij', 'kaprog_tkj'])))
                    <div class="panel-card p-8">
                        <h2 class="text-xl font-bold text-white mb-6">Aksi</h2>
                        <a href="{{ route('peminjaman.return.form', $peminjaman->id) }}" class="btn-primary inline-flex items-center justify-center rounded-full px-6 py-3 gap-2">
                            <i class="fas fa-undo"></i>Kembalikan Alat
                        </a>
                    </div>
                @endif
            </div>

            <div class="space-y-6">
                <div class="panel-card p-6">
                    <h3 class="text-lg font-bold text-white mb-4">Ringkasan</h3>
                    <div class="space-y-4 text-sm text-slate-300">
                        <div class="flex justify-between items-center border-b border-slate-700 pb-4">
                            <span>Status:</span>
                            <span class="font-semibold text-white">{{ $statusLabel }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-slate-700 pb-4">
                            <span>Peminjam:</span>
                            <span class="font-semibold text-white truncate">{{ $peminjaman->user?->name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-slate-700 pb-4">
                            <span>Alat:</span>
                            <span class="font-semibold text-white truncate">{{ $peminjaman->alat?->nama_alat ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Jumlah:</span>
                            <span class="font-semibold text-white">{{ $peminjaman->qty }}</span>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl bg-slate-900/90 border border-cyan-500/15 p-6 shadow-lg">
                    <h3 class="text-lg font-bold text-white mb-4">Pengembalian Tanpa File</h3>
                    <div class="flex items-center gap-3 text-cyan-200">
                        <i class="fas fa-info-circle text-xl"></i>
                        <span class="text-sm">Pengembalian tidak lagi membutuhkan unggahan foto atau bukti file.</span>
                    </div>
                </div>

                <div class="panel-card p-6">
                    <h3 class="text-lg font-bold text-white mb-4">Timeline</h3>
                    <div class="space-y-3 text-sm text-slate-300">
                        @if($peminjaman->borrowed_at)
                            <div class="flex gap-3">
                                <div class="flex flex-col items-center">
                                    <div class="w-3 h-3 bg-cyan-400 rounded-full mt-1.5"></div>
                                </div>
                                <div>
                                    <p class="font-semibold text-white">Dipinjam</p>
                                    <p class="text-slate-400 text-xs">{{ \Carbon\Carbon::parse($peminjaman->borrowed_at)->setTimezone('Asia/Jakarta')->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        @endif
                        @if($peminjaman->returned_at)
                            <div class="flex gap-3">
                                <div class="flex flex-col items-center">
                                    <div class="w-0.5 h-4 bg-slate-600"></div>
                                    <div class="w-3 h-3 bg-emerald-400 rounded-full"></div>
                                </div>
                                <div>
                                    <p class="font-semibold text-white">Dikembalikan</p>
                                    <p class="text-slate-400 text-xs">{{ \Carbon\Carbon::parse($peminjaman->returned_at)->setTimezone('Asia/Jakarta')->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
