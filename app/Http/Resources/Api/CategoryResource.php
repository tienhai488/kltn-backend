<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'icon' => $this->icon,
            /**
             * 0.Tắt 1.Bật
             */
            'status' => $this->status,
            /**
             * Số lượng dự án thuộc danh mục.
             * @var int
             */
            'projects_count' => $this->projects_count,
        ];
    }
}