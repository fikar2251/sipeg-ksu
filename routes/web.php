<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\KaryawanKontrakController;
use App\Http\Controllers\KaryawanTetapController;
use App\Http\Controllers\LemburController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Mail\GajiMail;
use Illuminate\Support\Facades\Mail;
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


    Route::get('roles', [RoleController::class, 'index'])->name('roles');
    Route::post('roles', [RoleController::class, 'store'])->name('input-roles');
    Route::get('rolepermissions/{id}', [RoleController::class, 'rolePermission'])->name('rolepermissions');
    Route::get('roles/{id}', [RoleController::class, 'show'])->name('show-roles');

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->middleware(['auth', 'verified'])->name('dashboard');
    });
    Route::group(['middleware' => ['can:karyawan']], function () {
        //
        Route::controller(KaryawanTetapController::class)->group(function () {
            Route::get('karyawanTetap', 'index')->name('karyawantetap');
            Route::get('karyawanTetap/create', 'create')->name('createkaryawantetap');
            Route::post('karyawanTetap/store', 'store')->name('postkaryawanTetap');
            Route::put('karyawanTetap/update/{karyawan}', 'update')->name('updatekaryawanTetap');
            Route::get('karyawanTetap/edit/{karyawan}', 'edit')->name('editkaryawanTetap');
            Route::get('karyawanTidakAktif', 'karyawanTidakAktif')->name('karyawanTidakAktif');
        });

        Route::controller(KaryawanKontrakController::class)->group(function () {
            Route::get('karyawanKontrak', 'index')->name('karyawankontrak');
            Route::get('karyawanKontrak/create', 'create')->name('createkaryawanKontrak');
            Route::post('karyawanKontrak/store', 'store')->name('postkaryawanKontrak');
            Route::put('karyawanKontrak/update/{karyawanKontrak}', 'update')->name('updatekaryawanKontrak');
            Route::get('karyawanKontrak/edit/{karyawanKontrak}', 'edit')->name('editkaryawanKontrak');
        });
    });


    Route::group(['middleware' => ['can:penggajian']], function () {
        //
        Route::controller(ImportController::class)->group(function () {
            Route::group(['middleware' => ['can:absensi']], function () {
                Route::get('import', 'index')->name('import');
                Route::get('kehadiran', 'kehadiran')->name('kehadiran');
            });
            Route::get('cetak/{cetak}', 'cetak')->name('cetak');
            Route::get('gajiAll', 'gajiAll')->name('gajiAll');
            Route::post('dataGajiTetap', 'dataGajiTetap')->name('dataGajiTetap');
            Route::post('dataGajiKontrak', 'dataGajiKontrak')->name('dataGajiKontrak');
            Route::get('gaji/{gaji}', 'detailGaji')->name('detailGaji');
            Route::post('gaji', 'hitungSalary')->name('hitungSalary');
            Route::post('file-import', 'create')->name('file-import');
            Route::post('update-absen', 'updateAbsen')->name('update-absen');
        });
    });

    Route::group(['middleware' => ['can:user-management']], function () {
        //
        Route::controller(UserController::class)->group(function () {
            Route::get('users', 'index')->name('users');
            Route::post('users-store', 'store')->name('users-store');
            Route::get('users-edit/{id}', 'edit')->name('users-edit');
            Route::post('users-update/{id}', 'update')->name('users-update');
            Route::get('users-delete/{id}', 'destroy')->name('users-delete');

            Route::controller(PermissionController::class)->group(function () {
                Route::get('permissions', 'index')->name('permissions');
                Route::post('input-permission', 'store')->name('input-permission');
                Route::get('permissions/{id}', 'show')->name('show-permissions');
                Route::post('permissions/update', 'update')->name('update-permissions');
                Route::get('permissions/delete/{id}', 'destroy')->name('delete-permissions');
            });
        });
    });

    Route::group(['middleware' => ['can:lembur']], function () {
        //
        Route::controller(LemburController::class)->group(function () {
            Route::get('lembur', 'index')->name('lembur');
            Route::get('importlembur', 'import')->name('importlembur');
            Route::post('import-lembur', 'store')->name('import-lembur');
            Route::get('lemburAll', 'lemburAll')->name('lemburAll');
            Route::get('lemburFilter', 'filterLembur')->name('lemburFilter');
            Route::post('update-absen-rudianto', 'updateAbsen')->name('update-absen-rudianto');
        });
    });

    Route::group(['middleware' => ['can:slip gaji']], function () {
        //
        Route::post('/testemail', [GajiController::class, 'kirimGaji'])->name('kirimGaji');
        Route::get('/send', [GajiController::class, 'index'])->name('send');
    });

    Route::group(['middleware' => ['can:pph']], function () {
        //
        Route::get('/pph', [GajiController::class, 'pph'])->name('pph');
        Route::post('/datapph', [GajiController::class, 'dataPph'])->name('dataPph');
    });
});



require __DIR__ . '/auth.php';
