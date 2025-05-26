<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

use App\Models\User;
use App\Http\Controllers\SupervisorAccount\SupervisorController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentSupervisor\StudentSupervisorController;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/profile', [UserController::class, 'getProfile']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::post('/create-admin', [UserController::class, 'insertAdmin']);

Route::post('/create-supervisor', [SupervisorController::class, 'store'])->name('user.supervisor.create');

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'username' => 'sometimes',
        'email' => 'sometimes|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('username', $request->username)->orWhere('email', $request->email)->first();

    if (! $user) {
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

Route::middleware(['auth:sanctum', 'abilities:crud-employees'])
    ->prefix('employees')
    ->group(function () {
        Route::get('/', [EmployeeController::class, 'getEmployees']);
        Route::post('/', [EmployeeController::class, 'addEmployee']);
        Route::get('{id}', [EmployeeController::class, 'getEmployeeById']);
        Route::put('{id}', [EmployeeController::class, 'updateEmployee']);
        Route::delete('{id}', [EmployeeController::class, 'deleteEmployee']);
    });
Route::middleware('auth:sanctum')->group(function () {

    // ! Supervisor

    Route::get('/profile', [SupervisorController::class, 'profile'])->name('auth.profile');
    Route::get('/supervisors', [SupervisorController::class, 'index'])->name('user.supervisor.index')->middleware('can:admin-level');
    Route::get('/supervisor/{supervisor}', [SupervisorController::class, 'show'])->name('user.supervisor.show')->middleware('can:admin-level');
    Route::patch('/supervisor/{supervisor}', [SupervisorController::class, 'update'])->name('user.supervisor.update')->middleware('can:update-owner-level,supervisor');
    Route::delete('/supervisor/{supervisor}', [SupervisorController::class, 'destroy'])->name('user.supervisor.destroy')->middleware('can:admin-level');

    // ! Student

    Route::get('/students/by-section/{sectionId}', [StudentController::class, 'getBySection'])->middleware('can:admin-level');
    Route::get('/students', [StudentController::class, 'index'])->name('student.index')->middleware('can:admin-level');
    Route::prefix('student')->middleware(['can:admin-level'])->group(function () {
        Route::post('/create', [StudentController::class, 'store'])->name('student.create');
        Route::get('/{student}', [StudentController::class, 'show'])->name('student.show');
        Route::patch('/{student}', [StudentController::class, 'update'])->name('student.update');
        Route::delete('/{student}', [StudentController::class, 'destroy'])->name('student.destroy');
        Route::get('/deleted', [StudentController::class, 'deletedStudents'])->name('student.deleted');
        Route::post('/code-regenerate/{student}', [StudentController::class, 'codeRegenerate'])->name('student.code.regenerate');
    });

    Route::get('/gradeinfo', [SchoolController::class, 'gradeInfo'])->name('grade.info')->middleware('can:admin-level');

    Route::prefix('assignment')->group(function () {
        Route::get('/{supervisor}', [StudentSupervisorController::class, 'show'])->name('assignments.show');
        Route::post('/', [StudentSupervisorController::class, 'store'])->name('assignments.store');
        Route::delete('/', [StudentSupervisorController::class, 'destroy'])->name('assignments.destroy');
    });

    Route::apiResource('majors', MajorController::class)->middleware('can:admin-level');

    Route::apiResource('sections', SectionController::class)->middleware('can:admin-level');

    // ! Absences
    Route::get('/absences', [AbsenceController::class, 'index'])->name('student.absences')->middleware('can:admin-level');
    Route::prefix('absence')->middleware(['can:admin-level'])->group(function () {
        Route::put('/of-section', [AbsenceController::class, 'sectionAbsenceAtDay'])->name('student.absences.get');
        Route::post('/add-start', [AbsenceController::class, 'startAbsence'])->name('student.absences.add.start');
        Route::post('/add-end', [AbsenceController::class, 'endAbsence'])->name('student.absences.add.end');
        Route::delete('/delete-start', [AbsenceController::class, 'deleteStartAbsence'])->name('student.absences.delete.start');
        Route::delete('/delete-end', [AbsenceController::class, 'deleteEndAbsence'])->name('student.absences.delete.end');
    });
});
