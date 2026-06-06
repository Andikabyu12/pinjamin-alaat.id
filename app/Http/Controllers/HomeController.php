<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Alat;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            if ($user->role === 'wali_kelas') {
                return $this->waliKelasHome();
            } elseif ($user->role === 'kaonsli_sij') {
                return $this->kaonsliSijHome();
            } elseif ($user->role === 'kaprog_tkj') {
                return $this->kaprogTkjHome();
            } else {
                return redirect()->route('dashboard');
            }
        }

        return view('home');
    }

    public function developers()
    {
        return view('developers');
    }

    private function waliKelasHome()
    {
        $user = auth()->user();
        $major = $user->major;

        $siswaCount = DB::table('users')
            ->where('role', 'siswa')
            ->where('major', $major)
            ->count();

        $peminjamanCount = DB::table('peminjaman')
            ->join('users', 'peminjaman.user_id', '=', 'users.id')
            ->where('users.major', $major)
            ->count();

        $peminjamanPending = DB::table('peminjaman')
            ->join('users', 'peminjaman.user_id', '=', 'users.id')
            ->where('users.major', $major)
            ->where('status', 'pending')
            ->count();

        $peminjamanApproved = DB::table('peminjaman')
            ->join('users', 'peminjaman.user_id', '=', 'users.id')
            ->where('users.major', $major)
            ->where('status', 'approved')
            ->count();

        return view('home', compact('siswaCount', 'peminjamanCount', 'peminjamanPending', 'peminjamanApproved'));
    }

    private function kaonsliSijHome()
    {
        $peminjamanCount = Peminjaman::whereHas('user', function ($q) {
            $q->where('major', 'SIJA');
        })->count();

        $siswaCount = User::where('role', 'siswa')
            ->where('major', 'SIJA')
            ->count();

        $peminjamanPending = Peminjaman::where('status', 'pending')
            ->whereHas('user', function ($q) {
                $q->where('major', 'SIJA');
            })->count();

        $peminjamanApproved = Peminjaman::where('status', 'approved')
            ->whereHas('user', function ($q) {
                $q->where('major', 'SIJA');
            })->count();

        return view('home', compact('peminjamanCount', 'siswaCount', 'peminjamanPending', 'peminjamanApproved'));
    }

    private function kaprogTkjHome()
    {
        $alatCount = Alat::count();
        $alatAvailable = Alat::where('status', 'available')->count();
        $alatUsed = Alat::where('status', 'used')->count();
        
        $peminjamanCount = Peminjaman::whereHas('user', function ($q) {
            $q->where('major', 'TKJ');
        })->count();

        return view('home', compact('alatCount', 'alatAvailable', 'alatUsed', 'peminjamanCount'));
    }
}