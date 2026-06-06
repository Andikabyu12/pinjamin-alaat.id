@extends('layouts.app')

@section('title', 'Daftar Admin - Peminjaman Alat TI')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-8">
    <div class="bg-white/95 backdrop-blur-lg p-8 rounded-3xl shadow-xl w-full max-w-sm border border-slate-200">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-slate-900">Daftar Admin</h2>
            <p class="text-sm text-slate-600 mt-2">Cukup isi nama, email, dan password.</p>
        </div>

        <form method="POST" action="{{ route('register.admin.post') }}">
            @csrf

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="mb-4">
                <label class="block text-slate-700 text-sm font-semibold mb-2">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none" placeholder="Nama Admin" required>
            </div>

            <div class="mb-4">
                <label class="block text-slate-700 text-sm font-semibold mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none" placeholder="admin@example.com" required>
            </div>

            <input type="hidden" name="role" value="admin">

            <div class="mb-4">
                <label class="block text-slate-700 text-sm font-semibold mb-2">Password</label>
                <input type="password" name="password" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none" placeholder="Minimal 6 karakter" required>
            </div>

            <div class="mb-6">
                <label class="block text-slate-700 text-sm font-semibold mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none" placeholder="Ulangi password" required>
            </div>

            <button type="submit" class="w-full bg-slate-900 text-white font-semibold rounded-xl py-3 hover:bg-slate-800 transition">Daftar Admin</button>

            <p class="mt-5 text-center text-sm text-slate-600">Sudah punya akun? <a href="{{ route('login') }}" class="text-slate-900 font-semibold">Masuk</a></p>
            <div class="mt-4 text-center text-sm text-slate-600">Atau daftar peran lain: <a href="{{ route('register.wali-kelas') }}" class="text-blue-600 font-semibold">Wali Kelas</a>, <a href="{{ route('register.kaonsli-sij') }}" class="text-purple-600 font-semibold">Kakonsli SIJA</a>, <a href="{{ route('register.kaprog-tkj') }}" class="text-green-600 font-semibold">Kaprog TKJ</a>.</div>
        </form>
    </div>
</div>
@endsection
