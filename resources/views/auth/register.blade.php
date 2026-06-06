@extends('layouts.app')

@section('title', 'Daftar - Peminjaman Alat TI')

@section('content')
<div class="relative min-h-screen overflow-hidden bg-slate-950 text-slate-100">
    <div class="pointer-events-none absolute inset-0 opacity-40">
        <div class="absolute -left-20 -top-16 h-80 w-80 rounded-full bg-cyan-500/20 blur-3xl"></div>
        <div class="absolute right-0 top-24 h-72 w-72 rounded-full bg-blue-500/20 blur-3xl"></div>
        <div class="absolute bottom-0 left-10 h-96 w-96 rounded-full bg-indigo-500/15 blur-3xl"></div>
    </div>

    <div class="relative px-4 py-12 lg:px-10 lg:py-16">
        <div class="mx-auto grid max-w-6xl gap-8 xl:grid-cols-[1.05fr_0.95fr]">
            <div class="relative overflow-hidden rounded-[32px] border border-white/10 bg-gradient-to-br from-slate-900/95 via-slate-950 to-slate-950/95 p-10 shadow-2xl shadow-cyan-500/20 backdrop-blur-xl">
                <div class="absolute -right-24 top-12 h-48 w-48 rounded-full bg-cyan-500/10 blur-3xl"></div>
                <div class="absolute -left-20 bottom-10 h-56 w-56 rounded-full bg-blue-500/10 blur-3xl"></div>

                <div class="relative z-10 flex h-full flex-col justify-between gap-8">
                    <div>
                        <span class="inline-flex rounded-full bg-cyan-500/15 px-4 py-2 text-sm font-semibold text-cyan-200 ring-1 ring-cyan-400/20">SMKN 6 Malang</span>
                        <h2 class="mt-8 text-5xl font-black tracking-tight text-white">Informasi Pendaftaran</h2>
                        <p class="mt-5 max-w-xl text-sm leading-7 text-slate-300">Daftarkan akun Anda untuk mengakses sistem peminjaman alat TI. Dengan mendaftar, Anda dapat melihat ketersediaan alat, membuat peminjaman, dan memantau riwayat peminjaman dengan lebih mudah.</p>
                    </div>

                    <div class="space-y-4">
                        <div class="rounded-3xl border border-cyan-500/20 bg-slate-950/70 p-5 shadow-xl shadow-cyan-500/10">
                            <h3 class="text-lg font-bold text-white">Keuntungan Mendaftar</h3>
                            <ul class="mt-4 space-y-3 text-sm text-slate-300">
                                <li>✓ Akses sistem peminjaman alat dengan cepat</li>
                                <li>✓ Kelola peminjaman kapan saja</li>
                                <li>✓ Notifikasi real-time dan status pinjaman</li>
                                <li>✓ Riwayat peminjaman lengkap dan terstruktur</li>
                            </ul>
                        </div>

                        <a href="{{ route('login', ['redirect_to' => request('redirect_to')]) }}" class="inline-flex w-fit items-center justify-center rounded-full bg-white/95 px-6 py-3 text-sm font-bold text-slate-950 transition duration-300 hover:bg-white">Sudah Punya Akun? Masuk</a>
                    </div>
                </div>
            </div>

            <!-- Right Panel - Register Form -->
            <div class="rounded-[32px] border border-white/10 bg-white/95 p-10 shadow-2xl shadow-slate-900/20 backdrop-blur-xl">
                <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.35em] text-slate-500">Formulir Pendaftaran</p>
                        <h1 class="mt-3 text-4xl font-black text-slate-900">Buat Akun Baru</h1>
                    </div>
                    <div class="rounded-3xl bg-cyan-600/10 px-4 py-2 text-sm font-semibold text-cyan-700">Warna konsisten biru-cyan</div>
                </div>

                <form method="POST" action="{{ route('register.post') }}" class="space-y-6">
                    @csrf

                    @if($errors->any())
                        <div class="rounded-3xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
                            <strong class="block font-semibold">Terdapat kesalahan:</strong>
                            <ul class="mt-2 list-disc space-y-1 pl-5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <input type="hidden" name="redirect_to" value="{{ request('redirect_to') }}">

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700">Nama Depan</label>
                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" placeholder="Nama Depan" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100" />
                            @error('first_name')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700">Nama Belakang</label>
                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" placeholder="Nama Belakang" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100" />
                            @error('last_name')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="email@domain.com" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100" />
                        @error('email')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Peran / Role</label>
                        <select name="role" id="role" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                            <option value="">-- Pilih Role --</option>
                            <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                            @unless($adminExists ?? false)
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            @endunless
                            <option value="wali_kelas" {{ old('role') == 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
                            <option value="kaonsli_sij" {{ old('role') == 'kaonsli_sij' ? 'selected' : '' }}>Kakonsli SIJA</option>
                            <option value="kaprog_tkj" {{ old('role') == 'kaprog_tkj' ? 'selected' : '' }}>Kaprog TKJ</option>
                        </select>
                        @error('role')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
                    </div>

                    <div id="siswaOnlyFields" style="display: none;" class="rounded-3xl border border-slate-200 bg-slate-50/90 p-5 shadow-sm">
                        <div class="mb-5 rounded-3xl bg-cyan-600/10 p-4 text-sm text-cyan-700">
                            Data Kelas &amp; Jurusan untuk role <span class="font-semibold">Siswa</span> atau <span class="font-semibold">Wali Kelas</span>.
                        </div>

                        <div id="nisField">
                            <label class="mb-2 block text-sm font-semibold text-slate-700">NIS</label>
                            <input id="nis" type="text" name="nis" value="{{ old('nis') }}" placeholder="123456" class="w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100" />
                            @error('nis')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">Kelas</label>
                                <select name="kelas" id="kelas" class="w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                                    <option value="">-- Pilih Kelas --</option>
                                    <option value="10 TKJ 1" {{ old('kelas') == '10 TKJ 1' ? 'selected' : '' }}>10 TKJ 1</option>
                                    <option value="10 TKJ 2" {{ old('kelas') == '10 TKJ 2' ? 'selected' : '' }}>10 TKJ 2</option>
                                    <option value="11 TKJ 1" {{ old('kelas') == '11 TKJ 1' ? 'selected' : '' }}>11 TKJ 1</option>
                                    <option value="11 TKJ 2" {{ old('kelas') == '11 TKJ 2' ? 'selected' : '' }}>11 TKJ 2</option>
                                    <option value="12 TKJ 1" {{ old('kelas') == '12 TKJ 1' ? 'selected' : '' }}>12 TKJ 1</option>
                                    <option value="12 TKJ 2" {{ old('kelas') == '12 TKJ 2' ? 'selected' : '' }}>12 TKJ 2</option>
                                    <option value="10 SIJA 1" {{ old('kelas') == '10 SIJA 1' ? 'selected' : '' }}>10 SIJA 1</option>
                                    <option value="10 SIJA 2" {{ old('kelas') == '10 SIJA 2' ? 'selected' : '' }}>10 SIJA 2</option>
                                    <option value="11 SIJA 1" {{ old('kelas') == '11 SIJA 1' ? 'selected' : '' }}>11 SIJA 1</option>
                                    <option value="11 SIJA 2" {{ old('kelas') == '11 SIJA 2' ? 'selected' : '' }}>11 SIJA 2</option>
                                    <option value="12 SIJA 1" {{ old('kelas') == '12 SIJA 1' ? 'selected' : '' }}>12 SIJA 1</option>
                                    <option value="12 SIJA 2" {{ old('kelas') == '12 SIJA 2' ? 'selected' : '' }}>12 SIJA 2</option>
                                </select>
                                @error('kelas')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">Jurusan</label>
                                <select name="major" id="major" class="w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                                    <option value="">-- Pilih Jurusan --</option>
                                    <option value="SIJA" {{ old('major') == 'SIJA' ? 'selected' : '' }}>SIJA</option>
                                    <option value="TKJ" {{ old('major') == 'TKJ' ? 'selected' : '' }}>TKJ</option>
                                </select>
                                @error('major')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700">Password</label>
                            <div class="relative">
                                <input type="password" name="password" id="password" required placeholder="••••••••" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 pr-12 text-slate-900 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100" />
                                <span id="passwordCheck" class="absolute right-4 top-3 text-xl text-slate-400"></span>
                            </div>
                            @error('password')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700">Konfirmasi Password</label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="••••••••" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 pr-12 text-slate-900 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100" />
                                <span id="confirmPasswordCheck" class="absolute right-4 top-3 text-xl text-slate-400"></span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <input type="checkbox" id="terms" name="terms" class="mt-1 h-5 w-5 rounded border border-slate-300 bg-white text-cyan-600 focus:ring-2 focus:ring-cyan-400" required>
                        <label for="terms" class="text-sm text-slate-700">Saya setuju dengan <a href="#" class="font-semibold text-cyan-600 hover:text-cyan-800">Syarat dan Ketentuan</a></label>
                    </div>

                    <button type="submit" class="w-full rounded-3xl bg-gradient-to-r from-cyan-600 via-blue-600 to-indigo-600 px-6 py-3 text-base font-bold text-white shadow-xl shadow-cyan-500/20 transition hover:-translate-y-0.5 hover:shadow-cyan-500/30">REGISTER</button>

                    <div class="relative my-4">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-slate-200"></div>
                        </div>
                        <div class="relative flex justify-center text-xs text-slate-500"><span class="bg-white px-3">atau</span></div>
                    </div>

                    <div class="text-center text-sm text-slate-600">Sudah punya akun? <a href="{{ route('login', ['redirect_to' => request('redirect_to')]) }}" class="font-semibold text-cyan-600 hover:text-cyan-800">Masuk disini</a></div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
