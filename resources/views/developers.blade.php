@extends('layouts.app')

@section('title', 'Menu Pengembang - Peminjaman Alat TI')

@section('content')
<div class="min-h-screen bg-slate-950/90 py-10">
    <div class="mx-auto flex max-w-7xl flex-col gap-8 px-4 lg:flex-row lg:px-8">
        <aside class="w-full rounded-[32px] border border-white/10 bg-slate-900/80 p-6 shadow-2xl backdrop-blur-lg lg:w-80">
            <div class="mb-8">
                <p class="text-sm uppercase tracking-[0.3em] text-cyan-300/90">Tentang Kami</p>
                <h1 class="mt-3 text-3xl font-bold text-white">Tim Pengembang</h1>
                <p class="mt-4 text-slate-400">Halaman ini menampilkan profil tim pengembang aplikasi, lengkap dengan foto, kelas, jurusan, dan kontak.</p>
            </div>

            <nav class="space-y-3 text-sm text-slate-200">
                <a href="#overview" class="block rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 transition hover:border-cyan-400 hover:text-white">Overview Tim</a>
                <a href="#team" class="block rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 transition hover:border-cyan-400 hover:text-white">Profil Anggota</a>
                <a href="#contact" class="block rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 transition hover:border-cyan-400 hover:text-white">Kontak</a>
            </nav>
        </aside>
 
        <main class="w-full overflow-hidden rounded-[32px] border border-white/10 bg-slate-900/80 shadow-2xl backdrop-blur-lg">
            <div class="border-b border-white/10 p-8">
                <div id="overview" class="space-y-3">
                    <span class="inline-flex items-center rounded-full bg-cyan-500/10 px-3 py-1 text-xs uppercase tracking-[0.3em] text-cyan-300">Tentang Kami</span>
                    <h2 class="text-4xl font-bold text-white">Menu Pengembang</h2>
                    <p class="max-w-3xl text-slate-300">Selamat datang di halaman pengembang. Di sini Anda dapat melihat tim yang membuat sistem ini, informasi kelas, jurusan, dan kontak masing-masing anggota.</p>
                </div>
            </div>

            <div class="space-y-8 p-8">
                <section id="team" class="space-y-6">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h3 class="text-2xl font-semibold text-white">Profil Anggota</h3>
                            <p class="text-slate-400">anggota yang bertanggung jawab atas pembuatan sistem ini.</p>
                        </div>
                        <span class="rounded-full bg-white/5 px-4 py-2 text-sm text-slate-300">Hanya di home</span>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        @foreach([
                            ['name' => 'Andika Bayu Pratama', 'major' => 'SIJA', 'kelas' => '11 SIJA 1', 'role' => 'Pengembang, dan Desainer UI/UX', 'photo' => asset('images/ANDIKA.png'), 'phone' => '085755947554', 'email' => 'bayu16847@gmail.com'],
                            ['name' => 'Fathi Amrullah S', 'major' => 'SIJA', 'kelas' => '11 SIJA 1', 'role' => 'Pengembang Backend', 'photo' => asset('images/FATHI.png'), 'phone' => '0813-2345-6789', 'email' => 'fathi.amrullah@example.com'],
                            ['name' => 'Faza Lana Tama', 'major' => 'SIJA', 'kelas' => '11 SIJA 1', 'role' => 'Desainer UI/UX', 'photo' => asset('images/FAZA.png'), 'phone' => '0814-9876-5432', 'email' => 'faza.lana@example.com'],
                            ['name' => 'Mey Ronald Rifky S', 'major' => 'SIJA', 'kelas' => '11 SIJA 1', 'role' => 'Manajer Proyek', 'photo' => asset('images/RONALD.png'), 'phone' => '0815-6789-0123', 'email' => 'mey.ronald@example.com'],
                        ] as $member)
                            <article class="relative overflow-hidden rounded-[28px] border border-white/10 bg-slate-950/90 p-6 shadow-xl transition hover:border-cyan-400/40 hover:shadow-[0_40px_100px_rgba(6,182,212,0.28)] @if($member['name'] === 'Andika Bayu Pratama') ring-1 ring-cyan-500/20 border-cyan-400/30 bg-gradient-to-br from-cyan-950/90 via-slate-950/80 to-slate-900 shadow-[0_55px_140px_rgba(6,182,212,0.35)] @endif">
                                @if($member['name'] === 'Andika Bayu Pratama')
                                    <div class="pointer-events-none absolute -right-10 top-10 h-44 w-44 rounded-full bg-cyan-500/15 blur-3xl"></div>
                                    <div class="pointer-events-none absolute left-4 top-16 h-28 w-28 rounded-full bg-cyan-400/15 blur-2xl"></div>
                                    <div class="absolute inset-x-0 top-4 flex justify-center">
                                        <span class="inline-flex items-center gap-2 rounded-full border border-cyan-400/15 bg-slate-950/80 px-4 py-2 text-[11px] uppercase tracking-[0.25em] text-cyan-100 shadow-lg backdrop-blur-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-cyan-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                <path d="M12 2l2.9 6.6 7.1.6-5.5 4.7 1.8 7-6.3-3.8L5.5 21 7.3 14 1.8 9.3l7.1-.6L12 2z"/>
                                            </svg>
                                            Mastermind
                                        </span>
                                    </div>
                                @endif
                                <div class="relative flex flex-col items-center gap-3">
                                    <div class="relative overflow-hidden rounded-full border-4 border-cyan-400/20 bg-slate-900 shadow-[0_0_0_1px_rgba(255,255,255,0.05)] @if($member['name'] === 'Andika Bayu Pratama') w-[310px] h-[310px] @else w-[250px] h-[250px] @endif">
                                        @if($member['name'] === 'Andika Bayu Pratama')
                                            <div class="absolute inset-0 rounded-full bg-cyan-500/15 blur-3xl"></div>
                                            <div class="absolute inset-0 rounded-full ring-2 ring-cyan-300/10"></div>
                                            <div class="pointer-events-none absolute -right-2 top-2 h-12 w-12 rounded-full bg-cyan-300/20 blur-xl"></div>
                                        @endif
                                        <img src="{{ $member['photo'] }}" alt="Foto {{ $member['name'] }}" class="relative h-full w-full object-cover object-center" />
                                    </div>
                                    <div class="text-center">
                                        <h4 class="text-base font-semibold text-white flex items-center justify-center gap-2">
                                            {{ $member['name'] }}
                                            @if($member['name'] === 'Andika Bayu Pratama')
                                                <span class="inline-flex items-center gap-1 rounded-full bg-cyan-500/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-cyan-100 shadow-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                        <path d="M12 2l2.9 6.6 7.1.6-5.5 4.7 1.8 7-6.3-3.8L5.5 21 7.3 14 1.8 9.3l7.1-.6L12 2z"/>
                                                    </svg>
                                                    Lead
                                                </span>
                                            @endif
                                        </h4>
                                        <div class="mx-auto mt-3 h-0.5 w-16 rounded-full bg-cyan-400/30"></div>
                                        <p class="mt-3 text-sm text-slate-300">{{ $member['role'] }}</p>
                                        @if($member['name'] === 'Andika Bayu Pratama')
                                            <p class="mx-auto mt-3 max-w-[20rem] rounded-full border border-cyan-500/20 bg-cyan-500/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-cyan-100 shadow-inner shadow-cyan-500/10">
                                                Pembuat konsep visual dan arsitek teknis aplikasi
                                            </p>
                                            <div class="mt-4 flex flex-wrap justify-center gap-2 text-[11px] uppercase tracking-[0.24em] text-slate-300">
                                                <span class="rounded-full bg-cyan-500/10 px-3 py-1 text-cyan-100">Visionary</span>
                                                <span class="rounded-full bg-white/5 px-3 py-1 text-slate-200">Creative Lead</span>
                                                <span class="rounded-full bg-cyan-400/10 px-3 py-1 text-cyan-100">Brand Architect</span>
                                            </div>
                                            <div class="mt-4 rounded-3xl border border-cyan-400/20 bg-slate-950/80 px-4 py-3 text-center text-xs uppercase tracking-[0.26em] text-cyan-200 shadow-inner shadow-cyan-500/10">
                                                Istimewa: profil paling menonjol dalam tim
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-5 grid gap-3 rounded-3xl bg-slate-900/80 p-4 text-slate-300">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="font-medium text-slate-200">Kelas</span>
                                        <span>{{ $member['kelas'] }}</span>
                                    </div>
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="font-medium text-slate-200">Jurusan</span>
                                        <span>{{ $member['major'] }}</span>
                                    </div>
                                    <div class="flex items-start justify-between gap-4 text-sm">
                                        <span class="font-medium text-slate-200">Sebagai</span>
                                        <span class="block max-w-[18rem] rounded-2xl border border-cyan-500/10 bg-cyan-500/5 px-3 py-2 text-right text-cyan-100 shadow-sm">
                                            {{ $member['role'] }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="font-medium text-slate-200">Telepon</span>
                                        <span>
                                            <a href="tel:{{ $member['phone'] }}" class="inline-flex items-center gap-2 text-slate-300 hover:text-cyan-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-cyan-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 4.5a2 2 0 012-2h2a1 1 0 01.9.55l1.2 2.4a1 1 0 01-.2 1.1L8.4 9.6a11 11 0 006 6l2.1-1.1a1 1 0 011 .1l2.4 1.2a1 1 0 01.55.9V20a2 2 0 01-2 2H5a2 2 0 01-2-2V4.5z"/>
                                                </svg>
                                                <span class="truncate">{{ $member['phone'] }}</span>
                                            </a>
                                        </span>
                                    </div>
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="font-medium text-slate-200">Email</span>
                                            <span>
                                                <a href="mailto:{{ $member['email'] }}" class="inline-flex items-center gap-2 text-slate-300 hover:text-cyan-300">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-cyan-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8.5v7A2.5 2.5 0 005.5 18h13a2.5 2.5 0 002.5-2.5v-7A2.5 2.5 0 0018.5 6h-13A2.5 2.5 0 003 8.5z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.5l-9 6-9-6"/>
                                                    </svg>
                                                    <span class="truncate">{{ $member['email'] }}</span>
                                                </a>
                                            </span>
                                        </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>


                <section id="contact" class="rounded-[28px] border border-white/10 bg-slate-950/80 p-8">
                    <h3 class="text-2xl font-semibold text-white">Informasi Kontak</h3>
                    <p class="mt-3 text-slate-400">Hubungi kami jika Anda ingin tahu lebih lanjut tentang aplikasi atau tim pengembang.</p>
                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-3xl bg-slate-900/80 p-6 text-slate-200 shadow-sm">
                            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Koordinator Tim</p>
                            <p class="mt-2 text-lg font-semibold text-white">Nama Koordinator</p>
                            <p class="mt-1 text-slate-400">koordinator@example.com</p>
                        </div>
                        <div class="rounded-3xl bg-slate-900/80 p-6 text-slate-200 shadow-sm">
                            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Lokasi</p>
                            <p class="mt-2 text-lg font-semibold text-white">SMKN 6 Malang</p>
                            <p class="mt-1 text-slate-400">Jurusan SIJA</p>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>
</div>
@endsection
