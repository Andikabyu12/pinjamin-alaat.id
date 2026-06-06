@extends('layouts.app')

@section('content')
<div class="min-h-screen py-10">
    <div class="mx-auto max-w-2xl">
        <div class="rounded-[2rem] border border-white/10 bg-slate-950/95 p-8 shadow-2xl backdrop-blur-xl">
            <div class="mb-8 space-y-3">
                <p class="text-sm uppercase tracking-[0.28em] text-cyan-300">Form Tugas</p>
                <h1 class="text-3xl font-semibold text-white">Tambah Tugas Baru</h1>
                <p class="max-w-2xl text-slate-400">Buat tugas dengan cepat dan kelola status secara mudah dari tampilan yang konsisten.</p>
            </div>

            <form action="{{ route('tasks.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label for="title" class="block text-sm font-semibold text-slate-200">Nama Tugas</label>
                    <input id="title" type="text" name="title" value="{{ old('title') }}" required class="w-full rounded-2xl border border-slate-700 bg-slate-900/90 px-4 py-3 text-slate-100 placeholder:text-slate-500 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 transition" placeholder="Masukkan nama tugas" />
                </div>

                <div class="space-y-2">
                    <label for="description" class="block text-sm font-semibold text-slate-200">Deskripsi</label>
                    <textarea id="description" name="description" required class="w-full rounded-2xl border border-slate-700 bg-slate-900/90 px-4 py-3 text-slate-100 placeholder:text-slate-500 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 transition" rows="4" placeholder="Tuliskan detail tugas...">{{ old('description') }}</textarea>
                </div>

                <div class="space-y-2">
                    <label for="status" class="block text-sm font-semibold text-slate-200">Status</label>
                    <select id="status" name="status" class="w-full rounded-2xl border border-slate-700 bg-slate-900/90 px-4 py-3 text-slate-100 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 transition">
                        <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Belum selesai</option>
                        <option value="1" {{ old('status') === '1' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <x-back-link fallback="{{ route('tasks.index') }}" class="inline-flex items-center justify-center rounded-full border border-slate-700 bg-slate-900/80 px-6 py-3 text-sm font-semibold text-slate-200 transition hover:bg-slate-800">Batal</x-back-link>
                    <button type="submit" class="inline-flex items-center justify-center rounded-full bg-gradient-to-r from-cyan-500 to-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:from-cyan-400 hover:to-blue-500">Simpan Tugas</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection