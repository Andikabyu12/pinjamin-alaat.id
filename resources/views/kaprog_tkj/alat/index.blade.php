@extends('layouts.app')

@section('title', 'Data Alat - Kaprog TKJ')

@section('content')
<div class="container mx-auto px-4">
    <div class="card-soft rounded-2xl p-8 border border-slate-200">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 mb-2">Data Alat TKJ</h1>
                <p class="text-slate-600">Kelola inventori alat Teknik Komputer Jaringan</p>
            </div>
            <form action="{{ route('kaprog_tkj.search-alat') }}" method="GET" class="w-full md:w-auto flex gap-3 items-center">
                <input
                    type="text"
                    name="q"
                    value="{{ old('q', $query ?? request('q')) }}"
                    placeholder="Cari nama, kode, atau kategori..."
                    class="w-full md:w-80 rounded-full border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none"
                />
                <button type="submit" class="inline-flex items-center gap-2 gradient-btn text-white px-6 py-3 rounded-lg hover:shadow-lg transition">
                    <i class="fas fa-search"></i>
                    Cari
                </button>
            </form>
        </div>

        <!-- Tabel Alat -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-100 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Gambar</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Kode Alat</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Nama Alat</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Kategori</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Kondisi</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-slate-900">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($alats as $alat)
                        @php
                            $imageUrl = $alat->gambar && file_exists(public_path('uploads/alats/' . $alat->gambar))
                                ? asset('uploads/alats/' . $alat->gambar)
                                : asset('images/PINJAMIN.ID.png');
                        @endphp
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-sm text-slate-900">
                                <img src="{{ $imageUrl }}" alt="{{ $alat->nama_alat }}" class="h-12 w-12 rounded-xl object-cover border border-slate-200" />
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-900 font-medium">{{ $alat->kode_alat }}</td>
                            <td class="px-6 py-4 text-sm text-slate-900">{{ $alat->nama_alat }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $alat->kategori }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ 
                                    $alat->status === 'available' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700'
                                }}">
                                    {{ ucfirst($alat->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ ucfirst($alat->kondisi ?? 'baik') }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('kaprog_tkj.show-alat', ['kode_alat' => $alat->kode_alat]) }}" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700 text-sm font-medium">
                                    <i class="fas fa-eye"></i>
                                    Lihat
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-600">
                                <i class="fas fa-inbox text-3xl mb-3 block text-slate-400"></i>
                                Tidak ada data alat
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($alats instanceof \Illuminate\Pagination\Paginator)
            <div class="mt-6">
                {{ $alats->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</div>
@endsection
