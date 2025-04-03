<?php

namespace App\Http\Requests\Api\Volunteer;

use App\Rules\CheckRegistedUser;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class StoreVolunteerRequest extends FormRequest
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
            /**
             * Một tình nguyện viên chỉ có thể đăng ký một lần cho một dự án, nếu chưa bị từ chối trước đó.
             */
            'user_id' => [
                'required',
                'exists:users,id',
                new CheckRegistedUser($this->project_id),
            ],
            'project_id' => 'required|exists:projects,id',
            'name' => 'required|max:255',
            'email' => 'required|email:filter|max:255',
            'phone_number' => [
                'required',
                new PhoneNumber,
            ],
            'department_id' => [
                'required',
                'exists:departments,id',
            ],
            'class' => [
                'required',
                'max:255',
            ],
            'student_code' => [
                'required',
                'max:255',
            ],
            'note' => 'nullable',
        ];
    }
}