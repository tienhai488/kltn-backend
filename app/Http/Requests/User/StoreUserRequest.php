<?php

namespace App\Http\Requests\User;

use App\Acl\Acl;
use App\Enum\Gender;
use App\Enum\UserStatus;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return checkPermission(Acl::PERMISSION_USER_ADD);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'username' => [
                'nullable',
                'string',
                'max:255',
                'unique:users',
            ],
            'email' => [
                'required',
                'string',
                'email:rfc,dns,filter',
                'max:255',
                'unique:users',
            ],
            'phone_number' => [
                'required',
                'unique:users,phone_number',
                new PhoneNumber,
            ],
            'birth_of_date' => [
                'nullable',
                'before_or_equal:' . now()->subYears(16)->format('Y-m-d'),
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            'status' => [
                'required',
                new Enum(UserStatus::class),
            ],
            'gender' => [
                'required',
                new Enum(Gender::class),
            ],
            'address' => [
                'required',
                'string',
                'max:255'
            ],
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
            'user_avatar' => 'nullable',
        ];
    }

    public function attributes()
    {
        return ['name' => 'họ tên'];
    }

    protected function passedValidation()
    {
        $this->merge(['password' => Hash::make($this->input('password'))]);
    }
}