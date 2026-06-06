@extends('layouts.app')

@section('title', 'Impor Siswa')

@section('content')
<div class="page-shell">
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-24 left-0 w-80 h-80 rounded-full bg-slate-700/30 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 rounded-full bg-cyan-500/10 blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="panel-card max-w-2xl mx-auto p-8">
            <div class="mb-6">
                <p class="text-sm uppercase tracking-[0.3em] text-cyan-300 font-semibold">Impor Siswa</p>
                <h1 class="mt-3 text-4xl font-black text-white">Unggah Data Siswa</h1>
                <p class="mt-2 text-slate-400">Upload file Excel atau CSV dengan kolom yang sudah ditentukan untuk menyimpan data siswa.</p>
            </div>

            @if(session('success'))
                <div class="mb-6 rounded-3xl border border-emerald-400/30 bg-emerald-500/10 p-4 text-emerald-100">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-6 rounded-3xl border border-rose-400/30 bg-rose-500/10 p-4 text-rose-100">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="mb-6 rounded-3xl border border-rose-400/30 bg-rose-500/10 p-4 text-rose-100">
                    <ul class="list-disc list-inside space-y-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('siswas.import.post') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div>
                    <label for="file" class="block text-sm font-semibold text-slate-300 mb-2">File Excel / CSV</label>
                    <input type="file" name="file" id="file" accept=".xlsx,.csv,text/csv" class="dark-input w-full rounded-3xl px-4 py-3 text-slate-100" required>
                </div>
                <div class="space-y-3 text-sm text-slate-400">
                    <p>Pastikan file CSV berisi header sesuai urutan: <strong>No, NIS, Nama Lengkap, Kelas, Jurusan</strong>.</p>
                    <p>Impor maksimal <strong>10000 siswa</strong> per unggahan. Data duplikat atau tidak valid akan dilewati.</p>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <x-back-link fallback="{{ route('siswas.index') }}" class="btn-secondary px-5 py-3">Kembali</x-back-link>
                    <button type="submit" class="btn-primary px-5 py-3">Mulai Impor</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection