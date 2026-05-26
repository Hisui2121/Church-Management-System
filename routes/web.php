<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MemberController;

Route::get('/', function () {
    return view('/login');
});
Route::middleware('guest')->group(function () {

    // STEP 1
    Route::get('/register/account', [RegisterController::class, 'accountForm']);
    Route::post('/register/account', [RegisterController::class, 'saveAccount']);

    // STEP 2
    Route::get('/register/personal', [RegisterController::class, 'personalForm']);
    Route::post('/register/personal', [RegisterController::class, 'savePersonal']);

    // STEP 3
    Route::get('/register/review', [RegisterController::class, 'review']);
    Route::post('/register/submit', [RegisterController::class, 'submit']);

});

Route::get('/login', [LoginController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [LoginController::class, 'store'])
    ->middleware('guest');

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/hello', [HelloController::class, 'index']);

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('members', MemberController::class);
    Route::get('/member', [MemberController::class, 'index'])
        ->name('member.index');

});
