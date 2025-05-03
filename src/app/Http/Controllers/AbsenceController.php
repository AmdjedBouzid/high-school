<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absence;
use App\Models\AbsenceAction;
use App\Models\Student;
use App\Models\Section;

use App\Http\Resources\AbsenceResource;
use App\Http\Resources\SectionResource;

class AbsenceController extends Controller
{
    
    public function sectionAbsenceAtDay(Request $request)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'date' => 'required|date_format:Y-m-d',
        ]);

        $section = Section::with(['students.absences' => function($query) use ($request) {
            $query->with(['fromAction', 'toAction'])
              ->whereHas('fromAction', function($q) use ($request) {
              $q->whereDate('time', $request->date);
              })
              ->orWhereNull('to');
        }])->findOrFail($request->section_id);

        return new SectionResource($section); 
    }


    public function handelRequest(Request $request){
        foreach ($request->absences as $absence) {
            if ( ! Absence::where('student_id', $absence->student_id)->whereNull('to')->exists()) {
                $absenceAction = AbsenceAction::create([
                    'time' => $absence->time,
                    'made_by' => $request->user()->id,
                    'type' => $absence->type,
                ]);
    
                Absence::create([
                    'student_id' => $absence->student_id,
                    'from' => $absenceAction->id,
                ]);
            }
        }
        foreach ($request->presents as $present) {
            $absence = Absence::where('student_id', $request->student_id)
                ->where('from', $present->from_id)
                ->whereNull('to')
                ->first();
            
            if ($absence) {
                $absenceAction = AbsenceAction::create([
                        'time' => $present->endtime,
                        'made_by' => $request->user()->id,
                        'type' => $present->type,
                    ]);
                    $absence->to = $absenceAction->id;
                    $absence->save();
            }
        }
        foreach ($request->deletedAbsences as $absence) {
            $absence = Absence::where('student_id', $absence->student_id)
                ->where('from', $absence->from_id)
                ->first();
                
            if ($absence) {
                $absence->delete();
            }   
        }
        foreach ($request->deletedPresents as $present) {
            $absence = Absence::where('student_id', $present->student_id)
                ->where('from', $present->from_id)
                ->first();

            if ($absence) {
                $absence->delete();
            }
        }
    }
    
    public function index()
    {
        $absences = Absence::with(['student', 'fromAction', 'toAction'])->get();

        $grouped = $absences->groupBy(function ($absence) {
            return $absence->student->section_id ?? 'no-section';
        })->map(function ($group) {
            return AbsenceResource::collection($group);
        });;
        
        return response()->json(
            [
                "data" => $grouped
            ]
        );
    }

    public function startAbsence(Request $request){
        
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'time' => 'required|date_format:Y-m-d H:i:s',
        ]);

        if (Absence::where('student_id', $request->student_id)->whereNull('to')->exists()) {
            return response()->json([
                "message" => "Student is already absent",
            ], 422);
        }

        $absenceAction = AbsenceAction::create([
            'time' => $request->time,
            'made_by' => $request->user()->id,
        ]);

        Absence::create([
            'student_id' => $request->student_id,
            'from' => $absenceAction->id,
        ]);

        return response()->json([
            "data" => $absenceAction
        ]);

    }

    public function deleteStartAbsence(Request $request){
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'from_id' => 'required|exists:absence_actions,id',
        ]);

        $absence = Absence::where('student_id', $request->student_id)
            ->where('from', $request->from_id)
            ->first();
        
        if (!$absence) {
            return response()->json([
                "message" => "No active absence found for this student",
            ], 422);
        }
        
        $absence->delete();

        return response()->json([
            "message" => "Absence deleted successfully"
        ]);
    }

    public function endAbsence(Request $request){
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'from_id' => 'required|exists:absence_actions,id',
            'endtime' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $absence = Absence::where('student_id', $request->student_id)
            ->where('from', $request->from_id)
            ->whereNull('to')
            ->first();
            
        if (!$absence) {
            return response()->json([
                "message" => "No active absence found for this student",
                ], 422);
        }
        $absenceAction = AbsenceAction::create([
            'time' => $request->endtime,
            'made_by' => $request->user()->id,
        ]);
        $absence->to = $absenceAction->id;
        $absence->save();
        return response()->json([
            "data" => $absenceAction
        ]);
    }
    
    public function deleteEndAbsence(Request $request){
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'to_id' => 'required|exists:absence_actions,id',
        ]);

        $absence = Absence::where('student_id', $request->student_id)
            ->where('to', $request->to_id)
            ->first();
        
        if (!$absence) {
            return response()->json([
                "message" => "No active absence found for this student",
            ], 422);
        }
        
        $absence->to = null;
        $absence->save();

        return response()->json([
            "message" => "Absence deleted successfully"
        ]);
    }

    public function show(Student $student)
    {
        $absences = Absence::with(['fromAction', 'toAction'])
            ->where('student_id', $student->id)
            ->get();

        return response()->json([
            "data" => $absences
        ]);
    }

}
