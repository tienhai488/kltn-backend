<?php

namespace App\Http\Requests\Api\Donation;

use App\Enum\AnonymousStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DonationRequest extends FormRequest
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
            'project_id' => [
                'nullable',
                'integer',
                'min:1',
                'exists:projects,id',
            ],
            'user_id' => [
                'nullable',
                'integer',
                'min:1',
                'exists:users,id',
            ],
            'department_id' => [
                'nullable',
                'integer',
                'min:1',
                'exists:departments,id',
            ],
            'keyword' => 'nullable|string',
            'is_anonymous' => [
                'nullable',
                Rule::enum(AnonymousStatus::class),
            ],
        ];
    }
}
