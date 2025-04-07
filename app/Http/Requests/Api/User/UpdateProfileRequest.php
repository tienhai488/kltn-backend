<?php

namespace App\Http\Requests\Api\User;

use App\Enum\Gender;
use App\Rules\PhoneNumber;
use App\Traits\ApiResponses;
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
                'nullable',
                'before_or_equal:' . now()->subYears(16)->format('Y-m-d'),
            ],
            'gender' => [
                'nullable',
                new Enum(Gender::class),
            ],
            'address' => [
                'nullable',
                'string',
                'max:255',
            ],
            'phone_number' => [
                'required',
                Rule::unique('users')->ignore(auth()->id()),
                new PhoneNumber,
            ],
            'description' => 'nullable',
            'facebook' => 'nullable',
            'youtube' => 'nullable',
            'tiktok' => 'nullable',
            'department_id' => [
                'nullable',
                Rule::requiredIf(fn() => !empty($this->student_code) || !empty($this->class)),
                'exists:departments,id',
            ],
            'class' => [
                Rule::requiredIf(fn() => !empty($this->department_id)),
                'max:255',
            ],
            'student_code' => [
                Rule::requiredIf(fn() => !empty($this->department_id)),
                'max:255',
            ],
        ];
    }
}
