<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\KaryawanKontrakController;
use App\Http\Controllers\KaryawanTetapController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('roles', [RoleController::class, 'index'])->name('roles');
Route::post('roles', [RoleController::class, 'store'])->name('input-roles');

Route::controller(DashboardController::class)->group(function () {
    Route::get('/', 'index')->middleware(['auth', 'verified'])->name('dashboard');
});

Route::controller(KaryawanTetapController::class)->group(function () {
    Route::get('karyawanTetap', 'index')->name('karyawantetap');
});

Route::controller(KaryawanKontrakController::class)->group(function () {
    Route::get('karyawanKontrak', 'index')->name('karyawankontrak');
});

Route::controller(PermissionController::class)->group(function () {
    Route::get('permissions', 'index')->name('permissions');
});

Route::controller(ImportController::class)->group(function () {
    Route::get('import', 'index')->name('import');
    Route::post('file-import', 'create')->name('file-import');
});

Route::controller(UserController::class)->group(function () {
    Route::get('users', 'index')->name('users');
});

require __DIR__ . '/auth.php';
