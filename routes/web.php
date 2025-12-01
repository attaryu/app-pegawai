<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\Employee\LeaveController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\SalaryController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('pages.home.index'))->name('index');

Route::prefix('/dashboard')
    ->middleware(['auth'])
    ->name('dashboard.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');

        Route::middleware('role:admin')->name('admin.')->group(function () {
            Route::resource('employees', \App\Http\Controllers\Admin\EmployeeController::class);
            Route::resource('departments', DepartmentController::class);
            Route::resource('positions', PositionController::class);
            Route::resource('attendances', AttendanceController::class)->except(['show']);
            Route::resource('salaries', SalaryController::class)->except(['show']);

            Route::prefix('/leave-requests')->name('leave-requests.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Admin\LeaveController::class, 'index'])->name('index');
                Route::patch('/{id}/approve', [\App\Http\Controllers\Admin\LeaveController::class, 'approve'])->name('approve');
                Route::patch('/{id}/reject', [\App\Http\Controllers\Admin\LeaveController::class, 'reject'])->name('reject');
            });
        });

        Route::middleware('role:employee')->name('employee.')->group(function () {
            Route::get('/statistic', [\App\Http\Controllers\Employee\EmployeeController::class, 'statistic'])->name('statistic');

            Route::prefix('/attendances')->name('attendances.')->group(function () {
                Route::get('/history', [AttendanceController::class, 'history'])->name('history');
                Route::post('/check-in', [AttendanceController::class, 'checkIn'])->name('checkin');
                Route::post('/check-out', [AttendanceController::class, 'checkOut'])->name('checkout');
            });

            Route::prefix('/leave')->name('leave.')->group(function () {
                Route::get('/', [LeaveController::class, 'index'])->name('index');
                Route::get('/requests', [LeaveController::class, 'create'])->name('create');
                Route::post('/requests', [LeaveController::class, 'store'])->name('store');
                Route::patch('/requests/{id}/cancel', [LeaveController::class, 'cancel'])->name('cancel');
            });
        });
    });
