<?php

use App\Components\Route2;
use Illuminate\Support\Facades\Route;

Route2::get('/login', [
    \App\Http\Controllers\LoginController::class, 'login',
])->name('login.login');

Route2::get('/register', [
    \App\Http\Controllers\LoginController::class, 'register',
])->name('auth.register');

Route2::post('/register', [
    \App\Http\Controllers\LoginController::class, 'register',
])->name('auth.registerPost');

Route2::get('/reset-password', [
    \App\Http\Controllers\LoginController::class, 'resetPassword',
])->name('auth.resetPassword');

Route2::post('/reset-password', [
    \App\Http\Controllers\LoginController::class, 'resetPassword',
])->name('auth.resetPasswordPost');

Route2::get('/reset-password-act', [
    \App\Http\Controllers\LoginController::class, 'resetPasswordAct',
])->name('auth.resetPasswordAct');

Route2::post('/reset-password-act', [
    \App\Http\Controllers\LoginController::class, 'resetPasswordAct',
])->name('auth.resetPasswordAct.Post');

Route2::get('/active-account', [
    \App\Http\Controllers\LoginController::class, 'activeAccount',
])->name('auth.activeAccount');

Route2::post('/active-account', [
    \App\Http\Controllers\LoginController::class, 'activeAccount',
])->name('auth.activeAccount.Post');

Route2::get('/logout', [
    \App\Http\Controllers\LoginController::class, 'logout',
]);

Route2::post('/post-login', [
    \App\Http\Controllers\LoginController::class, 'postLogin',
])->name('post.login');

Route2::get('/post-login', [
    \App\Http\Controllers\LoginController::class, 'postLogin',
])->name('get.login');

//Google Login:
Route::get('auth/google', [\App\Http\Controllers\LoginController::class, 'redirectToGoogle']);

Route::get('google/callback', [\App\Http\Controllers\LoginController::class, 'handleGoogleCallback']);
