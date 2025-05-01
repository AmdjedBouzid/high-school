<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use App\Http\Resources\GradeResource;

class SchoolController extends Controller
{
    public function gradeInfo(Grade $grade)
    {
        return new GradeResource($grade->load(["majors.sections"]));
    }
}
