@extends('layouts.app')

@section('title', 'Detail Alat - Kaprog TKJ')

@section('content')
<div class="container mx-auto px-4">
    <div class="mb-6">
        <x-back-link fallback="{{ route('kaprog_tkj.alat') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Data Alat
        </x-back-link>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Info Alat -->
        <div class="md:col-span-1">
            <div class="card-soft rounded-2xl p-6 border border-slate-200">
                <div class="text-center mb-6">
                    @php
                        $imageUrl = $alat->gambar && file_exists(public_path('uploads/alats/' . $alat->gambar))
                            ? asset('uploads/alats/' . $alat->gambar)
                            : asset('images/PINJAMIN.ID.png');
                    @endphp
                    <div class="mx-auto mb-5 h-48 w-48 overflow-hidden rounded-3xl border border-slate-200 bg-slate-100">
                        <img src="{{ $imageUrl }}" alt="{{ $alat->nama_alat }}" class="h-full w-full object-cover" />
                    </div>
                    <h2 class="text-xl font-bold text-slate-900">{{ $alat->nama_alat }}</h2>
                    <p class="text-slate-600 text-sm">{{ $alat->kode_alat }}</p>
                </div>

                <div class="space-y-4">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Kode Alat</p>
                        <p class="text-slate-900 font-semibold">{{ $alat->kode_alat }}</p>
                    </div>
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Kategori</p>
                        <p class="text-slate-900 font-semibold">{{ $alat->kategori }}</p>
                    </div>
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Status</p>
                        <p class="text-slate-900 font-semibold">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ 
                                $alat->status === 'available' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700'
                            }}">
                                {{ ucfirst($alat->status) }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Kondisi</p>
                        <p class="text-slate-900 font-semibold">{{ ucfirst($alat->kondisi ?? 'baik') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Peminjaman -->
        <div class="md:col-span-2">
            <div class="card-soft rounded-2xl p-6 border border-slate-200">
                <h3 class="text-xl font-bold text-slate-900 mb-6">Riwayat Peminjaman</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-100 border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-slate-900">No. Peminjaman</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-900">Nama Peminjam</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-900">Tanggal</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-900">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse($peminjamanHistory as $peminjaman)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-4 py-3 text-slate-900 font-medium">{{ $peminjaman->nomor_peminjaman }}</td>
                                    <td class="px-4 py-3 text-slate-600">{{ $peminjaman->user->name }}</td>
                                    <td class="px-4 py-3 text-slate-600">{{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ 
                                            $peminjaman->status === 'approved' ? 'bg-green-100 text-green-700' :
                                            ($peminjaman->status === 'pending' ? 'bg-yellow-100 text-yellow-700' :
                                            'bg-slate-100 text-slate-700')
                                        }}">
                                            {{ ucfirst($peminjaman->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-slate-600">
                                        Tidak ada riwayat peminjaman
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($peminjamanHistory instanceof \Illuminate\Pagination\Paginator)
                    <div class="mt-4">
                        {{ $peminjamanHistory->links('pagination::tailwind') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
