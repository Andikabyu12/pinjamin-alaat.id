@extends('layouts.app')

@section('title', 'Detail Siswa - Wali Kelas')

@section('content')
<div class="container mx-auto px-4">
    <div class="card-soft rounded-2xl p-8 border border-slate-200">
        <div class="flex items-center gap-4 mb-6">
            <x-back-link fallback="{{ route('wali_kelas.siswa') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-800">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </x-back-link>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 mb-6">Detail Siswa</h1>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">NIS</label>
                        <p class="text-slate-900">{{ $siswa->nis }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                        <p class="text-slate-900">{{ $siswa->name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Email</label>
                        <p class="text-slate-900">{{ $siswa->email }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Kelas</label>
                        <p class="text-slate-900">{{ $siswa->kelas }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Jurusan</label>
                        <p class="text-slate-900">{{ $siswa->major }}</p>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-xl font-bold text-slate-900 mb-6">Riwayat Peminjaman</h2>

                <div class="space-y-4">
                    @php
                        $peminjamans = DB::table('peminjaman')
                            ->join('alats', 'peminjaman.alat_id', '=', 'alats.id')
                            ->where('peminjaman.user_id', $siswa->id)
                            ->select('peminjaman.*', 'alats.nama_alat')
                            ->orderBy('peminjaman.created_at', 'desc')
                            ->limit(5)
                            ->get();
                    @endphp

                    @forelse($peminjamans as $peminjaman)
                        <div class="border border-slate-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-semibold text-slate-900">{{ $peminjaman->nama_alat }}</h3>
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{
                                    $peminjaman->status === 'approved' ? 'bg-green-100 text-green-700' :
                                    ($peminjaman->status === 'pending' ? 'bg-yellow-100 text-yellow-700' :
                                    'bg-slate-100 text-slate-700')
                                }}">
                                    {{ ucfirst($peminjaman->status) }}
                                </span>
                            </div>
                            <p class="text-sm text-slate-600">Tanggal: {{ \Carbon\Carbon::parse($peminjaman->borrowed_at)->format('d/m/Y') }}</p>
                        </div>
                    @empty
                        <p class="text-slate-600">Belum ada riwayat peminjaman</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection