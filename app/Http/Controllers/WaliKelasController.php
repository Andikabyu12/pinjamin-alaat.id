<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WaliKelasController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $major = $user->major;
        $kelas = $user->kelas;

        // Siswa di jurusan dan kelas wali kelas
        $siswaCount = DB::table('users')
            ->where('role', 'siswa')
            ->whereRaw('LOWER(major) = ?', [strtolower($major)])
            ->when($kelas, fn($query) => $query->whereRaw('LOWER(kelas) = ?', [strtolower($kelas)]))
            ->count();

        // Peminjaman di jurusan dan kelas wali kelas
        $basePeminjaman = DB::table('peminjaman')
            ->join('users', 'peminjaman.user_id', '=', 'users.id')
            ->whereRaw('LOWER(users.major) = ?', [strtolower($major)])
            ->when($kelas, fn($query) => $query->whereRaw('LOWER(users.kelas) = ?', [strtolower($kelas)]));

        $peminjamanCount = (clone $basePeminjaman)->count();
        $peminjamanPending = (clone $basePeminjaman)->where('peminjaman.status', 'pending')->count();
        $peminjamanApproved = (clone $basePeminjaman)->where('peminjaman.status', 'approved')->count();
        $peminjamanReturned = (clone $basePeminjaman)->where('peminjaman.status', 'returned')->count();

        // Prepare monthly chart data for last 6 months (ending this month)
        $months = [];
        $borrowData = [];
        $returnData = [];

        $now = now();
        // show last 12 months (oldest → newest)
        for ($i = 11; $i >= 0; $i--) {
            $dt = $now->copy()->subMonths($i);
            $months[] = $dt->format('M Y');

            // count borrows for the month (use borrowed_at or created_at)
            $start = $dt->copy()->startOfMonth()->toDateTimeString();
            $end = $dt->copy()->endOfMonth()->toDateTimeString();

            $borrowCount = (clone $basePeminjaman)
                ->whereBetween(DB::raw("COALESCE(peminjaman.borrowed_at, peminjaman.created_at)"), [$start, $end])
                ->count();

            // count returns for the month (returned_at between)
            $returnCount = (clone $basePeminjaman)
                ->whereBetween('peminjaman.returned_at', [$start, $end])
                ->whereNotNull('peminjaman.returned_at')
                ->count();

            $borrowData[] = $borrowCount;
            $returnData[] = $returnCount;
        }

        return view('wali_kelas.dashboard', compact(
            'siswaCount',
            'peminjamanCount',
            'peminjamanPending',
            'peminjamanApproved',
            'peminjamanReturned',
            'major',
            'kelas',
            'months',
            'borrowData',
            'returnData'
        ));
    }

    public function siswa()
    {
        $user = auth()->user();
        $major = $user->major;
        $kelas = $user->kelas;

        $query = DB::table('users')
            ->where('role', 'siswa')
            ->whereRaw('LOWER(major) = ?', [strtolower($major)])
            ->when($kelas, fn($query) => $query->whereRaw('LOWER(kelas) = ?', [strtolower($kelas)]));

        $siswas = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('wali_kelas.siswa.index', compact('siswas'));
    }

    public function peminjaman()
    {
        $user = auth()->user();
        $major = $user->major;
        $kelas = $user->kelas;

        $peminjamans = DB::table('peminjaman')
            ->join('users', 'peminjaman.user_id', '=', 'users.id')
            ->join('alats', 'peminjaman.alat_id', '=', 'alats.id')
            ->select(
                'peminjaman.*',
                'users.nis as nis',
                'users.name as nama_siswa',
                'users.kelas',
                'users.major',
                'alats.nama_alat',
                'alats.kode_alat_text as kode_alat_text'
            )
            ->whereRaw('LOWER(users.major) = ?', [strtolower($major)])
            ->when($kelas, fn($query) => $query->whereRaw('LOWER(users.kelas) = ?', [strtolower($kelas)]))
            ->orderBy('peminjaman.created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('wali_kelas.peminjaman.index', compact('peminjamans'));
    }

    public function searchSiswa(Request $request)
    {
        $user = auth()->user();
        $major = $user->major;
        $kelas = $user->kelas;
        $q = trim($request->query('q', ''));

        $query = DB::table('users')
            ->where('role', 'siswa')
            ->whereRaw('LOWER(major) = ?', [strtolower($major)])
            ->when($kelas, fn($query) => $query->whereRaw('LOWER(kelas) = ?', [strtolower($kelas)]));

        if ($q !== '') {
            $query->where(function($sub) use ($q) {
                $sub->where('name', 'like', '%' . $q . '%')
                    ->orWhere('nis', 'like', '%' . $q . '%');
            });
        }

        $siswas = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('wali_kelas.siswa.index', compact('siswas', 'q'));
    }

    public function searchPeminjaman(Request $request)
    {
        $user = auth()->user();
        $major = $user->major;
        $kelas = $user->kelas;
        $q = trim($request->query('q', ''));

        $query = DB::table('peminjaman')
            ->join('users', 'peminjaman.user_id', '=', 'users.id')
            ->join('alats', 'peminjaman.alat_id', '=', 'alats.id')
            ->select(
                'peminjaman.*',
                'users.nis as nis',
                'users.name as nama_siswa',
                'users.kelas',
                'users.major',
                'alats.nama_alat',
                'alats.kode_alat_text as kode_alat_text'
            )
            ->whereRaw('LOWER(users.major) = ?', [strtolower($major)])
            ->when($kelas, fn($query) => $query->whereRaw('LOWER(users.kelas) = ?', [strtolower($kelas)]));

        if ($q !== '') {
            $query->where(function($sub) use ($q) {
                $sub->where('users.name', 'like', '%' . $q . '%')
                    ->orWhere('users.nis', 'like', '%' . $q . '%')
                    ->orWhere('alats.nama_alat', 'like', '%' . $q . '%');
            });
        }

        $peminjamans = $query->orderBy('peminjaman.created_at', 'desc')->paginate(15)->withQueryString();

        return view('wali_kelas.peminjaman.index', compact('peminjamans', 'q'));
    }

    public function showSiswa($id)
    {
        $user = auth()->user();
        $major = $user->major;

        $siswa = DB::table('users')
            ->where('id', $id)
            ->where('role', 'siswa')
            ->whereRaw('LOWER(major) = ?', [strtolower($major)])
            ->first();

        if (!$siswa) {
            abort(404);
        }

        return view('wali_kelas.siswa.show', compact('siswa'));
    }
}