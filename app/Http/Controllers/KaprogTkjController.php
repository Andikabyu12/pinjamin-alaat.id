<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;

class KaprogTkjController extends Controller
{
    /**
     * Show dashboard for Kaprog TKJ
     */
    public function dashboard()
    {
        $alatCount = Alat::count();
        $alatAvailable = Alat::where('status', 'available')->count();
        $alatUsed = Alat::where('status', 'used')->count();
        $peminjamanCount = Peminjaman::whereHas('user', function ($q) {
            $q->where('major', 'TKJ');
        })->count();

        $peminjamanByClass = Peminjaman::join('users', 'peminjaman.user_id', '=', 'users.id')
            ->where('users.major', 'TKJ')
            ->selectRaw('users.kelas as kelas, count(peminjaman.id) as total')
            ->groupBy('users.kelas')
            ->pluck('total', 'kelas')
            ->toArray();

        return view('kaprog_tkj.dashboard', [
            'alatCount' => $alatCount,
            'alatAvailable' => $alatAvailable,
            'alatUsed' => $alatUsed,
            'peminjamanCount' => $peminjamanCount,
            'peminjamanByClass' => [
                '10' => $peminjamanByClass['10'] ?? 0,
                '11' => $peminjamanByClass['11'] ?? 0,
                '12' => $peminjamanByClass['12'] ?? 0,
            ],
        ]);
    }

    /**
     * View all alat
     */
    public function alat()
    {
        $alats = Alat::paginate(15);
        return view('kaprog_tkj.alat.index', compact('alats'));
    }

    /**
     * Search alat
     */
    public function searchAlat(Request $request)
    {
        $query = trim($request->get('q', ''));
        $alats = Alat::query();

        if ($query !== '') {
            $alats->where(function ($builder) use ($query) {
                $builder->where('nama_alat', 'like', "%{$query}%")
                    ->orWhere('kode_alat_text', 'like', "%{$query}%")
                    ->orWhere('kategori', 'like', "%{$query}%");
            });
        }

        $alats = $alats->paginate(15)->appends(['q' => $query]);

        return view('kaprog_tkj.alat.index', compact('alats', 'query'));
    }

    /**
     * View peminjaman
     */
    public function peminjaman()
    {
        $peminjamans = Peminjaman::with(['user', 'alat'])
            ->whereHas('user', function ($q) {
                $q->where('major', 'TKJ');
            })
            ->paginate(15);

        return view('kaprog_tkj.peminjaman.index', compact('peminjamans'));
    }

    /**
     * Search peminjaman
     */
    public function searchPeminjaman(Request $request)
    {
        $query = $request->get('q');

        $peminjamans = Peminjaman::with(['user', 'alat'])
            ->whereHas('user', function ($q) {
                $q->where('major', 'TKJ');
            })
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('nomor_peminjaman', 'like', "%$query%")
                    ->orWhere('status', 'like', "%$query%")
                    ->orWhereHas('user', function ($q) use ($query) {
                        $q->where('name', 'like', "%$query%");
                    })
                    ->orWhereHas('alat', function ($q) use ($query) {
                        $q->where('nama_alat', 'like', "%$query%")
                          ->orWhere('kode_alat_text', 'like', "%$query%");
                    });
            })
            ->paginate(15);

        return view('kaprog_tkj.peminjaman.index', compact('peminjamans', 'query'));
    }

    /**
     * Show alat detail
     */
    public function showAlat($kode_alat)
    {
        $alat = Alat::where('kode_alat', $kode_alat)->firstOrFail();
        $peminjamanHistory = Peminjaman::where('kode_alat', $kode_alat)
            ->whereHas('user', function ($q) {
                $q->where('major', 'TKJ');
            })
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('kaprog_tkj.alat.show', compact('alat', 'peminjamanHistory'));
    }
}
