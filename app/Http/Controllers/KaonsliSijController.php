<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;

class KaonsliSijController extends Controller
{
    /**
     * Show dashboard for Kaonsli Sij
     */
    public function dashboard()
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

        $peminjamanByClass = Peminjaman::join('users', 'peminjaman.user_id', '=', 'users.id')
            ->where('users.major', 'SIJA')
            ->selectRaw('users.kelas as kelas, count(peminjaman.id) as total')
            ->groupBy('users.kelas')
            ->pluck('total', 'kelas')
            ->toArray();

        return view('kaonsli_sij.dashboard', [
            'peminjamanCount' => $peminjamanCount,
            'siswaCount' => $siswaCount,
            'peminjamanPending' => $peminjamanPending,
            'peminjamanApproved' => $peminjamanApproved,
            'peminjamanByClass' => [
                '10' => $peminjamanByClass['10'] ?? 0,
                '11' => $peminjamanByClass['11'] ?? 0,
                '12' => $peminjamanByClass['12'] ?? 0,
            ],
        ]);
    }

    /**
     * View all peminjaman
     */
    public function peminjaman()
    {
        $peminjamans = Peminjaman::with(['user', 'alat'])
            ->whereHas('user', function ($q) {
                $q->where('major', 'SIJA');
            })
            ->paginate(15);

        return view('kaonsli_sij.peminjaman.index', compact('peminjamans'));
    }

    /**
     * Search peminjaman
     */
    public function searchPeminjaman(Request $request)
    {
        $query = $request->get('q');

        $peminjamans = Peminjaman::with(['user', 'alat'])
            ->whereHas('user', function ($q) {
                $q->where('major', 'SIJA');
            })
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('nomor_peminjaman', 'like', "%$query%")
                    ->orWhere('status', 'like', "%$query%")
                    ->orWhereHas('user', function ($q) use ($query) {
                        $q->where('name', 'like', "%$query%")
                          ->orWhere('nis', 'like', "%$query%");
                    })
                    ->orWhereHas('alat', function ($q) use ($query) {
                        $q->where('nama_alat', 'like', "%$query%")
                          ->orWhere('kode_alat_text', 'like', "%$query%");
                    });
            })
            ->paginate(15);

        return view('kaonsli_sij.peminjaman.index', compact('peminjamans', 'query'));
    }

    /**
     * View all siswa
     */
    public function siswa()
    {
        $siswas = User::where('role', 'siswa')
            ->where('major', 'SIJA')
            ->paginate(15);

        return view('kaonsli_sij.siswa.index', compact('siswas'));
    }

    /**
     * Search siswa
     */
    public function searchSiswa(Request $request)
    {
        $query = $request->get('q');

        $siswas = User::where('role', 'siswa')
            ->where('major', 'SIJA')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%$query%")
                  ->orWhere('nis', 'like', "%$query%")
                  ->orWhere('kelas', 'like', "%$query%");
            })
            ->paginate(15);

        return view('kaonsli_sij.siswa.index', compact('siswas', 'query'));
    }

    /**
     * View siswa detail
     */
    public function showSiswa(Request $request, $id)
    {
        $query = $request->get('q');
        $siswa = User::where('role', 'siswa')
            ->where('major', 'SIJA')
            ->findOrFail($id);

        $peminjamans = $siswa->peminjamans()
            ->when($query, function ($q) use ($query) {
                $q->where('nomor_peminjaman', 'like', "%{$query}%")
                  ->orWhere('status', 'like', "%{$query}%")
                  ->orWhereHas('alat', function ($q2) use ($query) {
                      $q2->where('nama_alat', 'like', "%{$query}%")
                         ->orWhere('kode_alat_text', 'like', "%{$query}%");
                  });
            })
            ->paginate(10)
            ->appends(['q' => $query]);

        return view('kaonsli_sij.siswa.show', compact('siswa', 'peminjamans', 'query'));
    }
}
