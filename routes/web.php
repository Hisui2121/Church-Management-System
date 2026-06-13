<?php

use App\Http\Controllers\Admin\AnnouncementsController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\Admin\MembersController as AdminMembersController;
use App\Http\Controllers\Admin\MembersExportController;
use App\Http\Controllers\Admin\MessagesController;
use App\Http\Controllers\Admin\MinistriesController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\UserPermissionController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

// ── Landing / redirect ────────────────────────────────────────────────────────
Route::redirect('/', '/login');
Route::get('/hello', [HelloController::class, 'index'])->name('landing');

// ── Guest-only routes ─────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {

    // Multi-step registration
    Route::get('/register/account',  [RegisterController::class, 'accountForm'])->name('register.account');
    Route::post('/register/account', [RegisterController::class, 'saveAccount']);

    Route::group([], function () {
        Route::get('/register/personal',  [RegisterController::class, 'personalForm'])->name('register.personal');
        Route::post('/register/personal', [RegisterController::class, 'savePersonal']);

        Route::get('/register/review',  [RegisterController::class, 'review'])->name('register.review');
        Route::post('/register/submit', [RegisterController::class, 'submit'])->name('register.submit');
    });

    // Login
    Route::get('/login',  [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:5,1');
});

// ── Authenticated routes ──────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    // Profile & Settings pages (simple placeholders)
    Route::get('/profile', function () { return view('profile'); })->name('profile');
    Route::get('/settings', function () { return view('settings'); })->name('settings');

    // Member dashboard & check-in
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
    Route::post('/dashboard/check-in', [DashboardController::class, 'checkIn'])->name('member.check_in');

    // Member CRUD (Policy-controlled)
    Route::resource('members', MemberController::class);

    // Shared read-only views (members + admins)
    Route::get('/events',        [EventsController::class, 'index'])->name('events.index');
    Route::get('/announcements', [AnnouncementsController::class, 'index'])->name('announcements.index');
    Route::get('/ministries',    [MinistriesController::class, 'index'])->name('ministries.index');

    // Audit logs (permission guarded inside controller)
    Route::prefix('audit-logs')->name('audit_logs.')->group(function () {
        Route::get('/',             [AuditLogController::class, 'index'])->name('index');
        Route::get('/{auditLog}',   [AuditLogController::class, 'show'])->name('show');
        Route::delete('/clear',     [AuditLogController::class, 'clear'])->name('clear');
    });
});

// ── Admin-only routes ─────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Members
        Route::get('/members',               [AdminMembersController::class, 'index'])->name('members.index');
        Route::get('/members/create',        [AdminMembersController::class, 'create'])->name('members.create');
        Route::get('/members/export',        [MembersExportController::class, 'export'])->name('members.export');
        Route::get('/members/report',        [MembersExportController::class, 'report'])->name('members.report');
        Route::post('/members',              [AdminMembersController::class, 'store'])->name('members.store');
        Route::get('/members/{id}',          [AdminMembersController::class, 'show'])->name('members.show');
        Route::get('/members/{id}/edit',     [AdminMembersController::class, 'edit'])->name('members.edit');
        Route::put('/members/{id}',          [AdminMembersController::class, 'update'])->name('members.update');
        Route::delete('/members/{id}',       [AdminMembersController::class, 'destroy'])->name('members.destroy');

        // Users
        Route::get('/users',                          [UsersController::class, 'index'])->name('users.index');
        Route::get('/users/create',                   [UsersController::class, 'create'])->name('users.create');
        Route::post('/users',                         [UsersController::class, 'store'])->name('users.store');
        Route::get('/users/{user}',                   [UsersController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit',              [UsersController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}',                   [UsersController::class, 'update'])->name('users.update');
        Route::get('/users/{user}/change-password',   [UsersController::class, 'changePassword'])->name('users.changePassword');
        Route::put('/users/{user}/change-password',   [UsersController::class, 'updatePassword'])->name('users.updatePassword');
        Route::delete('/users/{user}',                [UsersController::class, 'destroy'])->name('users.destroy');

        // Ministries
        Route::get('/ministries',                     [MinistriesController::class, 'index'])->name('ministries.index');
        Route::get('/ministries/create',              [MinistriesController::class, 'create'])->name('ministries.create');
        Route::post('/ministries',                    [MinistriesController::class, 'store'])->name('ministries.store');
        Route::post('/ministries/{ministry}/members/{user}', [MinistriesController::class, 'assignMember'])->name('ministries.members.assign');
        Route::delete('/ministries/{ministry}/members/{user}', [MinistriesController::class, 'removeMember'])->name('ministries.members.remove');
        Route::get('/ministries/{ministry}',          [MinistriesController::class, 'show'])->name('ministries.show');
        Route::get('/ministries/{ministry}/edit',     [MinistriesController::class, 'edit'])->name('ministries.edit');
        Route::put('/ministries/{ministry}',          [MinistriesController::class, 'update'])->name('ministries.update');
        Route::delete('/ministries/{ministry}',       [MinistriesController::class, 'destroy'])->name('ministries.destroy');

        // Events
        Route::get('/events',                         [EventsController::class, 'index'])->name('events.index');
        Route::get('/events/create',                  [EventsController::class, 'create'])->name('events.create');
        Route::post('/events',                        [EventsController::class, 'store'])->name('events.store');
        Route::get('/events/{event}/edit',            [EventsController::class, 'edit'])->name('events.edit');
        Route::put('/events/{event}',                 [EventsController::class, 'update'])->name('events.update');
        Route::delete('/events/{event}',              [EventsController::class, 'destroy'])->name('events.destroy');

        // Announcements
        Route::get('/announcements',                      [AnnouncementsController::class, 'index'])->name('announcements.index');
        Route::get('/announcements/create',               [AnnouncementsController::class, 'create'])->name('announcements.create');
        Route::post('/announcements',                     [AnnouncementsController::class, 'store'])->name('announcements.store');
        Route::get('/announcements/{announcement}/edit',  [AnnouncementsController::class, 'edit'])->name('announcements.edit');
        Route::put('/announcements/{announcement}',       [AnnouncementsController::class, 'update'])->name('announcements.update');
        Route::delete('/announcements/{announcement}',    [AnnouncementsController::class, 'destroy'])->name('announcements.destroy');

        // Banners
        Route::get('/banners',               [BannerController::class, 'index'])->name('banners.index');
        Route::get('/banners/create',        [BannerController::class, 'create'])->name('banners.create');
        Route::post('/banners',              [BannerController::class, 'store'])->name('banners.store');
        Route::get('/banners/{banner}/edit', [BannerController::class, 'edit'])->name('banners.edit');
        Route::put('/banners/{banner}',      [BannerController::class, 'update'])->name('banners.update');
        Route::delete('/banners/{banner}',   [BannerController::class, 'destroy'])->name('banners.destroy');

        // Attendance
        Route::resource('attendance', AttendanceController::class)->only(['index', 'create', 'store']);

        // Permissions (Role-based)
        Route::get('/permissions',              [UserPermissionController::class, 'index'])->name('permissions.index');
        Route::post('/permissions',             [UserPermissionController::class, 'store'])->name('permissions.store');
        Route::get('/permissions/{role}/edit',  [UserPermissionController::class, 'edit'])->name('permissions.edit');
        Route::put('/permissions/{role}',       [UserPermissionController::class, 'update'])->name('permissions.update');
        Route::delete('/permissions/{role}',    [UserPermissionController::class, 'destroy'])->name('permissions.destroy');

        // Messages
        Route::get('/messages',                    [MessagesController::class, 'index'])->name('messages.index');
        Route::post('/messages',                   [MessagesController::class, 'store'])->name('messages.store');
        Route::patch('/messages/{message}/read',   [MessagesController::class, 'markRead'])->name('messages.read');
        Route::delete('/messages/{message}',       [MessagesController::class, 'destroy'])->name('messages.destroy');

        // Orders
        Route::get('/orders',            [OrdersController::class, 'index'])->name('orders.index');
        Route::put('/orders/{order}',    [OrdersController::class, 'update'])->name('orders.update');
        Route::delete('/orders/{order}', [OrdersController::class, 'destroy'])->name('orders.destroy');
    });
