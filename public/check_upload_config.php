<?php
// Diagnostic script untuk cek PHP configuration
echo "=== PHP Upload Configuration ===\n\n";
echo "upload_max_filesize: " . ini_get('upload_max_filesize') . "\n";
echo "post_max_size: " . ini_get('post_max_size') . "\n";
echo "memory_limit: " . ini_get('memory_limit') . "\n";
echo "max_execution_time: " . ini_get('max_execution_time') . " seconds\n";
echo "max_input_vars: " . ini_get('max_input_vars') . "\n";

echo "\n=== Disk Space ===\n";
echo "Disk free space: " . round(disk_free_space('/') / 1024 / 1024) . " MB\n";

echo "\n=== PHP Version ===\n";
echo "PHP Version: " . phpversion() . "\n";

// Calculate approximate max rows based on average row size
$avgRowSize = 100; // bytes per row (rough estimate)
$uploadMax = convertToBytes(ini_get('upload_max_filesize'));
$postMax = convertToBytes(ini_get('post_max_size'));
$effectiveMax = min($uploadMax, $postMax);
$maxApproxRows = floor($effectiveMax / $avgRowSize);

echo "\n=== Estimasi Baris Maksimal ===\n";
echo "Batasan efektif: " . round($effectiveMax / 1024 / 1024) . " MB\n";
echo "Perkiraan max rows (100 bytes/row): " . $maxApproxRows . " rows\n";

function convertToBytes($value) {
    $value = trim($value);
    $unit = strtoupper(substr($value, -1));
    $value = (int) $value;
    
    switch ($unit) {
        case 'M': return $value * 1024 * 1024;
        case 'K': return $value * 1024;
        case 'G': return $value * 1024 * 1024 * 1024;
        default: return $value;
    }
}
?>
