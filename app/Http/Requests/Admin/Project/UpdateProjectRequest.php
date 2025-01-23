<?php

namespace App\Http\Requests\Admin\Project;

use App\Acl\Acl;
use App\Enum\ProjectStatus;
use App\Enum\ProjectType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return checkPermission(Acl::PERMISSION_PROJECT_EDIT);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'type' => [
                'required',
                Rule::enum(ProjectType::class),
            ],
            'status' => [
                'required',
                Rule::enum(ProjectStatus::class),
            ],
            'content' => 'required|string',
            'donation_target' => [
                'required_if:type,' . ProjectType::DONATION->value . ',' . ProjectType::BOTH->value . ',' . '',
                'numeric',
                'gt:0',
            ],
            'volunteer_quantity' => [
                'required_if:type,' . ProjectType::VOLUNTEER->value . ',' . ProjectType::BOTH->value . ',' . '',
                'integer',
                'gt:0',
            ],
            'background_image' => 'required',
            'related_images' => 'nullable|array',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'tên dự án',
            'start_date' => 'thời gian bắt đầu',
            'end_date' => 'thời gian kết thúc',
            'type' => 'loại dự án',
            'background_image' => 'ảnh nền dự án',
            'related_images' => 'hình ảnh liên quan',
        ];
    }
}
