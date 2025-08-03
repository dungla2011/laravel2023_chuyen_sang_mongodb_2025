<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\MenuTree;
use MongoDB\BSON\ObjectId;
use Illuminate\Support\Facades\DB;

echo "=== FIXED IMPORT SQL DATA TO MONGODB ===\n\n";

// Read SQL file
$sqlFile = __DIR__ . '/menu_trees.sql';
if (!file_exists($sqlFile)) {
    die("Error: SQL file not found: $sqlFile\n");
}

$sqlContent = file_get_contents($sqlFile);

// Parse INSERT statements using regex
preg_match_all(
    '/INSERT INTO `menu_trees` \(`id`, `name`, `parent_id`, `created_at`, `updated_at`, `deleted_at`, `orders`, `link`, `gid_allow`, `open_new_window`, `icon`, `id_news`\) VALUES\s*(.*?);/s',
    $sqlContent,
    $matches
);

if (empty($matches[1])) {
    die("Error: No INSERT statements found in SQL file\n");
}

// Parse VALUES data
$allData = [];

foreach ($matches[1] as $valuesSection) {
    preg_match_all('/\(([^)]+)\)/s', $valuesSection, $rowMatches);
    
    foreach ($rowMatches[1] as $row) {
        $values = [];
        $parts = str_getcsv($row, ',', "'");
        
        foreach ($parts as $part) {
            $part = trim($part);
            if ($part === 'NULL') {
                $values[] = null;
            } elseif (is_numeric($part)) {
                $values[] = (int)$part;
            } else {
                $values[] = trim($part, "'\"");
            }
        }
        
        if (count($values) >= 12) {
            $allData[] = [
                'old_id' => $values[0],
                'name' => $values[1],
                'old_parent_id' => $values[2],
                'created_at' => $values[3],
                'updated_at' => $values[4],
                'deleted_at' => $values[5],
                'orders' => $values[6],
                'link' => $values[7],
                'gid_allow' => $values[8],
                'open_new_window' => $values[9],
                'icon' => $values[10],
                'id_news' => $values[11]
            ];
        }
    }
}

echo "Parsed " . count($allData) . " records from SQL file\n\n";

// Clear existing collection first
echo "Clearing existing menu_trees collection...\n";
MenuTree::truncate();

// Pass 1: Insert all records without parent_id (with known ObjectIds)
echo "Pass 1: Inserting records and building ObjectId mapping...\n";
$idMapping = [];
$insertedCount = 0;

foreach ($allData as $record) {
    try {
        $menuTree = new MenuTree();
        
        // Generate ObjectId manually
        $objectId = new \MongoDB\BSON\ObjectId();
        $menuTree->_id = $objectId;
        
        $menuTree->name = $record['name'];
        $menuTree->parent_id = null; // Will be set in pass 2
        $menuTree->created_at = $record['created_at'] ? new \MongoDB\BSON\UTCDateTime(strtotime($record['created_at']) * 1000) : null;
        $menuTree->updated_at = $record['updated_at'] ? new \MongoDB\BSON\UTCDateTime(strtotime($record['updated_at']) * 1000) : null;
        $menuTree->deleted_at = $record['deleted_at'] ? new \MongoDB\BSON\UTCDateTime(strtotime($record['deleted_at']) * 1000) : null;
        $menuTree->orders = $record['orders'] ?? 0;
        $menuTree->link = $record['link'] ?? '';
        $menuTree->gid_allow = $record['gid_allow'];
        $menuTree->open_new_window = $record['open_new_window'] ?? 0;
        $menuTree->icon = $record['icon'];
        $menuTree->id_news = $record['id_news'];
        $menuTree->old_id = $record['old_id'];
        $menuTree->old_parent_id = $record['old_parent_id'];
        
        $menuTree->save();
        
        // Debug the actual ObjectId before storing
        if ($record['old_id'] == 4) { // Debug Admin Menu specifically
            echo "DEBUG Admin Menu ObjectId after save: " . var_export($menuTree->_id, true) . "\n";
            echo "DEBUG Admin Menu ObjectId as string: '" . (string)$menuTree->_id . "'\n";
        }
        
        // Store the actual ObjectId that was created using integer key (AFTER save)
        $idMapping[(int)$record['old_id']] = (string)$menuTree->_id;
        $insertedCount++;
        
        if ($insertedCount % 50 == 0) {
            echo "Inserted $insertedCount records...\n";
        }
        
    } catch (\Exception $e) {
        echo "Error inserting record {$record['old_id']}: " . $e->getMessage() . "\n";
    }
}

echo "Pass 1 completed: $insertedCount records inserted\n\n";

// Debug ID mapping
echo "=== DEBUG ID MAPPING ===\n";
echo "ID Mapping contains " . count($idMapping) . " entries\n";
$sampleKeys = array_slice(array_keys($idMapping), 0, 10);
foreach ($sampleKeys as $key) {
    echo "- Key $key -> ObjectId: {$idMapping[$key]}\n";
}
echo "\nChecking specific parent IDs in mapping:\n";
$checkIds = [1, 3, 4, 89, 260, 262, 261, 543];
foreach ($checkIds as $id) {
    if (isset($idMapping[$id])) {
        echo "✓ ID $id found in mapping\n";
    } else {
        echo "✗ ID $id NOT in mapping\n";
    }
}
echo "========================\n\n";

// Pass 2: Update parent_id relationships
echo "Pass 2: Setting parent_id relationships...\n";
$updated = 0;
$orphans = 0;

foreach ($allData as $record) {
    if ($record['old_parent_id'] && $record['old_parent_id'] != 0) {
        // Convert to integer to match database type
        $parent_id_int = (int)$record['old_parent_id'];
        $child_id_int = (int)$record['old_id'];
        
        if (isset($idMapping[$parent_id_int])) {
            // Check if both parent and child are active (not soft deleted)
            $parent = MenuTree::where('old_id', $parent_id_int)->first();
            $child = MenuTree::where('old_id', $child_id_int)->first();
            
            if ($parent && $child) {
                // Update the record with correct parent_id using integer old_id
                $child->parent_id = (string)$idMapping[$parent_id_int];
                $child->save();
                $updated++;
                
                if ($parent_id_int == 4) {
                    echo "✓ Set parent for '{$record['name']}' -> Admin Menu ObjectId: {$idMapping[$parent_id_int]}\n";
                }
            } else {
                if (!$parent) {
                    echo "⚠ Warning: Parent ID {$record['old_parent_id']} is deleted/inactive for record '{$record['name']}'\n";
                } else {
                    echo "⚠ Warning: Child ID {$record['old_id']} is deleted/inactive for record '{$record['name']}'\n";
                }
                $orphans++;
            }
        } else {
            echo "⚠ Warning: Parent ID {$record['old_parent_id']} not found in mapping for record '{$record['name']}'\n";
            $orphans++;
        }
    }
}

echo "Pass 2 completed: $updated relationships set, $orphans orphans\n\n";

// Verification
echo "=== VERIFICATION ===\n";
$total = MenuTree::withTrashed()->count();
$active = MenuTree::count();
$deleted = MenuTree::onlyTrashed()->count();

echo "Total records: $total (Active: $active, Deleted: $deleted)\n\n";

// Test Admin Menu specifically
$adminMenu = MenuTree::withTrashed()->where('old_id', 4)->first();
if ($adminMenu) {
    echo "Admin Menu: '{$adminMenu->name}' (ObjectId: {$adminMenu->_id})\n";
    
    $activeChildren = MenuTree::where('parent_id', $adminMenu->_id)->count();
    $allChildren = MenuTree::withTrashed()->where('parent_id', $adminMenu->_id)->count();
    
    echo "Admin Menu children: $allChildren total ($activeChildren active)\n\n";
    
    if ($allChildren > 0) {
        echo "Sample children:\n";
        $samples = MenuTree::withTrashed()->where('parent_id', $adminMenu->_id)->take(5)->get();
        foreach ($samples as $child) {
            $status = $child->deleted_at ? 'DELETED' : 'ACTIVE';
            echo "- {$child->name} ($status)\n";
        }
    }
}

echo "\n=== IMPORT COMPLETED ===\n";
