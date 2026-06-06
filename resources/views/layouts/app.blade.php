
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Peminjaman Alat TI')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Scroll Progress Bar -->
    <style>
        .scroll-progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, #38bdf8, #818cf8);
            width: 0%;
            z-index: 999;
            transition: width 0.2s ease;
            box-shadow: 0 0 10px rgba(56, 189, 248, 0.6);
        }
    </style>
    <script>
        (function() {
            try {
                const savedTheme = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const nextTheme = savedTheme || (prefersDark ? 'dark' : 'light');
                document.documentElement.classList.remove('theme-light', 'theme-dark');
                document.documentElement.classList.add(nextTheme === 'light' ? 'theme-light' : 'theme-dark');
            } catch (error) {
                console.warn('Theme initialization failed', error);
            }
        })();
    </script>
</head>
<body class="@auth role-{{ str_replace('_', '-', Auth::user()->role) }} @endauth">
    <!-- Scroll Progress Bar -->
    <div class="scroll-progress-bar" id="scrollProgressBar"></div>

    <div class="app-bg-decor" aria-hidden="true">
        <div class="app-glow-sphere app-glow-sphere--1"></div>
        <div class="app-glow-sphere app-glow-sphere--2"></div>
    </div>

    <div class="content-wrapper">
        <header class="relative z-20">
            <div class="w-full px-6 py-5">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-3 rounded-3xl border border-orange-200/80 bg-slate-950/90 px-4 py-3 text-slate-100 shadow-lg shadow-slate-950/40 transition hover:bg-slate-900">
                        <div class="flex h-11 w-11 items-center justify-center rounded-3xl bg-gradient-to-br from-orange-300 to-pink-400 text-slate-900 shadow-xl shadow-orange-300/30">
                            <i class="fas fa-laptop-code"></i>
                        </div>
                        <div>
                            <div class="text-sm font-semibold leading-none">SMKN 6 Malang</div>
                            <div class="text-xs text-slate-500">Peminjaman Alat TI</div>
                        </div>
                    </a>

                    @php
                        $dashboardActive = Request::routeIs('dashboard') || Request::routeIs('admin.*') || Request::routeIs('wali_kelas.*') || Request::routeIs('kaonsli_sij.*') || Request::routeIs('kaprog_tkj.*');
                    @endphp
                    <div class="hidden items-center gap-4 md:flex">
                        <a href="{{ route('home') }}" class="nav-link {{ Request::routeIs('home') ? 'active' : '' }} text-sm font-semibold text-slate-700">Beranda</a>
                        @auth
                        <a href="{{ route('dashboard') }}" class="nav-link {{ $dashboardActive ? 'active' : '' }} text-sm font-semibold text-slate-700">Dashboard</a>
                        @endauth
                        <a href="{{ route('home.developers') }}" class="nav-link {{ Request::routeIs('home.developers') ? 'active' : '' }} text-sm font-semibold text-slate-700">Pengembang</a>
                    </div>

                    <div class="items-center gap-3 flex">
                        @auth
                        <div class="relative">
                            <button id="notificationToggle" type="button" aria-expanded="false" aria-controls="notificationMenu" class="relative inline-flex items-center gap-2 rounded-full border border-slate-700/70 bg-slate-950/80 px-4 py-3 text-slate-100 shadow-lg shadow-slate-950/40 transition hover:bg-slate-900">
                                <i class="fas fa-bell"></i>
                                <span class="hidden sm:inline">Notifikasi</span>
                                @if(($notificationCount ?? 0) > 0)
                                    <span class="absolute -right-1 -top-1 inline-flex h-5 min-w-[20px] items-center justify-center rounded-full bg-rose-500 px-1.5 text-[10px] font-bold text-white">{{ $notificationCount }}</span>
                                @endif
                            </button>

                            <div id="notificationMenu" class="hidden absolute right-0 z-50 mt-3 w-80 rounded-3xl border border-slate-200/20 bg-white/95 p-4 shadow-2xl shadow-slate-950/15 backdrop-blur-xl">
                                <div class="mb-4 flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900">Notifikasi</p>
                                        <p class="text-xs text-slate-500">{{ $notificationCount ?? 0 }} item baru</p>
                                    </div>
                                    <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">Segarkan</span>
                                </div>
                                @if(!empty($notificationItems) && count($notificationItems) > 0)
                                    <ul class="space-y-3">
                                        @foreach($notificationItems as $item)
                                            @if(!empty($item['action']))
                                                <a href="{{ $item['action'] }}" class="block rounded-3xl border border-slate-200/80 bg-slate-50 p-3 transition hover:border-cyan-300/60 hover:bg-cyan-50">
                                                    <div class="flex items-start justify-between gap-3">
                                                        <div>
                                                            <p class="text-sm font-semibold text-slate-900">{{ $item['title'] }}</p>
                                                            <p class="mt-1 text-xs text-slate-500">{{ $item['message'] }}</p>
                                                        </div>
                                                        @if(!empty($item['type']))
                                                            <span class="inline-flex items-center rounded-full px-2 py-1 text-[10px] font-semibold {{ $item['type'] === 'warning' ? 'bg-orange-500 text-white' : 'bg-cyan-500 text-white' }}">{{ ucfirst($item['type']) }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mt-3 flex items-center gap-2 text-xs font-semibold text-slate-700 hover:text-slate-900">
                                                        <span>Lihat detail</span>
                                                        <i class="fas fa-arrow-right"></i>
                                                    </div>
                                                </a>
                                            @else
                                                <li class="rounded-3xl border border-slate-200/80 bg-slate-50 p-3">
                                                    <div class="flex items-start justify-between gap-3">
                                                        <div>
                                                            <p class="text-sm font-semibold text-slate-900">{{ $item['title'] }}</p>
                                                            <p class="mt-1 text-xs text-slate-500">{{ $item['message'] }}</p>
                                                        </div>
                                                        @if(!empty($item['type']))
                                                            <span class="inline-flex items-center rounded-full px-2 py-1 text-[10px] font-semibold {{ $item['type'] === 'warning' ? 'bg-orange-500 text-white' : 'bg-cyan-500 text-white' }}">{{ ucfirst($item['type']) }}</span>
                                                        @endif
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-sm text-slate-500">Tidak ada notifikasi saat ini.</p>
                                @endif
                            </div>
                        </div>
                        @endauth

                        <button id="themeToggle" type="button" data-theme-toggle class="btn-toggle rounded-full border border-slate-700/70 bg-slate-950/80 px-4 py-3 text-slate-100 shadow-lg shadow-slate-950/40 transition hover:bg-slate-900">
                            <i id="themeToggleIcon" class="fas fa-moon"></i>
                            <span id="themeToggleLabel" class="hidden sm:inline">Gelap</span>
                        </button>
                    </div>

                    <button type="button" onclick="toggleMobileMenu()" class="inline-flex h-11 w-11 items-center justify-center rounded-3xl border border-slate-700/70 bg-slate-950/80 text-slate-200 shadow-lg shadow-slate-950/40 transition hover:bg-slate-900 md:hidden">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
                <div id="mobileMenu" class="hidden mt-4 space-y-3 rounded-3xl border border-orange-200/70 bg-white/95 p-4 shadow-xl md:hidden">
                    <a href="{{ route('home') }}" class="block rounded-2xl px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">Beranda</a>
                    @auth
                    <a href="{{ route('dashboard') }}" class="block rounded-2xl px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">Dashboard</a>
                    @endauth
                    <a href="{{ route('home.developers') }}" class="block rounded-2xl px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">Pengembang</a>
                    @auth
                    <a href="{{ route('dashboard') }}" class="block rounded-2xl px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">Notifikasi @if(($notificationCount ?? 0) > 0) ({{ $notificationCount }}) @endif</a>
                    @endauth
                    @guest
                    <a href="{{ route('login') }}" class="block rounded-2xl bg-orange-100 px-4 py-3 text-sm font-semibold text-orange-700 hover:bg-orange-200">Masuk</a>
                    <a href="{{ route('register') }}" class="block rounded-2xl bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-200">Daftar</a>
                    @endguest
                    <button type="button" data-theme-toggle class="w-full rounded-2xl border border-orange-200 bg-orange-100 px-4 py-3 text-sm font-semibold text-orange-700 hover:bg-orange-200">Gelap/Terang</button>
                    @auth
                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="w-full rounded-2xl bg-red-100 px-4 py-3 text-sm font-semibold text-red-700 hover:bg-red-200">Keluar</button>
                    </form>
                    @endauth
                </div>
            </div>
        </header>

        @if(session('success') || session('error'))
            <div class="w-full px-6 py-4">
                <div class="{{ session('success') ? 'alert-success' : 'alert-error' }} rounded-3xl">
                    {{ session('success') ?? session('error') }}
                </div>
            </div>
        @endif

        <main class="min-h-screen px-6 py-8 page-shell">
            @php
                $dashboardWithSidebar = auth()->check() && (
                    Request::routeIs('dashboard') ||
                    Request::routeIs('admin.*') ||
                    Request::routeIs('alats.*') ||
                    Request::routeIs('siswas.*') ||
                    Request::routeIs('peminjaman.*') ||
                    Request::routeIs('wali_kelas.*') ||
                    Request::routeIs('kaonsli_sij.*') ||
                    Request::routeIs('kaprog_tkj.*')
                );
            @endphp

            @if($dashboardWithSidebar)
                <div class="grid w-full gap-6 lg:grid-cols-[320px_1fr]">
                    @include('components.sidebar')
                    <div class="w-full">
                        @yield('content')
                    </div>
                </div>
            @else
                <div class="w-full">
                    @yield('content')
                </div>
            @endif
        </main>
    </div>

    <footer class="relative z-10 border-t border-orange-100 bg-white/90 px-6 py-8 backdrop-blur-lg shadow-inner shadow-orange-100/50">
        <div class="w-full">
            <div class="flex flex-col gap-8 lg:flex-row lg:items-start lg:justify-between">
                <!-- Footer Info -->
                <div class="flex-1">
                    <div class="mb-2 inline-block rounded-lg border border-orange-200/60 bg-orange-100 px-3 py-1.5 text-xs font-semibold text-orange-700 uppercase tracking-wider">Kelompok 8</div>
                    <p class="mt-3 text-sm font-medium text-slate-700">© {{ date('Y') }} Peminjaman Alat TI SMKN 6 Malang.</p>
                    <p class="mt-2 text-xs text-slate-500">Sistem manajemen peminjaman alat teknologi informasi yang cepat, rapi, dan responsif.</p>
                </div>

                <!-- Quick Access Cards -->
                <div class="flex flex-col gap-3 sm:flex-row sm:gap-4 lg:flex-col lg:gap-3">
                    <!-- Quick Access to Home -->
                    <a href="{{ route('home') }}" class="group relative inline-flex items-center gap-2 rounded-lg border border-cyan-400/30 bg-gradient-to-r from-cyan-500/15 to-blue-500/10 px-4 py-2.5 text-sm font-semibold text-cyan-300 transition-all duration-300 hover:border-cyan-400/60 hover:bg-gradient-to-r hover:from-cyan-500/30 hover:to-blue-500/20 hover:shadow-lg hover:shadow-cyan-500/30 active:scale-95">
                        <i class="fas fa-home text-cyan-400"></i>
                        <span>Beranda</span>
                        <span class="absolute -right-2 -top-2 inline-flex h-5 w-5 items-center justify-center rounded-full bg-cyan-400 text-xs font-bold text-cyan-950 opacity-0 transition-opacity duration-300 group-hover:opacity-100">â†’</span>
                    </a>

                    <!-- Quick Access to Dashboard -->
                    @auth
                    <a href="{{ route('dashboard') }}" class="group relative inline-flex items-center gap-2 rounded-lg border border-purple-400/30 bg-gradient-to-r from-purple-500/15 to-pink-500/10 px-4 py-2.5 text-sm font-semibold text-purple-300 transition-all duration-300 hover:border-purple-400/60 hover:bg-gradient-to-r hover:from-purple-500/30 hover:to-pink-500/20 hover:shadow-lg hover:shadow-purple-500/30 active:scale-95">
                        <i class="fas fa-chart-line text-purple-400"></i>
                        <span>Dashboard</span>
                        <span class="absolute -right-2 -top-2 inline-flex h-5 w-5 items-center justify-center rounded-full bg-purple-400 text-xs font-bold text-purple-950 opacity-0 transition-opacity duration-300 group-hover:opacity-100">â†’</span>
                    </a>
                    @endauth
                    <a href="{{ route('home.developers') }}" class="group relative inline-flex items-center gap-2 rounded-lg border border-emerald-400/30 bg-gradient-to-r from-emerald-500/15 to-teal-500/10 px-4 py-2.5 text-sm font-semibold text-emerald-300 transition-all duration-300 hover:border-emerald-400/60 hover:bg-gradient-to-r hover:from-emerald-500/30 hover:to-teal-500/20 hover:shadow-lg hover:shadow-emerald-500/30 active:scale-95">
                        <i class="fas fa-users text-emerald-400"></i>
                        <span>Pengembang</span>
                        <span class="absolute -right-2 -top-2 inline-flex h-5 w-5 items-center justify-center rounded-full bg-emerald-400 text-xs font-bold text-emerald-950 opacity-0 transition-opacity duration-300 group-hover:opacity-100">â†’</span>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Interactive Effects Script -->
    <script src="{{ asset('js/interactive.js') }}"></script>

    <script>
        // Scroll progress bar
        window.addEventListener('scroll', () => {
            const scrollHeight = document.documentElement.scrollHeight - window.innerHeight;
            const scrolled = (window.scrollY / scrollHeight) * 100;
            const progressBar = document.getElementById('scrollProgressBar');
            if (progressBar) {
                progressBar.style.width = scrolled + '%';
            }
        });

        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('hidden');
        }

        (function() {
            const notificationToggle = document.getElementById('notificationToggle');
            const notificationMenu = document.getElementById('notificationMenu');
            if (notificationToggle && notificationMenu) {
                const setAria = (open) => {
                    notificationToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                };

                notificationToggle.addEventListener('click', function(event) {
                    event.stopPropagation();
                    notificationMenu.classList.toggle('hidden');
                    setAria(!notificationMenu.classList.contains('hidden'));
                });

                notificationMenu.addEventListener('click', function(event) {
                    event.stopPropagation();
                });

                document.addEventListener('click', function(event) {
                    if (!notificationToggle.contains(event.target) && !notificationMenu.contains(event.target)) {
                        if (!notificationMenu.classList.contains('hidden')) {
                            notificationMenu.classList.add('hidden');
                            setAria(false);
                        }
                    }
                });
            }
        })();

        document.addEventListener('click', function(event) {
            const button = event.target.closest('button');
            const mobileMenu = document.getElementById('mobileMenu');
            if (!mobileMenu || !button) return;
            if (!button.closest('header')) {
                return;
            }
        });

        (function() {
            const backLink = document.querySelector('[data-back-fallback]');
            if (!backLink) return;
            const fallbackUrl = backLink.getAttribute('data-back-fallback');
            if (!fallbackUrl) return;

            try {
                const referrer = document.referrer;
                if (!referrer) return;
                const referrerUrl = new URL(referrer);
                if (referrerUrl.origin !== window.location.origin) {
                    window.history.pushState({ appBackIntercept: true }, '', window.location.href);
                    window.addEventListener('popstate', function(event) {
                        if (event.state && event.state.appBackIntercept) {
                            window.location.href = fallbackUrl;
                        }
                    });
                }
            } catch (error) {
                // ignore invalid referrer values
            }
        })();

        function applyTheme(theme) {
            const root = document.documentElement;
            const icon = document.getElementById('themeToggleIcon');
            const label = document.getElementById('themeToggleLabel');

            root.classList.remove('theme-light', 'theme-dark');
            root.classList.add(theme === 'light' ? 'theme-light' : 'theme-dark');

            if (icon) {
                icon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
            }
            if (label) {
                label.textContent = theme === 'dark' ? 'Terang' : 'Gelap';
            }
            localStorage.setItem('theme', theme);
        }

        function toggleTheme() {
            const root = document.documentElement;
            const nextTheme = root.classList.contains('theme-dark') ? 'light' : 'dark';
            applyTheme(nextTheme);
        }

        (function() {
            const savedTheme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            applyTheme(savedTheme || (prefersDark ? 'dark' : 'light'));

            const themeToggleButtons = document.querySelectorAll('[data-theme-toggle]');
            themeToggleButtons.forEach((button) => {
                button.addEventListener('click', toggleTheme);
            });
        })();
    </script>

    @stack('scripts')
</body>
</html>

