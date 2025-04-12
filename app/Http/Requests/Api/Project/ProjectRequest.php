<?php

namespace App\Http\Requests\Api\Project;

use App\Acl\Acl;
use App\Enum\ProjectType;
use App\Enum\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
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
                'string',
                Rule::enum(ProjectType::class),
            ],
            'category_id' => 'nullable|integer|min:1',
            'role' => [
                'nullable',
                'string',
                Rule::in([Acl::ROLE_ORGANIZATION, Acl::ROLE_INDIVIDUAL]),
            ],
            'keyword' => 'nullable|string',
            'project_id' => [
                'nullable',
                'integer',
                'min:1',
                'exists:projects,id',
            ],
            'project_slug' => [
                'nullable',
                'exists:projects,slug',
            ],
            'user_id' => [
                'nullable',
                'integer',
                'min:1',
                'exists:users,id',
            ],
            'user_type' => [
                'nullable',
                Rule::enum(UserType::class),
            ],
        ];
    }
}