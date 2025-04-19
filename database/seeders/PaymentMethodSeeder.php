<?php

namespace Database\Seeders;

use App\Enum\ActiveStatus;
use App\Enum\PaymentMethodCode;
use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = [
            [
                'code' => PaymentMethodCode::VNPAY,
                'name' => 'Thanh toán qua VNPay',
                'description' => 'Thanh toán trực tuyến qua cổng VNPay',
                'api_config' => [
                    'return_url' => '/payment/vnpay-return',
                ],
                'icon_url' => '/icons/payment/vnpay.svg',
                'sort_order' => 1,
                'status' => ActiveStatus::ACTIVE,
            ],
            [
                'code' => PaymentMethodCode::MOMO,
                'name' => 'Thanh toán qua MoMo',
                'description' => 'Thanh toán trực tuyến qua cổng MoMo',
                'api_config' => [
                    'return_url' => '/payment/momo-return',
                ],
                'icon_url' => '/icons/payment/momo.svg',
                'sort_order' => 2,
                'status' => ActiveStatus::ACTIVE,
            ],
            [
                'code' => PaymentMethodCode::BANK_TRANSFER,
                'name' => 'Chuyển khoản ngân hàng',
                'description' => 'Chuyển khoản trực tiếp vào tài khoản ngân hàng',
                'api_config' => [
                    'note_template' => 'Thanh toán đơn hàng {order_code}'
                ],
                'icon_url' => '/icons/payment/bank.svg',
                'sort_order' => 3,
                'status' => ActiveStatus::ACTIVE,
            ],
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethod::firstOrCreate(
                ['code' => $method['code']],
                $method
            );
        }
    }
}