<?php

return [
    'vnp_TmnCode' => env('VNPAY_TMN_CODE', 'P8ANVBP7'),
    'vnp_HashSecret' => env('VNPAY_HASH_SECRET', 'EV93G5OCXDQK5TXI6BLQBQFU8IBGT1FY'),
    'vnp_Url' => env('VNPAY_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html'),
    'vnp_ReturnUrl' => env('VNPAY_RETURN_URL', env('APP_URL') . '/payment/return'),
    'vnp_ApiUrl' => env('VNPAY_API_URL', 'https://sandbox.vnpayment.vn/merchant_webapi/api/transaction'),
];