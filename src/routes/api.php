<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController; // Verify that this class exists in the specified namespace or create it if missing
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SupervisorAccount\SupervisorController;


Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/profile', [UserController::class, 'getProfile']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::post('/create-admin', [UserController::class, 'insertAdmin']);



Route::middleware(['auth:sanctum', 'abilities:crud-employees'])
    ->prefix('employees')
    ->group(function () {
        Route::get('/', [EmployeeController::class, 'getEmployees']);
        Route::post('/', [EmployeeController::class, 'addEmployee']);
        Route::get('{id}', [EmployeeController::class, 'getEmployeeById']);
        Route::put('{id}', [EmployeeController::class, 'updateEmployee']);
        Route::delete('{id}', [EmployeeController::class, 'deleteEmployee']);
    });


Route::middleware(['auth:sanctum', 'abilities:crud-supervisor'])
    ->prefix('supervisor')
    ->group(function () {
        Route::post('/', [SupervisorController::class, 'store'])->name('user.supervisor.store');
        Route::get('/', [SupervisorController::class, 'index'])->name('user.supervisor.index');
        Route::get('/{supervisor}', [SupervisorController::class, 'show'])->name('user.supervisor.show');
        Route::patch('/{supervisor}', [SupervisorController::class, 'update'])->name('user.supervisor.update');
        Route::delete('/{supervisor}', [SupervisorController::class, 'destroy'])->name('user.supervisor.destroy');
    });
