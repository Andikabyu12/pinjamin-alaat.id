@extends('layouts.app')

@section('title', 'Detail Siswa - Kakonsli SIJA')

@section('content')
<div class="container mx-auto px-4 py-8">
    <a href="{{ route('kaonsli_sij.siswa') }}" class="text-blue-600 hover:underline mb-4 inline-block">&larr; Kembali ke Data Siswa</a>

    <div class="max-w-3xl mx-auto bg-white border border-slate-200 rounded-lg p-6 shadow-sm">
        <h1 class="text-2xl font-semibold mb-4">Detail Siswa</h1>

        <div class="space-y-4 mb-8">
            <div>
                <p class="text-sm text-slate-600">Nama</p>
                <p class="text-lg font-semibold">{{ $siswa->name }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-600">NIS</p>
                <p class="text-lg font-semibold">{{ $siswa->nis }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-600">Kelas</p>
                <p class="text-lg font-semibold">{{ $siswa->kelas }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-600">Jurusan</p>
                <p class="text-lg font-semibold">{{ $siswa->major ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-600">Email</p>
                <p class="text-lg font-semibold">{{ $siswa->email }}</p>
            </div>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-4">Riwayat Peminjaman</h2>

            <form action="{{ route('kaonsli_sij.show-siswa', $siswa->id) }}" method="GET" class="mb-4">
                <div class="flex gap-2">
                    <input type="text" name="q" value="{{ old('q', $query ?? '') }}" placeholder="Cari nomor, alat, atau status..." class="w-full rounded border border-slate-300 px-3 py-2" />
                    <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white">Cari</button>
                </div>
            </form>

            <table class="w-full border-collapse">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="border p-2 text-left">No.</th>
                        <th class="border p-2 text-left">Alat</th>
                        <th class="border p-2 text-left">Status</th>
                        <th class="border p-2 text-left">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $peminjaman)
                        <tr class="odd:bg-slate-50">
                            <td class="border p-2">{{ $peminjaman->nomor_peminjaman }}</td>
                            <td class="border p-2">{{ $peminjaman->kode_alat }}</td>
                            <td class="border p-2">{{ ucfirst($peminjaman->status) }}</td>
                            <td class="border p-2">{{ $peminjaman->tanggal_peminjaman }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="border p-4 text-center text-slate-600">Tidak ada riwayat peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($peminjamans instanceof \Illuminate\Pagination\Paginator)
                <div class="mt-4">
                    {{ $peminjamans->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
