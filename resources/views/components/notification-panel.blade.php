<div class="rounded-3xl border border-slate-700/50 bg-slate-950/80 p-6 shadow-2xl glass-panel">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-cyan-300">Notifikasi</p>
            <h2 class="mt-2 text-2xl font-bold text-white">Aktivitas Terbaru</h2>
        </div>
        <span class="inline-flex items-center gap-2 rounded-full border border-slate-700/50 bg-slate-800/80 px-4 py-2 text-sm text-slate-200">
            <i class="fas fa-bell"></i> {{ $notificationCount ?? 0 }} notifikasi
        </span>
    </div>

    @if(!empty($notificationItems) && count($notificationItems) > 0)
        <div class="mt-6 space-y-4">
            @foreach($notificationItems as $item)
                <div class="rounded-3xl border border-slate-800/70 bg-slate-900/90 p-4">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <p class="font-semibold text-white">{{ $item['title'] }}</p>
                            <p class="mt-1 text-sm text-slate-400">{{ $item['message'] }}</p>
                        </div>
                        @if(!empty($item['type']))
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $item['type'] === 'warning' ? 'bg-orange-500/15 text-orange-200' : 'bg-cyan-500/15 text-cyan-200' }}">
                                {{ ucfirst($item['type']) }}
                            </span>
                        @endif
                    </div>

                    @if(!empty($item['action']))
                        <a href="{{ $item['action'] }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-slate-200 hover:text-white">
                            Lihat detail <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <p class="mt-6 text-sm text-slate-400">Semua aktivitas sudah terpantau, tidak ada notifikasi baru.</p>
    @endif
</div>
