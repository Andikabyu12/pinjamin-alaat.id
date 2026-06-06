@extends('layouts.app')

@section('title', 'Data Siswa - Kakonsli SIJA')

@section('content')
<div class="container mx-auto px-4">
    <div class="card-soft rounded-2xl p-8 border border-slate-200">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 mb-2">Data Siswa</h1>
                <p class="text-slate-600">Kelola dan lihat informasi siswa</p>
            </div>
            <a href="{{ route('kaonsli_sij.search-siswa') }}" class="inline-flex items-center gap-2 gradient-btn text-white px-6 py-3 rounded-lg hover:shadow-lg transition">
                <i class="fas fa-search"></i>
                Cari Siswa
            </a>
        </div>

        <!-- Tabel Siswa -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-100 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">NIS</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Nama</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Kelas</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Jurusan</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Email</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-slate-900">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($siswas as $siswa)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-sm text-slate-900 font-medium">{{ $siswa->nis }}</td>
                            <td class="px-6 py-4 text-sm text-slate-900">{{ $siswa->name }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $siswa->kelas }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $siswa->major ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $siswa->email }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('kaonsli_sij.show-siswa', $siswa->id) }}" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700 text-sm font-medium">
                                    <i class="fas fa-eye"></i>
                                    Lihat
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-600">
                                <i class="fas fa-inbox text-3xl mb-3 block text-slate-400"></i>
                                Tidak ada data siswa
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($siswas instanceof \Illuminate\Pagination\Paginator)
            <div class="mt-6">
                {{ $siswas->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</div>
@endsection
