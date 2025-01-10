<?php

namespace App\Http\Requests\Admin\Department;

use App\Acl\Acl;
use App\Enum\DepartmentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDepartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return checkPermission(Acl::PERMISSION_DEPARTMENT_ADD);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'string',
                'max:255',
                'unique:departments',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:departments',
            ],
            'description' => 'required|string',
            'status' => [
                'required',
                Rule::enum(DepartmentStatus::class),
            ],
            'department_thumbnail' => 'nullable',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'code' => 'mã phòng ban',
            'name' => 'tên phòng ban',
        ];
    }
}
