<?php

namespace App\Http\Requests\Api\Donation;

use App\Enum\PaymentMethodCode;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDonationRequest extends FormRequest
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
            'user_id' => 'nullable|exists:users,id',
            'project_id' => 'required|exists:projects,id',
            'name' => 'required|max:255',
            'email' => 'nullable|email|max:255',
            'phone_number' => [
                'nullable',
                new PhoneNumber,
            ],
            'amount' => 'required|numeric|min:10000',
            'is_anonymous' => 'required|boolean',
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
            'payment_method_code' => [
                'required',
                Rule::enum(PaymentMethodCode::class),
            ],
        ];
    }
}
