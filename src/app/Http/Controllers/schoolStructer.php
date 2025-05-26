<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;

class SchoolStructer extends Controller
{
    public function getGradeDetails($id)
    {
        // Load grade with both relationships in one query
        $grade = Grade::with(['majors'])->findOrFail($id);

        return response()->json([
            'grade' => $grade->only(['id', 'name']), // Basic grade info
            'majors' => $grade->majors,
        ]);
    }
}
