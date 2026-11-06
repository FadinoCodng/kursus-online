<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Aplikasi Lembaga Pelatihan Teknologi (Kelas Online)
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. LANDING PAGE & PUBLIK
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/courses/{slug}', [HomeController::class, 'showCourse'])->name('courses.show');
Route::post('/courses/register', [HomeController::class, 'registerCourse'])->name('courses.register');

// Fitur Bonus: Halaman Artikel / Blog
Route::get('/articles', [HomeController::class, 'articles'])->name('articles.index');
Route::get('/articles/{slug}', [HomeController::class, 'showArticle'])->name('articles.show');

// ==========================================
// 2. AUTENTIKASI ADMIN
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ==========================================
// 3. DASHBOARD ADMIN (PROTECTED)
// ==========================================
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Kategori
    Route::resource('categories', CategoryController::class)->except(['show']);

    // CRUD Kelas
    Route::resource('courses', CourseController::class);

    // Kelola Pendaftar
    Route::get('/registrations', [RegistrationController::class, 'index'])->name('registrations.index');
    Route::patch('/registrations/{registration}/status', [RegistrationController::class, 'updateStatus'])->name('registrations.update-status');
    Route::delete('/registrations/{registration}', [RegistrationController::class, 'destroy'])->name('registrations.destroy');
    Route::get('/registrations/export/csv', [RegistrationController::class, 'export'])->name('registrations.export');

    // Kelola Artikel (Bonus)
    Route::resource('articles', ArticleController::class)->except(['show']);
});
