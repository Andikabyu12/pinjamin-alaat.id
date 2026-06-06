<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class AdminController extends Controller
{
    public function index()
    {
        $counts = [
            'siswas' => 0,
            'alats' => 0,
            'peminjaman' => 0,
            'returned' => 0,
        ];

        try {
            if (Schema::hasTable('siswas')) {
                $counts['siswas'] = DB::table('siswas')->count();
            }

            if (Schema::hasTable('alats')) {
                $counts['alats'] = DB::table('alats')->count();
            }

            if (Schema::hasTable('peminjaman')) {
                $counts['peminjaman'] = DB::table('peminjaman')->count();
                $counts['returned'] = DB::table('peminjaman')->where('status', 'returned')->count();
            } elseif (Schema::hasTable('peminjaman_alats')) {
                $counts['peminjaman'] = DB::table('peminjaman_alats')->count();
            }
        } catch (QueryException $e) {
            // log if needed, but continue with default zero counts
            logger()->warning('AdminController@index DB error: '.$e->getMessage());
        }

        return view('admin.index', compact('counts'));
    }

    public function users(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');
        
        $query = User::select(['id', 'name', 'email', 'role', 'major', 'nis', 'kelas']);
        
        if ($search) {
            $query->where(function ($sub) use ($search) {
                $sub->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('nis', 'like', '%' . $search . '%');
            });
        }
        
        if ($role) {
            $query->where('role', $role);
        }
        
        $users = $query->paginate(15)->withQueryString();
        
        return view('admin.users', compact('users', 'search', 'role'));
    }

    public function editUser($id)
    {
        $user = User::select(['id', 'name', 'email', 'role', 'major', 'nis', 'kelas'])->findOrFail($id);
        return view('admin.users-edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'role' => 'required|string|in:siswa,admin,wali_kelas,kaonsli_sij,kaprog_tkj',
            'major' => 'nullable|string|in:SIJA,TKJ',
            'nis' => 'nullable|string|max:50|unique:users,nis,' . $id,
            'kelas' => 'nullable|string|in:10 TKJ 1,10 TKJ 2,11 TKJ 1,11 TKJ 2,12 TKJ 1,12 TKJ 2,10 SIJA 1,10 SIJA 2,11 SIJA 1,11 SIJA 2,12 SIJA 1,12 SIJA 2',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'major' => $request->major,
            'nis' => $request->nis,
            'kelas' => $request->kelas,
        ]);

        return redirect()->route('admin.users')->with('success', 'User berhasil diperbarui!');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users')->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }
        
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus!');
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        
        // Reset password to default 'password'
        $user->update([
            'password' => Hash::make('password'),
        ]);
        
        return redirect()->route('admin.users.edit', $id)->with('success', 'Password pengguna berhasil direset ke default "password". Informasikan kepada pengguna untuk segera mengganti password mereka.');
    }
}

