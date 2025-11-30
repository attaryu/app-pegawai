<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
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
            Route::resource('employees', EmployeeController::class);
            Route::resource('departments', DepartmentController::class);
            Route::resource('positions', PositionController::class);
            Route::resource('attendances', AttendanceController::class)->except(['show']);
            Route::resource('salaries', SalaryController::class)->except(['show']);
        });

        Route::middleware('role:employee')->name('employee.')->group(function() {
            Route::get('/statistic', [EmployeeController::class, 'statistic'])->name('statistic');

            Route::prefix('/attendances')->name('attendances.')->group(function() {
                Route::get('/history', [AttendanceController::class, 'history'])->name('history');
                Route::post('/check-in', [AttendanceController::class, 'checkIn'])->name('checkin');
                Route::post('/check-out', [AttendanceController::class, 'checkOut'])->name('checkout');
            });

            Route::prefix('/leave')->name('leave.')->group(function() {
                Route::get('/', [LeaveController::class, 'index'])->name('index');
                Route::get('/requests', [LeaveController::class, 'create'])->name('create');
                Route::post('/requests', [LeaveController::class, 'store'])->name('store');
                Route::patch('/requests/{id}/cancel', [LeaveController::class, 'cancel'])->name('cancel');
            });
        });
    });
