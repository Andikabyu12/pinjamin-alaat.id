<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Alat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('q');
        $majorFilter = $request->query('major', '');
        $query = Peminjaman::with(['user', 'alat'])->latest('created_at');

        if (auth()->user()->role === 'siswa') {
            $query->where('user_id', auth()->id());
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('peminjaman.nomor_peminjaman', 'like', "%{$search}%")
                  ->orWhere('peminjaman.status', 'like', "%{$search}%")
                  ->orWhereHas('alat', function ($q2) use ($search) {
                      $q2->where('nama_alat', 'like', "%{$search}%")
                         ->orWhere('kode_alat_text', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // apply major filter (based on user's major field)
        if ($majorFilter !== '') {
            $query->whereHas('user', function($q2) use ($majorFilter) {
                $q2->where('major', $majorFilter);
            });
        }

        $peminjamans = $query->get();

        // counts per major for quick tabs
        $countsQuery = Peminjaman::with('user');
        if (auth()->user()->role === 'siswa') {
            $countsQuery->where('user_id', auth()->id());
        }
        if ($search) {
            $countsQuery->where(function ($s) use ($search) {
                $s->where('nomor_peminjaman', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }
        $counts = $countsQuery->get()
            ->groupBy(function($item){ return strtolower($item->user?->major ?? 'other'); })
            ->map(fn($g) => $g->count());

        return view('peminjaman.index', compact('peminjamans', 'search', 'counts', 'majorFilter'));
    }

    public function create(Request $request)
    {
        // Only list alats that have available good stock and are in 'baik' condition
        $alats = Alat::where('stok_baik', '>', 0)->where('kondisi', 'baik')->get();
        $selectedAlat = $request->query('alat_id');
        return view('peminjaman.create', compact('alats', 'selectedAlat'));
    }

    public function location(Request $request)
    {
        $alat_id = $request->query('alat_id');
        $borrow_date = $request->query('borrow_date', date('Y-m-d'));
        $return_date = $request->query('return_date', date('Y-m-d'));
        return view('peminjaman.location', compact('alat_id', 'borrow_date', 'return_date'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'alat_id' => 'required|string',
                'qty' => 'required|integer|min:1',
                'borrow_date' => 'required|date',
                'return_date' => 'required|date|after_or_equal:today',
                'photo_borrow' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'accuracy' => 'nullable|numeric',
            ], [
                'alat_id.required' => 'Silakan masukkan kode alat.',
                'alat_id.string' => 'Kode alat harus berupa teks.',
                'qty.required' => 'Jumlah alat harus diisi.',
                'qty.integer' => 'Jumlah harus berupa angka.',
                'qty.min' => 'Jumlah minimal adalah 1.',
                'borrow_date.required' => 'Tanggal pinjam harus diisi.',
                'borrow_date.date' => 'Tanggal pinjam tidak valid.',
                'photo_borrow.image' => 'Foto harus berupa gambar.',
                'photo_borrow.mimes' => 'Foto harus berformat jpeg, png, jpg, atau gif.',
                'return_date.required' => 'Tanggal pengembalian harus diisi.',
                'return_date.date' => 'Tanggal pengembalian tidak valid.',
                'return_date.after' => 'Tanggal pengembalian harus setelah hari ini.',
                'latitude.required' => 'Lokasi (latitude) diperlukan untuk peminjaman.',
                'latitude.numeric' => 'Latitude tidak valid.',
                'longitude.required' => 'Lokasi (longitude) diperlukan untuk peminjaman.',
                'longitude.numeric' => 'Longitude tidak valid.',
                'accuracy.numeric' => 'Akurasi lokasi tidak valid.',
            ]);

            // handle optional uploaded borrow photo (save to public/uploads/peminjaman)
            $borrowPhotoFilename = null;
            if ($request->hasFile('photo_borrow')) {
                $file = $request->file('photo_borrow');
                $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-_\.]/', '_', $file->getClientOriginalName());
                $uploadPath = public_path('uploads/peminjaman');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                $file->move($uploadPath, $filename);
                $borrowPhotoFilename = $filename;
            }

            $allowedCenter = ['lat' => 0.4703382, 'lng' => 101.3717251];
            $allowedRadius = 2000;
            $distance = $this->calculateDistance($validated['latitude'], $validated['longitude'], $allowedCenter['lat'], $allowedCenter['lng']);
            if ($distance > $allowedRadius) {
                return back()->withErrors(['latitude' => 'Lokasi Anda berada di luar area peminjaman. Pastikan Anda berada dalam radius ' . $allowedRadius . ' meter.'])->withInput();
            }

            $inputAlat = $validated['alat_id'];
            $alatQuery = Alat::where('kode_alat_text', $inputAlat);
            if (is_numeric($inputAlat)) {
                $alatQuery->orWhere('id', $inputAlat);
            }
            $alat = $alatQuery->first();

            if (!$alat) {
                return back()->withErrors(['alat_id' => 'Kode alat tidak valid atau tidak ditemukan.'])->withInput();
            }

            // Block borrowing if alat kondisi is not baik
            if (isset($alat->kondisi) && $alat->kondisi !== 'baik') {
                return back()->withErrors(['alat_id' => 'Alat tidak dalam kondisi baik dan tidak dapat dipinjam.'])->withInput();
            }

            $available = $alat->stok_baik ?? $alat->stok;
            if ($validated['qty'] > $available) {
                return back()->withErrors(['qty' => "Jumlah maksimal untuk alat ini adalah {$available}."])->withInput();
            }

            if ($available < $validated['qty']) {
                return back()->withErrors(['qty' => 'Stok tidak cukup untuk alat ' . $alat->nama_alat])->withInput();
            }

            DB::transaction(function () use ($validated, $alat) {
                Peminjaman::create([
                    'user_id' => auth()->id(),
                    'alat_id' => $alat->id,
                    'qty' => $validated['qty'],
                    'status' => 'approved',
                    'nomor_peminjaman' => Peminjaman::generateNomorPeminjaman(),
                    'return_date' => $validated['return_date'],
                    'borrowed_at' => $validated['borrow_date'] ?? now(),
                ]);

                // decrement good stock
                if (Schema::hasColumn('alats', 'stok_baik')) {
                    $alat->decrement('stok_baik', $validated['qty']);
                    // keep legacy stok in sync if present
                    if (Schema::hasColumn('alats', 'stok')) {
                        $alat->decrement('stok', $validated['qty']);
                    }
                } else {
                    $alat->decrement('stok', $validated['qty']);
                }
            });

            return redirect()->route('peminjaman.index')->with('success', 'Peminjaman alat ' . $alat->nama_alat . ' berhasil dibuat dan otomatis disetujui.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    private function calculateDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371000;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) * sin($dLng / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::with('alat', 'user')->findOrFail($id);

        $user = auth()->user();
        $userMajor = strtoupper($user->major ?: '');
        $loanMajor = strtoupper($peminjaman->user->major ?? '');

        if ($user->role === 'siswa' && $peminjaman->user_id !== $user->id) {
            abort(403);
        }

        if (in_array($user->role, ['wali_kelas', 'kaonsli_sij', 'kaprog_tkj'])) {
            if ($userMajor === '' || $loanMajor === '' || $userMajor !== $loanMajor) {
                abort(403);
            }
        }

        return view('peminjaman.show', compact('peminjaman'));
    }

    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status' => 'approved']);
        return back()->with('success', 'Peminjaman disetujui');
    }

    public function returnForm($id)
    {
        $peminjaman = Peminjaman::with('alat', 'user')->findOrFail($id);

        if ($peminjaman->status !== 'approved') {
            return back()->with('error', 'Peminjaman belum dapat dikembalikan.');
        }

        if (auth()->user()->role === 'wali_kelas') {
            abort(403);
        }

        if (auth()->user()->role === 'siswa' && $peminjaman->user_id !== auth()->id()) {
            abort(403);
        }

        return view('peminjaman.return', compact('peminjaman'));
    }

    public function returnItem(Request $request, $id)
    {
        $peminjaman = Peminjaman::with('alat', 'user')->findOrFail($id);

        if ($peminjaman->status !== 'approved') {
            return back()->with('error', 'Peminjaman tidak dapat dikembalikan.');
        }

        if (auth()->user()->role === 'wali_kelas') {
            abort(403);
        }

        if (auth()->user()->role === 'siswa' && $peminjaman->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'photo_return' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'return_description' => 'nullable|string|max:1000',
        ], [
            'photo_return.image' => 'Foto bukti harus berupa file gambar.',
            'photo_return.mimes' => 'Foto bukti harus berformat jpeg, png, jpg, atau gif.',
            'return_description.max' => 'Deskripsi maksimal 1000 karakter.',
        ]);

        $photoPath = $peminjaman->photo_return;
        if ($request->hasFile('photo_return')) {
            $file = $request->file('photo_return');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-_\.]/', '_', $file->getClientOriginalName());
            $uploadPath = public_path('uploads/peminjaman');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $file->move($uploadPath, $filename);
            if ($photoPath && file_exists(public_path('uploads/peminjaman/' . $photoPath))) {
                @unlink(public_path('uploads/peminjaman/' . $photoPath));
            }
            $photoPath = $filename;
        }

        DB::transaction(function () use ($peminjaman, $validated, $photoPath) {
            $peminjaman->update([
                'status' => 'returned',
                'returned_at' => now(),
                'photo_return' => $photoPath,
                'return_description' => $validated['return_description'] ?? null,
            ]);
            // increment good stock when item returned
            if (Schema::hasColumn('alats', 'stok_baik')) {
                $peminjaman->alat->increment('stok_baik', $peminjaman->qty);
                if (Schema::hasColumn('alats', 'stok')) {
                    $peminjaman->alat->increment('stok', $peminjaman->qty);
                }
            } else {
                $peminjaman->alat->increment('stok', $peminjaman->qty);
            }
        });

        return redirect()->route('peminjaman.index')->with('success', 'Alat berhasil dikembalikan.');
    }
}
