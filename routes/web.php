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
    Route::resource('events', AdminEventController::class);
    Route::post('/events/bulk-delete', [AdminEventController::class, 'bulkDelete'])->name('events.bulk-delete');
    Route::resource('galleries', App\Http\Controllers\Admin\GalleryController::class);
    Route::post('/galleries/bulk-delete', [App\Http\Controllers\Admin\GalleryController::class, 'bulkDelete'])->name('galleries.bulk-delete');
    Route::post('/galleries/bulk-toggle-status', [App\Http\Controllers\Admin\GalleryController::class, 'bulkToggleStatus'])->name('galleries.bulk-toggle-status');
    Route::resource('pages', App\Http\Controllers\Admin\PageController::class);
    Route::post('pages/upload-image', [App\Http\Controllers\Admin\PageController::class, 'uploadImage'])->name('pages.upload-image');
});

// Dynamic Pages (must be last)
Route::get('/{slug}', [HomeController::class, 'page'])->name('page.show');
