<?php

// app/Http/Controllers/Api/SectionController.php
namespace App\Http\Controllers;

use App\Models\Section;
use App\Http\Controllers\Controller;
use App\Http\Requests\SectionRequest;
use App\Http\Resources\SectionResource;
use App\Http\Requests\UpdateSectionRequest;

class SectionController extends Controller
{
    public function index()
    {
        return SectionResource::collection(Section::with('major')->get());
    }

    public function store(SectionRequest $request)
    {
        $existingSection = Section::where('major_id', $request->major_id)
            ->where('name', $request->name)
            ->first();

        if ($existingSection) {
            return response()->json(['message' => 'Section already exists'], 422);
        }
        $section = Section::create($request->validated());
        return new SectionResource($section);
    }

    public function show(Section $section)
    {
        return new SectionResource($section->load(['major', 'students']));
    }

    public function update(UpdateSectionRequest $request, Section $section)
    {
        // Use existing values for fields not present in request
        $name = $request->input('name', $section->name);
        $major_id = $request->input('major_id', $section->major_id);

        // Uniqueness check
        $duplicate = Section::where('name', $name)
            ->where('major_id', $major_id)
            ->where('id', '!=', $section->id)
            ->exists();

        if ($duplicate) {
            return response()->json([
                'message' => 'A section with this name, grade, and major already exists.',
                'errors' => [
                    'name' => ['A section with this name, grade, and major already exists.']
                ]
            ], 422);
        }
        $section->update($request->validated());

        return new SectionResource($section->load('major'));
    }


    public function destroy(Section $section)
    {
        $section->delete();
        return response()->json(['message' => 'Section deleted successfully']);
    }
}
