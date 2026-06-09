<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\Admin\MemberStatusController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MembersController as AdminMembersController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\MinistriesController;
use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\Admin\AnnouncementsController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\MessagesController;
use App\Http\Controllers\Admin\OrdersController;

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

    // Member read-only events and announcements
    Route::get('/events', [EventsController::class, 'index'])->name('events.index');
    Route::get('/announcements', [AnnouncementsController::class, 'index'])->name('announcements.index');

    // Audit logs
    Route::get('/audit-logs',            [AuditLogController::class, 'index'])->name('audit_logs.index');
    Route::get('/audit-logs/{auditLog}', [AuditLogController::class, 'show'])->name('audit_logs.show');
    Route::delete('/audit-logs/clear',   [AuditLogController::class, 'clear'])->name('audit_logs.clear');
});

// ---------------------------------------------------------------------------
// Admin-only routes
// ---------------------------------------------------------------------------
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Admin Members
    Route::get('/members', [AdminMembersController::class, 'index'])->name('members.index');
    Route::get('/members/create', [AdminMembersController::class, 'create'])->name('members.create');
    Route::post('/members', [AdminMembersController::class, 'store'])->name('members.store');
    Route::get('/members/{id}', [AdminMembersController::class, 'show'])->name('members.show');
    Route::get('/members/{id}/edit', [AdminMembersController::class, 'edit'])->name('members.edit');
    Route::put('/members/{id}', [AdminMembersController::class, 'update'])->name('members.update');
    Route::delete('/members/{id}', [AdminMembersController::class, 'destroy'])->name('members.destroy');

    // Admin Users
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('/users', [UsersController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UsersController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UsersController::class, 'update'])->name('users.update');
    Route::get('/users/{user}/change-password', [UsersController::class, 'changePassword'])->name('users.changePassword');
    Route::put('/users/{user}/change-password', [UsersController::class, 'updatePassword'])->name('users.updatePassword');
    Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');

    // Admin Ministries
    Route::get('/ministries', [MinistriesController::class, 'index'])->name('ministries.index');
    Route::get('/ministries/create', [MinistriesController::class, 'create'])->name('ministries.create');
    Route::post('/ministries', [MinistriesController::class, 'store'])->name('ministries.store');
    Route::get('/ministries/{ministry}/edit', [MinistriesController::class, 'edit'])->name('ministries.edit');
    Route::put('/ministries/{ministry}', [MinistriesController::class, 'update'])->name('ministries.update');
    Route::delete('/ministries/{ministry}', [MinistriesController::class, 'destroy'])->name('ministries.destroy');

    // Admin Events
    Route::get('/events', [EventsController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventsController::class, 'create'])->name('events.create');
    Route::post('/events', [EventsController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventsController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventsController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventsController::class, 'destroy'])->name('events.destroy');

    // Admin Announcements
    Route::get('/announcements', [AnnouncementsController::class, 'index'])->name('announcements.index');
    Route::get('/announcements/create', [AnnouncementsController::class, 'create'])->name('announcements.create');
    Route::post('/announcements', [AnnouncementsController::class, 'store'])->name('announcements.store');
    Route::get('/announcements/{announcement}/edit', [AnnouncementsController::class, 'edit'])->name('announcements.edit');
    Route::put('/announcements/{announcement}', [AnnouncementsController::class, 'update'])->name('announcements.update');
    Route::delete('/announcements/{announcement}', [AnnouncementsController::class, 'destroy'])->name('announcements.destroy');

    // Admin Banners
    Route::get('/banners', [BannerController::class, 'index'])->name('banners.index');
    Route::get('/banners/create', [BannerController::class, 'create'])->name('banners.create');
    Route::post('/banners', [BannerController::class, 'store'])->name('banners.store');
    Route::get('/banners/{banner}/edit', [BannerController::class, 'edit'])->name('banners.edit');
    Route::put('/banners/{banner}', [BannerController::class, 'update'])->name('banners.update');
    Route::delete('/banners/{banner}', [BannerController::class, 'destroy'])->name('banners.destroy');

    // Admin Messages
    Route::get('/messages', [MessagesController::class, 'index'])->name('messages.index');

    // Admin Orders
    Route::get('/orders', [OrdersController::class, 'index'])->name('orders.index');

    // Member Status permissions management
    Route::get('/member-statuses',                     [MemberStatusController::class, 'index'])->name('member-statuses.index');
    Route::get('/member-statuses/{memberStatus}/edit', [MemberStatusController::class, 'edit'])->name('member-statuses.edit');
    Route::put('/member-statuses/{memberStatus}',      [MemberStatusController::class, 'update'])->name('member-statuses.update');
});
