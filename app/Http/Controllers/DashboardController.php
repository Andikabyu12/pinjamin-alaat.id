<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'admin':
                return $this->adminDashboard();
            case 'siswa':
                return $this->siswaDashboard();
            case 'wali_kelas':
                return redirect()->route('wali_kelas.dashboard');
            case 'kaonsli_sij':
                return redirect()->route('kaonsli_sij.dashboard');
            case 'kaprog_tkj':
                return redirect()->route('kaprog_tkj.dashboard');
            default:
                abort(403);
        }
    }

    private function adminDashboard()
    {
        return view('dashboard', [
            'totalAlat' => Alat::count(),
            'totalPeminjaman' => Peminjaman::count(),
            'returnedPeminjaman' => Peminjaman::where('status', 'returned')->count(),
            'totalUsers' => User::count(),
            'recentAlats' => Alat::latest()->take(5)->get(),
            'recentPeminjamans' => Peminjaman::with('user', 'alat')->latest()->take(5)->get(),
            'role' => 'admin',
        ]);
    }

    private function siswaDashboard()
    {
        $user = Auth::user();
        $peminjamanQuery = Peminjaman::where('user_id', $user->id);

        $totalUserPeminjamans = $peminjamanQuery->count();
        $pendingPeminjamans = Peminjaman::where('user_id', $user->id)->where('status', 'pending')->count();
        $approvedPeminjamans = Peminjaman::where('user_id', $user->id)->where('status', 'approved')->count();
        $returnedPeminjamans = Peminjaman::where('user_id', $user->id)->where('status', 'returned')->count();
        $activePeminjamans = Peminjaman::where('user_id', $user->id)->whereIn('status', ['pending', 'approved'])->count();

        return view('dashboard', [
            'myPeminjamans' => $peminjamanQuery->with('alat')->latest()->get(),
            'availableAlats' => Alat::where('stok', '>', 0)->get(),
            'totalUserPeminjamans' => $totalUserPeminjamans,
            'pendingPeminjamans' => $pendingPeminjamans,
            'approvedPeminjamans' => $approvedPeminjamans,
            'returnedPeminjamans' => $returnedPeminjamans,
            'activePeminjamans' => $activePeminjamans,
            'role' => 'siswa',
        ]);
    }

    private function waliKelasDashboard()
    {
        $user = Auth::user();
        return [
            'totalAlat' => Alat::count(),
            'peminjamans' => Peminjaman::with('user', 'alat')->whereHas('user', function($q) use ($user) {
                $q->where('major', $user->major);
            })->latest()->get(),
            'role' => 'wali_kelas',
        ];
    }

    private function kakomkalDashboard($major)
    {
        return [
            'totalAlat' => Alat::count(),
            'peminjamans' => Peminjaman::with('user', 'alat')->whereHas('user', function($q) use ($major) {
                $q->where('major', $major);
            })->latest()->get(),
            'alatStats' => Alat::selectRaw('status, count(*) as count')->groupBy('status')->get(),
            'role' => 'kakomkal',
        ];
    }
}
