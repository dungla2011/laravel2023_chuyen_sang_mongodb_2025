<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

echo "=== TEST BELONGSTOMANY RELATIONSHIP ===\n\n";

// Test 1: Lấy user đầu tiên
echo "📋 Test 1: Lấy user và roles\n";
$user = User::first();
if ($user) {
    echo "✅ User found: {$user->email} (ID: {$user->_id})\n";
    
    try {
        echo "🔍 Testing _roles() relationship...\n";
        $roles = $user->_roles()->get();
        echo "✅ Roles query executed successfully\n";
        echo "📊 Roles count: " . $roles->count() . "\n";
        
        if ($roles->count() > 0) {
            echo "\n📝 Roles list:\n";
            foreach ($roles as $role) {
                echo "- Role ID: {$role->id}, Name: " . ($role->name ?? 'N/A') . "\n";
            }
        } else {
            echo "⚠️  No roles found for this user\n";
        }
        
    } catch (Exception $e) {
        echo "❌ Error with _roles() relationship: " . $e->getMessage() . "\n";
    }
} else {
    echo "❌ No users found\n";
}

echo "\n" . str_repeat("-", 50) . "\n";

// Test 2: Kiểm tra role_user collection
echo "📋 Test 2: Kiểm tra role_user collection\n";
try {
    $roleUserCount = DB::connection('mongodb')->table('role_user')->count();
    echo "✅ role_user collection exists with {$roleUserCount} documents\n";
    
    if ($roleUserCount > 0) {
        $sampleRoleUser = DB::connection('mongodb')->table('role_user')->first();
        echo "📄 Sample role_user document:\n";
        print_r($sampleRoleUser);
    }
    
} catch (Exception $e) {
    echo "❌ Error accessing role_user collection: " . $e->getMessage() . "\n";
}

echo "\n" . str_repeat("-", 50) . "\n";

// Test 3: Kiểm tra roles collection
echo "📋 Test 3: Kiểm tra roles collection\n";
try {
    $rolesCount = DB::connection('mongodb')->table('roles')->count();
    echo "✅ roles collection exists with {$rolesCount} documents\n";
    
    if ($rolesCount > 0) {
        $sampleRole = DB::connection('mongodb')->table('roles')->first();
        echo "📄 Sample role document:\n";
        print_r($sampleRole);
    }
    
} catch (Exception $e) {
    echo "❌ Error accessing roles collection: " . $e->getMessage() . "\n";
}

echo "\n=== TEST COMPLETED ===\n";
