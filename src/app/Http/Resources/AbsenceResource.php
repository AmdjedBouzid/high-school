<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AbsenceActionResource;
use App\Http\Resources\StudentResource;

class AbsenceResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'student' => new StudentResource($this->whenLoaded('student')),
            'fromAction' => $this->whenLoaded('fromAction'),
            'toAction' => $this->whenLoaded('toAction'),
        ];
    }

}
