@extends('layouts.app')

@section('title', 'Data Peminjaman - Wali Kelas')

@section('content')
<div class="min-h-screen py-10">
    <div class="container mx-auto px-4">
        <div class="grid gap-6 xl:grid-cols-[minmax(320px,1fr)_minmax(620px,1.4fr)]">
            <div class="rounded-[2rem] border border-white/10 bg-slate-950/80 p-8 shadow-[0_32px_90px_rgba(15,23,42,0.45)] backdrop-blur-xl">
                <div class="mb-8">
                    <p class="text-sm uppercase tracking-[0.3em] text-cyan-300/75">Wali Kelas</p>
                    <h1 class="mt-3 text-4xl font-semibold text-white">Daftar Peminjaman</h1>
                    <p class="mt-4 text-slate-400">Pantau peminjaman alat siswa jurusan {{ auth()->user()->major }} dengan tampilan yang lebih bersih dan profesional.</p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-3xl border border-slate-800/80 bg-slate-900/80 p-6">
                        <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Total peminjaman</p>
                        <p class="mt-4 text-3xl font-semibold text-white">{{ $peminjamans->total() }}</p>
                    </div>
                    <div class="rounded-3xl border border-slate-800/80 bg-slate-900/80 p-6">
                        <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Disetujui</p>
                        <p class="mt-4 text-3xl font-semibold text-emerald-400">{{ $peminjamans->where('status', 'approved')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-[2rem] border border-white/10 bg-slate-950/80 p-6 shadow-[0_32px_90px_rgba(15,23,42,0.45)] backdrop-blur-xl">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-semibold text-white">Cari Data Peminjaman</h2>
                        <p class="mt-1 text-slate-400">Cari siswa, NIS/NISN, atau nama alat untuk menemukan rekaman lebih cepat.</p>
                    </div>
                    <form action="{{ route('wali_kelas.search-peminjaman') }}" method="GET" class="flex w-full gap-3 md:w-auto">
                        <input type="text" name="q" placeholder="Cari berdasarkan nama siswa, NIS/NISN, atau alat..." value="{{ request('q') }}" class="min-w-0 flex-1 rounded-2xl border border-slate-700 bg-slate-900/80 px-4 py-3 text-slate-100 placeholder:text-slate-500 focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-500/20">
                        <button type="submit" class="rounded-2xl bg-cyan-500 px-6 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400">Cari</button>
                    </form>
                </div>

                <div class="overflow-hidden rounded-[1.75rem] border border-white/10 bg-slate-900/85">
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-separate border-spacing-y-3 text-sm enhanced-table">
                            <thead class="bg-slate-950/90 text-slate-400">
                                <tr class="rounded-[1.25rem] bg-slate-950/95">
                                    <th class="px-5 py-4 text-left font-semibold uppercase tracking-[0.2em]">No</th>
                                    <th class="px-5 py-4 text-left font-semibold uppercase tracking-[0.2em]">NIS / NISN</th>
                                    <th class="px-5 py-4 text-left font-semibold uppercase tracking-[0.2em]">Nama Siswa</th>
                                    <th class="px-5 py-4 text-left font-semibold uppercase tracking-[0.2em]">Kelas</th>
                                    <th class="px-5 py-4 text-left font-semibold uppercase tracking-[0.2em]">Nama Alat</th>
                                    <th class="px-5 py-4 text-left font-semibold uppercase tracking-[0.2em]">Tanggal</th>
                                    <th class="px-5 py-4 text-left font-semibold uppercase tracking-[0.2em]">Status</th>
                                    <th class="px-5 py-4 text-center font-semibold uppercase tracking-[0.2em]">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-slate-200">
                                @forelse($peminjamans as $peminjaman)
                                    <tr class="transition hover:bg-slate-800/70">
                                        <td data-label="No" class="px-5 py-4 font-medium text-slate-100">{{ $peminjamans->firstItem() + $loop->index }}</td>
                                        <td data-label="NIS / NISN" class="px-5 py-4 text-slate-100">{{ $peminjaman->nis ?? '-' }}</td>
                                        <td data-label="Nama Siswa" class="px-5 py-4 text-slate-100">{{ $peminjaman->nama_siswa }}</td>
                                        <td data-label="Kelas" class="px-5 py-4 text-slate-300">{{ $peminjaman->kelas ?? '-' }}</td>
                                        <td data-label="Nama Alat" class="px-5 py-4 text-slate-300">{{ $peminjaman->nama_alat }}</td>
                                        <td data-label="Tanggal" class="px-5 py-4 text-slate-300">{{ \Carbon\Carbon::parse($peminjaman->borrowed_at)->format('d/m/Y') }}</td>
                                        <td data-label="Status" class="px-5 py-4">
                                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{
                                                $peminjaman->status === 'approved' ? 'bg-emerald-500/10 text-emerald-300' :
                                                ($peminjaman->status === 'pending' ? 'bg-amber-500/10 text-amber-300' :
                                                'bg-slate-700/80 text-slate-200')
                                            }}">
                                                {{ ucfirst($peminjaman->status) }}
                                            </span>
                                        </td>
                                        <td data-label="Aksi" class="px-5 py-4 text-center">
                                            <a href="{{ route('peminjaman.show', $peminjaman->id) }}" class="inline-flex items-center gap-2 rounded-full border border-slate-700 bg-slate-950/80 px-4 py-2 text-xs font-semibold text-cyan-300 transition hover:border-cyan-400 hover:text-white">
                                                <i class="fas fa-eye"></i>
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-5 py-10 text-center text-slate-500">
                                            <i class="fas fa-inbox text-4xl mb-3 block text-slate-600"></i>
                                            Tidak ada peminjaman ditemukan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($peminjamans instanceof \Illuminate\Pagination\Paginator)
                    <div class="mt-6 flex items-center justify-end">
                        {{ $peminjamans->links('pagination::tailwind') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection