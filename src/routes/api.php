<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use PhpParser\Node\Stmt\TryCatch;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/profile', [UserController::class, 'getProfile']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
