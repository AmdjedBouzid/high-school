<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\MajorRequest;
use App\Http\Requests\UpdateMajorRequest;
use App\Http\Resources\MajorResource;
use App\Models\Major;
use Illuminate\Http\Response;

class MajorController extends Controller
{
    // GET /api/majors
    public function index()
    {
        $majors = Major::with('grade')->get();
        return MajorResource::collection($majors);
    }

    // POST /api/majors
    public function store(MajorRequest $request)
    {
        $major = Major::create($request->validated());
        return new MajorResource($major->load('grade'));
    }

    // GET /api/majors/{major}
    public function show(Major $major)
    {
        $major->load('grade');
        return new MajorResource($major);
    }

    // PUT/PATCH /api/majors/{major}
    public function update(UpdateMajorRequest $request, Major $major)
    {
        $major->update($request->validated());
        return new MajorResource($major->load('grade'));
    }

    // DELETE /api/majors/{major}
    public function destroy(Major $major)
    {
        $major->delete();
        return response()->json(['message' => 'Major deleted successfully.'], Response::HTTP_OK);
    }
}
