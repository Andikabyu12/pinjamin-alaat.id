@extends('layouts.app')

@section('title', 'Daftar Wali Kelas - Peminjaman Alat TI')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-8">
    <div class="bg-white/95 backdrop-blur-lg p-10 rounded-3xl shadow-2xl w-full max-w-md border-2 border-white/50">
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-blue-600 to-cyan-600 text-white rounded-3xl mb-6 shadow-lg">
                <i class="fas fa-chalkboard-teacher text-4xl"></i>
            </div>
            <h2 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent">Wali Kelas</h2>
            <p class="text-gray-600 text-sm mt-2">Daftarkan Wali Kelas untuk mengelola peminjaman siswa per jurusan.</p>
        </div>

        <div class="mb-8 p-4 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl border-2 border-blue-200">
            <p class="text-xs font-bold text-blue-700 uppercase tracking-wide mb-3">Atau daftar sebagai:</p>
            <div class="grid grid-cols-2 gap-2">
                <a href="{{ route('register.admin') }}" class="bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-bold py-2 px-3 rounded-lg text-center text-xs transition transform hover:scale-105 hover:shadow-lg">
                    <i class="fas fa-user-shield mr-1"></i>Admin Umum
                </a>
                <a href="{{ route('register.kaonsli-sij') }}" class="bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-bold py-2 px-3 rounded-lg text-center text-xs transition transform hover:scale-105 hover:shadow-lg">
                    <i class="fas fa-user-graduate mr-1"></i>Kakonsli SIJA
                </a>
                <a href="{{ route('register.kaprog-tkj') }}" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-2 px-3 rounded-lg text-center text-xs transition transform hover:scale-105 hover:shadow-lg">
                    <i class="fas fa-user-graduate mr-1"></i>Kaprog TKJ
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('register.wali-kelas.post') }}">
            @csrf

            @if($errors->any())
                <div class="bg-gradient-to-r from-red-100 to-red-50 border-2 border-red-400 text-red-800 px-4 py-3 rounded-lg mb-4 font-medium">
                    <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
                </div>
            @endif

            <div class="mb-5">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" class="shadow appearance-none border-2 border-blue-200 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-blue-500 focus:shadow-lg transition" placeholder="Nama Wali Kelas" required>
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="shadow appearance-none border-2 border-blue-200 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-blue-500 focus:shadow-lg transition" placeholder="wali-kelas@email.com" required>
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 text-sm font-bold mb-2">Jurusan</label>
                <select name="major" class="shadow appearance-none border-2 border-blue-200 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-blue-500 focus:shadow-lg transition" required>
                    <option value="">-- Pilih Jurusan --</option>
                    <option value="SIJA" {{ old('major') == 'SIJA' ? 'selected' : '' }}>SIJA</option>
                    <option value="TKJ" {{ old('major') == 'TKJ' ? 'selected' : '' }}>TKJ</option>
                </select>
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 text-sm font-bold mb-2">Kelas</label>
                <select name="kelas" class="shadow appearance-none border-2 border-blue-200 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-blue-500 focus:shadow-lg transition" required>
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
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" class="shadow appearance-none border-2 border-blue-200 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-blue-500 focus:shadow-lg transition" placeholder="••••••••" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="shadow appearance-none border-2 border-blue-200 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-blue-500 focus:shadow-lg transition" placeholder="••••••••" required>
            </div>

            <button class="w-full bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-lg transition transform hover:scale-105 shadow-lg" type="submit">
                <i class="fas fa-user-check mr-2"></i>Daftar Wali Kelas
            </button>

            <div class="text-center mt-6">
                <p class="text-sm text-gray-700">Sudah punya akun? <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-800 transition">Masuk disini</a></p>
            </div>
        </form>
    </div>
</div>
@endsection
