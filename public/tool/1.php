<?php 


require_once __DIR__ . '/../../vendor/autoload.php';

// Bootstrap Laravel application
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\DB;

echo "OK123";
