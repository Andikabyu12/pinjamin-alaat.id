@extends('layouts.app')

@section('content')
<div class="min-h-screen py-10">
    <div class="mx-auto max-w-6xl space-y-8">
        <section class="rounded-[2rem] border border-white/10 bg-slate-950/95 p-8 shadow-2xl backdrop-blur-xl">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="space-y-3">
                    <p class="text-sm uppercase tracking-[0.28em] text-cyan-300">Task Tracker</p>
                    <h1 class="text-3xl font-semibold text-white">Daftar Kegiatan Harian</h1>
                    <p class="max-w-2xl text-slate-400">Atur tugas harian dengan tampilan yang lebih rapi, modern, dan mudah dibaca.</p>
                </div>
                <a href="{{ route('tasks.create') }}" class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-cyan-500 to-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:from-cyan-400 hover:to-blue-500">
                    <i class="fas fa-plus"></i>
                    Buat Tugas
                </a>
            </div>

            <div class="mt-8">
                @if($tasks->isEmpty())
                    <div class="rounded-[1.5rem] border border-slate-800 bg-slate-900/80 p-10 text-center shadow-lg">
                        <h2 class="text-2xl font-semibold text-white">Belum ada tugas</h2>
                        <p class="mt-3 text-slate-400">Tambahkan tugas baru untuk mulai mengatur aktivitas harian Anda.</p>
                        <a href="{{ route('tasks.create') }}" class="mt-6 inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-blue-600 to-sky-500 px-5 py-3 text-sm font-semibold text-white shadow-lg transition hover:from-blue-500 hover:to-sky-400">
                            <i class="fas fa-tasks"></i> Tambah Tugas Sekarang
                        </a>
                    </div>
                @else
                    <div class="overflow-hidden rounded-[1.5rem] border border-slate-800 bg-slate-900/80 shadow-xl">
                        <table class="min-w-full divide-y divide-slate-800 text-sm">
                            <thead class="bg-slate-950/90 text-slate-300">
                                <tr>
                                    <th class="px-4 py-4 text-left font-semibold uppercase tracking-wider">No</th>
                                    <th class="px-4 py-4 text-left font-semibold uppercase tracking-wider">Nama Kegiatan</th>
                                    <th class="px-4 py-4 text-left font-semibold uppercase tracking-wider">Deskripsi</th>
                                    <th class="px-4 py-4 text-left font-semibold uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-4 text-center font-semibold uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800 bg-slate-950 text-slate-200">
                                @foreach($tasks as $i => $task)
                                    <tr class="hover:bg-slate-900/70 transition">
                                        <td class="px-4 py-4 font-medium text-cyan-300">{{ $i + 1 }}</td>
                                        <td class="px-4 py-4 font-semibold text-white">{{ $task->title }}</td>
                                        <td class="px-4 py-4 text-slate-400">{{ Str::limit($task->description, 80) }}</td>
                                        <td class="px-4 py-4">
                                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $task->is_completed ? 'bg-emerald-500 text-slate-950' : 'bg-amber-500 text-slate-950' }}">
                                                {{ $task->is_completed ? 'Selesai' : 'Belum selesai' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            <div class="inline-flex flex-wrap items-center justify-center gap-2">
                                                <a href="/tasks/{{ $task->id }}/edit" class="inline-flex items-center gap-2 rounded-full bg-slate-700 px-4 py-2 text-xs font-semibold text-white transition hover:bg-slate-600">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus tugas ini?')" class="inline-flex items-center gap-2 rounded-full bg-red-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-red-700">
                                                        <i class="fas fa-trash-alt"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </section>
    </div>
</div>
@endsection