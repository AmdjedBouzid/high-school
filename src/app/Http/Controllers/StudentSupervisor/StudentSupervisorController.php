<?php

namespace App\Http\Controllers\StudentSupervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\User;
use App\Http\Resources\SupervisorResource;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentCollection;
use App\Http\Resources\SupervisorCollection;

class StudentSupervisorController extends Controller
{

    public function index(User $supervisor)
    {
        $students = $supervisor->studends()
            ->with(['studentType', 'studentState'])
            ->get();

        return StudentResource::collection($students);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|exists:students,code',
            'user_id' => 'required|exists:users,id'
        ]);
        
        $student = Student::where('code', $validated['code'])->first();
        
        if ($student->supervisors()->where('user_id', $validated['user_id'])->exists()) {
            return response()->json([
                'message' => 'This supervisor is already assigned to the student'
            ], 422);
        }

        $student->supervisors()->attach($validated['user_id']);

        return response()->json([
            'message' => 'Supervisor assigned successfully',
        ], 201);
    }

    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'student_id' => 'required|exists:students,id'
        ]);

        $student = Student::find($validated['student_id']);

        if (!$student->supervisors()->where('user_id', $supervisor->id)->exists()) {
            return response()->json([
                'message' => 'This supervisor is not assigned to the student'
            ], 404);
        }

        $student->supervisors()->detach($supervisor->id);

        return response()->json([
            'message' => 'Supervisor removed successfully'
        ]);
    }

}