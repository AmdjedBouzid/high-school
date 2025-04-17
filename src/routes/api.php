<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use PhpParser\Node\Stmt\TryCatch;
use App\Http\Controllers\EmployeeController;

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
