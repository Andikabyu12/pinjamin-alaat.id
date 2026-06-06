@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-slate-100 to-slate-50 py-10 relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-40 left-1/4 w-96 h-96 rounded-full bg-emerald-500/15 blur-3xl"></div>
        <div class="absolute top-1/2 -right-32 w-80 h-80 rounded-full bg-blue-500/15 blur-3xl"></div>
        <div class="absolute bottom-0 left-1/3 w-72 h-72 rounded-full bg-cyan-500/10 blur-3xl"></div>
    </div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="rounded-3xl bg-slate-950/90 p-6 shadow-lg border border-slate-800 backdrop-blur relative overflow-hidden">
            <div class="absolute inset-x-0 top-0 h-20 bg-gradient-to-r from-cyan-600/15 via-blue-500/15 to-transparent pointer-events-none"></div>
            <div class="absolute left-0 top-0 w-32 h-32 bg-gradient-to-br from-cyan-400/20 to-blue-400/10 rounded-full blur-2xl -ml-16 -mt-16"></div>
            @if(session('success'))
                <div class="mb-6 rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800 font-medium relative z-10">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6 relative z-10">
                <div>
                    <h1 class="text-3xl font-bold text-white">Daftar Peminjaman</h1>
                    @if(auth()->user()->role === 'siswa')
                        <p class="mt-2 text-slate-300">Lihat riwayat peminjaman Anda. Semua peminjaman siswa langsung disetujui tanpa persetujuan tambahan.</p>
                    @else
                        <p class="mt-2 text-slate-300">Lihat daftar peminjaman alat. Admin dapat menandai pengembalian untuk peminjaman yang sudah selesai.</p>
                    @endif
                </div>
                @if(auth()->user()->role === 'siswa')
                    <a href="{{ route('peminjaman.create') }}" class="inline-flex items-center rounded-full bg-gradient-to-r from-cyan-600 to-blue-700 px-5 py-3 text-sm font-semibold text-white shadow-lg transition hover:shadow-xl">Pinjam Alat</a>
                @endif
            </div>

            <form action="{{ route('peminjaman.index') }}" method="GET" class="mb-6">
                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <label for="q" class="sr-only">Cari peminjaman</label>
                    <div class="flex-1 min-w-0">
                        <input id="q" name="q" type="text" value="{{ old('q', $search ?? '') }}" placeholder="Cari alat, peminjam, status, atau nomor..." class="w-full rounded-full border border-slate-700 bg-slate-900/90 px-4 py-3 text-sm text-slate-100 shadow-sm placeholder:text-slate-500 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20" />
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <button type="submit" class="inline-flex items-center justify-center rounded-full bg-gradient-to-r from-cyan-600 to-blue-700 px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:shadow-xl">
                            <i class="fas fa-search mr-2"></i>Cari
                        </button>
                        @if(!empty($search))
                            <a href="{{ route('peminjaman.index') }}" class="inline-flex items-center justify-center rounded-full border border-slate-700 bg-slate-800 px-6 py-3 text-sm font-semibold text-slate-200 transition hover:bg-slate-700">
                                Reset
                            </a>
                        @endif
                    </div>
                </div>
            </form>

            <div class="mb-6 flex flex-wrap items-center gap-3">
                @php
                    $counts = $counts ?? collect();
                    $majorFilter = $majorFilter ?? '';
                @endphp
                @if(auth()->user()->role === 'siswa')
                    <span class="inline-flex items-center rounded-full bg-blue-600 px-4 py-2 text-sm font-semibold text-white">
                        Peminjaman Saya <span class="ml-2 inline-block rounded-full bg-slate-700 px-2 py-0.5 text-xs text-slate-200">{{ $counts->sum() ?? 0 }}</span>
                    </span>
                @else
                    <a href="{{ route('peminjaman.index') }}" class="px-4 py-2 rounded-full text-sm font-semibold {{ $majorFilter === '' ? 'bg-blue-600 text-white' : 'bg-slate-800 text-slate-200' }}">Semua <span class="ml-2 text-xs inline-block bg-slate-700 px-2 py-0.5 rounded">{{ $counts->sum() ?? 0 }}</span></a>
                    <a href="{{ route('peminjaman.index', array_merge(request()->query(), ['major' => 'tkj'])) }}" class="px-4 py-2 rounded-full text-sm font-semibold {{ $majorFilter === 'tkj' ? 'bg-cyan-600 text-white' : 'bg-slate-800 text-slate-200' }}">TKJ <span class="ml-2 text-xs inline-block bg-slate-700 px-2 py-0.5 rounded">{{ $counts['tkj'] ?? 0 }}</span></a>
                    <a href="{{ route('peminjaman.index', array_merge(request()->query(), ['major' => 'sija'])) }}" class="px-4 py-2 rounded-full text-sm font-semibold {{ $majorFilter === 'sija' ? 'bg-cyan-600 text-white' : 'bg-slate-800 text-slate-200' }}">SIJA <span class="ml-2 text-xs inline-block bg-slate-700 px-2 py-0.5 rounded">{{ $counts['sija'] ?? 0 }}</span></a>
                @endif
            </div>

            @if($peminjamans->isEmpty())
                <div class="rounded-3xl border border-slate-800 bg-slate-900/80 p-10 text-center">
                    <div class="flex flex-col items-center justify-center gap-3">
                        <svg class="w-12 h-12 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-slate-200 text-lg font-semibold">Belum ada data peminjaman</p>
                        <p class="text-sm text-slate-400">Mulai dengan mengajukan permintaan peminjaman alat.</p>
                    </div>
                </div>
            @else
                <div class="hidden md:block overflow-hidden rounded-3xl border border-slate-800 bg-slate-900/80">
                    <table class="min-w-full divide-y divide-slate-800 text-sm">
                        <thead class="bg-slate-950 text-slate-200">
                            <tr>
                                <th class="px-4 py-4 text-left font-semibold">#</th>
                                <th class="px-4 py-4 text-left font-semibold">Peminjam</th>
                                <th class="px-4 py-4 text-left font-semibold">Alat</th>
                                <th class="px-4 py-4 text-center font-semibold">Jumlah</th>
                                <th class="px-4 py-4 text-left font-semibold">Kembali</th>
                                <th class="px-4 py-4 text-left font-semibold">Status</th>
                                <th class="px-4 py-4 text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800 bg-slate-950">
                            @foreach($peminjamans as $peminjaman)
                                @php
                                    $overdue = method_exists($peminjaman, 'isOverdue') && $peminjaman->isOverdue();
                                    if ($overdue) {
                                        $statusClass = 'bg-rose-500 text-white';
                                        $statusLabel = '⚠ Terlambat';
                                    } else {
                                        $statusClass = match($peminjaman->status) {
                                            'approved' => 'bg-emerald-500 text-white',
                                            'returned' => 'bg-slate-600 text-slate-100',
                                            'pending' => 'bg-amber-500 text-slate-950',
                                            default => 'bg-slate-700 text-slate-100',
                                        };
                                        $statusLabel = match($peminjaman->status) {
                                            'approved' => '✓ Disetujui',
                                            'returned' => '↩ Dikembalikan',
                                            'pending' => '⏱ Menunggu',
                                            default => ucfirst($peminjaman->status),
                                        };
                                    }
                                @endphp
                                <tr class="hover:bg-slate-900/70 transition">
                                    <td class="px-4 py-4 text-slate-300 font-medium">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-4 text-slate-100">
                                        <div class="font-semibold">{{ $peminjaman->user?->name ?? 'User tidak ditemukan' }}</div>
                                        <div class="mt-1 text-xs text-slate-400">
                                            {{ $peminjaman->user?->nis ?? '-' }} · {{ $peminjaman->user?->kelas ?? '-' }}
                                        </div>
                                        <div class="mt-1 text-xs text-slate-500">{{ $peminjaman->user?->email ?? '-' }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-slate-100">
                                        <div class="font-semibold">{{ $peminjaman->alat?->nama_alat ?? '-' }}</div>
                                        <div class="mt-1 text-xs text-slate-400">{{ $peminjaman->alat?->kode_alat_text ?? 'Alat tidak ditemukan' }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-center font-semibold text-cyan-300">{{ $peminjaman->qty }}</td>
                                    <td class="px-4 py-4 text-slate-300">
                                        {{ $peminjaman->return_date ? \Carbon\Carbon::parse($peminjaman->return_date)->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <div class="flex flex-wrap justify-center gap-2">
                                            <a href="{{ route('peminjaman.show', $peminjaman->id) }}" class="rounded-full bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700 transition whitespace-nowrap">👁 Detail</a>
                                            @if($peminjaman->status === 'pending' && auth()->user()->role === 'admin')
                                                <form action="{{ route('peminjaman.approve', $peminjaman->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="rounded-full bg-emerald-600 px-3 py-2 text-xs font-semibold text-white hover:bg-emerald-700 transition whitespace-nowrap">✓ Setujui</button>
                                                </form>
                                            @elseif($peminjaman->status === 'approved' && (
                                                (auth()->user()->role === 'siswa' && $peminjaman->user_id === auth()->id()) ||
                                                in_array(auth()->user()->role, ['admin', 'kaonsli_sij', 'kaprog_tkj'])
                                            ))
                                                <a href="{{ route('peminjaman.return.form', $peminjaman->id) }}" class="inline-flex rounded-full bg-slate-600 px-3 py-2 text-xs font-semibold text-white hover:bg-slate-700 transition whitespace-nowrap">↩ Kembalikan</a>
                                            @else
                                                <span class="text-slate-400 text-xs">-</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="space-y-4 md:hidden">
                    @foreach($peminjamans as $peminjaman)
                        @php
                            $overdue = method_exists($peminjaman, 'isOverdue') && $peminjaman->isOverdue();
                            if ($overdue) {
                                $statusClass = 'bg-rose-500 text-white';
                                $statusLabel = '⚠ Terlambat';
                            } else {
                                $statusClass = match($peminjaman->status) {
                                    'approved' => 'bg-emerald-500 text-white',
                                    'returned' => 'bg-slate-600 text-slate-100',
                                    'pending' => 'bg-amber-500 text-slate-950',
                                    default => 'bg-slate-700 text-slate-100',
                                };
                                $statusLabel = match($peminjaman->status) {
                                    'approved' => '✓ Disetujui',
                                    'returned' => '↩ Dikembalikan',
                                    'pending' => '⏱ Menunggu',
                                    default => ucfirst($peminjaman->status),
                                };
                            }
                        @endphp
                        <article class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900/80 p-5 shadow-sm">
                            <div class="flex items-start justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Peminjaman #{{ $loop->iteration }}</p>
                                    <h3 class="mt-2 text-lg font-semibold text-white">{{ $peminjaman->alat?->nama_alat ?? '-' }}</h3>
                                    <p class="mt-1 text-sm text-slate-400">{{ $peminjaman->alat?->kode_alat_text ?? 'Alat tidak ditemukan' }}</p>
                                </div>
                                <span class="rounded-full px-3 py-1 text-sm font-semibold {{ $statusClass }}">{{ $statusLabel }}</span>
                            </div>
                            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                                <div>
                                    <p class="text-xs text-slate-500">Peminjam</p>
                                    <p class="mt-1 font-medium text-slate-100">{{ $peminjaman->user?->name ?? 'User tidak ditemukan' }}</p>
                                    <p class="text-xs text-slate-400">{{ $peminjaman->user?->nis ?? '-' }} · {{ $peminjaman->user?->kelas ?? '-' }}</p>
                                    <p class="text-xs text-slate-500">{{ $peminjaman->user?->email ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500">Detail</p>
                                    <p class="mt-1 text-slate-100"><span class="font-semibold">Jumlah:</span> {{ $peminjaman->qty }}</p>
                                    <p class="mt-1 text-slate-100"><span class="font-semibold">Kembali:</span> {{ $peminjaman->return_date ? \Carbon\Carbon::parse($peminjaman->return_date)->format('d M Y') : '-' }}</p>
                                </div>
                            </div>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <a href="{{ route('peminjaman.show', $peminjaman->id) }}" class="rounded-full bg-blue-600 px-4 py-2 text-xs font-semibold text-white hover:bg-blue-700 transition">👁 Detail</a>
                                @if($peminjaman->status === 'pending' && auth()->user()->role === 'admin')
                                    <form action="{{ route('peminjaman.approve', $peminjaman->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="rounded-full bg-emerald-600 px-4 py-2 text-xs font-semibold text-white hover:bg-emerald-700 transition">✓ Setujui</button>
                                    </form>
                                @elseif($peminjaman->status === 'approved' && (
                                    (auth()->user()->role === 'siswa' && $peminjaman->user_id === auth()->id()) ||
                                    in_array(auth()->user()->role, ['admin', 'kaonsli_sij', 'kaprog_tkj'])
                                ))
                                    <a href="{{ route('peminjaman.return.form', $peminjaman->id) }}" class="rounded-full bg-slate-600 px-4 py-2 text-xs font-semibold text-white hover:bg-slate-700 transition">↩ Kembalikan</a>
                                @else
                                    <span class="text-slate-400 text-xs">Tidak ada aksi</span>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
