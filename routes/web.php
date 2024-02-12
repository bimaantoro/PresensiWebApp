<?php

use App\Http\Controllers\Admin\ConfigWorkingHourController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\PengajuanIzinPesertaController;
use App\Http\Controllers\Admin\SetWorkingHourStudentController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RedirectAuthenticatedUsersController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\History\HistoryController;
use App\Http\Controllers\Manager\DashboardManagerController;
use App\Http\Controllers\Pengajuan\PengajuanIzinAbsenController;
use App\Http\Controllers\Pengajuan\PengajuanIzinController;
use App\Http\Controllers\Pengajuan\PengajuanIzinSakitController;
use App\Http\Controllers\Presence\PresenceController;
use App\Http\Controllers\Profile\ProfileController;
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

Route::middleware(['guest'])->group(function() {
    Route::controller(LoginController::class)->group(function() {
        Route::get('/', 'index')->name('login');
        Route::post('/login', 'authenticate')->name('authenticate');
    });
});

Route::middleware(['auth'])->group(function() {

    Route::get('/redirectAuthenticatedUsers', [RedirectAuthenticatedUsersController::class, 'home']);

    // Manager
    Route::middleware(['authRole:manager'])->group(function() {
        Route::get('/manager/logout', [LoginController::class, 'logout']);

        Route::controller(DashboardManagerController::class)->group(function() {
            Route::get('/manager/dashboard', 'reportPresence')->name('dashboard-manager');
            Route::post('/manager/report-presence/print', 'printReportPresence');
            Route::post('/manager/recap-presence/print', 'printRecapPresence');
        });
    });

    // Admin
    Route::middleware(['authRole:admin'])->group(function() {
        Route::get('/admin/logout', [LoginController::class, 'logout']);

        Route::controller(DashboardAdminController::class)->group(function() {
            Route::get('/admin/dashboard', 'index')->name('dashboard-admin');
            Route::post('/admin/presences', 'getPresence');
            Route::post('/admin/presence/show-map', 'showMap');
        });

        Route::controller(StudentController::class)->group(function() {
            Route::get('/admin/students', 'index')->name('student-admin');
            Route::post('/admin/student/store', 'store')->name('student.store');
            Route::post('/admin/student/edit', 'edit')->name('student.edit');
            Route::put('/admin/student/{id}/update', 'update');
            Route::delete('/admin/student/{id}/delete', 'destroy');
        });

        Route::controller(PengajuanIzinPesertaController::class)->group(function() {
            Route::get('/admin/pengajuan-izin', 'index')->name('pengajuan-izin-admin');
            Route::put('/admin/pengajuan-izin/approve', 'update');
            Route::get('/admin/pengajuan-izin/{id}/decline', 'decline');
        });

        Route::controller(ConfigWorkingHourController::class)->group(function() {
            Route::get('/admin/config/work-hours', 'index');
            Route::post('/admin/config/work-hour/store', 'store');
            Route::post('/admin/config/work-hour/edit', 'edit');
            Route::put('/admin/config/work-hour/{id}/update', 'update');
            Route::delete('/admin/config/work-hour/{id}/delete', 'destroy');
        });

        Route::controller(SetWorkingHourStudentController::class)->group(function() {
            Route::get('admin/setting/{id}/work-hour', 'setWorkHourStudent');
            Route::post('admin/setting/work-hour/store', 'storeWorkHourStudent');
            Route::post('admin/setting/work-hour/update', 'updateWorkHourStudent');
        });
    });

    // User
    Route::middleware(['authRole:user'])->group(function() {
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

        Route::controller(DashboardController::class)->group(function() {
            Route::get('/dashboard', 'index')->name('dashboard');
        });

        Route::controller(PresenceController::class)->group(function() {
            Route::get('/presence/create', 'create')->name('presence.create');
            Route::post('/presence/store', 'store')->name('presence.store');
        });

        Route::controller(ProfileController::class)->group(function() {
            Route::get('/profile', 'edit')->name('profile');
            Route::put('/profile/{id}', 'update');
        });

        Route::controller(HistoryController::class)->group(function() {
            Route::get('/history', 'index')->name('history');
            Route::post('/history', 'search');
        });

        Route::controller(PengajuanIzinController::class)->group(function() {
            Route::get('/pengajuan-izin', 'index')->name('pengajuan-izin');
            Route::get('/pengajuan-izin/{id}/showact', 'showAct');
            Route::get('/pengajuan-izin/{id}/delete', 'destroy');
            // Route::post('/pengajuan-izin/check', 'check');
        });

        Route::controller(PengajuanIzinAbsenController::class)->group(function() {
            Route::get('/pengajuan-izin/absen', 'create');
            Route::post('/pengajuan-izin/absen/store', 'store');
            Route::post('/pengajuan-izin/absen/check', 'check');

            Route::get('/pengajuan-izin/absen/{id}/edit', 'edit');
            Route::put('/pengajuan-izin/absen/{id}/update', 'update');
        });

        Route::controller(PengajuanIzinSakitController::class)->group(function() {
            Route::get('/pengajuan-izin/sakit', 'create');
            Route::post('/pengajuan-izin/sakit/store', 'store');
            Route::post('/pengajuan-izin/sakit/check', 'check');

            Route::get('/pengajuan-izin/sakit/{id}/edit', 'edit');
            Route::put('/pengajuan-izin/sakit/{id}/update', 'update');
        });
    });
});