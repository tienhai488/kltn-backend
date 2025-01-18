<?php

namespace App\Http\Requests\User;

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
            'username' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('users')->ignore(auth()->id()),
            ],
            'birth_of_date' => [
                'nullable',
                'before_or_equal:' . now()->subYears(16)->format('Y-m-d'),
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
                Rule::unique('users')->ignore(auth()->id()),
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