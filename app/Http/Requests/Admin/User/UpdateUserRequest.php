<?php

namespace App\Http\Requests\Admin\User;

use App\Acl\Acl;
use App\Enum\Gender;
use App\Enum\UserStatus;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return checkPermission(Acl::PERMISSION_USER_EDIT);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
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
            'status' => [
                'required',
                new Enum(UserStatus::class),
            ],
            'phone_number' => [
                'required',
                Rule::unique('users')->ignore($this->user->id),
                new PhoneNumber,
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
            'roles' => 'required',
            'roles.*' => 'exists:roles,id',
            'user_avatar' => 'nullable',
        ];

        if (request()->password || request()->password_confirmation) {
            $rules['password'] = [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
                'confirmed',
            ];
        }

        return $rules;
    }

    public function attributes()
    {
        return ['name' => 'họ tên'];
    }
}