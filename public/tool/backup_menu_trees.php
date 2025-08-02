<?php 

require_once __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\MenuTree;
use Illuminate\Support\Facades\DB;

echo "=== BACKUP CURRENT MENU_TREES ===" . PHP_EOL;

$allRecords = MenuTree::all();
$backupData = $allRecords->toArray();

$backupFile = __DIR__ . '/menu_trees_backup_' . date('Y-m-d_H-i-s') . '.json';
file_put_contents($backupFile, json_encode($backupData, JSON_PRETTY_PRINT));

echo "✅ Backup created: " . basename($backupFile) . PHP_EOL;
echo "   Records backed up: " . count($backupData) . PHP_EOL;
echo "   File size: " . formatBytes(filesize($backupFile)) . PHP_EOL;

function formatBytes($size, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB');
    for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
        $size /= 1024;
    }
    return round($size, $precision) . ' ' . $units[$i];
}

echo PHP_EOL . "First 3 records preview:" . PHP_EOL;
foreach (array_slice($backupData, 0, 3) as $i => $record) {
    echo "Record " . ($i + 1) . ": ID={$record['id']}, parent_id={$record['parent_id']}, name='{$record['name']}'" . PHP_EOL;
}

echo PHP_EOL . "✅ Backup completed successfully!" . PHP_EOL;
