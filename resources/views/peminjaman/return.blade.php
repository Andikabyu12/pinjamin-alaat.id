@extends('layouts.app')

@section('content')
<div class="page-shell">
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-24 left-0 w-80 h-80 rounded-full bg-slate-700/30 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 rounded-full bg-cyan-500/10 blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 lg:px-8 relative z-10">
        <div class="mx-auto max-w-3xl panel-card p-8">
            <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between mb-8">
                <div>
                    <p class="text-sm uppercase tracking-[0.2em] text-cyan-300">Pengembalian Alat</p>
                    <h1 class="mt-3 text-3xl font-bold text-white">Unggah Bukti Pengembalian</h1>
                    <p class="mt-2 text-slate-400">Isi data dan catatan saat mengembalikan alat.</p>
                </div>
                <x-back-link fallback="{{ route('peminjaman.index') }}" class="btn-secondary inline-flex items-center rounded-full px-5 py-3 text-sm font-semibold">
                    Kembali ke Daftar
                </x-back-link>
            </div>

            @if(session('success'))
                <div class="mb-6 rounded-3xl border border-emerald-400/30 bg-emerald-500/10 p-4 text-emerald-100">
                    {{ session('success') }}
                </div>
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

            <div class="space-y-6">
                <div class="rounded-3xl border border-slate-700/60 bg-slate-950/80 p-6">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <p class="text-sm uppercase tracking-[0.18em] text-slate-400">No. Peminjaman</p>
                            <p class="mt-2 text-lg font-semibold text-white">{{ $peminjaman->nomor_peminjaman }}</p>
                        </div>
                        <div>
                            <p class="text-sm uppercase tracking-[0.18em] text-slate-400">Alat</p>
                            <p class="mt-2 text-lg font-semibold text-white">{{ $peminjaman->alat?->nama_alat ?? '-' }}</p>
                            <p class="text-sm text-slate-400">{{ $peminjaman->alat?->kode_alat_text ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm uppercase tracking-[0.18em] text-slate-400">Jumlah</p>
                            <p class="mt-2 text-lg font-semibold text-white">{{ $peminjaman->qty }}</p>
                        </div>
                        <div>
                            <p class="text-sm uppercase tracking-[0.18em] text-slate-400">Tanggal Kembali</p>
                            <p class="mt-2 text-lg font-semibold text-white">{{ $peminjaman->return_date ? \Carbon\Carbon::parse($peminjaman->return_date)->format('d M Y') : '-' }}</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('peminjaman.return', $peminjaman->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="rounded-3xl border border-slate-700/60 bg-slate-950/80 p-6">
                        <div class="grid gap-6">
                            <div>
                                <label for="return_description" class="block text-sm font-semibold text-slate-300 mb-2">Deskripsi Pengembalian</label>
                                <textarea id="return_description" name="return_description" rows="4" class="dark-textarea w-full rounded-3xl px-4 py-3 text-slate-100" placeholder="Tambahkan catatan singkat tentang kondisi alat...">{{ old('return_description') }}</textarea>
                            </div>

                            <div>
                                <label for="photo_return" class="block text-sm font-semibold text-slate-300 mb-2">Foto Bukti Pengembalian</label>
                                <input id="photo_return" name="photo_return" type="file" accept="image/*" class="dark-input w-full rounded-3xl px-4 py-3 text-slate-100" />
                                <p class="mt-2 text-sm text-slate-400">Unggah foto saat pengembalian sebagai bukti kondisi atau serah terima.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <x-back-link fallback="{{ route('peminjaman.index') }}" class="btn-secondary px-6 py-3">Batal</x-back-link>
                        <button type="submit" class="btn-primary px-6 py-3">Tandai Sebagai Dikembalikan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection