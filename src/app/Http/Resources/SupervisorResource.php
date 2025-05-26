<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupervisorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'username' => $this->username,
            
            'supervisor_info' => [
                'phone_number' => $this->whenLoaded('supervisorInfo', fn () => $this->supervisorInfo->phone_number),
                'address' => $this->whenLoaded('supervisorInfo', fn () => $this->supervisorInfo->address),
                'sexe' => $this->whenLoaded('supervisorInfo', fn () => $this->supervisorInfo->sexe == 'M' ? 'Male' : 'Female'),
            ],
            
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            
            'role' => $this->whenLoaded('role', fn () => $this->role->name),

            'students' => $this->whenLoaded('students', fn () => $this->students),
        ];
    }
}