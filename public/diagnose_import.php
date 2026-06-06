<?php
// Script untuk diagnosa file import

echo "=== DIAGNOSTIC IMPORT TOOL ===\n\n";

// Cek file test yang ada
$testFiles = [
    'public/test_sija_35_rows.csv',
    'public/test_12_kelas_432_siswa.csv',
    'public/test_generated.xlsx',
];

foreach ($testFiles as $file) {
    if (file_exists($file)) {
        echo "Ditemukan file: $file\n";
        echo "Ukuran: " . filesize($file) . " bytes\n";
        
        // Parse file
        if (str_ends_with($file, '.csv')) {
            $handle = fopen($file, 'r');
            $rowCount = 0;
            $rows = [];
            
            while (($row = fgetcsv($handle)) !== false && $rowCount < 5) {
                $rows[] = $row;
                $rowCount++;
            }
            
            // Count total rows
            rewind($handle);
            $totalRows = 0;
            while (fgetcsv($handle) !== false) {
                $totalRows++;
            }
            fclose($handle);
            
            echo "Total baris: $totalRows\n";
            echo "Preview 5 baris pertama:\n";
            foreach ($rows as $i => $row) {
                echo "  Row $i: " . json_encode($row) . "\n";
            }
        } elseif (str_ends_with($file, '.xlsx')) {
            require __DIR__ . '/vendor/autoload.php';
            try {
                $xlsx = \Shuchkin\SimpleXLSX::parse($file);
                $rows = $xlsx->rows();
                echo "Total baris: " . count($rows) . "\n";
                echo "Preview 5 baris pertama:\n";
                foreach (array_slice($rows, 0, 5) as $i => $row) {
                    echo "  Row $i: " . json_encode($row) . "\n";
                }
            } catch (\Exception $e) {
                echo "Error: " . $e->getMessage() . "\n";
            }
        }
        echo "\n";
    }
}

echo "\n=== SIMULATOR IMPORT ===\n";
echo "Jalankan: php scripts/simulate_import.php\n";
echo "Ini akan menunjukkan detail parsing dan error\n";
?>
