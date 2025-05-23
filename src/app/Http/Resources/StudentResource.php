<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AbsenceResource;

class StudentResource extends JsonResource
{
    public function toArray($request)
    {
        $array = [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,

            'section' => $this->whenLoaded('section', fn() => $this->section->name),
            'code' => $this->code,

            'student_state' => $this->whenLoaded('recordStatus', fn() => $this->recordStatus->name),
            'student_type' => $this->whenLoaded('studentType', fn() => $this->studentType->name),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'inserted_by' => $this->whenLoaded('insertedBy', fn() => $this->insertedBy->username),
            
            'absences' => $this->whenLoaded('absences', function() {
                return AbsenceResource::collection($this->absences);
            })

        ];

        if ($this->deleted_at) {
            $array['deleted_at'] = $this->deleted_at;
        }

        return $array;
    }
}
