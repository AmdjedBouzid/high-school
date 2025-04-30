<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Student;
use App\Models\StudentState;
use App\Models\StudentType;

// use App\Http\Resources\StudentCollection;
use App\Http\Resources\StudentResource;

use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentUpdateRequest;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['studentState', 'studentType', 'insertedBy', "section"])->get();

        return StudentResource::collection($students);
        // return new StudentCollection($students);
    }
    
    
    
    
    public function store(StudentStoreRequest $request)
    {
        $student = Student::create(array_merge(
            $request->validated(),
            ['inserted_by' => $request->user()->id]
        ));
        $student->load(['studentState', 'studentType', 'insertedBy']);
        return new StudentResource($student);
    }


    public function show(Student $student)
    {
        return new StudentResource($student->load(['studentState', 'studentType']));
    }


    public function update(StudentUpdateRequest $request, Student $student)
    {
        $student->update($request->validated());
        return new StudentResource($student);
    }
    
    public function destroy(Student $student)
    {
        $student->delete();
        
        return response()->json([
            'message' => 'Student deleted successfully.'
        ], 200);
    }

    public function deletedStudents()
    {
        $students = Student::onlyTrashed()
        ->with(['studentState', 'studentType', 'insertedBy'])
        ->latest()
        ->get();
        
        return StudentResource::collection($students);
        // return new StudentCollection($students);
    }

    public function getBySection($sectionId)
    {
        // Fetch students that belong to the specific section
        $students = Student::with(['recordStatus', 'studentType', 'insertedBy'])
            ->where('section_id', $sectionId)
            ->latest()
            ->get();

        // Return the collection of students without pagination
        return new StudentCollection($students);
    }
}
