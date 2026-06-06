@extends('layouts.app')

@section('content')
<div class="page-shell overflow-hidden relative">
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-28 left-0 w-80 h-80 rounded-full bg-slate-700/30 blur-3xl"></div>
        <div class="absolute top-10 right-6 w-72 h-72 rounded-full bg-cyan-500/10 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 rounded-full bg-violet-500/10 blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        @php
            $classes = $classes ?? collect([]);
            $jurusans = $jurusans ?? collect([]);
            $q = $q ?? request('q');
            $selectedKelas = $kelas ?? request('kelas');
            $selectedJurusan = $jurusan ?? request('jurusan');
        @endphp

        <div class="mb-10 rounded-3xl border border-slate-700/60 bg-slate-950/90 p-8 shadow-xl backdrop-blur-xl">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div class="max-w-3xl">
                    <p class="text-sm uppercase tracking-[0.3em] text-cyan-300 font-semibold">Kelola Data Siswa</p>
                    <h1 class="mt-3 text-4xl md:text-5xl font-black text-white">Dashboard Data Siswa</h1>
                    <p class="mt-4 text-slate-400 text-base md:text-lg">Lihat, edit, dan filter data siswa dengan tampilan yang modern, profesional, dan mudah digunakan.</p>
                </div>
                <div class="flex flex-wrap items-center gap-3 justify-start lg:justify-end">
                    <a href="{{ route('siswas.create') }}" class="btn-primary rounded-full px-6 py-3 inline-flex items-center gap-2"> <i class="fas fa-plus"></i> Tambah Siswa</a>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('siswas.import') }}" class="btn-secondary rounded-full px-6 py-3 inline-flex items-center gap-2"> <i class="fas fa-file-import"></i> Impor</a>
                        <a href="{{ route('siswas.export') }}" class="btn-secondary rounded-full px-6 py-3 inline-flex items-center gap-2"> <i class="fas fa-file-export"></i> Export</a>
                    @endif
                </div>
            </div>

            <div class="mt-8 grid gap-4 sm:grid-cols-3">
                <div class="rounded-3xl border border-slate-700/60 bg-slate-900/80 p-5">
                    <p class="text-xs uppercase tracking-[0.3em] text-cyan-300 font-semibold">Total Siswa</p>
                    <p class="mt-4 text-3xl font-black text-white">{{ method_exists($siswas, 'total') ? $siswas->total() : $siswas->count() }}</p>
                    <p class="mt-2 text-sm text-slate-400">Data siswa yang terdaftar.</p>
                </div>
                <div class="rounded-3xl border border-slate-700/60 bg-slate-900/80 p-5">
                    <p class="text-xs uppercase tracking-[0.3em] text-violet-300 font-semibold">Kelas</p>
                    <p class="mt-4 text-3xl font-black text-white">{{ $classes->count() }}</p>
                    <p class="mt-2 text-sm text-slate-400">Jumlah kelas aktif.</p>
                </div>
                <div class="rounded-3xl border border-slate-700/60 bg-slate-900/80 p-5">
                    <p class="text-xs uppercase tracking-[0.3em] text-amber-300 font-semibold">Jurusan</p>
                    <p class="mt-4 text-3xl font-black text-white">{{ $jurusans->count() }}</p>
                    <p class="mt-2 text-sm text-slate-400">Total jurusan yang tersedia.</p>
                </div>
            </div>
        </div>

        <div class="glass-panel rounded-3xl border border-slate-700/60 bg-slate-950/90 p-6 mb-8 shadow-xl">
            <form action="{{ route('siswas.index') }}" method="GET" class="grid gap-4 lg:grid-cols-[1.9fr_1fr_1fr_auto] items-end">
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Cari Nama / NIS</label>
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
                        <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama / NIS" class="dark-input w-full rounded-3xl border border-slate-700/80 bg-slate-900/80 pl-12 pr-4 py-3 text-slate-100" />
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Kelas</label>
                    <select name="kelas" class="dark-select w-full rounded-3xl border border-slate-700/80 bg-slate-900/80 px-4 py-3 text-slate-100">
                        <option value="">Semua Kelas</option>
                        @foreach($classes as $c)
                            <option value="{{ $c }}" {{ $selectedKelas == $c ? 'selected' : '' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Jurusan</label>
                    <select name="jurusan" class="dark-select w-full rounded-3xl border border-slate-700/80 bg-slate-900/80 px-4 py-3 text-slate-100">
                        <option value="">Semua Jurusan</option>
                        @foreach($jurusans as $j)
                            <option value="{{ $j }}" {{ $selectedJurusan == $j ? 'selected' : '' }}>{{ strtoupper($j) }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn-primary rounded-3xl px-6 py-3">Cari</button>
            </form>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-3xl border border-emerald-400/30 bg-emerald-500/10 p-4 text-emerald-100">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-6 rounded-3xl border border-rose-400/30 bg-rose-500/10 p-4 text-rose-100">{{ session('error') }}</div>
        @endif

        <div class="grid gap-6 lg:grid-cols-12">
            <aside class="lg:col-span-3 hidden lg:block">
                <div class="sticky top-24 rounded-3xl border border-slate-700/60 bg-slate-950/90 p-6 shadow-xl">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-white mb-2">Filter Kelas</h3>
                        <p class="text-sm text-slate-400">Pilih klasifikasi kelas untuk mempersempit daftar.</p>
                    </div>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('siswas.index') }}" class="flex items-center justify-between gap-3 rounded-3xl border border-slate-700/80 bg-slate-900/80 px-4 py-3 text-sm text-slate-200 transition hover:border-cyan-400/40 {{ empty($selectedKelas) ? 'border-cyan-400/40 bg-slate-900' : '' }}">
                                <span>Semua</span>
                                <span class="rounded-full bg-slate-800 px-2 py-0.5 text-xs text-slate-100">{{ $classCounts->sum() ?? 0 }}</span>
                            </a>
                        </li>
                        @foreach($classes as $c)
                            <li>
                                <a href="{{ route('siswas.index', array_merge(request()->query(), ['kelas' => $c])) }}" class="flex items-center justify-between gap-3 rounded-3xl border border-slate-700/80 bg-slate-900/80 px-4 py-3 text-sm text-slate-200 transition hover:border-cyan-400/40 {{ $selectedKelas == $c ? 'border-cyan-400/40 bg-slate-900' : '' }}">
                                    <span>{{ $c }}</span>
                                    <span class="rounded-full bg-slate-800 px-2 py-0.5 text-xs text-slate-100">{{ $classCounts[$c] ?? 0 }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-8">
                        <h4 class="text-sm font-semibold text-white mb-3">Jurusan</h4>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('siswas.index') }}" class="rounded-full bg-slate-900/80 px-3 py-1 text-xs text-slate-100">Semua</a>
                            @foreach($jurusans as $j)
                                <a href="{{ route('siswas.index', array_merge(request()->query(), ['jurusan' => $j])) }}" class="rounded-full bg-slate-900/80 px-3 py-1 text-xs text-slate-100">{{ strtoupper($j) }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </aside>

            <main class="lg:col-span-9">
                <div class="panel-card rounded-3xl border border-slate-700/60 bg-slate-950/90 p-6 shadow-xl">
                    <div class="rounded-3xl border border-slate-700/70 bg-slate-900/90 p-5 text-slate-200 mb-6">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                            <div>
                                <p class="text-sm uppercase tracking-[0.24em] text-cyan-300 mb-2">
                                    @if($q)
                                        Pencarian aktif
                                    @elseif($selectedKelas)
                                        Filter kelas
                                    @elseif($selectedJurusan)
                                        Filter jurusan
                                    @else
                                        Status tampilan
                                    @endif
                                </p>
                                <p class="text-lg font-semibold text-white">
                                    @if($q)
                                        "{{ $q }}" • {{ method_exists($siswas, 'total') ? ($siswas->total() . ' siswa cocok') : ($siswas->count() . ' siswa cocok') }}
                                    @elseif(method_exists($siswas, 'total'))
                                        {{ $siswas->firstItem() ?? 0 }}&ndash;{{ $siswas->lastItem() ?? 0 }} dari {{ $siswas->total() }} siswa
                                    @else
                                        {{ $siswas->count() }} siswa
                                    @endif
                                </p>
                                @if($selectedKelas || $selectedJurusan)
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        @if($selectedKelas)
                                            <span class="rounded-full bg-cyan-600/15 px-3 py-1 text-xs text-cyan-200 border border-cyan-500/30">Kelas: {{ $selectedKelas }}</span>
                                        @endif
                                        @if($selectedJurusan)
                                            <span class="rounded-full bg-indigo-600/15 px-3 py-1 text-xs text-indigo-200 border border-indigo-500/30">Jurusan: {{ strtoupper($selectedJurusan) }}</span>
                                        @endif
                                        <a href="{{ route('siswas.index') }}" class="rounded-full bg-slate-900/80 px-3 py-1 text-xs font-semibold text-slate-200 hover:bg-slate-800">Reset filter</a>
                                    </div>
                                @endif
                            </div>
                            <div class="text-sm text-slate-400">
                                @if(method_exists($siswas, 'total'))
                                    Halaman {{ $siswas->currentPage() }} dari {{ $siswas->lastPage() }}
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="overflow-hidden rounded-3xl border border-slate-700/60 bg-slate-950/80 shadow-inner">
                        <table class="min-w-full border-collapse text-sm text-left text-slate-200">
                            <thead class="bg-slate-900/95 text-slate-300 uppercase tracking-[0.2em] text-xs">
                                <tr>
                                    <th class="px-5 py-4">Nama</th>
                                    <th class="px-5 py-4">Kelas</th>
                                    <th class="px-5 py-4">Jurusan</th>
                                    <th class="px-5 py-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800">
                                @forelse($siswas as $siswa)
                                    <tr class="transition hover:bg-slate-900/80">
                                        <td class="px-5 py-4 font-semibold text-slate-100">{{ $siswa->nama }}</td>
                                        <td class="px-5 py-4 text-slate-300">{{ $siswa->kelas }}</td>
                                        <td class="px-5 py-4 uppercase text-slate-300">{{ $siswa->jurusan }}</td>
                                        <td class="px-5 py-4 flex flex-wrap gap-2">
                                            <a href="{{ route('siswas.edit', $siswa->id) }}" class="inline-flex items-center gap-2 rounded-full bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-500 transition">Edit</a>
                                            <form action="{{ route('siswas.destroy', $siswa->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus siswa ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-2 rounded-full bg-rose-600 px-3 py-2 text-xs font-semibold text-white hover:bg-rose-500 transition">Hapus</button>
                                            </form>
                                            @if(auth()->user()->role === 'admin')
                                                <form action="{{ route('siswas.resetPassword', $siswa->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Reset password siswa ini ke default "password"?');">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center gap-2 rounded-full bg-amber-500 px-3 py-2 text-xs font-semibold text-white hover:bg-amber-400 transition">Reset Password</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-slate-500 py-10">Belum ada data siswa untuk ditampilkan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if(method_exists($siswas, 'links'))
                    <div class="mt-6 rounded-3xl border border-slate-700/60 bg-slate-950/90 px-4 py-3 text-slate-200 shadow-sm">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div class="text-sm text-slate-400">
                                Halaman {{ $siswas->currentPage() }} dari {{ $siswas->lastPage() }}
                            </div>
                            <div>{{ $siswas->links() }}</div>
                        </div>
                    </div>
                @endif
            </main>
        </div>
    </div>
</div>
@endsection