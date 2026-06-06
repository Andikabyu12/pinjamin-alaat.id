@extends('layouts.app')

@section('content')
<div class="page-shell">
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-32 right-0 w-80 h-80 rounded-full bg-gradient-to-br from-cyan-500/15 to-transparent blur-3xl"></div>
    </div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="mb-10 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-cyan-300 font-semibold">Edit User</p>
                <h1 class="mt-3 text-4xl font-black text-white">Perbarui Akun</h1>
                <p class="mt-3 text-slate-400">Ubah detail akun pengguna dengan tampilan yang lebih konsisten.</p>
            </div>
            <x-back-link fallback="{{ route('admin.users') }}" class="inline-flex items-center rounded-full border border-slate-700 bg-slate-950/80 px-5 py-3 text-sm font-semibold text-slate-200 hover:bg-slate-900">Kembali ke Users</x-back-link>
        </div>

        <div class="glass-panel p-8 max-w-2xl mx-auto">
            <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-300 mb-2">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="dark-input w-full rounded-2xl px-4 py-3 text-slate-100 @error('name') border-rose-500/70 @enderror" />
                        @error('name')
                            <p class="text-rose-300 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-300 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="dark-input w-full rounded-2xl px-4 py-3 text-slate-100 @error('email') border-rose-500/70 @enderror" />
                        @error('email')
                            <p class="text-rose-300 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-300 mb-2">Role</label>
                        <select name="role" class="dark-select w-full rounded-2xl px-4 py-3 text-slate-100 @error('role') border-rose-500/70 @enderror">
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="siswa" {{ old('role', $user->role) === 'siswa' ? 'selected' : '' }}>Siswa</option>
                            <option value="wali_kelas" {{ old('role', $user->role) === 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
                            <option value="kaonsli_sij" {{ old('role', $user->role) === 'kaonsli_sij' ? 'selected' : '' }}>Kakonsli SIJA</option>
                            <option value="kaprog_tkj" {{ old('role', $user->role) === 'kaprog_tkj' ? 'selected' : '' }}>Kaprog TKJ</option>
                        </select>
                        @error('role')
                            <p class="text-rose-300 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-300 mb-2">Major (Jurusan)</label>
                        <select name="major" class="dark-select w-full rounded-2xl px-4 py-3 text-slate-100 @error('major') border-rose-500/70 @enderror">
                            <option value="">- Pilih Major -</option>
                            <option value="SIJA" {{ old('major', $user->major) === 'SIJA' ? 'selected' : '' }}>SIJA</option>
                            <option value="TKJ" {{ old('major', $user->major) === 'TKJ' ? 'selected' : '' }}>TKJ</option>
                        </select>
                        @error('major')
                            <p class="text-rose-300 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-300 mb-2">NIS (Nomor Induk Siswa)</label>
                        <input type="text" name="nis" value="{{ old('nis', $user->nis) }}"
                            class="dark-input w-full rounded-2xl px-4 py-3 text-slate-100 @error('nis') border-rose-500/70 @enderror" placeholder="Untuk siswa saja" />
                        @error('nis')
                            <p class="text-rose-300 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-300 mb-2">Kelas</label>
                        <select name="kelas" class="dark-select w-full rounded-2xl px-4 py-3 text-slate-100 @error('kelas') border-rose-500/70 @enderror">
                            <option value="">- Pilih Kelas -</option>
                            <option value="10 TKJ 1" {{ old('kelas', $user->kelas) === '10 TKJ 1' ? 'selected' : '' }}>10 TKJ 1</option>
                            <option value="10 TKJ 2" {{ old('kelas', $user->kelas) === '10 TKJ 2' ? 'selected' : '' }}>10 TKJ 2</option>
                            <option value="11 TKJ 1" {{ old('kelas', $user->kelas) === '11 TKJ 1' ? 'selected' : '' }}>11 TKJ 1</option>
                            <option value="11 TKJ 2" {{ old('kelas', $user->kelas) === '11 TKJ 2' ? 'selected' : '' }}>11 TKJ 2</option>
                            <option value="12 TKJ 1" {{ old('kelas', $user->kelas) === '12 TKJ 1' ? 'selected' : '' }}>12 TKJ 1</option>
                            <option value="12 TKJ 2" {{ old('kelas', $user->kelas) === '12 TKJ 2' ? 'selected' : '' }}>12 TKJ 2</option>
                            <option value="10 SIJA 1" {{ old('kelas', $user->kelas) === '10 SIJA 1' ? 'selected' : '' }}>10 SIJA 1</option>
                            <option value="10 SIJA 2" {{ old('kelas', $user->kelas) === '10 SIJA 2' ? 'selected' : '' }}>10 SIJA 2</option>
                            <option value="11 SIJA 1" {{ old('kelas', $user->kelas) === '11 SIJA 1' ? 'selected' : '' }}>11 SIJA 1</option>
                            <option value="11 SIJA 2" {{ old('kelas', $user->kelas) === '11 SIJA 2' ? 'selected' : '' }}>11 SIJA 2</option>
                            <option value="12 SIJA 1" {{ old('kelas', $user->kelas) === '12 SIJA 1' ? 'selected' : '' }}>12 SIJA 1</option>
                            <option value="12 SIJA 2" {{ old('kelas', $user->kelas) === '12 SIJA 2' ? 'selected' : '' }}>12 SIJA 2</option>
                        </select>
                        @error('kelas')
                            <p class="text-rose-300 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Reset Section -->
                    <div class="border-t border-slate-700 pt-6 mt-6">
                        <h3 class="text-base font-semibold text-slate-200 mb-4">Reset Password</h3>
                        <p class="text-sm text-slate-400 mb-4">
                            Untuk alasan keamanan, admin tidak dapat melihat password pengguna. 
                            Gunakan tombol di bawah untuk mereset password ke nilai default.
                        </p>
                        <button type="button" class="btn-secondary px-6 py-3" onclick="confirmPasswordReset()">
                            Reset Password ke Default
                        </button>
                        <p class="text-xs text-slate-500 mt-2">
                            Default password adalah: <code class="bg-slate-800 px-2 py-1 rounded text-amber-300">password</code>
                        </p>
                    </div>
                </div>

                <div class="mt-8 flex flex-wrap gap-4">
                    <button type="submit" class="btn-primary px-6 py-3">Simpan Perubahan</button>
                    <x-back-link fallback="{{ route('admin.users') }}" class="btn-secondary px-6 py-3">Batal</x-back-link>
                </div>
            </form>

            <!-- Hidden form for password reset -->
            <form id="resetPasswordForm" method="POST" action="{{ route('admin.users.reset-password', $user->id) }}" style="display: none;">
                @csrf
                @method('POST')
            </form>
        </div>
    </div>
</div>

<script>
function confirmPasswordReset() {
    if (confirm('Apakah Anda yakin ingin mereset password pengguna ini ke nilai default "password"?')) {
        document.getElementById('resetPasswordForm').submit();
    }
}
</script>
@endsection
