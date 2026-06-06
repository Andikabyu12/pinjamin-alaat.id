@extends('layouts.app')

@section('title', '419 Session Expired')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-10 sm:px-6 lg:px-8">
    <div class="w-full max-w-3xl rounded-[32px] border border-white/10 bg-slate-900/85 p-10 text-center shadow-2xl backdrop-blur-lg">
        <span class="inline-flex items-center justify-center rounded-full bg-rose-500/15 p-4 text-rose-300 mb-6 text-3xl">
            <i class="fas fa-clock"></i>
        </span>
        <h1 class="text-5xl font-bold text-white">419</h1>
        <p class="mt-4 text-lg text-slate-300">Sesi Anda telah habis atau token keamanan tidak lagi berlaku.</p>
        <p class="mt-2 text-sm text-slate-400">Silakan muat ulang halaman dan masuk kembali untuk melanjutkan.</p>
        <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row sm:justify-center">
            <button onclick="window.location.reload()" class="btn-primary">Muat Ulang</button>
            <a href="{{ route('login') }}" class="btn-secondary">Masuk Kembali</a>
        </div>
    </div>
</div>
@endsection
