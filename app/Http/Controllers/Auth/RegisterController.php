<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    private function adminExists()
    {
        return User::where('role', 'admin')->exists();
    }

    public function showRegistrationForm()
    {
        if (User::count() === 0) {
            return view('auth.register-first-admin');
        }

        return view('auth.register', [
            'adminExists' => $this->adminExists(),
        ]);
    }

    public function register(Request $request)
    {
        if (User::count() === 0) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'role' => 'admin',
                'major' => null,
                'nis' => null,
                'kelas' => null,
                'password' => Hash::make($request->input('password')),
            ]);

            return redirect()->route('login')->with('success', 'Admin pertama berhasil dibuat! Silakan login.');
        }

        $role = $request->input('role');

        if ($role === 'admin' && $this->adminExists()) {
            return back()->with('error', 'Hanya boleh ada satu akun admin di sistem.')->withInput();
        }

        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'role' => 'required|string|in:siswa,admin,wali_kelas,kaonsli_sij,kaprog_tkj',
            'password' => 'required|string|min:6|confirmed',
        ];

        if ($role === 'siswa') {
            $rules = array_merge($rules, [
                'nis' => 'required|string|max:50|unique:users,nis',
                'kelas' => 'required|string|in:10 TKJ 1,10 TKJ 2,11 TKJ 1,11 TKJ 2,12 TKJ 1,12 TKJ 2,10 SIJA 1,10 SIJA 2,11 SIJA 1,11 SIJA 2,12 SIJA 1,12 SIJA 2',
                'major' => 'required|string|in:SIJA,TKJ',
            ]);
        } elseif ($role === 'wali_kelas') {
            $rules = array_merge($rules, [
                'major' => 'required|string|in:SIJA,TKJ',
                'kelas' => 'required|string|in:10 TKJ 1,10 TKJ 2,11 TKJ 1,11 TKJ 2,12 TKJ 1,12 TKJ 2,10 SIJA 1,10 SIJA 2,11 SIJA 1,11 SIJA 2,12 SIJA 1,12 SIJA 2',
            ]);
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $userData = [
            'name' => trim($request->input('first_name') . ' ' . $request->input('last_name')),
            'email' => $request->input('email'),
            'role' => $role,
            'password' => Hash::make($request->input('password')),
            'nis' => null,
            'kelas' => null,
            'major' => null,
        ];

        if ($role === 'siswa') {
            $userData['nis'] = $request->input('nis');
            $userData['kelas'] = $request->input('kelas');
            $userData['major'] = $request->input('major');
        } elseif ($role === 'wali_kelas') {
            $userData['kelas'] = $request->input('kelas');
            $userData['major'] = $request->input('major');
        } elseif ($role === 'kaonsli_sij') {
            $userData['major'] = 'SIJA';
        } elseif ($role === 'kaprog_tkj') {
            $userData['major'] = 'TKJ';
        }

        User::create($userData);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login dengan akun Anda.');
    }

    public function showAdminRegistrationForm()
    {
        if ($this->adminExists()) {
            return redirect()->route('dashboard')->with('error', 'Hanya boleh ada satu akun admin di sistem.');
        }

        return view('auth.register-admin');
    }

    public function registerAdmin(Request $request)
    {
        if ($this->adminExists()) {
            return back()->with('error', 'Hanya boleh ada satu akun admin di sistem.')->withInput();
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'role' => 'required|string|in:admin',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => 'admin',
            'major' => null,
            'nis' => null,
            'kelas' => null,
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect()->route('login')->with('success', 'Admin baru berhasil didaftarkan. Silakan login.');
    }

    public function showKaonsliSijForm()
    {
        return view('auth.register-kaonsli-sij');
    }

    public function registerKaonsliSij(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => 'kaonsli_sij',
            'major' => 'SIJA',
            'nis' => null,
            'kelas' => null,
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran Kakonsli SIJA berhasil! Silakan login dengan akun Anda.');
    }

    public function showWaliKelasForm()
    {
        return view('auth.register-wali-kelas');
    }

    public function registerWaliKelas(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'major' => 'required|string|in:SIJA,TKJ',
            'kelas' => 'required|string|in:10 TKJ 1,10 TKJ 2,11 TKJ 1,11 TKJ 2,12 TKJ 1,12 TKJ 2,10 SIJA 1,10 SIJA 2,11 SIJA 1,11 SIJA 2,12 SIJA 1,12 SIJA 2',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => 'wali_kelas',
            'major' => $request->input('major'),
            'nis' => null,
            'kelas' => $request->input('kelas'),
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran Wali Kelas berhasil! Silakan login dengan akun Anda.');
    }

    public function showKaprogTkjForm()
    {
        return view('auth.register-kaprog-tkj');
    }

    public function registerKaprogTkj(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => 'kaprog_tkj',
            'major' => 'TKJ',
            'nis' => null,
            'kelas' => null,
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran Kaprog TKJ berhasil! Silakan login dengan akun Anda.');
    }
}
