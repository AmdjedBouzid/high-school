<?php

// app/Http/Resources/SectionResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\StudentResource;

class SectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'major' => $this->whenLoaded('major', fn() => [
                'id' => $this->major->id,
                'name' => $this->major->name,
                'grade_id' => $this->major->grade_id,
            ]),

            'students' => $this->whenLoaded('students', fn() => StudentResource::collection($this->students)),
            
        ];
    }
}
