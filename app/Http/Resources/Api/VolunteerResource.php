<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VolunteerResource extends JsonResource
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
            'user' => UserResource::make($this->whenLoaded('user')),
            'project' => $this->whenLoaded('project'),
            'department' => $this->whenLoaded('department'),
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'note' => $this->note,
            'student_code' => $this->student_code,
            'class' => $this->class,
            'status' => $this->status,
            'status_label' => $this->status->getLabel(),
            'status_badge' => $this->status->getBadge(),
            'created_at' => $this->created_at,
        ];
    }
}
