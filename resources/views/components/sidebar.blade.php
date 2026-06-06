<!-- Sidebar Navigation Component -->
@php
    $roleColors = [
        'admin' => 'bg-red-500/15 text-red-200 border-red-500/20',
        'siswa' => 'bg-blue-500/15 text-blue-200 border-blue-500/20',
        'wali_kelas' => 'bg-purple-500/15 text-purple-200 border-purple-500/20',
        'kaonsli_sij' => 'bg-indigo-500/15 text-indigo-200 border-indigo-500/20',
        'kaprog_tkj' => 'bg-emerald-500/15 text-emerald-200 border-emerald-500/20',
    ];
    $currentRoleClass = $roleColors[Auth::user()->role] ?? 'bg-slate-500/15 text-slate-200 border-slate-500/20';
@endphp

<aside class="w-full rounded-[32px] border border-slate-800/70 bg-slate-950/95 p-6 text-slate-200 shadow-2xl shadow-slate-950/40">
    <div class="mb-8">
        <div class="flex items-center gap-3">
            <div class="flex h-12 w-12 items-center justify-center rounded-3xl bg-gradient-to-br from-cyan-500 to-sky-500 text-white shadow-lg shadow-cyan-500/20">
                <i class="fas fa-bars-staggered text-lg"></i>
            </div>
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Navigasi</p>
                <h2 class="text-lg font-semibold text-white">Dashboard Menu</h2>
            </div>
        </div>
        <div class="mt-6 rounded-3xl border border-slate-800/80 bg-slate-900/90 p-4 text-sm">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-slate-400 uppercase tracking-[0.25em] text-[10px]">Role</p>
                    <p class="mt-1 font-semibold text-white">{{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}</p>
                </div>
                <span class="role-badge {{ $currentRoleClass }}">
                    <i class="fas fa-user-lock text-[0.7rem]"></i>
                    {{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}
                </span>
            </div>
        </div>
    </div>

    <nav class="space-y-3">
        @php
            $menus = \App\Services\MenuService::getMenuItems();
        @endphp

        @forelse($menus as $menu)
            @php
                $hasSubmenu = isset($menu['subMenu']) && count($menu['subMenu']) > 0;
                $menuOpen = $hasSubmenu ? \App\Services\MenuService::isMenuOpen($menu) : false;
                $menuActive = \App\Services\MenuService::isActive($menu['active'] ?? $menu['route']);
                $menuUrl = \Illuminate\Support\Facades\Route::has($menu['route']) ? route($menu['route']) : '#';
            @endphp

            @if($hasSubmenu)
                <div class="space-y-2">
                    <div class="flex items-center justify-between gap-3 rounded-3xl border border-slate-800/70 bg-slate-900/90 px-4 py-4 {{ $menuOpen ? 'border-cyan-500 bg-slate-900 shadow-inner shadow-cyan-500/10' : 'hover:border-cyan-500/40 hover:bg-slate-900' }}">
                        <a href="{{ $menuUrl }}" class="flex items-center gap-3 text-sm font-semibold {{ $menuActive ? 'text-white' : 'text-slate-100' }}">
                            <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-800 text-cyan-300 shadow-inner shadow-cyan-500/10">
                                <i class="{{ $menu['icon'] }}"></i>
                            </span>
                            <span>{{ $menu['label'] }}</span>
                        </a>
                        <button type="button" onclick="toggleSubmenu(this)" aria-expanded="{{ $menuOpen ? 'true' : 'false' }}" aria-label="Toggle submenu for {{ $menu['label'] }}" class="rounded-full border border-slate-800/70 bg-slate-900/90 p-3 text-slate-300 transition hover:border-cyan-500/40 hover:bg-slate-900">
                            <i class="fas fa-chevron-down transition-transform duration-300 {{ $menuOpen ? 'rotate-180' : '' }}"></i>
                        </button>
                    </div>
                    <div class="submenu {{ $menuOpen ? '' : 'hidden' }} space-y-1 rounded-3xl border border-slate-800/70 bg-slate-900/90 p-2">
                        @foreach($menu['subMenu'] as $sub)
                            @php
                                $subUrl = \Illuminate\Support\Facades\Route::has($sub['route']) ? route($sub['route']) : '#';
                                $subActive = \App\Services\MenuService::isActive($sub['route']);
                            @endphp
                            <a href="{{ $subUrl }}" class="flex items-center gap-3 rounded-3xl px-4 py-3 text-sm transition duration-200 {{ $subActive ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                                <i class="{{ $sub['icon'] }} w-5 text-slate-400"></i>
                                <span>{{ $sub['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                <a href="{{ $menuUrl }}" class="flex items-center gap-3 rounded-3xl border border-slate-800/70 bg-slate-900/90 px-4 py-4 text-sm font-semibold transition duration-300 {{ $menuActive ? 'border-cyan-500 bg-slate-900 shadow-inner shadow-cyan-500/10 text-white' : 'text-slate-100 hover:border-cyan-500/40 hover:bg-slate-900' }}">
                    <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-800 text-cyan-300 shadow-inner shadow-cyan-500/10">
                        <i class="{{ $menu['icon'] }}"></i>
                    </span>
                    <span>{{ $menu['label'] }}</span>
                </a>
            @endif
        @empty
            <p class="text-slate-400 text-sm">Tidak ada menu</p>
        @endforelse
    </nav>
</aside>

<script>
function toggleSubmenu(button) {
    const submenu = button.nextElementSibling;
    const icon = button.querySelector('.fa-chevron-down');

    if (!submenu) {
        return;
    }

    submenu.classList.toggle('hidden');
    icon.style.transform = submenu.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
}
</script>

<style>
.submenu {
    max-height: 260px;
    overflow-y: auto;
}
.submenu::-webkit-scrollbar {
    width: 8px;
}
.submenu::-webkit-scrollbar-thumb {
    background: rgba(148, 163, 184, 0.45);
    border-radius: 999px;
}
.submenu::-webkit-scrollbar-track {
    background: transparent;
}
</style>
