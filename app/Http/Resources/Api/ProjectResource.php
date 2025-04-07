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
            /**
             * Kiểm tra xem dự án có phải là của tổ chức hay không.
             */
            'is_organization' => $this->whenLoaded('user', fn() => $this->user->hasRole(Acl::ROLE_ORGANIZATION)),
            /**
             * Kiểm tra xem dự án có phải là của cá nhân hay không.
             */
            'is_individual' => $this->whenLoaded('user', fn() => $this->user->hasRole(Acl::ROLE_INDIVIDUAL)),
            /**
             * Trạng thái của dự án.
             */
            'front_status' => $this->front_status,
            /**
             * Trạng thái của dự án.
             */
            'front_status_label' => $this->front_status->getLabel(),
            /**
             * Danh mục của dự án.
             */
            'category' => CategoryResource::make($this->whenLoaded('category')),
            /**
             * Thống tin người tạo dự án.
             */
            'user' => UserResource::make($this->whenLoaded('user')),
            /**
             * Tên dự án.
             */
            'name' => $this->name,
            'slug' => $this->slug,
            /**
             * Loại dự án.
             */
            'type' => $this->type,
            /**
             * Ảnh nền của dự án.
             */
            'background_image' => $this->background_image,
            /**
             * Hình ảnh liên quan của dự án.
             */
            'related_images' => $this->related_images
                ->map(fn($media) => $media->original_url)
                ->toArray(),
            /**
             * Câu chuyện của dự án.
             */
            'content' => $this->content,

            /**
             * Phần trăm đã quyên góp.
             */
            'donation_percent' => $this->donations_with_paid_sum_amount && $this->donation_target > 0 ? round($this->donations_with_paid_sum_amount / $this->donation_target * 100) : 0,
            /**
             * Tổng số tiền tiền đã quyên góp.
             */
            'donations_with_paid_sum_amount' => $this->donations_with_paid_sum_amount ?? 0,
            /**
             * Mục tiêu quyên góp dự án.
             */
            'donation_target' => $this->donation_target ?? 0,
            /**
             * Số lượt đã quyên góp.
             */
            'donations_with_paid_count' => $this->donations_with_paid_count ?? 0,

            /**
             * Phần trăm tình nguyện viên đã tham gia.
             */
            'volunteer_percent' => $this->volunteers_without_canceled_count && $this->volunteer_quantity > 0 ? round($this->volunteers_without_canceled_count / $this->volunteer_quantity * 100) : 0,
            /**
             * Số lượng tình nguyện viên đã đăng ký.
             */
            'volunteers_without_canceled_count' => $this->volunteers_without_canceled_count ?? 0,
            /**
             * Mục tiêu tình nguyện viên dự án.
             */
            'volunteer_quantity' => $this->volunteer_quantity ?? 0,

            /**
             * Thời gian còn lại.
             */
            'diff_date' => $this->getDiffAttribute(),
            /**
             * Thời gian bắt đầu của dự án.
             */
            'start_date' => $this->start_date,
            /**
             * Thời gian kết thúc của dự án.
             */
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
