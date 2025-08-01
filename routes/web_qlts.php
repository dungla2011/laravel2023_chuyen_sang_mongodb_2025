<?php

use App\Components\Route2;
use Illuminate\Support\Facades\Route;

$routeName = 'public.qlts.scan_qr';
$r = Route2::match(['get', 'post'], '/scan-qr', [
    \App\Http\Controllers\QltsController::class, 'scanQr',
])->name($routeName);//->middleware('can:'.$routeName);
$r->route_desc_ = 'Tạo Menu';
