<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

echo "=== DEBUG BELONGSTOMANY RELATIONSHIP ===\n\n";

// Get admin user
$admin = User::where('email', 'admin@abc.com')->first();
echo "✅ Admin user: {$admin->email} (ID: {$admin->_id})\n";

// Manual check what belongsToMany query generates
echo "\n🔍 Debug relationship execution:\n";
try {
    $roles = $admin->_roles()->get();
    echo "✅ Relationship executed successfully\n";
    echo "📊 Roles found: " . $roles->count() . "\n";
} catch (Exception $e) {
    echo "❌ Relationship error: " . $e->getMessage() . "\n";
}

// Check raw pivot data
echo "\n📊 Raw pivot data:\n";
$pivotData = DB::connection('mongodb')->table('role_user')
    ->where('user_id', $admin->_id)
    ->get();
    
foreach ($pivotData as $pivot) {
    echo "- user_id: {$pivot->user_id}, role_id: {$pivot->role_id}\n";
    
    // Try to find the role manually
    $role = Role::where('_id', $pivot->role_id)->first();
    if ($role) {
        echo "  → Role found: {$role->name}\n";
    } else {
        echo "  → Role NOT found!\n";
    }
}

// Try manual relationship join
echo "\n🔗 Manual join test:\n";
$roleIds = $pivotData->pluck('role_id')->toArray();
echo "Role IDs from pivot: " . implode(', ', $roleIds) . "\n";

$roles = Role::whereIn('_id', $roleIds)->get();
echo "Roles found by whereIn: " . $roles->count() . "\n";
foreach ($roles as $role) {
    echo "- {$role->name} (ID: {$role->_id})\n";
}

// Check if both models use same connection
echo "\n🔌 Connection check:\n";
echo "User connection: " . $admin->getConnectionName() . "\n";
if ($roles->count() > 0) {
    echo "Role connection: " . $roles->first()->getConnectionName() . "\n";
}

echo "\n=== DEBUG COMPLETED ===\n";
