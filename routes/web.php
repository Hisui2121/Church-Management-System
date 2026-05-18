<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\RegisterController;

// ==========================================
// 1. ROOT / LANDING PAGE ROUTE
// ==========================================
Route::get('/', [HelloController::class, 'index'])->name('landing');

// ==========================================
// 2. MULTI-STEP REGISTRATION ROUTES
// ==========================================
// Step 1: Account Creation
Route::get('/register/account', [RegisterController::class, 'accountForm'])->name('register.account');
Route::post('/register/account', [RegisterController::class, 'saveAccount']);

// Step 2: Personal Information
Route::get('/register/personal', [RegisterController::class, 'personalForm'])->name('register.personal');
Route::post('/register/personal', [RegisterController::class, 'savePersonal']);

// Step 3: Church Information
Route::get('/register/church', [RegisterController::class, 'churchForm'])->name('register.church');
Route::post('/register/church', [RegisterController::class, 'saveChurch']);

// Step 4: Final Review & Submit
Route::get('/register/review', [RegisterController::class, 'review'])->name('register.review');
Route::post('/register/submit', [RegisterController::class, 'submit']);

// ==========================================
// 3. AUTHENTICATION ROUTES (LOGIN & HOME)
// ==========================================
// Pagpapakita ng Login Form
Route::get('/login', function(){
    return view('login');
})->name('login');

// Pagsalo sa Login Form Submit (Temporary Logic)
Route::post('/login', function() {
    return redirect()->route('home');
});

// ANG NAWALA MONG ROUTE (Pansamantalang bagsakan ng logged-in users)
Route::get('/home', function () {
    return view('home');
})->name('home');