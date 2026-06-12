<?php

use App\Http\Controllers\ChangeRequestAttachmentController;
use App\Http\Controllers\ChangeRequestController;
use App\Http\Controllers\ChangeRequestTimelineController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManagerTimelineController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/up', function () {
    return response()->noContent();
});

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role:client')->group(function () {
        Route::resource('change-requests', ChangeRequestController::class);
        Route::delete('change-requests/{changeRequest}/attachments/{attachment}', [ChangeRequestAttachmentController::class, 'destroy'])
            ->name('change-requests.attachments.destroy');
    });

    Route::middleware('role:client,developer,manager,admin')->group(function () {
        Route::get('change-requests/{changeRequest}/attachments/{attachment}/download', [ChangeRequestAttachmentController::class, 'download'])
            ->name('change-requests.attachments.download');
    });

    Route::middleware('role:developer')->prefix('developer')->name('timelines.')->group(function () {
        Route::get('/timelines', [ChangeRequestTimelineController::class, 'index'])->name('index');
        Route::get('/change-requests/{changeRequest}/timeline/create', [ChangeRequestTimelineController::class, 'create'])->name('create');
        Route::post('/change-requests/{changeRequest}/timeline', [ChangeRequestTimelineController::class, 'store'])->name('store');
        Route::get('/timelines/{timeline}/edit', [ChangeRequestTimelineController::class, 'edit'])->name('edit');
        Route::put('/timelines/{timeline}', [ChangeRequestTimelineController::class, 'update'])->name('update');
    });

    Route::middleware('role:manager')->prefix('manager')->name('manager.')->group(function () {
        Route::get('/timelines', [ManagerTimelineController::class, 'index'])->name('timelines.index');
        Route::get('/timelines/{timeline}', [ManagerTimelineController::class, 'show'])->name('timelines.show');
        Route::post('/timelines/{timeline}/approve', [ManagerTimelineController::class, 'approve'])->name('timelines.approve');
        Route::post('/timelines/{timeline}/reject', [ManagerTimelineController::class, 'reject'])->name('timelines.reject');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
