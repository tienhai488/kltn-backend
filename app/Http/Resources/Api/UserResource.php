<?php

namespace App\Http\Resources\Api;

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
            'username' => $this->username,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'birth_of_date' => $this->birth_of_date,
            'status_label' => $this->status->getLabel(),
            'status_badge' => $this->status->getBadge(),
            'gender' => $this->gender,
            'address' => $this->address,
        ];
    }
}