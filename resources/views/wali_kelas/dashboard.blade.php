@extends('layouts.app')

@section('title', 'Dashboard Wali Kelas')

@section('content')
<div class="min-h-screen py-10 relative overflow-hidden">
    <div class="container mx-auto px-4 lg:px-8 relative z-10 max-w-7xl">
        <!-- Header -->
        <div class="mb-10 rounded-3xl panel-card p-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.28em] text-cyan-300">Dashboard Wali Kelas</p>
                    <h1 class="mt-4 text-4xl sm:text-5xl font-bold text-white">Halo, {{ Auth::user()->name }}</h1>
                    <p class="mt-3 text-slate-300">Jurusan: <span class="font-semibold text-white">{{ $major }}</span> @if(!empty($kelas)) | Kelas: <span class="font-semibold text-white">{{ $kelas }}</span>@endif</p>
                    <p class="mt-2 text-slate-400 max-w-2xl">Pantau siswa, peminjaman, dan status kelas Anda dengan tampilan yang bersih dan profesional.</p>
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

        <!-- Statistics -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4 mb-10">
            <div class="rounded-3xl bg-slate-950/85 border border-slate-700/50 p-6 shadow-2xl glass-panel">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.24em] font-semibold text-cyan-300">Siswa</p>
                        <p class="mt-4 text-4xl font-extrabold text-white">{{ $siswaCount }}</p>
                        <p class="mt-2 text-sm text-slate-400">Siswa terdaftar</p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-3xl bg-cyan-500/15 text-cyan-300 border border-cyan-500/20">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                </div>
                <div class="mt-6 rounded-3xl bg-slate-900/70 border border-cyan-500/10 p-4">
                    <p class="text-sm text-slate-400">Jurusan / Kelas</p>
                    <p class="mt-1 text-sm text-white">{{ $major }}{{ !empty($kelas) ? ' • Kelas ' . $kelas : '' }}</p>
                </div>
            </div>

            <div class="rounded-3xl bg-slate-950/85 border border-slate-700/50 p-6 shadow-2xl glass-panel">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.24em] font-semibold text-emerald-300">Peminjaman</p>
                        <p class="mt-4 text-4xl font-extrabold text-white">{{ $peminjamanCount }}</p>
                        <p class="mt-2 text-sm text-slate-400">Total tercatat</p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-3xl bg-emerald-500/15 text-emerald-300 border border-emerald-500/20">
                        <i class="fas fa-hand-holding-box text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl bg-slate-950/85 border border-slate-700/50 p-6 shadow-2xl glass-panel">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.24em] font-semibold text-amber-300">Menunggu</p>
                        <p class="mt-4 text-4xl font-extrabold text-white">{{ $peminjamanPending }}</p>
                        <p class="mt-2 text-sm text-slate-400">Perlu perhatian</p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-3xl bg-amber-500/15 text-amber-300 border border-amber-500/20">
                        <i class="fas fa-hourglass-end text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl bg-slate-950/85 border border-slate-700/50 p-6 shadow-2xl glass-panel">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.24em] font-semibold text-rose-300">Disetujui</p>
                        <p class="mt-4 text-4xl font-extrabold text-white">{{ $peminjamanApproved }}</p>
                        <p class="mt-2 text-sm text-slate-400">Peminjaman aktif</p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-3xl bg-rose-500/15 text-rose-300 border border-rose-500/20">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="chart-panel p-6 mb-10">
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.24em] text-slate-400">Grafik Peminjaman</p>
                    <h2 class="text-2xl font-bold text-white">Status Peminjaman Kelas</h2>
                    <p class="mt-2 text-sm text-slate-400">Grafik menampilkan data pinjam dan kembalikan selama 12 bulan terakhir.</p>
                </div>
                <span class="inline-flex items-center rounded-full border border-cyan-400/20 bg-cyan-500/10 px-4 py-2 text-sm text-cyan-100">Total: {{ $peminjamanCount }}</span>
            </div>
            <div class="grid gap-3 sm:grid-cols-3 mb-6">
                @foreach([
                    'Disetujui' => ['value' => $peminjamanApproved, 'color' => 'bg-emerald-500/15 text-emerald-200 border-emerald-500/20'],
                    'Menunggu' => ['value' => $peminjamanPending, 'color' => 'bg-amber-500/15 text-amber-200 border-amber-500/20'],
                    'Dikembalikan' => ['value' => $peminjamanReturned ?? 0, 'color' => 'bg-sky-500/15 text-sky-200 border-sky-500/20'],
                ] as $label => $meta)
                    <div class="badge-chip {{ $meta['color'] }}">
                        <span class="font-semibold">{{ $label }}</span>
                        <strong>{{ $meta['value'] }}</strong>
                    </div>
                @endforeach
            </div>
            <div class="rounded-3xl border border-slate-700/40 bg-slate-950/85 p-4">
                <canvas id="monthlyChart" class="w-full h-72"></canvas>
            </div>
            <div class="mt-8 space-y-4">
                @foreach([
                    'Disetujui' => ['value' => $peminjamanApproved, 'color' => 'bg-emerald-500'],
                    'Menunggu' => ['value' => $peminjamanPending, 'color' => 'bg-amber-500'],
                    'Dikembalikan' => ['value' => $peminjamanReturned ?? 0, 'color' => 'bg-sky-500'],
                ] as $label => $meta)
                    @php
                        $percent = $peminjamanCount > 0 ? min(100, round($meta['value'] / $peminjamanCount * 100)) : 0;
                    @endphp
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-sm text-slate-300">
                            <span>{{ $label }}</span>
                            <span class="font-semibold text-white">{{ $meta['value'] }}</span>
                        </div>
                        <div class="h-3 rounded-full bg-slate-800 overflow-hidden">
                            <div class="h-full {{ $meta['color'] }} rounded-full" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Menu -->
        <div>
            <h2 class="text-2xl font-bold text-slate-100 mb-6">Menu Utama</h2>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                <a href="{{ route('wali_kelas.siswa') }}" class="group rounded-3xl bg-slate-950/85 border border-slate-700/50 p-6 text-white transition hover:shadow-2xl hover:scale-105 glass-panel">
                    <div class="text-3xl mb-4 text-cyan-300"><i class="fas fa-list-ul"></i></div>
                    <h3 class="text-lg font-bold mb-1">Daftar Siswa</h3>
                    <p class="text-slate-400 text-sm">Lihat semua siswa</p>
                </a>

                <a href="{{ route('wali_kelas.search-siswa') }}" class="group rounded-3xl bg-slate-950/85 border border-slate-700/50 p-6 text-white transition hover:shadow-2xl hover:scale-105 glass-panel">
                    <div class="text-3xl mb-4 text-purple-300"><i class="fas fa-magnifying-glass"></i></div>
                    <h3 class="text-lg font-bold mb-1">Cari Siswa</h3>
                    <p class="text-slate-400 text-sm">Temukan siswa</p>
                </a>

                <a href="{{ route('wali_kelas.peminjaman') }}" class="group rounded-3xl bg-slate-950/85 border border-slate-700/50 p-6 text-white transition hover:shadow-2xl hover:scale-105 glass-panel">
                    <div class="text-3xl mb-4 text-emerald-300"><i class="fas fa-boxes"></i></div>
                    <h3 class="text-lg font-bold mb-1">Peminjaman</h3>
                    <p class="text-slate-400 text-sm">Pantau peminjaman</p>
                </a>

                <a href="{{ route('wali_kelas.search-peminjaman') }}" class="group rounded-3xl bg-slate-950/85 border border-slate-700/50 p-6 text-white transition hover:shadow-2xl hover:scale-105 glass-panel">
                    <div class="text-3xl mb-4 text-orange-300"><i class="fas fa-search"></i></div>
                    <h3 class="text-lg font-bold mb-1">Cari Peminjaman</h3>
                    <p class="text-slate-400 text-sm">Temukan peminjaman</p>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
        <script>
            (function(){
                const labels = @json($months ?? []);
                const borrowData = @json($borrowData ?? []);
                const returnData = @json($returnData ?? []);

                const ctx = document.getElementById('monthlyChart');
                if (!ctx) return;

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Dipinjam',
                                data: borrowData,
                                borderColor: 'rgba(56, 189, 248, 1)',
                                backgroundColor: 'rgba(56, 189, 248, 0.12)',
                                tension: 0.3,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                fill: true,
                            },
                            {
                                label: 'Dikembalikan',
                                data: returnData,
                                borderColor: 'rgba(52, 211, 153, 1)',
                                backgroundColor: 'rgba(52, 211, 153, 0.12)',
                                tension: 0.3,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                fill: true,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { labels: { color: '#cbd5e1' } },
                            tooltip: { mode: 'index', intersect: false }
                        },
                        scales: {
                            x: { ticks: { color: '#94a3b8' }, grid: { color: 'rgba(148,163,184,0.06)' } },
                            y: { beginAtZero: true, ticks: { color: '#94a3b8' }, grid: { color: 'rgba(148,163,184,0.06)' } }
                        }
                    }
                });
            })();
        </script>
    @endpush
