@extends('layouts.app')

@section('content')
<div class="page-shell">
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-24 -left-24 w-72 h-72 rounded-full bg-cyan-500/15 blur-3xl"></div>
        <div class="absolute top-1/4 right-0 w-96 h-96 rounded-full bg-purple-500/10 blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between mb-8">
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-cyan-300 font-semibold">Detail Alat</p>
                <h1 class="mt-3 text-4xl font-black text-white">{{ $alat->nama_alat }}</h1>
                <p class="mt-2 text-slate-400">Informasi lengkap peralatan dan spesifikasinya dalam satu tampilan.</p>
            </div>
            <x-back-link fallback="{{ route('alats.index') }}" class="inline-flex items-center rounded-full border border-slate-700 bg-slate-950/80 px-5 py-3 text-sm font-semibold text-slate-200 hover:bg-slate-900">← Kembali ke daftar</x-back-link>
        </div>

        <div class="panel-card p-10 max-w-4xl mx-auto space-y-8">
            <div class="grid gap-10 lg:grid-cols-[360px_1fr]">
                <div class="rounded-3xl overflow-hidden bg-slate-950/80 border border-slate-700/40">
                    @if($alat->gambar && file_exists(public_path('uploads/alats/' . $alat->gambar)))
                        <img src="{{ asset('uploads/alats/' . $alat->gambar) }}" alt="{{ $alat->nama_alat }}" class="h-full w-full object-cover object-center" />
                    @else
                        <div class="flex h-full min-h-[280px] items-center justify-center bg-slate-900/80 text-slate-400 text-lg">Tidak ada gambar</div>
                    @endif
                </div>

                <div class="space-y-6">
                    <div class="rounded-3xl bg-slate-950/80 border border-slate-700/40 p-6">
                        <h2 class="text-2xl font-bold text-white mb-4">Ringkasan Alat</h2>
                        <div class="space-y-4 text-slate-300">
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-sm uppercase tracking-[0.2em] text-slate-500">Kode Alat</span>
                                <span class="font-semibold text-cyan-300">{{ $alat->kode_alat ?? $alat->kode_alat_text }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-sm uppercase tracking-[0.2em] text-slate-500">Stok</span>
                                <span class="font-semibold text-emerald-300">{{ $alat->stok_baik ?? $alat->stok }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-sm uppercase tracking-[0.2em] text-slate-500">Kondisi</span>
                                <span class="font-semibold text-violet-300">{{ $alat->kondisi ?? 'Baik' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-3xl bg-slate-950/80 border border-slate-700/40 p-6">
                        <h2 class="text-2xl font-bold text-white mb-4">Deskripsi</h2>
                        <p class="text-slate-300 leading-relaxed">{{ $alat->deskripsi ?? 'Deskripsi alat belum tersedia.' }}</p>
                    </div>

                    @auth
                        @if(Auth::user()->role == 'admin')
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('alats.edit', data_get($alat, 'kode_alat') ?? data_get($alat, 'kode_alat_text')) }}" class="btn-primary px-6 py-3">Edit</a>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
