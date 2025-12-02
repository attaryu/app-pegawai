<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('pages.home.index'))->name('index');

Route::middleware(['guest'])->group(function () {
    Route::controller(\App\Http\Controllers\AuthController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'loginProcess')->name('login.process');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

    Route::prefix('/dashboard')
        ->name('dashboard.')
        ->group(function () {
            Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('index');

            Route::middleware('role:admin')->name('admin.')->group(function () {
                Route::resource('employees', \App\Http\Controllers\Admin\EmployeeController::class);
                Route::resource('departments', \App\Http\Controllers\Admin\DepartmentController::class);
                Route::resource('positions', \App\Http\Controllers\Admin\PositionController::class);
                Route::resource('attendances', \App\Http\Controllers\Admin\AttendanceController::class)->except(['show']);
                Route::resource('salaries', \App\Http\Controllers\Admin\SalaryController::class)->except(['show']);

                Route::prefix('/leave-requests')
                    ->controller(\App\Http\Controllers\Admin\LeaveController::class)
                    ->name('leave-requests.')
                    ->group(function () {
                        Route::get('/', 'index')->name('index');
                        Route::patch('/{id}/approve', 'approve')->name('approve');
                        Route::patch('/{id}/reject', 'reject')->name('reject');
                    });
            });

            Route::middleware('role:employee')->name('employee.')->group(function () {
                Route::get('/statistic', [\App\Http\Controllers\Employee\EmployeeController::class, 'statistic'])->name('statistic');

                Route::prefix('/profile')
                    ->name('profile.')
                    ->controller(\App\Http\Controllers\Employee\EmployeeController::class)
                    ->group(function () {
                        Route::get('/', 'profile')->name('index');
                        Route::get('/edit', 'editProfile')->name('edit');
                        Route::patch('/update', 'updateProfile')->name('update');
                    });

                Route::prefix('/password')
                    ->name('password.')
                    ->controller(\App\Http\Controllers\Employee\EmployeeController::class)
                    ->group(function () {
                        Route::get('/edit', 'editPassword')->name('edit');
                        Route::patch('/update', 'updatePassword')->name('update');
                    });

                Route::prefix('/attendances')
                    ->name('attendances.')
                    ->controller(\App\Http\Controllers\Employee\AttendanceController::class)
                    ->group(function () {
                        Route::get('/history', 'history')->name('history');
                        Route::post('/check-in', 'checkIn')->name('checkin');
                        Route::post('/check-out', 'checkOut')->name('checkout');
                    });

                Route::prefix('/leave')
                    ->name('leave.')
                    ->controller(\App\Http\Controllers\Employee\LeaveController::class)
                    ->group(function () {
                        Route::get('/', 'index')->name('index');
                        Route::get('/requests', 'create')->name('create');
                        Route::post('/requests', 'store')->name('store');
                        Route::patch('/requests/{id}/cancel', 'cancel')->name('cancel');
                    });

                Route::get('/salaries/history', [\App\Http\Controllers\Employee\SalaryController::class, 'index'])->name('salaries.history');
            });
        });
});
