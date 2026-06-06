<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Shuchkin\SimpleXLSX;

class SiswaController extends Controller
{
    public function index()
    {
        try {
            // If the logged in user is admin, show all students. Otherwise show only the current NIS user.
            $user = auth()->user();
            $baseQuery = DB::table('siswas')
                ->leftJoin('alats', DB::raw('siswas.kode_barang COLLATE utf8mb4_general_ci'), '=', 'alats.kode_alat_text')
                ->select('siswas.*', DB::raw('alats.nama_alat as nama_barang'));

            // Apply optional filters: search query, kelas, jurusan
            $q = trim(request()->query('q', ''));
            $kelas = request()->query('kelas', '');
            $jurusan = request()->query('jurusan', '');

            if ($user && $user->role === 'admin') {
                // admin can see all students, with filters
                if ($q !== '') {
                    $baseQuery->where(function($sub) use ($q) {
                        $sub->where('nama','like','%'.$q.'%')
                            ->orWhere('nis','like','%'.$q.'%')
                            ->orWhere('kelas','like','%'.$q.'%')
                            ->orWhere('jurusan','like','%'.$q.'%')
                            ->orWhere('alats.nama_alat','like','%'.$q.'%');
                    });
                }
                if ($kelas !== '') $baseQuery->where('kelas', $kelas);
                if ($jurusan !== '') $baseQuery->where('jurusan', $jurusan);

                $siswas = $baseQuery->orderBy('siswas.id')->paginate(25)->withQueryString();
            } elseif ($user && $user->nis) {
                // non-admin users see only their own record
                $baseQuery->where('siswas.nis', $user->nis);
                $siswas = $baseQuery->orderBy('siswas.id')->paginate(25)->withQueryString();
            } else {
                $siswas = collect([]);
            }

            // helper lists for filters
            $classes = DB::table('siswas')->select('kelas')->distinct()->pluck('kelas')->filter()->values();
            $jurusans = DB::table('siswas')->select('jurusan')->distinct()->pluck('jurusan')->filter()->values();
            $classCounts = DB::table('siswas')
                ->select('kelas', DB::raw('count(*) as cnt'))
                ->groupBy('kelas')
                ->pluck('cnt','kelas');

            $dbError = false;
        } catch (\Exception $e) {
            report($e);
            // When DB is not available, return an empty collection (no example row)
            $siswas = collect([]);
            $dbError = true;
        }
        $newNis = request()->query('new_nis');
        return view('siswas.index', compact('siswas','dbError','newNis','classes','jurusans','classCounts','q','kelas','jurusan'));
    }

    public function autocomplete(Request $request)
    {
        $q = trim($request->query('q',''));
        if ($q === '') return response()->json([]);

        try {
            $user = auth()->user();
            $query = DB::table('siswas')
                ->select('id','nis','nama','kelas','jurusan')
                ->where(function($sub) use ($q) {
                    $sub->where('nama','like','%'.$q.'%')
                        ->orWhere('nis','like','%'.$q.'%')
                        ->orWhere('kelas','like','%'.$q.'%')
                        ->orWhere('jurusan','like','%'.$q.'%');
                })
                ->orderBy('nama')
                ->limit(15);
            if ($user && $user->role !== 'admin' && $user->nis) {
                $query->where('nis',$user->nis);
            }
            $rows = $query->get();
            return response()->json($rows);
        } catch (\Exception $e) {
            report($e);
            return response()->json([]);
        }
    }

    public function classCounts()
    {
        try {
            $counts = DB::table('siswas')
                ->select('kelas', DB::raw('count(*) as cnt'))
                ->groupBy('kelas')
                ->orderBy('kelas')
                ->get();
            return response()->json($counts);
        } catch (\Exception $e) {
            report($e);
            return response()->json([]);
        }
    }

    public function create()
    {
        return view('siswas.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nis' => 'required|numeric',
            'nama' => 'required|string',
            'kelas' => 'required|in:10 TKJ 1,10 TKJ 2,11 TKJ 1,11 TKJ 2,12 TKJ 1,12 TKJ 2,10 SIJA 1,10 SIJA 2,11 SIJA 1,11 SIJA 2,12 SIJA 1,12 SIJA 2',
            'jurusan' => 'required|in:tkj,sija',
            'tanggal_pinjam' => 'nullable|date',
            'kode_barang' => 'nullable|numeric',
            'jam_pinjam' => 'nullable',
            'foto' => 'nullable|image|max:2048',
        ];

        // If the database is available, enforce unique NIS. If not, fall back
        // to a simple required rule so validation doesn't throw a DB exception.
        try {
            DB::connection()->getPdo();
            $rules['nis'] = 'required|numeric|unique:siswas,nis';
        } catch (\Exception $e) {
            report($e);
            $rules['nis'] = 'required|numeric';
        }

        $request->validate(array_merge($rules, [
            'password' => 'nullable|string|min:6|confirmed',
        ]));

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('siswas_photos', 'public');
        }

        // Attempt DB operations only if the connection is available. If
        // the DB is not reachable, report and redirect gracefully.
        try {
            DB::connection()->getPdo();
            $kodeLogin = null;
            try {
                $plain = $request->password ?: 'password';
                $kodeLogin = DB::table('tabel_login')->insertGetId([
                    'username' => $request->nis,
                    'password' => Hash::make($plain),
                    'level' => 'siswa',
                    'created_at' => now(),
                    'updated_at' => now(),
                ], 'kode_login');
            } catch (\Exception $e) {
                report($e);
                // continue without kodeLogin
            }

            DB::table('siswas')->insert([
                'nis' => $request->nis,
                'nama' => $request->nama,
                'kelas' => $request->kelas,
                'jurusan' => $request->jurusan,
                'kode_login' => $kodeLogin,
                'tanggal_pinjam' => $request->tanggal_pinjam ?: null,
                'kode_barang' => $request->kode_barang ?: null,
                'jam_pinjam' => $request->jam_pinjam ?: null,
                'foto' => $fotoPath,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('siswas.index')->with('success','Siswa ditambahkan.');
        } catch (\Exception $e) {
            report($e);
            return redirect()->route('siswas.index')->with('error','Database tidak tersedia, coba lagi nanti.');
        }
    }

    public function edit($id)
    {
        try {
            $siswa = DB::table('siswas')->where('id', $id)->first();
        } catch (\Exception $e) {
            report($e);
            return redirect()->route('siswas.index')->with('error','Database tidak tersedia.');
        }
        if (! $siswa) {
            return redirect()->route('siswas.index')->with('error','Siswa tidak ditemukan.');
        }
        return view('siswas.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nis' => 'required|numeric',
            'nama' => 'required|string',
            'kelas' => 'required|in:10 TKJ 1,10 TKJ 2,11 TKJ 1,11 TKJ 2,12 TKJ 1,12 TKJ 2,10 SIJA 1,10 SIJA 2,11 SIJA 1,11 SIJA 2,12 SIJA 1,12 SIJA 2',
            'jurusan' => 'required|in:tkj,sija',
            'kode_barang' => 'nullable|numeric',
        ]);
        $data = [
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'tanggal_pinjam' => $request->tanggal_pinjam ?: null,
            'kode_barang' => $request->kode_barang ?: null,
            'jam_pinjam' => $request->jam_pinjam ?: null,
            'updated_at' => now(),
        ];

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('siswas_photos', 'public');
            // delete old file if exists
            $old = DB::table('siswas')->where('id', $id)->value('foto');
            if ($old && \Illuminate\Support\Facades\Storage::disk('public')->exists($old)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($old);
            }
            $data['foto'] = $fotoPath;
        }

        // Update tabel_login password if provided
        try {
            DB::connection()->getPdo();
            if ($request->filled('password')) {
                $siswaRow = DB::table('siswas')->where('id', $id)->first();
                if ($siswaRow && $siswaRow->kode_login) {
                    DB::table('tabel_login')->where('kode_login', $siswaRow->kode_login)->update([
                        'password' => Hash::make($request->password),
                        'updated_at' => now(),
                    ]);
                } else {
                    // create login entry
                    $newKode = DB::table('tabel_login')->insertGetId([
                        'username' => $request->nis,
                        'password' => Hash::make($request->password),
                        'level' => 'siswa',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ], 'kode_login');
                    $data['kode_login'] = $newKode;
                }
            }
        } catch (\Exception $e) {
            report($e);
        }

        DB::table('siswas')->where('id', $id)->update($data);

        return redirect()->route('siswas.index')->with('success','Siswa diperbarui.');
    }

    public function destroy($id)
    {
        DB::table('siswas')->where('id', $id)->delete();
        return redirect()->route('siswas.index')->with('success','Siswa dihapus.');
    }

    public function importForm()
    {
        $user = auth()->user();
        if (! $user || $user->role !== 'admin') {
            abort(403);
        }
        return view('siswas.import');
    }

    public function import(Request $request)
    {
        $user = auth()->user();
        if (! $user || $user->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx',
        ]);

        $extension = strtolower($request->file('file')->getClientOriginalExtension());
        if ($extension === 'xls') {
            return redirect()->route('siswas.import')->with('error', 'Format .xls tidak didukung. Simpan file sebagai .xlsx atau .csv lalu coba lagi.');
        }

        $path = $request->file('file')->getRealPath();
        $rowNumber = 0;
        $imported = 0;
        $skipped = 0;
        $rows = [];

        if ($extension === 'xlsx') {
            try {
                $xlsx = SimpleXLSX::parse($path);
                if (! $xlsx) {
                    return redirect()->route('siswas.index')->with('error', 'Tidak dapat membaca file Excel impor: ' . SimpleXLSX::parseError());
                }
                // Parse all sheets from Excel and merge rows. Skip repeated header rows on subsequent sheets.
                $rows = [];
                // small inline header detector (matches later logic)
                $normalizeHeaderValueLocal = function ($value) {
                    $value = (string) $value;
                    $value = preg_replace('/^\xEF\xBB\xBF/', '', $value);
                    return strtolower(trim($value));
                };
                $rowLooksLikeHeaderLocal = function (array $row) use ($normalizeHeaderValueLocal) {
                    foreach ($row as $value) {
                        $value = $normalizeHeaderValueLocal($value);
                        if ($value === '') continue;
                        if (str_contains($value, 'nis') || str_contains($value, 'nomor') || str_contains($value, 'name') || str_contains($value, 'nama') || str_contains($value, 'kelas') || str_contains($value, 'jurusan') || str_contains($value, 'major') || $value === 'no') {
                            return true;
                        }
                    }
                    return false;
                };

                // Try to determine sheet count in a few ways (compat with different SimpleXLSX versions)
                $sheetCount = null;
                if (method_exists($xlsx, 'sheetCount')) {
                    $sheetCount = $xlsx->sheetCount();
                } elseif (method_exists($xlsx, 'sheetsCount')) {
                    $sheetCount = $xlsx->sheetsCount();
                } elseif (is_array(@$xlsx->sheets())) {
                    $sheetsArr = $xlsx->sheets();
                    $sheetCount = count($sheetsArr);
                }

                if (is_int($sheetCount) && $sheetCount > 0) {
                    for ($s = 0; $s < $sheetCount; $s++) {
                        $sheetRows = $xlsx->rows($s);
                        $sheetName = method_exists($xlsx, 'sheetName') ? $xlsx->sheetName($s) : '';
                        if (!is_array($sheetRows) || count($sheetRows) === 0) continue;
                        // If this is not the very first sheet and its first row looks like a header, skip that first row
                        if ($s > 0 && isset($sheetRows[0]) && is_array($sheetRows[0]) && $rowLooksLikeHeaderLocal($sheetRows[0])) {
                            $sheetRows = array_slice($sheetRows, 1);
                        }
                        foreach ($sheetRows as $r) {
                            if (!is_array($r)) continue;
                            $r['__sheet_name'] = $sheetName;
                            $rows[] = $r;
                        }
                    }
                } else {
                    // fallback: original behaviour (first sheet)
                    $rows = $xlsx->rows();
                }
            } catch (\Exception $e) {
                report($e);
                return redirect()->route('siswas.index')->with('error', 'Tidak dapat membaca file Excel impor.');
            }
        } else {
            $handle = fopen($path, 'r');

            if ($handle === false) {
                return redirect()->route('siswas.index')->with('error', 'Tidak dapat membaca file impor.');
            }

            $headerLines = [];
            for ($i = 0; $i < 5 && ($line = fgets($handle)) !== false; $i++) {
                if (trim($line) !== '') {
                    $headerLines[] = $line;
                }
            }
            rewind($handle);

            $guessDelimiter = function (array $lines) {
                $candidates = [',', ';', "\t"];
                $bestDelimiter = ',';
                $bestCount = 0;

                foreach ($candidates as $delimiter) {
                    $count = 0;
                    foreach ($lines as $line) {
                        $count += substr_count($line, $delimiter);
                    }
                    if ($count > $bestCount) {
                        $bestCount = $count;
                        $bestDelimiter = $delimiter;
                    }
                }

                return $bestDelimiter;
            };

            $delimiter = $guessDelimiter($headerLines);
            // use 0 (no length limit) so long fields/rows are not truncated
            while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
                if (count(array_filter($row, fn($value) => trim((string) $value) !== '')) === 0) {
                    continue;
                }
                $rows[] = $row;
            }

            fclose($handle);
        }

        $fieldMap = [
            'nis' => 0,
            'nama' => 1,
            'kelas' => null,
            'jurusan' => null,
            'kode_barang' => null,
        ];
        $header = null;
        $hasHeader = false;

        $normalizeHeaderValue = function ($value) {
            $value = (string) $value;
            $value = preg_replace('/^\xEF\xBB\xBF/', '', $value);
            return strtolower(trim($value));
        };

        $rowLooksLikeHeader = function (array $row) use ($normalizeHeaderValue) {
            foreach ($row as $value) {
                $value = $normalizeHeaderValue($value);
                if ($value === '') {
                    continue;
                }

                if (str_contains($value, 'nis') || str_contains($value, 'nomor') || str_contains($value, 'name') || str_contains($value, 'nama') || str_contains($value, 'kelas') || str_contains($value, 'jurusan') || str_contains($value, 'major') || $value === 'no') {
                    return true;
                }
            }
            return false;
        };

        if (count($rows) > 0 && is_array($rows[0]) && $rowLooksLikeHeader($rows[0])) {
            $hasHeader = true;
            $header = array_map($normalizeHeaderValue, $rows[0]);

            foreach ($header as $index => $value) {
                if (str_contains($value, 'nis') || str_contains($value, 'nomor')) {
                    $fieldMap['nis'] = $index;
                }
                if (str_contains($value, 'nama') || str_contains($value, 'name')) {
                    $fieldMap['nama'] = $index;
                }
                if (str_contains($value, 'kelas')) {
                    $fieldMap['kelas'] = $index;
                }
                if (str_contains($value, 'jurusan') || str_contains($value, 'major')) {
                    $fieldMap['jurusan'] = $index;
                }
                if (str_contains($value, 'kode_barang') || str_contains($value, 'kode alat') || str_contains($value, 'kode_alat') || str_contains($value, 'kode alat text')) {
                    $fieldMap['kode_barang'] = $index;
                }
            }
        }

        // If this is a simple sheet with 3 columns (No, Nama, NIS), map them directly.
        if (! $hasHeader && count($rows) > 0) {
            $firstRow = $rows[0];
            if (is_array($firstRow) && count($firstRow) >= 3) {
                $firstColVals = array_column($rows, 0);
                $thirdColVals = array_column($rows, 2);
                $numericFirstCol = true;
                $sequentialCount = 0;
                foreach ($firstColVals as $idx => $val) {
                    $val = trim((string) $val);
                    if ($val === '') { $numericFirstCol = false; break; }
                    if (!ctype_digit($val)) { $numericFirstCol = false; break; }
                    if ((int)$val === $idx + 1) { $sequentialCount++; }
                }
                $nisLikeCount = 0;
                foreach ($thirdColVals as $val) {
                    $val = trim((string) $val);
                    if (preg_match('/^\d{4,}\/\d{1,}\/\d{1,}$/', $val) || preg_match('/^\d{6,}$/', $val)) {
                        $nisLikeCount++;
                    }
                }
                if ($numericFirstCol && $sequentialCount >= max(3, count($firstColVals) - 2) && $nisLikeCount >= max(3, count($thirdColVals) - 2)) {
                    $fieldMap['nama'] = 1;
                    $fieldMap['nis'] = 2;
                    $fieldMap['kelas'] = null;
                    $fieldMap['jurusan'] = null;
                }
            }
        }

        $hasSheetNames = !empty($rows) && is_array($rows[0]) && array_key_exists('__sheet_name', $rows[0]);

        // If kelas wasn't found by header and sheet names are not available, try to detect the kelas column heuristically
        if ($fieldMap['kelas'] === null && !$hasSheetNames && count($rows) > ($hasHeader ? 1 : 0)) {
            $scanStart = $hasHeader ? 1 : 0;
            // increase heuristic scan window so large files still get detected correctly
            $sampleCount = min(1000, max(5, count($rows) - $scanStart));
            $candidates = [];
            $classPattern = '/\b(10|11|12)\b/i';
            $majorPattern = '/\b(tkj|sija|sija|tkj1|tkj2|sija1|sija2)\b/i';

            for ($i = $scanStart; $i < $scanStart + $sampleCount && $i < count($rows); $i++) {
                $r = $rows[$i];
                if (!is_array($r)) continue;
                foreach ($r as $colIdx => $cell) {
                    $cellStr = (string) $cell;
                    if (trim($cellStr) === '') continue;
                    if (!isset($candidates[$colIdx])) $candidates[$colIdx] = 0;
                    if (preg_match($classPattern, $cellStr) || preg_match($majorPattern, $cellStr)) {
                        $candidates[$colIdx]++;
                    }
                }
            }

            if (!empty($candidates)) {
                arsort($candidates);
                $best = array_key_first($candidates);
                // require at least 2 matches in sample to consider it a kelas column
                if ($candidates[$best] >= 2) {
                    $fieldMap['kelas'] = (int) $best;
                    // if jurusan not set, try to infer it from same column values
                    if ($fieldMap['jurusan'] === null) {
                        // if any value in that column contains TKJ or SIJA, map jurusan
                        for ($i = $scanStart; $i < $scanStart + $sampleCount && $i < count($rows); $i++) {
                            $v = strtolower((string) ($rows[$i][$best] ?? ''));
                                    if (str_contains($v, 'tkj')) { $fieldMap['jurusan'] = $best; break; }
                                    if (str_contains($v, 'sija') || str_contains($v, 'sij')) { $fieldMap['jurusan'] = $best; break; }
                        }
                    }
                }
            }
        }

        $getFieldValue = function ($row, $index) {
            return is_int($index) ? trim((string) ($row[$index] ?? '')) : '';
        };

        // enforce maximum data rows per import to avoid overload (10000 rows)
        $maxDataRows = 10000;
        $totalRows = count($rows);
        $truncatedCount = 0;
        if ($hasHeader) {
            // keep header + first $maxDataRows data rows
            $headerRow = $rows[0];
            $dataRows = array_slice($rows, 1, $maxDataRows);
            $truncatedCount = max(0, count($rows) - 1 - count($dataRows));
            $rows = array_merge([$headerRow], $dataRows);
        } else {
            $dataRows = array_slice($rows, 0, $maxDataRows);
            $truncatedCount = max(0, count($rows) - count($dataRows));
            $rows = $dataRows;
        }

        foreach ($rows as $rowIndex => $row) {
            if (!is_array($row) || count($row) < 2) {
                $skipped++;
                continue;
            }

            if ($rowIndex === 0 && $hasHeader) {
                continue;
            }

            $nis = $getFieldValue($row, $fieldMap['nis']);
            $nama = $getFieldValue($row, $fieldMap['nama']);
            $kelasRaw = $getFieldValue($row, $fieldMap['kelas']);
            $jurusanRaw = $getFieldValue($row, $fieldMap['jurusan']);
            $kodeBarang = $getFieldValue($row, $fieldMap['kode_barang']);
            $sheetName = trim((string) ($row['__sheet_name'] ?? ''));
            if ($sheetName !== '') {
                if ($kelasRaw === '' || preg_match('/^\s*\d+\s*$/', $kelasRaw)) {
                    $kelasRaw = $sheetName;
                }
                if ($jurusanRaw === '' || preg_match('/^\s*\d+\s*$/', $jurusanRaw)) {
                    $jurusanRaw = $sheetName;
                }
            }

            // Normalize kelas/jurusan into canonical format (e.g., "10 TKJ 1", "12 SIJA 2").
            // Returns both normalized kelas and jurusan (jurusan as lowercase 'tkj'|'sija').
            $normalizeKelas = function ($kelasRaw, $jurusanRaw = null) {
                $kRaw = trim((string) $kelasRaw);
                $jRaw = trim((string) $jurusanRaw);
                if ($kRaw === '' && $jRaw === '') return ['kelas' => '', 'jurusan' => ''];

                // remove BOM, control chars and normalize spacing
                $kClean = preg_replace('/^\xEF\xBB\xBF/', '', $kRaw);
                $s = strtoupper($kClean . ' ' . $jRaw);
                $s = preg_replace('/[\x00-\x1F]+/', ' ', $s);
                $s = preg_replace('/[^A-Z0-9 ]+/', ' ', $s);
                $s = preg_replace('/\s+/', ' ', trim($s));

                // Convert Roman numerals to Arabic: X->10, XI->11, XII->12
                $romanMap = ['XII' => '12', 'XI' => '11', 'X' => '10'];
                foreach ($romanMap as $roman => $arabic) {
                    $s = preg_replace('/\b' . $roman . '\b/', $arabic, $s);
                }

                // detect grade, major, and section
                $grade = null; $major = null; $section = null;
                if (preg_match('/\b(10|11|12)\b/', $s, $m)) $grade = $m[1];
                if (preg_match('/\b(TKJ|SIJA)\b/', $s, $m)) $major = $m[1];
                if (preg_match('/\b(1|2)\b/', $s, $m)) $section = $m[1];

                // If kelas column is a simple numeric code 1..12, map to canonical 12 classes
                if (preg_match('/^\s*(\d{1,2})\s*$/', $kRaw, $m2)) {
                    $n = intval($m2[1]);
                    $map = [
                        1 => '10 TKJ 1', 2 => '10 TKJ 2', 3 => '11 TKJ 1', 4 => '11 TKJ 2', 5 => '12 TKJ 1', 6 => '12 TKJ 2',
                        7 => '10 SIJA 1', 8 => '10 SIJA 2', 9 => '11 SIJA 1', 10 => '11 SIJA 2', 11 => '12 SIJA 1', 12 => '12 SIJA 2'
                    ];
                    if (isset($map[$n])) {
                        $parts = explode(' ', $map[$n]);
                        return ['kelas' => $map[$n], 'jurusan' => strtolower($parts[1])];
                    }
                }

                if ($grade && $major && $section) {
                    return ['kelas' => "$grade $major $section", 'jurusan' => strtolower($major)];
                }

                if ($grade && $major) {
                    // assume section 1 if missing
                    return ['kelas' => "$grade $major 1", 'jurusan' => strtolower($major)];
                }

                if ($grade && $section && !$major) {
                    // try to infer major from jurusanRaw
                    $jUp = strtoupper($jRaw);
                    if (str_contains($jUp, 'TKJ')) $major = 'TKJ';
                    elseif (str_contains($jUp, 'SIJA') || str_contains($jUp, 'SIJ')) $major = 'SIJA';
                    if ($major) return ['kelas' => "$grade $major $section", 'jurusan' => strtolower($major)];
                }

                if ($major && $section && !$grade) {
                    return ['kelas' => "$major $section", 'jurusan' => strtolower($major)];
                }

                // fallback: return cleaned original, jurusan from jurusanRaw if possible
                $jurusanOut = '';
                $jUp = strtoupper($jRaw);
                if (str_contains($jUp, 'TKJ')) $jurusanOut = 'tkj';
                elseif (str_contains($jUp, 'SIJA') || str_contains($jUp, 'SIJ')) $jurusanOut = 'sija';

                return ['kelas' => strtoupper($kClean), 'jurusan' => $jurusanOut];
            };

            // normalize only to derive canonical kelas/jurusan for inference;
            // however store the original kelas text from Excel when present
            $res = $normalizeKelas($kelasRaw, $jurusanRaw);
            $kelasNormalized = is_array($res) ? $res['kelas'] : $res;
            $jurusanNormalized = is_array($res) ? $res['jurusan'] : '';
            // prefer original kelas text for DB if provided, otherwise fallback to normalized
            $kelasForDb = $kelasRaw !== '' ? $kelasRaw : ($kelasNormalized ?: '');
            $jurusanForDb = $jurusanNormalized !== '' ? $jurusanNormalized : (trim((string)$jurusanRaw) ?: '');

                if ($nis === '' || $nama === '') {
                $first = $getFieldValue($row, 0);
                $second = $getFieldValue($row, 1);
                $third = $getFieldValue($row, 2);
                $fourth = $getFieldValue($row, 3);
                $fifth = $getFieldValue($row, 4);
                
                // Debug logging
                \Log::debug("Row $rowIndex has empty nis/nama before fallback", [
                    'nis' => $nis,
                    'nama' => $nama,
                    'fieldMap' => $fieldMap,
                    'raw_values' => [$first, $second, $third, $fourth, $fifth]
                ]);

                    if (is_numeric($first) && is_numeric($second) && $third !== '') {
                        $nis = $second;
                        $nama = $third;
                        $kelasRaw = $fourth ?: $kelasRaw;
                        $jurusanRaw = $fifth ?: $jurusanRaw;
                    } elseif (is_numeric($first) && !is_numeric($second) && is_numeric($third)) {
                        $nis = $third;
                        $nama = $second;
                        $kelasRaw = $fourth ?: $kelasRaw;
                        $jurusanRaw = $fifth ?: $jurusanRaw;
                    } elseif (is_numeric($first) && !is_numeric($second)) {
                        $nis = $first;
                        $nama = $second;
                        $kelasRaw = $third ?: $kelasRaw;
                        $jurusanRaw = $fourth ?: $jurusanRaw;
                    } elseif (is_numeric($second) && !is_numeric($first)) {
                        $nis = $second;
                        $nama = $first;
                        $kelasRaw = $third ?: $kelasRaw;
                        $jurusanRaw = $fourth ?: $jurusanRaw;
                    }
                    // re-run normalization/fallbacks after restructuring
                    $res = $normalizeKelas($kelasRaw, $jurusanRaw);
                    $kelasNormalized = is_array($res) ? $res['kelas'] : $res;
                    $jurusanNormalized = is_array($res) ? $res['jurusan'] : '';
                    $kelasForDb = $kelasRaw !== '' ? $kelasRaw : ($kelasNormalized ?: '');
                    $jurusanForDb = $jurusanNormalized !== '' ? $jurusanNormalized : (trim((string)$jurusanRaw) ?: '');
            }

            if ($nis === '' || $nama === '') {
                \Log::warning("Row $rowIndex SKIPPED: NIS or Nama still empty after all fallbacks", [
                    'nis' => $nis,
                    'nama' => $nama,
                    'raw_row' => $row
                ]);
                $skipped++;
                continue;
            }

                $existing = DB::table('siswas')->where('nis', $nis)->first();
            if ($existing) {
                // update missing or changed fields
                $update = [];
                if ($existing->nama !== $nama && $nama !== '') {
                    $update['nama'] = $nama;
                }
                    if (!empty($kelasForDb) && ($existing->kelas !== $kelasForDb)) {
                        $update['kelas'] = $kelasForDb;
                }
                    if (!empty($jurusanForDb) && ($existing->jurusan !== $jurusanForDb)) {
                        $update['jurusan'] = $jurusanForDb;
                }
                if (!empty($kodeBarang) && ($existing->kode_barang !== $kodeBarang)) {
                    $update['kode_barang'] = $kodeBarang;
                }
                if (!empty($update)) {
                    $update['updated_at'] = now();
                    DB::table('siswas')->where('nis', $nis)->update($update);
                    $imported++;
                } else {
                    $skipped++;
                }
                continue;
            }

            DB::table('siswas')->insert([
                'nis' => $nis,
                'nama' => $nama,
                'kelas' => $kelasForDb ?: null,
                'jurusan' => $jurusanForDb ?: null,
                'kode_login' => null,
                'tanggal_pinjam' => null,
                'kode_barang' => $kodeBarang ?: null,
                'jam_pinjam' => null,
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $imported++;
        }

        $message = "Impor selesai: $imported siswa ditambahkan, $skipped baris dilewati.";
        if (isset($truncatedCount) && $truncatedCount > 0) {
            $message .= " (Dibatasi: $truncatedCount baris lebih dari $maxDataRows diabaikan.)";
        }
        
        // Log detailed import info for debugging
        \Log::info('Import siswa selesai', [
            'total_rows' => count($rows),
            'imported' => $imported,
            'skipped' => $skipped,
            'has_header' => $hasHeader,
            'field_map' => $fieldMap
        ]);
        
        return redirect()->route('siswas.index')->with('success', $message);
    }

    public function resetPassword($id)
    {
        try {
            $siswa = DB::table('siswas')->where('id', $id)->first();
            if (! $siswa) {
                return redirect()->back()->with('error', 'Siswa tidak ditemukan.');
            }

            if (! $siswa->kode_login) {
                // Create login with default password
                $newKode = DB::table('tabel_login')->insertGetId([
                    'username' => $siswa->nis,
                    'password' => Hash::make('password'),
                    'level' => 'siswa',
                    'created_at' => now(),
                    'updated_at' => now(),
                ], 'kode_login');
                DB::table('siswas')->where('id', $id)->update(['kode_login' => $newKode]);
            } else {
                DB::table('tabel_login')->where('kode_login', $siswa->kode_login)->update([
                    'password' => Hash::make('password'),
                    'updated_at' => now(),
                ]);
            }

            return redirect()->back()->with('success', 'Password siswa telah direset ke default ("password"). Informasikan kepada siswa untuk segera mengganti password.');
        } catch (\Exception $e) {
            report($e);
            return redirect()->back()->with('error', 'Gagal mereset password: ' . $e->getMessage());
        }
    }

    public function export()
    {
        $user = auth()->user();
        if (! $user || $user->role !== 'admin') {
            abort(403);
        }

        try {
            $allStudents = DB::table('siswas')->get();

            // Sort in PHP: SIJA first, then TKJ; within each, sort by grade (10,11,12) then section (1,2) then name
            $allStudents = $allStudents->sort(function ($a, $b) {
                // Primary: jurusan (sija=0, tkj=1)
                $aJurusan = (strtolower($a->jurusan) === 'sija') ? 0 : 1;
                $bJurusan = (strtolower($b->jurusan) === 'sija') ? 0 : 1;
                if ($aJurusan !== $bJurusan) return $aJurusan <=> $bJurusan;

                // Secondary: extract grade from kelas (10, 11, 12)
                preg_match('/\b(10|11|12)\b/', $a->kelas ?? '', $mA);
                preg_match('/\b(10|11|12)\b/', $b->kelas ?? '', $mB);
                $aGrade = isset($mA[1]) ? (int)$mA[1] : 999;
                $bGrade = isset($mB[1]) ? (int)$mB[1] : 999;
                if ($aGrade !== $bGrade) return $aGrade <=> $bGrade;

                // Tertiary: extract section from kelas (1, 2)
                preg_match('/\b([1-2])\s*$/', $a->kelas ?? '', $mA);
                preg_match('/\b([1-2])\s*$/', $b->kelas ?? '', $mB);
                $aSection = isset($mA[1]) ? (int)$mA[1] : 999;
                $bSection = isset($mB[1]) ? (int)$mB[1] : 999;
                if ($aSection !== $bSection) return $aSection <=> $bSection;

                // Quaternary: sort by name
                return $a->nama <=> $b->nama;
            })->values();

            $presentClasses = DB::table('siswas')->select('kelas')->distinct()->pluck('kelas')->filter()->values()->toArray();
            $canonical = [
                '10 SIJA 1','10 SIJA 2','11 SIJA 1','11 SIJA 2','12 SIJA 1','12 SIJA 2',
                '10 TKJ 1','10 TKJ 2','11 TKJ 1','11 TKJ 2','12 TKJ 1','12 TKJ 2'
            ];
            $ordered = [];
            foreach ($canonical as $c) {
                if (in_array($c, $presentClasses)) $ordered[] = $c;
            }
            // add any non-canonical classes afterwards
            foreach ($presentClasses as $pc) {
                if (!in_array($pc, $ordered)) $ordered[] = $pc;
            }
            // finally include Unassigned as last
            $classes = collect($ordered);

            $tmpZip = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'siswas_export_' . time() . '.zip';
            $zip = new \ZipArchive();
            if ($zip->open($tmpZip, \ZipArchive::CREATE) !== true) {
                return redirect()->route('siswas.index')->with('error', 'Gagal membuat file ekspor.');
            }

            // add overall CSV
            $fp = fopen('php://temp', 'r+');
            fputcsv($fp, ['NIS', 'Nama', 'Kelas', 'Jurusan', 'Kode_Barang']);
            foreach ($allStudents as $s) {
                fputcsv($fp, [$s->nis, $s->nama, $s->kelas, $s->jurusan, $s->kode_barang]);
            }
            rewind($fp);
            $csvAll = stream_get_contents($fp);
            fclose($fp);
            $zip->addFromString('all_students.csv', $csvAll);

            // add per-class CSVs (12 classes will be included if present)
            foreach ($classes as $class) {
                $students = DB::table('siswas')->whereRaw('(kelas IS NULL OR kelas = "") OR kelas = ?',$class === 'Unassigned' ? [''] : [$class])->when($class !== 'Unassigned', function($q) use ($class){
                    return $q->where('kelas',$class);
                })->orderBy('nama')->get();

                $fp = fopen('php://temp', 'r+');
                fputcsv($fp, ['NIS', 'Nama', 'Kelas', 'Jurusan', 'Kode_Barang']);
                foreach ($students as $s) {
                    fputcsv($fp, [$s->nis, $s->nama, $s->kelas, $s->jurusan, $s->kode_barang]);
                }
                rewind($fp);
                $csv = stream_get_contents($fp);
                fclose($fp);

                $safeName = preg_replace('/[^A-Za-z0-9 _-]/', '_', $class);
                $zip->addFromString("class_{$safeName}.csv", $csv);
            }

            $zip->close();

            return response()->download($tmpZip, 'siswas_export_' . date('Ymd_His') . '.zip')->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            report($e);
            return redirect()->route('siswas.index')->with('error', 'Terjadi kesalahan saat membuat file ekspor.');
        }
    }

    public function search(Request $request)
    {
        $q = trim($request->query('q',''));
        $kelas = $request->query('kelas','');
        $jurusan = $request->query('jurusan','');

        // Redirect to index with the query string so filtering/pagination is unified
        $params = array_filter(['q' => $q, 'kelas' => $kelas, 'jurusan' => $jurusan]);
        return redirect()->route('siswas.index', $params);
    }
}
