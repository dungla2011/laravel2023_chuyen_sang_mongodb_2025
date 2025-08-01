<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\DB;

echo "=== MIGRATE PIVOT TABLE TO EMBEDDED ROLES ===\n\n";

// Get all users
$users = User::all();
echo "📊 Total users to migrate: " . $users->count() . "\n\n";

$migrated = 0;
$errors = 0;

foreach ($users as $user) {
    echo "👤 Processing user: {$user->email} (ID: {$user->_id})\n";
    
    try {
        // Get roles from pivot table
        $roleIds = DB::connection('mongodb')
            ->table('role_user')
            ->where('user_id', $user->_id)
            ->pluck('role_id')
            ->toArray();
        
        if (!empty($roleIds)) {
            // Update user with embedded role_ids
            $user->role_ids = $roleIds;
            $user->save();
            
            echo "  ✅ Added " . count($roleIds) . " roles: [" . implode(', ', $roleIds) . "]\n";
            $migrated++;
        } else {
            echo "  ⚠️  No roles found in pivot table\n";
        }
        
    } catch (Exception $e) {
        echo "  ❌ Error: " . $e->getMessage() . "\n";
        $errors++;
    }
    
    echo "\n";
}

echo "=== MIGRATION SUMMARY ===\n";
echo "✅ Users migrated: $migrated\n";
echo "❌ Errors: $errors\n";

// Test the new embedded approach
echo "\n=== TESTING EMBEDDED ROLES ===\n";
$admin = User::where('email', 'admin@abc.com')->first();
if ($admin && isset($admin->role_ids)) {
    echo "🧪 Admin role_ids: [" . implode(', ', $admin->role_ids) . "]\n";
    
    // Test manual role lookup
    $roles = DB::connection('mongodb')
        ->table('roles')
        ->whereIn('_id', $admin->role_ids)
        ->get(['_id', 'name']);
    
    echo "🔍 Roles found:\n";
    foreach ($roles as $role) {
        echo "  - {$role->name} (ID: {$role->_id})\n";
    }
} else {
    echo "⚠️  Admin user has no embedded role_ids\n";
}

echo "\n✅ Migration completed!\n";
