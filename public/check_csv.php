<?php
$file = 'test_sija_35_rows.csv';

echo "=== ANALYZING FILE: $file ===\n\n";

// Read file content raw
$content = file_get_contents($file);
echo "File size: " . filesize($file) . " bytes\n";

// Parse as CSV
$handle = fopen($file, 'r');
$rows = [];
$count = 0;

echo "\nFirst 10 rows:\n";
while (($row = fgetcsv($handle)) !== false && $count < 10) {
    echo "Row $count: " . json_encode($row) . "\n";
    $count++;
}
fclose($handle);

// Now count total rows
$handle = fopen($file, 'r');
$totalRows = 0;
while (fgetcsv($handle) !== false) {
    $totalRows++;
}
fclose($handle);

echo "\nTotal rows: $totalRows\n";
?>

