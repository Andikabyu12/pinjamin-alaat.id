@extends('layouts.app')

@section('content')
<div class="page-shell">
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-24 -left-24 w-72 h-72 rounded-full bg-cyan-500/15 blur-3xl"></div>
        <div class="absolute top-1/3 right-0 w-96 h-96 rounded-full bg-purple-500/10 blur-3xl"></div>
    </div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="mb-10 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-cyan-300 font-semibold">Kelola Pengguna</p>
                <h1 class="mt-3 text-4xl font-black text-white">Daftar User</h1>
                <p class="mt-3 text-slate-400">Lihat dan kelola semua akun pengguna sistem secara aman dan cepat.</p>
            </div>
            <x-back-link fallback="{{ route('dashboard') }}" class="inline-flex items-center rounded-full border border-slate-700 bg-slate-950/80 px-5 py-3 text-sm font-semibold text-slate-200 hover:bg-slate-900">Kembali</x-back-link>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-3xl border border-emerald-400/30 bg-emerald-500/10 p-4 text-emerald-100 shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 rounded-3xl border border-red-400/30 bg-red-500/10 p-4 text-red-100 shadow-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="glass-panel p-6 mb-6">
            <form method="GET" action="{{ route('admin.users') }}" class="grid gap-4 md:grid-cols-[1.6fr_1fr_auto] items-end">
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Cari User</label>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama, email, atau NIS..."
                        class="dark-input w-full rounded-2xl px-4 py-3 text-slate-100 placeholder:text-slate-500" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Filter Role</label>
                    <select name="role" class="dark-select w-full rounded-2xl px-4 py-3 text-slate-100">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="siswa" {{ $role === 'siswa' ? 'selected' : '' }}>Siswa</option>
                        <option value="wali_kelas" {{ $role === 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
                        <option value="kaonsli_sij" {{ $role === 'kaonsli_sij' ? 'selected' : '' }}>Kakonsli SIJA</option>
                        <option value="kaprog_tkj" {{ $role === 'kaprog_tkj' ? 'selected' : '' }}>Kaprog TKJ</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary px-6 py-3">Cari</button>
            </form>
        </div>

        <div class="glass-panel overflow-x-auto p-6">
            <table class="table-enhanced min-w-full">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Major</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="font-medium">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="role-badge
                                    @if($user->role === 'admin') bg-red-500/15 text-red-200 border-red-500/20
                                    @elseif($user->role === 'siswa') bg-blue-500/15 text-blue-200 border-blue-500/20
                                    @elseif($user->role === 'wali_kelas') bg-purple-500/15 text-purple-200 border-purple-500/20
                                    @elseif($user->role === 'kaonsli_sij') bg-indigo-500/15 text-indigo-200 border-indigo-500/20
                                    @elseif($user->role === 'kaprog_tkj') bg-emerald-500/15 text-emerald-200 border-emerald-500/20
                                    @else bg-slate-500/15 text-slate-200 border-slate-500/20
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                </span>
                            </td>
                            <td>{{ $user->major ?? '-' }}</td>
                            <td class="space-x-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="inline-flex px-3 py-2 rounded-2xl bg-cyan-600 text-xs font-semibold text-white hover:bg-cyan-500 transition">Edit</a>
                                <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="inline-block" onsubmit="return confirm('Yakin hapus user ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex px-3 py-2 rounded-2xl bg-rose-600 text-xs font-semibold text-white hover:bg-rose-500 transition">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-slate-400 py-6">Tidak ada user ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $users->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
