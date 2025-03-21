<?php

namespace App\Http\Requests\Api\User;

use App\Enum\UserStatus;
use App\Enum\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'page' => 'nullable|integer|min:1',
            'limit' => 'nullable|integer|min:1',
            'type' => [
                'nullable',
                Rule::enum(UserType::class),
            ],
            'keyword' => 'nullable|string',
            'department_id' => [
                'nullable',
                'integer',
                'min:1',
                'exists:departments,id',
            ],
            'status' => [
                'nullable',
                Rule::enum(UserStatus::class),
            ],
        ];
    }
}