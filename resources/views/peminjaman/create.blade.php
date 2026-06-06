@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12 relative overflow-hidden">
    <!-- Decorative Background -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-40 -right-32 w-96 h-96 rounded-full bg-gradient-to-br from-purple-500/25 to-transparent blur-3xl animate-pulse"></div>
        <div class="absolute top-1/3 -left-32 w-80 h-80 rounded-full bg-gradient-to-br from-blue-500/20 to-transparent blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-72 h-72 rounded-full bg-gradient-to-br from-pink-500/15 to-transparent blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="enhanced-card rounded-3xl bg-gradient-to-br from-slate-900/90 via-slate-900/85 to-slate-950/90 border border-cyan-500/30 p-10 shadow-2xl backdrop-blur-xl mb-10 overflow-hidden">
            <div class="absolute inset-0 opacity-40 pointer-events-none">
                <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-cyan-400/20 to-transparent rounded-full blur-3xl -mr-32 -mt-32"></div>
            </div>
            <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between relative z-10">
                <div>
                    <h1 class="text-5xl font-black text-white drop-shadow-lg flex items-center gap-3"><i class="fas fa-hand-holding-heart text-cyan-400"></i>Ajukan Peminjaman</h1>
                    <p class="mt-3 text-cyan-100 text-lg">Pilih alat dan tentukan jumlah serta tanggal pengembalian untuk peminjaman Anda</p>
                </div>
                <x-back-link fallback="{{ route('peminjaman.index') }}" class="inline-flex items-center rounded-2xl bg-slate-700/50 border border-slate-600 hover:border-slate-500 px-8 py-4 text-white font-semibold transition-all duration-300 hover:bg-slate-700">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </x-back-link>
            </div>
        </div>

        @if($errors->any())
            <div class="mb-8 rounded-2xl border border-red-500/50 bg-gradient-to-br from-red-500/20 to-red-600/10 p-6 text-red-200 font-medium shadow-lg mb-8 flex items-start gap-3">
                <i class="fas fa-exclamation-triangle text-red-400 text-xl mt-1 flex-shrink-0"></i>
                <div>
                    <h3 class="mb-3 font-bold text-red-100">Terjadi kesalahan:</h3>
                    <ul class="list-disc space-y-2 pl-5">
                        @foreach($errors->all() as $error)
                            <li class="text-sm">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if($alats->count() > 0)
            <div class="mb-10 glass-panel p-8 overflow-hidden relative">
                <div class="absolute inset-0 opacity-25 pointer-events-none">
                    <div class="absolute -top-20 right-0 w-60 h-60 bg-gradient-to-br from-emerald-400/20 to-transparent rounded-full blur-3xl"></div>
                </div>
                <div class="relative z-10 flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-3xl font-black text-white flex items-center gap-3"><i class="fas fa-box text-emerald-400"></i>Alat Siap Dipinjam</h2>
                        <p class="mt-3 text-slate-300 text-sm max-w-2xl">Pilih alat kemudian gunakan tombol di bawah setiap kartu untuk otomatis mengisi kode alat pada form peminjaman.</p>
                    </div>
                    <div class="rounded-3xl border border-emerald-500/20 bg-emerald-500/10 px-6 py-4 text-center">
                        <p class="text-xs uppercase tracking-[0.24em] text-emerald-200">Tersedia</p>
                        <p class="mt-2 text-3xl font-extrabold text-white">{{ $alats->count() }}</p>
                    </div>
                </div>

                <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($alats as $alat)
                        <div class="relative overflow-hidden rounded-3xl border border-slate-700/50 bg-slate-950/80 p-6 shadow-2xl transition-all duration-300 hover:-translate-y-1 hover:border-cyan-500/40 hover:bg-slate-900/90 group">
                            @if(isset($alat->gambar) && $alat->gambar && file_exists(public_path('uploads/alats/' . $alat->gambar)))
                                <div class="overflow-hidden rounded-3xl bg-slate-900 mb-4 h-40">
                                    <img src="{{ asset('uploads/alats/' . $alat->gambar) }}" alt="{{ $alat->nama_alat }}" class="h-full w-full object-cover object-center transition duration-500 group-hover:scale-110">
                                </div>
                            @else
                                <div class="overflow-hidden rounded-3xl bg-slate-900 mb-4 h-40 flex items-center justify-center">
                                    <i class="fas fa-image text-slate-600 text-4xl"></i>
                                </div>
                            @endif
                            <div class="flex items-start justify-between gap-2 mb-4">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Kode Alat</p>
                                    <p class="mt-1 text-sm font-semibold text-cyan-300">{{ $alat->kode_alat_text ?? $alat->kode_alat }}</p>
                                </div>
                                <div class="rounded-2xl bg-emerald-500/15 border border-emerald-500/30 px-3 py-1.5 text-xs font-semibold text-emerald-200">Stok {{ $alat->stok_baik ?? $alat->stok }}</div>
                            </div>
                            <p class="text-lg font-bold text-white mb-2">{{ $alat->nama_alat }}</p>
                            @if($alat->deskripsi)
                                <p class="text-sm text-slate-300 line-clamp-2 mb-4">{{ $alat->deskripsi }}</p>
                            @else
                                <p class="text-sm text-slate-400 italic mb-4">Tidak ada deskripsi tersedia</p>
                            @endif
                            <a href="{{ route('peminjaman.create', ['alat_id' => $alat->kode_alat_text ?? $alat->kode_alat]) }}" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-cyan-500/40 bg-cyan-500/10 px-4 py-3 text-sm font-bold text-cyan-200 transition duration-300 hover:bg-cyan-500/20">
                                <i class="fas fa-hand-holding"></i>Pinjam
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            @php
                $selectedValue = old('alat_id', $selectedAlat ?? '');
                $selectedLatitude = old('latitude', request('latitude'));
                $selectedLongitude = old('longitude', request('longitude'));
                $selectedAccuracy = old('accuracy', request('accuracy'));
            @endphp
            <div class="form-card p-8 overflow-hidden relative">
                <div class="absolute inset-0 opacity-20 pointer-events-none">
                    <div class="absolute -bottom-20 left-0 w-80 h-80 bg-gradient-to-br from-blue-400/15 to-transparent rounded-full blur-3xl"></div>
                </div>
                <h2 class="text-2xl font-bold text-white mb-6 relative z-10 flex items-center gap-2"><i class="fas fa-clipboard-list text-blue-400"></i>Detail Peminjaman</h2>

                <div class="mb-6 rounded-2xl border border-slate-700/40 bg-slate-900/70 p-4">
                    <h3 class="text-sm font-bold text-white mb-2">Pilih Lokasi</h3>
                    <p class="text-xs text-slate-400 mb-3">Buka peta besar untuk memilih lokasi bila belum terisi.</p>
                    <div class="flex flex-col gap-4">
                        <a href="{{ route('peminjaman.location', ['alat_id' => $selectedValue, 'borrow_date' => old('borrow_date', request('borrow_date', date('Y-m-d'))), 'return_date' => old('return_date', request('return_date', date('Y-m-d'))) ]) }}" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-500 transition">
                            <i class="fas fa-map-marker-alt"></i>Set Lokasi di Peta
                        </a>
                        @if($selectedLatitude && $selectedLongitude)
                            <div class="rounded-2xl border border-slate-700/50 bg-slate-950/80 p-4 text-slate-200">
                                <p class="text-sm font-semibold">Lokasi terpilih</p>
                                <p class="text-xs mt-2">Lat: {{ $selectedLatitude }} | Lng: {{ $selectedLongitude }} | Akurasi: {{ $selectedAccuracy ?? 'N/A' }} m</p>
                            </div>
                        @else
                            <div class="rounded-2xl border border-amber-500/30 bg-amber-500/10 p-4 text-amber-100">
                                <p class="text-sm">Lokasi belum dipilih. Tekan tombol "Set Lokasi di Peta" untuk memilih lokasi Anda.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <form action="{{ route('peminjaman.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 relative z-10" id="peminjamanForm">
                    @csrf
                    <input type="hidden" name="latitude" id="latitude" value="{{ $selectedLatitude }}">
                    <input type="hidden" name="longitude" id="longitude" value="{{ $selectedLongitude }}">
                    <input type="hidden" name="accuracy" id="accuracy" value="{{ $selectedAccuracy }}">
                    <div>
                        <label for="borrow_date" class="block text-sm font-bold text-slate-200 mb-3 uppercase tracking-wider">Tanggal Pinjam <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <span class="input-icon"><i class="fas fa-calendar-day"></i></span>
                            <input type="date" id="borrow_date" name="borrow_date" value="{{ old('borrow_date', date('Y-m-d')) }}" class="w-full rounded-2xl bg-slate-800/60 border border-slate-700/60 pl-14 pr-4 py-3.5 text-slate-100 placeholder-slate-500 transition-all duration-300 focus:border-blue-500/70 focus:bg-slate-800/90 focus:ring-2 focus:ring-blue-500/30 focus:outline-none shadow-inner @error('borrow_date') border-red-500/70 @enderror" required />
                        </div>
                        @error('borrow_date')
                            <p class="mt-1 text-sm text-red-400 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="photo_borrow" class="block text-sm font-bold text-slate-200 mb-3 uppercase tracking-wider">Upload Foto (Opsional)</label>
                        <div class="relative">
                            <input type="file" id="photo_borrow" name="photo_borrow" accept="image/*" class="w-full rounded-2xl bg-slate-800/60 border border-slate-700/60 px-4 py-3.5 text-slate-100 placeholder-slate-500 transition-all duration-300 focus:border-blue-500/70 focus:bg-slate-800/90 focus:ring-2 focus:ring-blue-500/30 focus:outline-none shadow-inner" />
                        </div>
                        @error('photo_borrow')
                            <p class="mt-1 text-sm text-red-400 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="alat_id" class="block text-sm font-bold text-slate-200 mb-3 uppercase tracking-wider">Kode Alat <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <span class="input-icon"><i class="fas fa-barcode"></i></span>
                            <input type="text" id="alat_id" name="alat_id" value="{{ old('alat_id', $selectedValue) }}" class="w-full rounded-2xl bg-slate-800/60 border border-slate-700/60 pl-14 pr-4 py-3.5 text-slate-100 placeholder-slate-500 transition-all duration-300 focus:border-blue-500/70 focus:bg-slate-800/90 focus:ring-2 focus:ring-blue-500/30 focus:outline-none shadow-inner @error('alat_id') border-red-500/70 @enderror" required placeholder="Contoh: A-001" />
                        </div>
                        <p class="mt-2 text-xs text-slate-400">Masukkan kode alat yang tersedia. Kode dapat dilihat di daftar alat di atas.</p>
                        @error('alat_id')
                            <p class="mt-1 text-sm text-red-400 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="qty" class="block text-sm font-bold text-slate-200 mb-3 uppercase tracking-wider">Jumlah <span class="text-red-400">*</span></label>
                            <div class="relative">
                                <span class="input-icon"><i class="fas fa-boxes"></i></span>
                                <input type="number" id="qty" name="qty" min="1" value="{{ old('qty', 1) }}" class="w-full rounded-2xl bg-slate-800/60 border border-slate-700/60 pl-14 pr-4 py-3.5 text-slate-100 placeholder-slate-500 transition-all duration-300 focus:border-blue-500/70 focus:bg-slate-800/90 focus:ring-2 focus:ring-blue-500/30 focus:outline-none shadow-inner @error('qty') border-red-500/70 @enderror" required />
                            </div>
                            <p id="qtyError" class="mt-2 text-sm text-red-400 hidden flex items-center gap-1"><i class="fas fa-exclamation-circle"></i><span id="qtyErrorMsg"></span></p>
                            @error('qty')
                                <p class="mt-1 text-sm text-red-400 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="return_date" class="block text-sm font-bold text-slate-200 mb-3 uppercase tracking-wider">Tanggal Pengembalian <span class="text-red-400">*</span></label>
                            <div class="relative">
                                <span class="input-icon"><i class="fas fa-calendar"></i></span>
                                <input type="date" id="return_date" name="return_date" value="{{ old('return_date', date('Y-m-d')) }}" class="w-full rounded-2xl bg-slate-800/60 border border-slate-700/60 pl-14 pr-4 py-3.5 text-slate-100 placeholder-slate-500 transition-all duration-300 focus:border-blue-500/70 focus:bg-slate-800/90 focus:ring-2 focus:ring-blue-500/30 focus:outline-none shadow-inner @error('return_date') border-red-500/70 @enderror" required />
                            </div>
                            <p class="mt-2 text-xs text-slate-400">Tanggal harus hari ini atau setelahnya</p>
                            @error('return_date')
                                <p class="mt-1 text-sm text-red-400 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="rounded-xl border border-cyan-500/30 bg-gradient-to-r from-cyan-500/15 to-blue-500/10 p-4">
                        <p class="text-sm text-cyan-200"><span class="font-bold">ℹ️ Informasi:</span> Peminjaman akan langsung disetujui dan dapat digunakan tanpa menunggu persetujuan tambahan dari admin.</p>
                    </div>

                    <div class="flex flex-wrap gap-3 pt-4">
                        <button type="submit" class="inline-flex items-center rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 px-8 py-3.5 text-base font-bold text-white shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed gap-2" id="submitBtn">
                            <i class="fas fa-hand-holding-heart"></i><span>Pinjam Sekarang</span>
                        </button>
                        <x-back-link fallback="{{ route('peminjaman.index') }}" class="inline-flex items-center rounded-xl bg-slate-700/50 border border-slate-600 hover:border-slate-500 px-8 py-3.5 text-base font-bold text-white transition-all duration-300 gap-2">
                            <i class="fas fa-times"></i>Batal
                        </x-back-link>
                    </div>
                </form>
            </div>
        @else
            <div class="enhanced-card rounded-3xl border border-yellow-500/30 bg-gradient-to-br from-yellow-500/15 to-yellow-600/10 p-10 text-center shadow-lg">
                <div class="flex flex-col items-center">
                    <i class="fas fa-inbox text-5xl text-yellow-400 mb-4"></i>
                    <h3 class="text-xl font-bold text-yellow-200 mb-2">Tidak Ada Alat Tersedia</h3>
                    <p class="text-yellow-100">Silakan minta admin untuk menambahkan alat terlebih dahulu. Coba kembali nanti.</p>
                </div>
            </div>
        @endif

        <script>
            const today = new Date();
            document.getElementById('return_date').min = today.toISOString().split('T')[0];
        </script>
    </div>
</div>
@endsection
