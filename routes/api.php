<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Mobile\AuthController;
use App\Http\Controllers\Api\Mobile\NewsController;
use App\Http\Controllers\Api\Mobile\BannerController;
use App\Http\Controllers\Api\Mobile\EmployeeController;
use App\Http\Controllers\Api\Mobile\AttendanceController;
use App\Http\Controllers\Api\Mobile\AuthEmployeeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\GpslocationController;
use App\Http\Controllers\Api\Website\ContactController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API Mobile
Route::group(['prefix' => 'mobile'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('reset-password', [AuthController::class, 'resetPassword']);
        Route::post('check-login-expiring', [AuthController::class, 'checkLoginExpiring']);
    });

    Route::middleware(['auth.mobile.employee'])->group(function () {
        Route::group(['prefix' => 'employees'], function () {
            Route::get('/', [EmployeeController::class, 'index']);
        });
        Route::group(['prefix' => 'banners'], function () {
            Route::get('/', [BannerController::class, 'getAllBanners']);
        });
        Route::group(['prefix' => 'news'], function () {
            Route::get('/', [NewsController::class, 'getAllNews']);
            Route::get('/{id}', [NewsController::class, 'showNewsDetail']);
        });
        Route::group(['prefix' => 'attendances'], function () {
            Route::get('all-employees-today-not-present', [AttendanceController::class, 'getAllEmployeesTodayNotPresent']);
            Route::get('history-presence', [AttendanceController::class, 'getHistoryPresence']);
            Route::get('rank-point', [AttendanceController::class, 'rankPoint']);
            Route::get('today-presence', [AttendanceController::class, 'getTodayPresence']);
            Route::get('today-izin-sakit', [AttendanceController::class, 'getTodayIzinSakit']);
            Route::get('current-employee-pengajuan-cuti', [AttendanceController::class, 'getAllPengajuanCutiCurrentEmployee']);
            Route::get('current-employee-pengajuan-izin-sakit', [AttendanceController::class, 'getAllPengajuanIzinSakitCurrentEmployee']);
            Route::get('current-employee-pengajuan-revisi-absen', [AttendanceController::class, 'getAllPengajuanRevisiAbsenCurrentEmployee']);
            Route::post('clock-in', [AttendanceController::class, 'clockIn']);
            Route::post('clock-out', [AttendanceController::class, 'clockOut']);
            Route::post('clock-istirahat', [AttendanceController::class, 'clockIstirahat']);
            Route::post('clock-istirahat-out', [AttendanceController::class, 'clockIstirahatOut']);
            Route::post('izin-or-sakit', [AttendanceController::class, 'izinOrSakit']);
            Route::post('pengajuan-cuti', [AttendanceController::class, 'pengajuanCuti']);
            Route::post('pengajuan-revisi-absen', [AttendanceController::class, 'pengajuanRevisiAbsen']);
        });
        Route::group(['prefix' => 'auth-employee'], function () {
            Route::post('update', [AuthEmployeeController::class, 'update']);
            Route::put('change-password', [AuthEmployeeController::class, 'changePassword']);
        });
        Route::group(['prefix' => 'auth'], function () {
            Route::get('employee', [AuthController::class, 'getCurrentAuthEmployee']);
        });

        Route::group(['prefix' => 'company'], function () {
            Route::get('/', [CompanyController::class, 'view']);
        });

        Route::group(['prefix'=> 'gps-location'], function () {
            Route::get('', [GpslocationController::class,'viewList']);
        });
    });
});
