<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\SalaryController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('index'))->name('index');

Route::prefix('/dashboard')
    ->middleware(['auth'])
    ->name('dashboard.')
    ->group(function () {
        Route::get('/', fn() => 'Ini dashboard')->name('index');

        Route::middleware('role:admin')->name('admin.')->group(function () {
            Route::resource('employees', EmployeeController::class);
            Route::resource('departments', DepartmentController::class);
            Route::resource('positions', PositionController::class);
        });

        Route::middleware('role:employee')->name('employee.')->group(function () {
            Route::resource('attendances', AttendanceController::class)->except(['show']);
            Route::resource('salaries', SalaryController::class)->except(['show']);
        });
    });
