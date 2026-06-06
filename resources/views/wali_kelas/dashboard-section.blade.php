<div class="container mx-auto px-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Header -->
        <div class="md:col-span-2">
            <h1 class="text-3xl font-bold text-slate-900 mb-2">Dashboard Wali Kelas</h1>
            <p class="text-slate-600">Kelola siswa dan peminjaman untuk jurusan {{ auth()->user()->major }}</p>
        </div>

        <!-- Card Statistik -->
        <div class="card-soft rounded-2xl p-6 border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-600 text-sm mb-1">Total Siswa</p>
                    <h3 class="text-3xl font-bold text-slate-900">{{ $siswaCount ?? 0 }}</h3>
                </div>
                <div class="bg-blue-100 rounded-full p-4">
                    <i class="fas fa-users text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="card-soft rounded-2xl p-6 border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-600 text-sm mb-1">Total Peminjaman</p>
                    <h3 class="text-3xl font-bold text-slate-900">{{ $peminjamanCount ?? 0 }}</h3>
                </div>
                <div class="bg-green-100 rounded-full p-4">
                    <i class="fas fa-hand-holding-box text-2xl text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="card-soft rounded-2xl p-6 border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-600 text-sm mb-1">Peminjaman Pending</p>
                    <h3 class="text-3xl font-bold text-slate-900">{{ $peminjamanPending ?? 0 }}</h3>
                </div>
                <div class="bg-yellow-100 rounded-full p-4">
                    <i class="fas fa-hourglass-end text-2xl text-yellow-600"></i>
                </div>
            </div>
        </div>

        <div class="card-soft rounded-2xl p-6 border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-600 text-sm mb-1">Peminjaman Disetujui</p>
                    <h3 class="text-3xl font-bold text-slate-900">{{ $peminjamanApproved ?? 0 }}</h3>
                </div>
                <div class="bg-emerald-100 rounded-full p-4">
                    <i class="fas fa-check-circle text-2xl text-emerald-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Cepat -->
    <div class="card-soft rounded-2xl p-8 border border-slate-200 mb-8">
        <h2 class="text-xl font-bold text-slate-900 mb-6">Menu Cepat</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('wali_kelas.siswa') }}" class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 p-6 text-white transition hover:shadow-lg">
                <div class="relative z-10">
                    <i class="fas fa-users text-3xl mb-3 block"></i>
                    <h3 class="text-lg font-semibold">Lihat Siswa</h3>
                    <p class="text-blue-100 text-sm mt-1">Kelola siswa jurusan {{ auth()->user()->major }}</p>
                </div>
                <div class="absolute inset-0 bg-white opacity-0 transition group-hover:opacity-10"></div>
            </a>

            <a href="{{ route('wali_kelas.search-siswa') }}" class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 p-6 text-white transition hover:shadow-lg">
                <div class="relative z-10">
                    <i class="fas fa-search text-3xl mb-3 block"></i>
                    <h3 class="text-lg font-semibold">Cari Siswa</h3>
                    <p class="text-purple-100 text-sm mt-1">Temukan siswa dengan cepat</p>
                </div>
                <div class="absolute inset-0 bg-white opacity-0 transition group-hover:opacity-10"></div>
            </a>

            <a href="{{ route('wali_kelas.peminjaman') }}" class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 p-6 text-white transition hover:shadow-lg">
                <div class="relative z-10">
                    <i class="fas fa-hand-holding-box text-3xl mb-3 block"></i>
                    <h3 class="text-lg font-semibold">Lihat Peminjaman</h3>
                    <p class="text-emerald-100 text-sm mt-1">Pantau peminjaman alat</p>
                </div>
                <div class="absolute inset-0 bg-white opacity-0 transition group-hover:opacity-10"></div>
            </a>

            <a href="{{ route('wali_kelas.search-peminjaman') }}" class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 p-6 text-white transition hover:shadow-lg">
                <div class="relative z-10">
                    <i class="fas fa-search text-3xl mb-3 block"></i>
                    <h3 class="text-lg font-semibold">Cari Peminjaman</h3>
                    <p class="text-orange-100 text-sm mt-1">Temukan peminjaman dengan cepat</p>
                </div>
                <div class="absolute inset-0 bg-white opacity-0 transition group-hover:opacity-10"></div>
            </a>
        </div>
    </div>
</div>
