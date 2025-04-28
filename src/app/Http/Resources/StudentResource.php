<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,

            'section' => $this->whenLoaded('section', fn() => new SectionResource($this->section)),
            'code' => $this->code,

            'student_state' => $this->whenLoaded('recordStatus', fn() => $this->recordStatus->name),
            'student_type' => $this->whenLoaded('studentType', fn() => $this->studentType->name),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'deleted_at' => $this->deleted_at,

            // Optional: Uncomment if relationship exists
            'inserted_by' => $this->whenLoaded('insertedBy', fn() => $this->insertedBy->username),
        ];
    }
}
