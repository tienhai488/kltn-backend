<?php

namespace App\Http\Requests\Api\Contact;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class StoreContractRequest extends FormRequest
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
             * @var string
             * @example string
             */
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            /**
             * @var string
             * @example test@gmail.com
             */
            'email' => [
                'required',
                'string',
                'email:rfc,dns,filter',
                'max:255',
            ],
            /**
             * @var string
             * @example 0987654321
             */
            'phone_number' => [
                'required',
                new PhoneNumber,
            ],
            /**
             * @var string
             * @example subject
             */
            'subject' => [
                'required',
                'string',
                'max:255',
            ],
            /**
             * @var string
             * @example content
             */
            'content' => [
                'required',
            ],
        ];
    }
}