<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            'user' => $this->whenLoaded('user'),
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'subject' => $this->subject,
            'content' => $this->content,
            'status_label' => $this->status->getLabel(),
            'status_badge' => $this->status->getBadge(),
        ];
    }
}