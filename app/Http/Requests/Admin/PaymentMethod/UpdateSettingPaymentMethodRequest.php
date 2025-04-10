<?php

namespace App\Http\Requests\Admin\PaymentMethod;

use App\Acl\Acl;
use App\Enum\PaymentMethodCode;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingPaymentMethodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return checkPermission(Acl::PERMISSION_PAYMENT_METHOD_EDIT);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->paymentMethod->code->value == PaymentMethodCode::VNPAY->value) {
            return [
                'vnpTmnCode' => 'required|string|max:255',
                'vnpHashSecret' => 'required|string|max:255',
                'vnpUrl' => 'required|url|max:255',
                'vnpReturnUrl' => 'required|string|max:255',
            ];
        }

        if ($this->paymentMethod->code->value == PaymentMethodCode::MOMO->value) {
            return [
                'endpoint' => 'required|url|max:255',
                'partnerCode' => 'required|string|max:255',
                'accessKey' => 'required|string|max:255',
                'secretKey' => 'required|string|max:255',
                'returnUrl' => 'required|string|max:255',
            ];
        }

        return [
            'pin_code' => [
                'required',
                'max:30',
            ],
            'bank_number' => [
                'required',
                'numeric',
                'digits_between:4,16',
            ],
            'bank_name' => [
                'required',
                'string',
                'max:255',
            ],
            'account_name' => [
                'required',
                'string',
                'max:255',
            ],
            'qr_image_src' => 'required',
        ];
    }

    /**
     * Specify custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'vnpTmnCode' => __('terminal id'),
            'vnpHashSecret' => __('secret key'),
            'vnpUrl' => __('đường dẫn thanh toán'),
            'vnpReturnUrl' => __('đường dẫn trả về sau khi thanh toán'),
            'endpoint' => __('đường dẫn thanh toán'),
            'partnerCode' => __('mã đối tác'),
            'accessKey' => __('access key'),
            'secretKey' => __('secret key'),
            'returnUrl' => __('đường dẫn trả về sau khi thanh toán'),
        ];
    }
}