<?php

namespace App\Http\Requests\Api\AccountRequest;

use App\Rules\CheckUsername;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class OrganizationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            /**
             * Ngày thành lập.
             */
            'birth' => 'required|date|before_or_equal:today',
            'website' => 'required|url|max:255',
            /**
             * Lĩnh vực hoạt động.
             */
            'field' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'username' => [
                'required',
                'max:30',
                new CheckUsername,
                'unique:users,username',
            ],
            'information' => 'required|string',
            'representative_name' => 'required|string|max:255',
            'representative_phone_number' => [
                'required',
                new PhoneNumber,
            ],
            'representative_email' => 'required|email:filter|max:255',
            /**
             * Hình ảnh minh chứng.
             * @example [
             *   {
             *     "name": "test.jpg",
             *     "base64": "base64"
             *   },
             *   {
             *     "name": "test2.jpg",
             *     "base64": "base64"
             *   }
             * ]
             */
            'related_images' => 'nullable|array',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string> An associative array mapping attribute names to their human-readable labels.
     */
    public function attributes()
    {
        return [
            'name' => __('tên tổ chức'),
            'birth' => __('ngày thành lập'),
            'website' => __('website'),
            'field' => __('lĩnh vực hoạt động'),
            'address' => __('địa chỉ'),
            'username' => __('tên đăng nhập'),
            'information' => __('thông tin tổ chức'),
            'representative_name' => __('tên người đại diện'),
            'representative_phone_number' => __('số điện thoại người đại diện'),
            'representative_email' => __('email người đại diện'),
            'related_images' => __('hình ảnh minh chứng'),
        ];
    }
}
