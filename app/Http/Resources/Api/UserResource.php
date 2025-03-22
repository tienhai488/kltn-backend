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
            'status' => $this->status,
            'status_label' => $this->status->getLabel(),
            'status_badge' => $this->status->getBadge(),
            'gender' => $this->gender,
            'address' => $this->address,
            'avatar_url' => $this->avatar_url,
            'description' => $this->description,
            'facebook' => $this->facebook,
            'youtube' => $this->youtube,
            'tiktok' => $this->tiktok,
            'type' => $this->type,
            /**
             * Số dự án đã tạo.
             */
            'projects_count' => $this->projects_count,
            /**
             * Tổng số tiền mà các dự án đã tạo đã nhận được.
             */
            'projects_donations_sum_amount' => $this->projects_donations_sum_amount,
            /**
             * Tổng số lượt ủng hộ.
             */
            'projects_donations_count' => $this->projects_donations_count,
            /**
             * Số lượt quyên góp.
             */
            'donations_count' => $this->donations_count,
            /**
             * Tổng số tiền đã quyên góp.
             */
            'donations_sum_amount' => $this->donations_sum_amount,
            /**
             * Số dự án đã tham gia tình nguyện.
             */
            'volunteers_without_canceled_count' => $this->volunteers_without_canceled_count,
        ];
    }
}
