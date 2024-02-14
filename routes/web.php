<?php

use App\Http\Controllers\Admin\ConfigWorkingHourController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\EmployeeAdminController;
use App\Http\Controllers\Admin\PengajuanIzinKaryawanController;
use App\Http\Controllers\Admin\PresenceEmployeeController;
use App\Http\Controllers\Admin\SetWorkingHourEmployeeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RedirectAuthenticatedUsersController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\History\HistoryController;
use App\Http\Controllers\Manager\ReportPresenceController;
use App\Http\Controllers\Pengajuan\PengajuanIzinController;
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

Route::middleware(['guest:employee'])->group(function() {
    Route::controller(LoginController::class)->group(function() {
        Route::get('/', 'index')->name('login');
        Route::post('/login', 'authenticate')->name('authenticate');
    });
});

Route::middleware(['auth:employee'])->group(function() {

    Route::get('/redirectAuthenticatedUsers', [RedirectAuthenticatedUsersController::class, 'home']);

    // Manager
    Route::middleware(['authRole:direktur'])->group(function() {

        Route::get('/direktur/logout', [LoginController::class, 'logout']);

        Route::controller(ReportPresenceController::class)->group(function() {
            Route::get('direktur/dashboard', 'reportPresence')->name('dashboard-direktur');
            Route::post('/direktur/report-presence/print', 'printReportPresence');
            Route::post('/direktur/recap-presence/print', 'printRecapPresence');
        });
    });

    // Admin
    Route::middleware(['authRole:admin'])->group(function() {
        Route::get('/admin/logout', [LoginController::class, 'logout']);

        Route::get('/admin/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard-admin');

        Route::controller(EmployeeAdminController::class)->group(function() {
            Route::get('/admin/employees', 'index')->name('employee-admin');
            Route::post('/admin/employee/store', 'store')->name('employee.store');
            Route::post('/admin/employee/edit', 'edit')->name('employee.edit');
            Route::put('/admin/employee/{id_employee}', 'update');
            Route::delete('/admin/employee/{id_employee}/delete', 'destroy');
        });

        Route::controller(PresenceEmployeeController::class)->group(function() {
            Route::get('/admin/presences', 'index')->name('presence-admin');
            Route::post('/admin/presences', 'getPresence')->name('presence-admin.get-presence');
            Route::post('/admin/presence/map', 'showMap')->name('presence-admin.show-map');
        });

        Route::controller(PengajuanIzinKaryawanController::class)->group(function() {
            Route::get('/admin/pengajuan-izin-karyawan', 'index')->name('pengajuan-izin-admin');
            Route::put('/admin/pengajuan-izin/approve', 'update');
            Route::get('/admin/pengajuan-izin/{id}/decline', 'decline');
            // Route::put('/admin/pengajuan-izin-karyawan/update', 'update');
            // Route::get('/admin/pengajuan-izin-karyawan/{id}', 'updateStatusApproved');
        });

        Route::controller(ConfigWorkingHourController::class)->group(function() {
            Route::get('/admin/config/work-hours', 'index');
            Route::post('/admin/config/work-hour/store', 'store');
            Route::post('/admin/config/work-hour/edit', 'edit');
            Route::put('/admin/config/work-hour/{id}/update', 'update');
            Route::delete('/admin/config/work-hour/{id}/delete', 'destroy');
        });

        Route::controller(SetWorkingHourEmployeeController::class)->group(function() {
            Route::get('admin/setting/{id}/work-hour', 'setWorkHourEmployee');
            Route::post('admin/setting/work-hour/store', 'storeWorkHourEmployee');
            Route::post('admin/setting/work-hour/update', 'updateWorkHourEmployee');
        });
    });

    // User
    Route::middleware(['authRole:karyawan'])->group(function() {
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::controller(PresenceController::class)->group(function() {
            Route::get('/presence/create', 'create')->name('presence.create');
            Route::post('/presence/store', 'store')->name('presence.store');
        });

        Route::controller(ProfileController::class)->group(function() {
            Route::get('/profile', 'edit')->name('profile');
            Route::put('/profile/{id_employee}', 'update');
        });

        Route::controller(HistoryController::class)->group(function() {
            Route::get('/history', 'index')->name('history');
            Route::post('/history', 'search');
        });

        Route::controller(PengajuanIzinController::class)->group(function() {
            Route::get('/pengajuan-izin', 'index')->name('pengajuan-izin');
            
            Route::get('/pengajuan-izin/absen', 'createAbsen');
            Route::post('/pengajuan-izin/absen/store', 'storeAbsen');

            Route::get('/pengajuan-izin/sakit', 'createSakit');
            Route::post('/pengajuan-izin/sakit/store', 'storeSakit');

            // Route::get('/pengajuan-izin/create', 'create')->name('pengajuan-izin.create');
            // Route::post('/pengajuan-izin/store', 'store')->name('pengajuan-izin.store');
            // Route::post('/pengajuan-izin/check', 'cekPengajuanIzin');
        });
    });
});