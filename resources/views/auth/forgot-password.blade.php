@extends('layouts.app')

@section('title', 'Lupa Password - Peminjaman Alat TI')

@section('content')
<div class="page-shell">
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-3xl mx-auto glass-panel p-8 rounded-3xl text-slate-200">
            <p class="text-xs uppercase tracking-[0.24em] text-cyan-300 font-semibold">Lupa Password</p>
            <h1 class="text-3xl font-black text-white mt-3 mb-4">Reset password melalui email</h1>
            <p class="text-slate-400 mb-8">Masukkan email yang terdaftar. Kami akan mengirim tautan aman untuk membuat password baru.</p>

            @if(session('status'))
                <div class="rounded-2xl border border-emerald-400/25 bg-emerald-500/10 p-4 text-emerald-100 mb-6">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Email terdaftar</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="w-full rounded-3xl border border-slate-700/70 bg-slate-950/70 px-4 py-3 text-slate-100 placeholder:text-slate-500 focus:border-cyan-400 focus:ring-cyan-400/20 focus:outline-none" />
                    @error('email')
                        <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-primary w-full rounded-3xl px-5 py-3">Kirim tautan reset</button>
            </form>

            <div class="mt-8 rounded-2xl bg-slate-900/80 border border-slate-700/40 p-6">
                <h3 class="text-sm font-semibold text-slate-200 mb-3">Cadangan jika belum menerima email</h3>
                <p class="text-sm text-slate-400 mb-3">Periksa folder spam/junk. Jika email belum diterima setelah beberapa menit, hubungi admin atau perbarui konfigurasi email sistem.</p>
                @if(!empty($adminWa))
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $adminWa) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-4 py-3 rounded-2xl bg-emerald-500 text-white hover:bg-emerald-400 transition">Hubungi Admin via WhatsApp</a>
                @endif
            </div>

            <div class="mt-6 text-sm text-slate-400">
                <a href="{{ route('login') }}" class="text-cyan-300 hover:text-cyan-200">Kembali ke halaman login</a>
            </div>
        </div>
    </div>
</div>
@endsection
