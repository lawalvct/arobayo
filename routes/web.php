<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/register', [RegistrationController::class, 'create'])->name('register');
Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');
Route::get('/contact', function() {
    return app(\App\Http\Controllers\HomeController::class)->page('contact');
})->name('contact');

// Admin Routes (protected by auth and admin middleware)
Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Events
    Route::resource('events', AdminEventController::class);
    Route::post('/events/bulk-delete', [AdminEventController::class, 'bulkDelete'])->name('events.bulk-delete');

    // Galleries
    Route::resource('galleries', App\Http\Controllers\Admin\GalleryController::class);
    Route::post('/galleries/bulk-delete', [App\Http\Controllers\Admin\GalleryController::class, 'bulkDelete'])->name('galleries.bulk-delete');
    Route::post('/galleries/bulk-toggle-status', [App\Http\Controllers\Admin\GalleryController::class, 'bulkToggleStatus'])->name('galleries.bulk-toggle-status');

    // Executives
    Route::resource('executives', App\Http\Controllers\Admin\ExecutiveController::class);
    Route::post('/executives/bulk-delete', [App\Http\Controllers\Admin\ExecutiveController::class, 'bulkDelete'])->name('executives.bulk-delete');
    Route::post('/executives/bulk-toggle-status', [App\Http\Controllers\Admin\ExecutiveController::class, 'bulkToggleStatus'])->name('executives.bulk-toggle-status');

    // Pages
    Route::resource('pages', App\Http\Controllers\Admin\PageController::class);
    Route::post('pages/upload-image', [App\Http\Controllers\Admin\PageController::class, 'uploadImage'])->name('pages.upload-image');
    Route::post('pages/{page}/save-draft', [App\Http\Controllers\Admin\PageController::class, 'saveDraft'])->name('pages.save-draft');

    // Navigation - Custom routes MUST come before resource routes
    Route::resource('navigations', App\Http\Controllers\Admin\NavigationController::class);

    Route::post('/navigations/update-order', [App\Http\Controllers\Admin\NavigationController::class, 'updateOrder'])->name('navigations.update-order');
    Route::post('/navigations/{navigation}/toggle-status', [App\Http\Controllers\Admin\NavigationController::class, 'toggleStatus'])->name('navigations.toggle-status');
    Route::delete('/navigations/bulk-delete', [App\Http\Controllers\Admin\NavigationController::class, 'bulkDelete'])->name('navigations.bulk-delete');
    Route::post('/navigations/bulk-toggle-status', [App\Http\Controllers\Admin\NavigationController::class, 'bulkToggleStatus'])->name('navigations.bulk-toggle-status');
    // Navigation resource routes (MUST come after custom routes)

    // Site Settings
    Route::get('/settings', [App\Http\Controllers\Admin\SiteSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [App\Http\Controllers\Admin\SiteSettingController::class, 'update'])->name('settings.update');

    // Media Library
    Route::get('/media', [App\Http\Controllers\Admin\MediaController::class, 'index'])->name('media.index');
    Route::post('/media', [App\Http\Controllers\Admin\MediaController::class, 'store'])->name('media.store');
    Route::delete('/media/{media}', [App\Http\Controllers\Admin\MediaController::class, 'destroy'])->name('media.destroy');


    // Registrations
    Route::get('/registrations', [App\Http\Controllers\Admin\RegistrationController::class, 'index'])->name('registrations.index');
    Route::get('/registrations/{id}', [App\Http\Controllers\Admin\RegistrationController::class, 'show'])->name('registrations.show');
    Route::post('/registrations/{id}/status', [App\Http\Controllers\Admin\RegistrationController::class, 'updateStatus'])->name('registrations.update-status');
    Route::delete('/registrations/{id}', [App\Http\Controllers\Admin\RegistrationController::class, 'destroy'])->name('registrations.destroy');
    Route::get('/registrations/documents/{id}/download', [App\Http\Controllers\Admin\RegistrationController::class, 'downloadDocument'])->name('registrations.documents.download');


});

// Dynamic Pages (must be last)
Route::get('/{slug}', [HomeController::class, 'page'])->name('page.show');


