@extends('layouts.app')

@section('title', 'Data Siswa - Wali Kelas')

@section('content')
<div class="container mx-auto px-4">
    <div class="card rounded-2xl p-6 border border-slate-700/40">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-white mb-1">Data Siswa</h1>
                <p class="text-slate-300 text-sm">
                    Menampilkan siswa wali kelas untuk kelas
                    <span class="font-semibold text-emerald-300">{{ auth()->user()->kelas }}</span>
                    jurusan
                    <span class="font-semibold text-emerald-300">{{ auth()->user()->major }}</span>.
                </p>
            </div>
        </div>

        <!-- Search Form -->
        <div class="mb-6">
            <form action="{{ route('wali_kelas.search-siswa') }}" method="GET" class="flex gap-3 items-center">
                <input type="text" name="q" placeholder="Cari berdasarkan nama atau NIS..." value="{{ request('q') }}" class="flex-1 rounded-xl bg-slate-800/60 border border-slate-700/50 px-4 py-3 text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-500/30" />
                <button type="submit" class="inline-flex items-center gap-2 gradient-btn text-white px-5 py-3 rounded-xl hover:shadow-lg transition">
                    <i class="fas fa-search"></i>
                    <span class="font-semibold">Cari</span>
                </button>
            </form>
        </div>

        <!-- Tabel Siswa -->
        <div class="overflow-x-auto rounded-lg shadow-lg border border-slate-700/40">
            <table class="w-full min-w-[720px] table-auto">
                <thead class="bg-slate-900/70 text-slate-300 sticky top-0 z-10">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">NIS</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Jurusan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $siswa)
                        <tr class="odd:bg-slate-800/40 even:bg-slate-900/30 hover:bg-cyan-500/10 transition-colors">
                            <td class="px-6 py-4 text-sm text-emerald-200 font-semibold">{{ $siswa->nis }}</td>
                            <td class="px-6 py-4 text-sm text-slate-100">{{ $siswa->name }}</td>
                            <td class="px-6 py-4 text-sm text-slate-300">{{ $siswa->kelas }}</td>
                            <td class="px-6 py-4 text-sm text-slate-300">{{ $siswa->major ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-slate-300">{{ $siswa->email }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('wali_kelas.show-siswa', $siswa->id) }}" class="inline-flex items-center gap-2 text-cyan-300 hover:text-cyan-200 text-sm font-medium">
                                    <i class="fas fa-eye"></i>
                                    <span>Lihat</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center gap-3">
                                    <i class="fas fa-inbox text-4xl text-slate-500"></i>
                                    <div class="text-lg font-medium">Tidak ada siswa ditemukan</div>
                                    <p class="text-sm text-slate-400">Coba ubah kata kunci pencarian atau tambahkan data siswa terlebih dahulu.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($siswas instanceof \Illuminate\Pagination\Paginator)
            <div class="mt-6 px-6 py-4">
                {{ $siswas->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</div>
@endsection