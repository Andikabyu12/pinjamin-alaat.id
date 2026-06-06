<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login', ['redirect_to' => request('redirect_to')]);
    }

    public function showAdminLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // prefer intended URL set by auth middleware
            if ($request->filled('redirect_to')) {
                return redirect($request->input('redirect_to'));
            }

            $user = Auth::user();
            switch ($user->role) {
                case 'admin':
                case 'siswa':
                    return redirect()->intended(route('dashboard'));
                case 'wali_kelas':
                    return redirect()->route('wali_kelas.dashboard');
                case 'kaonsli_sij':
                    return redirect()->route('kaonsli_sij.dashboard');
                case 'kaprog_tkj':
                    return redirect()->route('kaprog_tkj.dashboard');
                default:
                    return redirect()->route('dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    public function loginAdmin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $role = $request->input('role', 'admin');
        $remember = $request->filled('remember');

        // Validasi role yang diizinkan
        $allowedRoles = ['admin', 'kaonsli_sij', 'kaprog_tkj', 'wali_kelas'];
        if (!in_array($role, $allowedRoles)) {
            return back()->withErrors(['role' => 'Role tidak valid.']);
        }

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            
            // Cek apakah user memiliki role yang sesuai
            $roleMap = [
                'admin' => 'admin',
                'kakonsli_sija' => 'kakonsli_sij',
                'kaprog_tkj' => 'kaprog_tkj',
                'wali_kelas' => 'wali_kelas'
            ];
            
            $requiredRole = $roleMap[$role] ?? 'admin';
            
            if ($user->role !== $requiredRole) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Email tidak memiliki akses sebagai ' . strtoupper($role) . '.',
                ])->withInput($request->only('email'));
            }   

            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
