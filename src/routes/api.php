<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupervisorAccount\SupervisorController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


Route::post('/create-supervisor', [SupervisorController::class, 'store'])->name('user.supervisor.create');

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'username' => 'sometimes',
        'email' => 'sometimes|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('username', $request->username)->orWhere('email', $request->email)->first();

    if (! $user ) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
            'username' => ['The provided credentials are incorrect.'],
        ]);
    }
    if (! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'password' => ['Wrong password.'],
        ]);
    }

    return $user->createToken($request->device_name)->plainTextToken;
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [SupervisorController::class, 'profile'])->name('auth.profile');
    
    Route::get('/supervisors', [SupervisorController::class, 'index'])->name('user.supervisor.index')->middleware('can:admin-level');

    Route::get('/supervisor/{supervisor}', [SupervisorController::class, 'show'])->name('user.supervisor.show')->middleware('can:admin-level');
    
    Route::patch('/supervisor/{supervisor}', [SupervisorController::class, 'update'])->name('user.supervisor.update')->middleware('can:update-owner-level,supervisor');
});
