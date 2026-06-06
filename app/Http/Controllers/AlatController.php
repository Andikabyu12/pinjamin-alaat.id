<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class AlatController extends Controller
{
    private function findAlat($kode_alat)
    {
        $query = Alat::where('kode_alat_text', $kode_alat);
        if (is_numeric($kode_alat)) {
            $query->orWhere('id', $kode_alat);
        }
        return $query->first();
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $alats = collect();
        $error = null;

        try {
            $query = Alat::query();

            if ($search) {
                $query->where('nama_alat', 'like', '%' . $search . '%')
                      ->orWhere('kode_alat_text', 'like', '%' . $search . '%')
                      ->orWhere('deskripsi', 'like', '%' . $search . '%');
            }

            $alats = $query->orderBy('nama_alat')->paginate(10)->withQueryString();
        } catch (QueryException $e) {
            $error = 'Database connection error: ' . $e->getMessage();
        }

        return view('alats.index', compact('alats', 'search', 'error'));
    }

    public function create()
    {
        return view('alats.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'kode_alat_text' => 'required|string|max:100|unique:alats,kode_alat_text',
            'deskripsi' => 'nullable|string',
            'stok_baik' => 'required|integer|min:0',
            'stok_rusak' => 'nullable|integer|min:0',
            'kondisi' => 'required|in:baik,buruk',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'nama_alat' => $request->nama_alat,
            'kode_alat_text' => $request->kode_alat_text,
            'deskripsi' => $request->deskripsi,
            'stok' => $request->stok_baik ?? 0,
            'stok_baik' => $request->stok_baik ?? 0,
            'stok_rusak' => $request->stok_rusak ?? 0,
            'kondisi' => $request->kondisi ?? 'baik',
        ];

        // Handle image upload
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $uploadPath = public_path('uploads/alats');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $file->move($uploadPath, $filename);
            $data['gambar'] = $filename;
        }

        Alat::create($data);

        return redirect()->route('alats.index')->with('success','Alat berhasil ditambahkan!');
    }

    public function show($kode_alat)
    {
        $alat = $this->findAlat($kode_alat);
        
        if (!$alat) {
            return redirect()->route('alats.index')->with('error', 'Alat tidak ditemukan!');
        }
        
        return view('alats.show', compact('alat'));
    }

    public function edit($kode_alat)
    {
        $alat = $this->findAlat($kode_alat);
        
        if (!$alat) {
            return redirect()->route('alats.index')->with('error', 'Alat tidak ditemukan!');
        }
        
        return view('alats.edit', compact('alat'));
    }

    public function update(Request $request, $kode_alat)
    {
        $alat = $this->findAlat($kode_alat);
        if (!$alat) {
            return redirect()->route('alats.index')->with('error', 'Alat tidak ditemukan!');
        }

        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'kode_alat_text' => 'required|string|max:100|unique:alats,kode_alat_text,' . $alat->id,
            'deskripsi' => 'nullable|string',
            'stok_baik' => 'required|integer|min:0',
            'stok_rusak' => 'nullable|integer|min:0',
            'kondisi' => 'required|in:baik,buruk',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'nama_alat' => $request->nama_alat,
            'kode_alat_text' => $request->kode_alat_text,
            'deskripsi' => $request->deskripsi,
            'stok' => $request->stok_baik ?? $alat->stok,
            'stok_baik' => $request->stok_baik ?? $alat->stok_baik,
            'stok_rusak' => $request->stok_rusak ?? $alat->stok_rusak,
            'kondisi' => $request->kondisi ?? $alat->kondisi,
            'updated_at' => now(),
        ];

        // Handle image upload on update
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $uploadPath = public_path('uploads/alats');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $file->move($uploadPath, $filename);

            if ($alat->gambar && file_exists(public_path('uploads/alats/' . $alat->gambar))) {
                @unlink(public_path('uploads/alats/' . $alat->gambar));
            }

            $data['gambar'] = $filename;
        }

        $alat->update($data);

        return redirect()->route('alats.index')->with('success', 'Alat berhasil diperbarui!');
    }

    public function destroy($kode_alat)
    {
        $alat = $this->findAlat($kode_alat);
        if (!$alat) {
            return redirect()->route('alats.index')->with('error', 'Alat tidak ditemukan!');
        }

        // delete associated image file if exists
        if ($alat->gambar && file_exists(public_path('uploads/alats/' . $alat->gambar))) {
            @unlink(public_path('uploads/alats/' . $alat->gambar));
        }

        $alat->delete();
        
        return redirect()->route('alats.index')->with('success', 'Alat berhasil dihapus!');
    }
}
