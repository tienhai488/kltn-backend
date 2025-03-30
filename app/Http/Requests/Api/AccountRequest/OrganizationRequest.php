<?php

namespace App\Http\Requests\Api\AccountRequest;

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
            'username' => 'required|string|max:255|unique:users,username',
            'information' => 'required|string',
            'representative_name' => 'required|string|max:255',
            'representative_phone_number' => [
                'required',
                new PhoneNumber,
            ],
            'representative_email' => 'required|email:rfc,dns|max:255',
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
}
