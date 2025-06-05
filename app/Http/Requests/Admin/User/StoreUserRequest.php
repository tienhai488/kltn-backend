<?php

namespace App\Http\Requests\Admin\User;

use App\Acl\Acl;
use App\Enum\Gender;
use App\Enum\UserStatus;
use App\Rules\CheckUsername;
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
                'required',
                'max:30',
                new CheckUsername,
                'unique:users,username',
            ],
            'email' => [
                'required',
                'string',
                'email:filter',
                'max:255',
                'unique:users',
            ],
            'phone_number' => [
                'required',
                new PhoneNumber,
            ],
            'birth_of_date' => [
                'required',
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
            'role' => 'nullable|exists:roles,id',
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
