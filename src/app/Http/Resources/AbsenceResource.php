<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\StudentResource;

class AbsenceResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'from_action' => $this->whenLoaded('fromAction', fn() => new AbsenceActionResource($this->fromAction)),
            'to_action' => $this->whenLoaded('toAction', fn() => new AbsenceActionResource($this->toAction)),
            'absent_type' => $this->absent_type,
            'absent_description' => $this->absent_description,
            'presence_type' => $this->presence_type,
            'presence_description' => $this->presence_description,
        ];
    }
}

class AbsenceActionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'time' => $this->time,
            'made_by' => $this->madeBy->username,
        ];
    }
}
