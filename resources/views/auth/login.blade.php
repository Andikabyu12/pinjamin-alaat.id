@extends('layouts.app')

@section('title', 'Masuk - Peminjaman Alat TI')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 sm:px-6 py-12">
    <!-- Decorative Background -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-32 -right-32 w-80 h-80 rounded-full bg-gradient-to-br from-cyan-500/20 to-transparent blur-3xl animate-pulse"></div>
        <div class="absolute top-1/2 -left-40 w-96 h-96 rounded-full bg-gradient-to-br from-purple-500/15 to-transparent blur-3xl"></div>
        <div class="absolute bottom-0 right-1/3 w-72 h-72 rounded-full bg-gradient-to-br from-blue-500/10 to-transparent blur-3xl"></div>
    </div>

    <div class="w-full max-w-5xl rounded-3xl overflow-hidden relative z-10 animation-fadeInUp">
        <div class="grid gap-0 md:grid-cols-[1fr_1fr]">
            <!-- Left: Form -->
            <div class="p-8 sm:p-12 lg:p-16 bg-gradient-to-br from-slate-900 via-slate-950 to-slate-900 border border-cyan-500/20 rounded-l-3xl">
                <div class="space-y-8">
                    <!-- Header -->
                    <div class="space-y-2">
                        <p class="text-xs uppercase tracking-[0.2em] font-bold text-cyan-300">Welcome Back</p>
                        <h2 class="text-4xl sm:text-5xl font-black text-white drop-shadow-lg">Selamat Datang!</h2>
                        <p class="text-slate-400 text-sm mt-3">Masuk ke akun Anda untuk mengakses sistem peminjaman alat TI</p>
                    </div>

                    <!-- Form -->
                    <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                        @csrf

                        @if(session('success'))
                            <div class="rounded-xl bg-emerald-500/10 border border-emerald-500/30 p-4 text-emerald-200 text-sm flex items-center gap-3 animation-fadeInUp">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="rounded-xl bg-red-500/10 border border-red-500/30 p-4 text-red-200 text-sm flex items-center gap-3 animation-fadeInUp">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $errors->first() }}</span>
                            </div>
                        @endif

                        <!-- Email Input -->
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-[0.15em] text-slate-300">Email Address</label>
                            <div class="relative group">
                                <div class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-purple-500 rounded-xl blur opacity-0 group-focus-within:opacity-20 transition-opacity duration-300"></div>
                                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                       class="relative w-full rounded-xl border border-slate-700/60 bg-slate-800/50 px-4 py-3 text-white placeholder-slate-500 transition-all duration-300 focus:border-cyan-500/70 focus:bg-slate-800/80 focus:ring-2 focus:ring-cyan-500/30 focus:outline-none">
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-[0.15em] text-slate-300">Password</label>
                            <div class="relative group">
                                <div class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-purple-500 rounded-xl blur opacity-0 group-focus-within:opacity-20 transition-opacity duration-300"></div>
                                <div class="relative">
                                    <input type="password" name="password" required id="password"
                                           class="relative w-full rounded-xl border border-slate-700/60 bg-slate-800/50 px-4 py-3 text-white placeholder-slate-500 transition-all duration-300 focus:border-cyan-500/70 focus:bg-slate-800/80 focus:ring-2 focus:ring-cyan-500/30 focus:outline-none">
                                    <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-cyan-400 transition-colors">
                                        <i class="fas fa-eye" id="toggle-icon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Remember & Forgot -->
                        <div class="flex items-center justify-between gap-4 flex-wrap">
                            <label class="flex items-center gap-2 text-sm text-slate-300 hover:text-white transition-colors cursor-pointer">
                                <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-600 bg-slate-800 accent-cyan-500">
                                <span>Ingat saya</span>
                            </label>
                            <a href="{{ route('password.forgot') }}" class="text-sm text-cyan-400 hover:text-cyan-300 transition-colors font-semibold">Lupa Password?</a>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white py-3 font-bold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 flex items-center justify-center gap-2">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Masuk</span>
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="flex items-center gap-3 mt-6">
                        <div class="flex-1 h-px bg-gradient-to-r from-slate-700 to-transparent"></div>
                        <div class="text-xs text-slate-400 uppercase tracking-widest">Atau lanjutkan dengan</div>
                        <div class="flex-1 h-px bg-gradient-to-l from-slate-700 to-transparent"></div>
                    </div>

                    <!-- Register Link -->
                    <p class="text-center text-sm text-slate-400">
                        Belum punya akun?
                        <a href="{{ route('register', ['redirect_to' => $redirect_to ?? '']) }}" class="font-bold text-cyan-400 hover:text-cyan-300 transition-colors">Daftar di sini</a>
                    </p>
                </div>
            </div>

            <!-- Right: Illustration (Hidden on Mobile) -->
            <div class="hidden md:flex items-center justify-center bg-gradient-to-br from-slate-900 via-blue-900/40 to-purple-900/30 p-12 border border-cyan-500/20 rounded-r-3xl relative overflow-hidden">
                <!-- Animated background elements -->
                <div class="absolute inset-0 pointer-events-none">
                    <div class="absolute top-1/4 right-1/4 w-40 h-40 rounded-full bg-cyan-500/10 blur-3xl animate-pulse" style="animation-delay: 0s;"></div>
                    <div class="absolute bottom-1/4 left-1/4 w-40 h-40 rounded-full bg-purple-500/10 blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
                </div>

                <!-- Illustration Content -->
                <div class="relative z-10 text-center space-y-6">
                    <div class="relative inline-block">
                        <div class="absolute inset-0 bg-gradient-to-br from-cyan-500 to-purple-500 rounded-full blur-2xl opacity-40"></div>
                        <div class="relative bg-gradient-to-br from-cyan-500 to-blue-600 rounded-full p-8 text-white shadow-2xl">
                            <i class="fas fa-lock-open text-4xl"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-white mb-2">Akses Aman</h3>
                        <p class="text-slate-300 text-sm max-w-xs mx-auto">Sistem peminjaman alat TI dengan keamanan tingkat lanjut untuk melindungi data Anda.</p>
                    </div>
                    <div class="space-y-3 pt-4">
                        <div class="flex items-center gap-3 text-slate-300 text-sm">
                            <div class="flex-shrink-0 h-2 w-2 rounded-full bg-cyan-400"></div>
                            <span>Verifikasi akun yang ketat</span>
                        </div>
                        <div class="flex items-center gap-3 text-slate-300 text-sm">
                            <div class="flex-shrink-0 h-2 w-2 rounded-full bg-cyan-400"></div>
                            <span>Kontrol akses berbasis peran</span>
                        </div>
                        <div class="flex items-center gap-3 text-slate-300 text-sm">
                            <div class="flex-shrink-0 h-2 w-2 rounded-full bg-cyan-400"></div>
                            <span>Enkripsi data lengkap</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordField = document.getElementById('password');
    const toggleIcon = document.getElementById('toggle-icon');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}
</script>

<style>
.animation-fadeInUp {
    animation: fadeInUp 0.6s ease both;
}
</style>
@endsection
