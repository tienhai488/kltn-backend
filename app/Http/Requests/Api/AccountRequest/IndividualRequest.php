<?php

namespace App\Http\Requests\Api\AccountRequest;

use App\Rules\CheckUsername;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class IndividualRequest extends FormRequest
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
             * Ngày sinh.
             */
            'birth' => 'required|date|before_or_equal:today',
            'email' => 'required|email:filter|max:255',
            'phone_number' => [
                'required',
                new PhoneNumber,
            ],
            /**
             * Tên clb.
             */
            'club_name' => 'required|string|max:255',
            /**
             * Lĩnh vực hoạt động của clb.
             */
            'field' => 'required|string|max:255',
            'website' => 'required|url|max:255',
            'address' => 'required|string|max:255',
            'username' => [
                'required',
                'max:30',
                new CheckUsername,
                'unique:users,username',
            ],
            'information' => 'required|string',
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
    public function attributes(): array
    {
        return [
            'name' => __('họ và tên'),
            'birth' => __('ngày sinh'),
            'email' => __('email'),
            'phone_number' => __('số điện thoại'),
            'club_name' => __('tên clb'),
            'field' => __('lĩnh vực hoạt động của clb'),
            'website' => __('website'),
            'address' => __('địa chỉ'),
            'username' => __('tên tài khoản'),
            'information' => __('thông tin khác'),
            'related_images' => __('hình ảnh minh chứng'),
        ];
    }
}
