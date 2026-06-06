@extends('layouts.app')

@section('title', 'Data Peminjaman - Kaprog TKJ')

@section('content')
<div class="container mx-auto px-4">
    <div class="card-soft rounded-2xl p-8 border border-slate-200">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 mb-2">Data Peminjaman</h1>
                <p class="text-slate-600">Monitor semua peminjaman alat TKJ</p>
            </div>
            <a href="{{ route('kaprog_tkj.search-peminjaman') }}" class="inline-flex items-center gap-2 gradient-btn text-white px-6 py-3 rounded-lg hover:shadow-lg transition">
                <i class="fas fa-search"></i>
                Cari Peminjaman
            </a>
        </div>

        <!-- Tabel Peminjaman -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-100 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">No. Peminjaman</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Peminjam</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Alat</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Tanggal Peminjaman</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Status</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-slate-900">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($peminjamans as $peminjaman)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-sm text-slate-900 font-medium">{{ $peminjaman->nomor_peminjaman }}</td>
                            <td class="px-6 py-4 text-sm text-slate-900">{{ $peminjaman->user->name }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $peminjaman->alat?->kode_alat_text ?? $peminjaman->kode_alat ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ 
                                    $peminjaman->status === 'approved' ? 'bg-green-100 text-green-700' :
                                    ($peminjaman->status === 'pending' ? 'bg-yellow-100 text-yellow-700' :
                                    'bg-slate-100 text-slate-700')
                                }}">
                                    {{ ucfirst($peminjaman->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('peminjaman.show', $peminjaman->id) }}" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700 text-sm font-medium">
                                    <i class="fas fa-eye"></i>
                                    Lihat
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-600">
                                <i class="fas fa-inbox text-3xl mb-3 block text-slate-400"></i>
                                Tidak ada data peminjaman
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($peminjamans instanceof \Illuminate\Pagination\Paginator)
            <div class="mt-6">
                {{ $peminjamans->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</div>
@endsection
