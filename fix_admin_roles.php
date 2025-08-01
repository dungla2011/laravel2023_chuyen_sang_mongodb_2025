<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

echo "=== FIX ADMIN USER ROLES ===\n\n";

// Find admin user
$admin = User::where('email', 'admin@abc.com')->first();
if (!$admin) {
    die("❌ Admin user not found!\n");
}

echo "✅ Found admin user: {$admin->email} (ID: {$admin->_id})\n";

// Check current roles
$currentRoles = $admin->_roles()->get();
echo "📊 Current roles: " . $currentRoles->count() . "\n";

// Find or create admin role
$adminRole = Role::where('name', 'Admin')->first();
if (!$adminRole) {
    echo "🔍 Admin role not found, creating...\n";
    $adminRole = new Role();
    $adminRole->name = 'Admin';
    $adminRole->save();
    echo "✅ Created Admin role (ID: {$adminRole->_id})\n";
} else {
    echo "✅ Found Admin role: {$adminRole->name} (ID: {$adminRole->_id})\n";
}

// Clean existing wrong role_user records for this user
echo "\n🧹 Cleaning existing role_user records for user {$admin->_id}...\n";
$deleted = DB::connection('mongodb')->table('role_user')
    ->where('user_id', $admin->_id)
    ->delete();
echo "🗑️ Deleted {$deleted} old records\n";

// Create proper pivot record
echo "\n➕ Creating proper role_user record...\n";
$pivotData = [
    'user_id' => $admin->_id,
    'role_id' => $adminRole->_id,
];

DB::connection('mongodb')->table('role_user')->insert($pivotData);
echo "✅ Created pivot record: user_id={$admin->_id}, role_id={$adminRole->_id}\n";

// Verify the relationship
echo "\n🔍 Verifying relationship...\n";
$admin->refresh(); // Reload from database
$roles = $admin->_roles()->get();
echo "📊 Admin user now has " . $roles->count() . " role(s):\n";

foreach ($roles as $role) {
    echo "- Role: {$role->name} (ID: {$role->_id})\n";
}

// Test role checking functions
echo "\n🧪 Testing role functions...\n";
if (method_exists($admin, 'hasRole')) {
    $hasAdminRole = $admin->hasRole($adminRole->_id);
    echo "hasRole({$adminRole->_id}): " . ($hasAdminRole ? 'TRUE' : 'FALSE') . "\n";
}

if (method_exists($admin, 'getRoleNames')) {
    $roleNames = $admin->getRoleNames();
    echo "getRoleNames(): {$roleNames}\n";
}

echo "\n✅ Admin role assignment completed!\n";
