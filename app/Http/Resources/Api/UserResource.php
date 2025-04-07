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
            /**
             * Giới thiệu.
             */
            'description' => $this->description,
            'facebook' => $this->facebook,
            'youtube' => $this->youtube,
            'tiktok' => $this->tiktok,
            /**
             * Loại người dùng.
             */
            'type' => $this->type,
            /**
             * Số dự án đã tạo (Tổ chức/ Cá nhân).
             */
            'projects_count' => $this->projects_count,
            /**
             * Tổng số tiền mà các dự án đã tạo đã nhận được (Tổ chức/ Cá nhân).
             */
            'projects_donations_sum_amount' => $this->projects_donations_sum_amount,
            /**
             * Tổng số lượt ủng hộ (Tổ chức/ Cá nhân).
             */
            'projects_donations_count' => $this->projects_donations_count,
            /**
             * Tổng số lượt tham gia tình nguyện (Tổ chức/ Cá nhân).
             */
            'projects_volunteers_count' => $this->projects_volunteers_count,
            /**
             * Số lượt quyên góp (Cá nhân).
             */
            'donations_with_paid_count' => $this->donations_with_paid_count,
            /**
             * Số tiền đã quyên góp (Cá nhân).
             */
            'donations_with_paid_sum_amount' => $this->donations_with_paid_sum_amount,
            /**
             * Số lượt tham gia tình nguyện (Cá nhân).
             */
            'volunteers_without_canceled_count' => $this->volunteers_without_canceled_count,
        ];
    }
}