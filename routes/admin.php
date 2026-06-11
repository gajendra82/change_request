<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\ChangeRequestController as AdminChangeRequestController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ClientUserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DeveloperController;
use App\Http\Controllers\Admin\ManagerController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('clients', ClientController::class);
    Route::post('clients/{client}/toggle-status', [ClientController::class, 'toggleStatus'])->name('clients.toggle-status');

    Route::resource('client-users', ClientUserController::class);
    Route::post('client-users/{client_user}/toggle-status', [ClientUserController::class, 'toggleStatus'])->name('client-users.toggle-status');
    Route::post('client-users/{client_user}/reset-password', [ClientUserController::class, 'resetPassword'])->name('client-users.reset-password');

    Route::resource('developers', DeveloperController::class);
    Route::post('developers/{developer}/toggle-status', [DeveloperController::class, 'toggleStatus'])->name('developers.toggle-status');
    Route::post('developers/{developer}/reset-password', [DeveloperController::class, 'resetPassword'])->name('developers.reset-password');

    Route::resource('managers', ManagerController::class);
    Route::post('managers/{manager}/toggle-status', [ManagerController::class, 'toggleStatus'])->name('managers.toggle-status');
    Route::post('managers/{manager}/reset-password', [ManagerController::class, 'resetPassword'])->name('managers.reset-password');

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');

    Route::resource('projects', ProjectController::class);

    Route::get('change-requests', [AdminChangeRequestController::class, 'index'])->name('change-requests.index');
    Route::get('change-requests/{changeRequest}', [AdminChangeRequestController::class, 'show'])->name('change-requests.show');

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings/company', [SettingController::class, 'updateCompany'])->name('settings.company');
    Route::put('settings/notifications', [SettingController::class, 'updateNotifications'])->name('settings.notifications');

    Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

    Route::get('profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [AdminProfileController::class, 'update'])->name('profile.update');
});
