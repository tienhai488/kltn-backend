<?php

namespace App\Http\Resources\Api;

use App\Acl\Acl;
use App\Http\Resources\Api\CategoryResource;
use Carbon\Carbon;
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
            'is_organization' => $this->whenLoaded('user', fn() => $this->user->hasRole(Acl::ROLE_ORGANIZATION)),
            'is_individual' => $this->whenLoaded('user', fn() => $this->user->hasRole(Acl::ROLE_INDIVIDUAL)),
            'front_status' => $this->front_status,
            'front_status_label' => $this->front_status->getLabel(),
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'user' => UserResource::make($this->whenLoaded('user')),
            'name' => $this->name,
            'type' => $this->type,
            'background_image' => $this->background_image,
            'related_images' => $this->related_images
                ->map(fn($media) => $media->original_url)
                ->toArray(),
            'content' => $this->content,

            'donation_percent' => $this->donations_sum_amount ? round($this->donations_sum_amount / $this->donation_target * 100) : 0,
            'donations_sum_amount' => $this->donations_sum_amount,
            'donation_target' => $this->donation_target,
            'donations_count' => $this->donations_count,

            'volunteer_percent' => $this->volunteers_without_canceled_count ? round($this->volunteers_without_canceled_count / $this->volunteer_quantity * 100) : 0,
            'volunteers_without_canceled_count' => $this->volunteers_without_canceled_count ?? 0,
            'volunteer_quantity' => $this->volunteer_quantity,

            'diff_date' => $this->getDiffAttribute(),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ];
    }

    /**
     * Return the difference between end_date and start_date in a human-readable format.
     *
     * @return string
     */
    public function getDiffAttribute()
    {
        if ($this->end_date < Carbon::now()) {
            return 'Đã kết thúc';
        }

        $diffInDays = $this->start_date->diffInDays($this->end_date);

        if ($diffInDays >= 1) {
            return 'Còn ' . floor($diffInDays) . ' ngày';
        }

        $diffInHours = $this->start_date->diffInHours($this->end_date);
        return 'Còn ' . floor($diffInHours) . ' giờ';
    }
}
