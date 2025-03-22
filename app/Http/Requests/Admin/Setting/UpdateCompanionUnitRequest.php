<?php

namespace App\Http\Requests\Admin\Setting;

use App\Acl\Acl;
use App\Rules\CheckEmptyUploadMultipleImage;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanionUnitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return checkPermission(Acl::PERMISSION_SETTING_GENERAL);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'images' => [
                'required',
                'array',
                new CheckEmptyUploadMultipleImage,
            ],
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'images' => __('đơn vị đồng hành'),
        ];
    }
}
