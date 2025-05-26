<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use App\Http\Resources\GradeResource;

class SchoolController extends Controller
{
    public function gradeInfo()
    {
        $grades = Grade::with('majors.sections')->get();
        return GradeResource::collection($grades);
    }
}
