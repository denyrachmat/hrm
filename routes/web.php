<?php

use App\Http\Controllers\{
    AttendanceController,
    AttendanceRevisionController,
    DashboardController,
    EmployeeController,
    IzinsakitController,
    LeaveRequestController,
    MonthlyController,
    MapController,
    ResetPasswordController,
    ProfileController,
    UserController,
    RoleAndPermissionController,
    DepartmentController,
    CompanyController,
    EarningController,
    DeductionController,
    BannerController,
    CategorynewsController,
    NewsController,
    GpslocationController,
    ReportAttendanceController,
    RankingController,
    OffdayController,
    BankController,
    EmployeeEarningController,
    EmployeeFamilyController,
    EmployeeHasDeductionController
};
use App\Models\EmployeeFamily;
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

Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/dashboard', fn() => redirect()->route('dashboard'));
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', ProfileController::class)->name('profile');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleAndPermissionController::class);

    // Employee Routes
    Route::controller(EmployeeController::class)->group(function () {
        Route::get('/download-format-employees', 'downloadFormat')->name('download-format-employees');
        Route::get('/export-data-employees/{departement}/{work_status}/{use_gps_location}', 'exportEmployees')->name('export-data-employees');
        Route::post('/import-employees', 'import')->name('action-import-employees');
        Route::get('/pdf-employees/{departement}/{work_status}/{use_gps_location}', 'printPdf')->name('action-pdf-employees');
        Route::post('/save-file', 'employeeFile')->name('action-save-file');
        Route::delete('/delete-file/{id}', 'delFile')->name('action-delete-file');
        Route::delete('/reset-device/{id}', 'resetDevice')->name('resetDevice');
    });

    // Monthly Routes
    Route::controller(MonthlyController::class)->group(function () {
        Route::get('/slip/{id}', 'printPdf')->name('slip-employees');
        Route::get('/view-detail/{id}', 'viewDetail')->name('view-detail');
        Route::get('/download-format-monthlies/{departement}/{month}', 'downloadFormat')->name('download-format-monthlies');
        Route::post('/import-monthlies', 'import')->name('action-import-monthlies');
        Route::post('/sendMailSalary', 'sendMailSalary')->name('sendMailSalary');
        Route::post('/monthlies/generate', 'generateMonthly');
        Route::put('/monthlies/earning-deduct/{id}', 'updateMonthlyEarningDeduct');
        Route::post('/monthlies/store-earning-deduction', 'storeEarningDeduction')->name('store-earning-deduction');
        Route::delete('/monthly/earning-deduct/{id}', 'destroy')->name('monthly.earning-deduct.destroy');
    });

    Route::get('/api/markers', [MapController::class, 'getMarkers']);

    // Resource Routes
    Route::resources([
        'departments' => DepartmentController::class,
        'employees' => EmployeeController::class,
        'companies' => CompanyController::class,
        'earnings' => EarningController::class,
        'deductions' => DeductionController::class,
        'monthlies' => MonthlyController::class,
        'banners' => BannerController::class,
        'banks' => BankController::class,
        'categorynews' => CategorynewsController::class,
        'news' => NewsController::class,
        'gpslocations' => GpslocationController::class,
        'attendances' => AttendanceController::class,
        'izinsakits' => IzinsakitController::class,
        'report-attendances' => ReportAttendanceController::class,
        'attendance-revisions' => AttendanceRevisionController::class,
        'leave-requests' => LeaveRequestController::class,
        'rankings' => RankingController::class,
        'offdays' => OffdayController::class,
    ]);

    // Attendance Routes
    Route::controller(AttendanceController::class)->group(function () {
        Route::post('detailPoint', 'detailPoint')->name('detailPoint');
        Route::get('/export-data-atten/{start_date}/{end_date}/{departement}/{is_present}/{description}', 'exportAtten')->name('export-data-atten');
        Route::get('/pdf-atten/{start_date}/{end_date}/{departement}/{is_present}/{description}', 'printPdf')->name('action-pdf-atten');
    });

    // Izinsakit Routes
    Route::controller(IzinsakitController::class)->group(function () {
        Route::post('/approved', 'approved')->name('approved');
        Route::post('/rejected', 'rejected')->name('rejected');
    });

    // Attendance Revision Routes
    Route::controller(AttendanceRevisionController::class)->group(function () {
        Route::post('attendance-revisions/approved', 'approved')->name('attendance-revisions.approved');
        Route::post('attendance-revisions/rejected', 'rejected')->name('attendance-revisions.rejected');
    });

    // Leave Request Routes
    Route::controller(LeaveRequestController::class)->group(function () {
        Route::post('leave-requests/approved', 'approved')->name('leave-requests.approved');
        Route::post('leave-requests/rejected', 'rejected')->name('leave-requests.rejected');
    });

    Route::group([
        'prefix' => 'employee-earnings'
    ], function () {
        Route::post('/{employeeId}', [EmployeeEarningController::class, 'store']);
        Route::put('/{employeeHasEarningId}', [EmployeeEarningController::class, 'update']);
        Route::delete('/{employeeHasEarningId}', [EmployeeEarningController::class, 'destroy']);
    });

    Route::group([
        'prefix' => 'employee-deductions'
    ], function () {
        Route::post('/{employeeId}', [EmployeeHasDeductionController::class, 'store']);
        Route::put('/{employeeHasEarningId}', [EmployeeHasDeductionController::class, 'update']);
        Route::delete('/{employeeHasEarningId}', [EmployeeHasDeductionController::class, 'destroy']);
    });
});

// Reset Password Routes
Route::get('/reset-password', [ResetPasswordController::class, 'showResetForm'])->name('reset-password-form');
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('reset-password');
Route::get('/password-reset-success', [ResetPasswordController::class, 'successReset'])->name('password-reset-success');

Route::resource('branch-offices', App\Http\Controllers\BranchOfficeController::class)->middleware('auth');

Route::post('employee-family/store', [EmployeeFamilyController::class, 'store'])->name('employee-family.store');
Route::delete('employee-family/{id}', [EmployeeFamilyController::class, 'destroy'])->name('employee-family.destroy');


Route::resource('not-presents', App\Http\Controllers\NotPresentController::class)->middleware('auth');