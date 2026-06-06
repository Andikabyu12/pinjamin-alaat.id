@extends('layouts.app')

@section('title', 'Daftar Kakonsli SIJA - Peminjaman Alat TI')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-8">
    <div class="bg-white/95 backdrop-blur-lg p-10 rounded-3xl shadow-2xl w-full max-w-md border-2 border-white/50">
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-purple-600 to-pink-700 text-white rounded-3xl mb-6 shadow-lg">
                <i class="fas fa-chalkboard-user text-4xl"></i>
            </div>
            <h2 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">Kakonsli SIJA</h2>
            <p class="text-gray-600 text-sm mt-2">Koordinator Konseling SIJA untuk mengelola data siswa</p>
        </div>

        <!-- Navigasi Role Admin Lain -->
        <div class="mb-8 p-4 bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl border-2 border-purple-200">
            <p class="text-xs font-bold text-purple-700 uppercase tracking-wide mb-3">Atau Daftar Sebagai:</p>
            <div class="grid grid-cols-2 gap-2">
                <a href="{{ route('register.admin') }}" class="bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-bold py-2 px-3 rounded-lg text-center text-xs transition transform hover:scale-105 hover:shadow-lg">
                    <i class="fas fa-user-lock mr-1"></i>Admin Umum
                </a>
                <a href="{{ route('register.wali-kelas') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-2 px-3 rounded-lg text-center text-xs transition transform hover:scale-105 hover:shadow-lg">
                    <i class="fas fa-chalkboard-teacher mr-1"></i>Wali Kelas
                </a>
                <a href="{{ route('register.kaprog-tkj') }}" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-2 px-3 rounded-lg text-center text-xs transition transform hover:scale-105 hover:shadow-lg">
                    <i class="fas fa-user-graduate mr-1"></i>Kaprog TKJ
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('register.kaonsli-sij.post') }}">
            @csrf

            @if($errors->any())
                <div class="bg-gradient-to-r from-red-100 to-red-50 border-2 border-red-400 text-red-800 px-4 py-3 rounded-lg mb-4 font-medium">
                    <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
                </div>
            @endif

            <div class="mb-5">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" class="shadow appearance-none border-2 border-purple-200 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-purple-500 focus:shadow-lg transition" placeholder="Nama Kakonsli" required>
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="shadow appearance-none border-2 border-purple-200 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-purple-500 focus:shadow-lg transition" placeholder="kakonsli@email.com" required>
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" class="shadow appearance-none border-2 border-purple-200 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-purple-500 focus:shadow-lg transition" placeholder="••••••••" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="shadow appearance-none border-2 border-purple-200 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-purple-500 focus:shadow-lg transition" placeholder="••••••••" required>
            </div>

            <button class="w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-lg transition transform hover:scale-105 shadow-lg" type="submit">
                <i class="fas fa-user-check mr-2"></i>Daftar Kakonsli SIJA
            </button>

            <div class="text-center mt-6">
                <p class="text-sm text-gray-700">Sudah punya akun? <a href="{{ route('register.admin') }}" class="font-bold text-purple-600 hover:text-purple-800 transition">Kembali ke menu admin</a></p>
            </div>
        </form>
    </div>
</div>
@endsection
