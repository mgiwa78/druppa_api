<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'gender' => $this->gender,
            'title' => $this->title,
            'city' => $this->city,
            'email_verified_at' => $this->city,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'state' => $this->state,
            'postalCode' => $this->postal_code,
            'email' => $this->email,
        ];
    }
}