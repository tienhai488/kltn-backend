<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'category' => $this->whenLoaded('category'),
            'user' => $this->whenLoaded('user'),
            'name' => $this->name,
            'donation_target' => customFormatPrice($this->donation_target),
            'volunteer_quantity' => $this->volunteer_quantity,
            'volunteers_count' => $this->volunteers_count,
            'donations_count' => $this->donations_count,
            'volunteers_without_canceled_count' => $this->volunteers_without_canceled_count ?? 0,
            'donations_sum_amount' => customFormatPrice($this->donations_sum_amount),
            'start_date' => customFormatDate($this->start_date),
            'end_date' => customFormatDate($this->end_date),
            'content' => $this->content,
            'type' => $this->type,
            'status_label' => $this->status->getLabel(),
            'status_badge' => $this->status->getBadge(),
        ];
    }
}
