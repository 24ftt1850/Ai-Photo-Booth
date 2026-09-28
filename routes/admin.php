<?php

use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\PrintQueueController;
use App\Http\Controllers\Admin\ThemeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::redirect('/', '/admin/dashboard');

    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::resource('events', EventController::class);

    Route::patch('themes/{theme}/toggle', [ThemeController::class, 'toggle'])->name('themes.toggle');
    Route::resource('themes', ThemeController::class)->except('show');

    Route::get('analytics', AnalyticsController::class)->name('analytics');

    Route::get('prints', [PrintQueueController::class, 'index'])->name('prints.index');
    Route::patch('prints/{generatedImage}/printed', [PrintQueueController::class, 'markPrinted'])->name('prints.printed');
    Route::delete('prints/{generatedImage}', [PrintQueueController::class, 'destroy'])->name('prints.destroy');
});
