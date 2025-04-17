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
            'class' => $this->class,
            'code' => $this->code,
            'student_state' => $this->whenLoaded('studentState', fn () => $this->studentState->name),
            'student_type' => $this->whenLoaded('studentType', fn () => $this->studentType->name),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'insezzzrted_by' => $this->whenLoaded('insertedBy', fn () => $this->insertedBy->username),
            'deleted_at' => $this->deleted_at,
        ];
    }
}