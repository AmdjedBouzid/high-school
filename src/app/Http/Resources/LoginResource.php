<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    public function toArray(Request $request): array
    {

        if ($this->role_id == 1) {
            $abilities = ['crud-employees'];
        } elseif ($this->role_id == 2) {
            $abilities = [];
        } elseif ($this->role_id == 3) {
            $abilities = [];
        } else {
            $abilities = [];
        }



        $token = $this->createToken(
            $request->userAgent() ?? 'api-token',
            $abilities
        )->plainTextToken;

        return [
            'token' => $token,
            'user' => [
                'id' => $this->id,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'username' => $this->username,
                'email' => $this->email,
                'role' => $this->role?->name,
                'created_at' => $this->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            ],
        ];
    }
}
