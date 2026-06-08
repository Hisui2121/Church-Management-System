<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\Admin\MemberStatusController;

Route::redirect('/', '/login');

// ---------------------------------------------------------------------------
// Guest routes
// ---------------------------------------------------------------------------
Route::middleware('guest')->group(function () {

    Route::get('/register/account',  [RegisterController::class, 'accountForm'])->name('register.account');
    Route::post('/register/account', [RegisterController::class, 'saveAccount']);

    Route::get('/register/personal',  [RegisterController::class, 'personalForm'])->name('register.personal');
    Route::post('/register/personal', [RegisterController::class, 'savePersonal']);

    Route::get('/register/church',  [RegisterController::class, 'churchForm'])->name('register.church');
    Route::post('/register/church', [RegisterController::class, 'saveChurch']);

    Route::get('/register/review',  [RegisterController::class, 'review'])->name('register.review');
    Route::post('/register/submit', [RegisterController::class, 'submit']);

    Route::get('/login',  [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// ---------------------------------------------------------------------------
// Authenticated routes
// ---------------------------------------------------------------------------
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Members — Policy handles per-action authorization
    Route::resource('members', MemberController::class);

    // Audit logs
    Route::get('/audit-logs',            [AuditLogController::class, 'index'])->name('audit_logs.index');
    Route::get('/audit-logs/{auditLog}', [AuditLogController::class, 'show'])->name('audit_logs.show');
});

// ---------------------------------------------------------------------------
// Admin-only routes
// ---------------------------------------------------------------------------
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {

    // Member Status permissions management
    Route::get('/member-statuses',                     [MemberStatusController::class, 'index'])->name('member-statuses.index');
    Route::get('/member-statuses/{memberStatus}/edit', [MemberStatusController::class, 'edit'])->name('member-statuses.edit');
    Route::put('/member-statuses/{memberStatus}',      [MemberStatusController::class, 'update'])->name('member-statuses.update');
});
