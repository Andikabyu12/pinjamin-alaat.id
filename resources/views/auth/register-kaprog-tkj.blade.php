@extends('layouts.app')

@section('title', 'Daftar Kaprog TKJ - Peminjaman Alat TI')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-500 text-white rounded-lg mb-4">
                <i class="fas fa-chalkboard-user text-2xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Daftar Kaprog TKJ</h2>
            <p class="text-gray-600 text-sm">Buat akun Kepala Program TKJ untuk mengelola data alat dan peminjaman TKJ.</p>
        </div>

        <form method="POST" action="{{ route('register.kaprog-tkj.post') }}">
            @csrf

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                <input type="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <div class="flex items-center justify-between">
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full" type="submit">
                    Daftar Kaprog TKJ
                </button>
            </div>

            <div class="text-center mt-4">
                <p class="text-sm">Atau <a href="{{ route('register.admin') }}" class="text-green-500 hover:text-green-700">kembali ke menu admin</a></p>
                <p class="text-sm mt-2">Daftar peran lain: <a href="{{ route('register.wali-kelas') }}" class="text-blue-500 hover:text-blue-700">Wali Kelas</a> atau <a href="{{ route('register.kaonsli-sij') }}" class="text-purple-500 hover:text-purple-700">Kakonsli SIJA</a>.</p>
            </div>
        </form>
    </div>
</div>
@endsection
