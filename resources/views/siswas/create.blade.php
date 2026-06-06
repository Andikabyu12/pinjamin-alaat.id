@extends('layouts.app')

@section('content')
<div class="page-shell">
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-24 left-0 w-80 h-80 rounded-full bg-slate-700/30 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 rounded-full bg-cyan-500/10 blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="mb-10">
            <p class="text-sm uppercase tracking-[0.3em] text-cyan-300 font-semibold">Tambah Siswa</p>
            <h1 class="mt-3 text-4xl font-black text-white">Data Siswa Baru</h1>
            <p class="mt-2 text-slate-400">Isi profil siswa dengan cepat untuk keperluan peminjaman.</p>
        </div>

        @if($errors->any())
            <div class="mb-6 rounded-3xl border border-rose-500/30 bg-rose-500/10 p-4 text-rose-100 shadow-lg">
                <ul class="space-y-2 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="panel-card p-8 max-w-3xl mx-auto">
            <form action="{{ route('siswas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">NIS</label>
                    <input type="text" name="nis" value="{{ old('nis') }}" class="dark-input w-full rounded-2xl px-4 py-3 text-slate-100" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" class="dark-input w-full rounded-2xl px-4 py-3 text-slate-100" required>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-semibold text-slate-300 mb-2">Kelas</label>
                        <select name="kelas" class="dark-select w-full rounded-2xl px-4 py-3 text-slate-100" required>
                            <option value="">Pilih Kelas</option>
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
                    <div>
                        <label class="block text-sm font-semibold text-slate-300 mb-2">Jurusan</label>
                        <select name="jurusan" class="dark-select w-full rounded-2xl px-4 py-3 text-slate-100" required>
                            <option value="">Pilih jurusan</option>
                            <option value="tkj" {{ old('jurusan') == 'tkj' ? 'selected' : '' }}>TKJ</option>
                            <option value="sija" {{ old('jurusan') == 'sija' ? 'selected' : '' }}>SIJA</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <x-back-link fallback="{{ route('siswas.index') }}" class="btn-secondary px-5 py-3">Batal</x-back-link>
                    <div class="w-full sm:w-auto flex flex-col sm:flex-row gap-3">
                        <div>
                            <label class="block text-sm font-semibold text-slate-300 mb-2">Password (opsional)</label>
                            <input type="password" name="password" class="dark-input rounded-2xl px-3 py-2 text-slate-100" placeholder="Kosongkan untuk default 'password'">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-300 mb-2">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="dark-input rounded-2xl px-3 py-2 text-slate-100" placeholder="Konfirmasi password">
                        </div>
                        <button type="submit" class="btn-primary px-6 py-3">Simpan Siswa</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
