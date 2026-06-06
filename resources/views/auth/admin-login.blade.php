@extends('layouts.app')

@section('title', 'Admin Login - Peminjaman Alat TI')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-10">
    <div class="bg-white/95 backdrop-blur-lg p-10 rounded-3xl shadow-2xl w-full max-w-md border border-slate-200">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-indigo-600 to-purple-600 text-white rounded-3xl mb-4 shadow-lg">
                <i class="fas fa-user-plus text-3xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-slate-900">Daftar Admin</h2>
            <p class="text-sm text-slate-600 mt-2">Buat akun admin baru di sini.</p>
        </div>

        <form method="POST" action="{{ route('register.admin.post') }}">
            @csrf

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="mb-4">
                <label class="block text-slate-700 text-sm font-semibold mb-2">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:outline-none" placeholder="Nama Admin" required>
            </div>

            <div class="mb-4">
                <label class="block text-slate-700 text-sm font-semibold mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:outline-none" placeholder="admin@example.com" required>
            </div>

            <input type="hidden" name="role" value="admin">

            <div class="mb-4">
                <label class="block text-slate-700 text-sm font-semibold mb-2">Password</label>
                <input type="password" name="password" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:outline-none" placeholder="Minimal 6 karakter" required>
            </div>

            <div class="mb-6">
                <label class="block text-slate-700 text-sm font-semibold mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:outline-none" placeholder="Ulangi password" required>
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white font-semibold rounded-xl py-3 hover:bg-indigo-700 transition">Daftar Admin</button>

            <p class="mt-5 text-center text-sm text-slate-600">Sudah punya akun? <a href="{{ route('login') }}" class="text-indigo-600 font-semibold">Masuk sebagai pengguna</a></p>
        </form>
    </div>
</div>
@endsection
