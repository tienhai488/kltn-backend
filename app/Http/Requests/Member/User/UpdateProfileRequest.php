<?php

namespace App\Http\Requests\Member\User;

use App\Enum\Gender;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateProfileRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'birth_of_date' => [
                'required',
            ],
            'gender' => [
                'required',
                new Enum(Gender::class),
            ],
            'address' => [
                'required',
                'string',
                'max:255',
            ],
            'phone_number' => [
                'required',
                new PhoneNumber,
            ],
            'user_avatar' => 'nullable',
        ];
    }

    public function attributes()
    {
        return ['name' => 'họ tên'];
    }
}
