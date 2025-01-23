<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DonationResource extends JsonResource
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
            'project' => $this->whenLoaded('project'),
            'department' => $this->whenLoaded('department'),
            'account_number' => $this->account_number,
            'account_name' => $this->account_name,
            'code' => $this->code,
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'amount' => customFormatPrice($this->amount),
            'is_anonymous' => $this->is_anonymous,
            'anonymous_status_label' => $this->is_anonymous->getLabel(),
            'anonymous_status_badge' => $this->is_anonymous->getBadge(),
            'note' => $this->note,
            'student_code' => $this->student_code,
            'class' => $this->class,
            'created_at' => customFormatDate($this->created_at),
        ];
    }
}